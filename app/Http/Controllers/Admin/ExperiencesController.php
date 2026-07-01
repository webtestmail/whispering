<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Experience;
use App\Models\Admin\ExperienceSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ExperiencesController extends Controller
{
    private const SECTION_KEYS = [
        'editorial', 'what_to_expect', 'activities', 'day_timeline',
        'best_months', 'gallery', 'booking_sidebar', 'exp_cta',
    ];

    public function manageExperiences()
    {
        return view('admin.manage_experiences', [
            'currentPageName' => 'Experiences',
            'currentPageData' => 'experience',
            'addNewData' => 'admin.add.experience',
            'deleteUrl' => 'admin.experience.delete',
        ]);
    }

    public function experience_data(Request $request)
    {
        $data = Experience::orderBy('position_order')->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('season_tag', fn ($row) => $row->season_tag ?: '-')
            ->addColumn('listing_image', function ($row) {
                if (!$row->listing_image) {
                    return '-';
                }

                return '<img src="' . asset($row->listing_image) . '" width="60" height="50" class="rounded">';
            })
            ->addColumn('is_active', fn ($row) => $row->status === 'active' ? 'Active' : 'Inactive')
            ->addColumn('created_at', fn ($row) => $row->created_at ? $row->created_at->format('d M Y') : '-')
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.edit.experience', Crypt::encrypt($row->id));
                $deleteId = Crypt::encrypt($row->id);

                return '<div class="dropdown">
                    <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                        <i class="feather-more-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="' . $editUrl . '" class="dropdown-item">Edit</a>
                        <button class="dropdown-item delete" data-id="' . $deleteId . '" data-model="Experience">Delete</button>
                    </div>
                </div>';
            })
            ->rawColumns(['listing_image', 'action'])
            ->make(true);
    }

    public function experience_delete(Request $request)
    {
        $request->validate(['id' => 'required', 'model' => 'required']);

        try {
            $id = Crypt::decrypt($request->id);
            ExperienceSection::where('experience_id', $id)->delete();
            Experience::findOrFail($id)->delete();

            return response()->json(['success' => true, 'message' => 'Experience deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Invalid ID or experience not found.'], 400);
        }
    }

    public function addExperience(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate(['title' => 'required|string', 'slug' => 'nullable|string']);

            $order = Experience::max('position_order');
            $experience = Experience::create($this->experienceFields($request, ($order !== null) ? $order + 1 : 1));

            $this->storeExperienceImages($request, $experience);
            $this->seedDefaultSections($experience->id);

            return redirect()
                ->route('admin.edit.experience', Crypt::encrypt($experience->id))
                ->with('success', 'Experience created. Fill in the detail sections below and save.');
        }

        return view('admin.experience-ops', [
            'currentPageName' => 'Experience',
            'allData' => 'admin.manage_experiences',
        ]);
    }

    public function editExperience(Request $request, $experience)
    {
        $id = Crypt::decrypt($experience);
        $item = Experience::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate(['title' => 'required|string', 'slug' => 'nullable|string']);

            $item->fill($this->experienceFields($request, $item->position_order));
            $this->storeExperienceImages($request, $item);
            $item->save();

            $this->saveSectionsFromRequest($id, $request);

            return redirect()
                ->route('admin.edit.experience', $experience)
                ->with('success', 'Experience saved successfully.');
        }

        $item->encrypted_id = $experience;
        $this->seedDefaultSections($id);

        return view('admin.experience-ops', [
            'experience' => $item,
            'sections' => $this->loadSections($id),
            'currentPageName' => 'Experience',
            'allData' => 'admin.manage_experiences',
        ]);
    }

    private function experienceFields(Request $request, int $positionOrder): array
    {
        return [
            'position_order' => $request->filled('position_order') ? (int) $request->position_order : $positionOrder,
            'slug' => $this->uniqueSlug($request->slug ?: $request->title, $request->route('experience') ? Crypt::decrypt($request->route('experience')) : null),
            'status' => $request->status ?? 'active',
            'season_tag' => $request->season_tag,
            'season_style' => $request->season_style,
            'months' => $request->months,
            'temperature' => $request->temperature,
            'title' => $request->title,
            'listing_description' => htmlspecialchars($request->listing_description ?? '', ENT_QUOTES),
            'highlights' => $this->parseHighlights($request->highlights),
            'link_text' => $request->link_text,
            'hero_subtitle' => $request->hero_subtitle,
            'hero_description' => htmlspecialchars($request->hero_description ?? '', ENT_QUOTES),
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => htmlspecialchars($request->meta_description ?? '', ENT_QUOTES),
        ];
    }

    private function storeExperienceImages(Request $request, Experience $experience): void
    {
        if ($request->hasFile('listing_image')) {
            $experience->listing_image = $this->storeImage($request->file('listing_image'), 'images/experiences/', $experience->listing_image);
        }
        if ($request->hasFile('hero_image')) {
            $experience->hero_image = $this->storeImage($request->file('hero_image'), 'images/experiences/', $experience->hero_image);
        }
        $experience->save();
    }

    private function loadSections(int $experienceId)
    {
        return ExperienceSection::where('experience_id', $experienceId)
            ->whereNull('parent_id')
            ->with(['subsections' => fn ($q) => $q->orderBy('position_order')])
            ->get()
            ->keyBy('default_section_name');
    }

    private function saveSectionsFromRequest(int $experienceId, Request $request): void
    {
        $sections = $this->loadSections($experienceId);
        $input = $request->input('sections', []);

        $editorial = $this->updateParent($sections->get('editorial'), $experienceId, 'editorial', [
            'section_headline' => $input['editorial']['quote'] ?? null,
        ]);
        $this->syncRepeater($editorial, $experienceId, $input['editorial']['paragraphs'] ?? [], function ($row, $index, $order) {
            return [
                'description' => htmlspecialchars($row['text'] ?? '', ENT_QUOTES),
                'position_order' => $order,
            ];
        }, $request);

        $expect = $this->updateParent($sections->get('what_to_expect'), $experienceId, 'what_to_expect', [
            'section_headline' => $input['what_to_expect']['section_headline'] ?? null,
        ]);
        $this->syncRepeater($expect, $experienceId, $input['what_to_expect']['items'] ?? [], function ($row, $index, $order) {
            return [
                'section_subheading' => $row['label'] ?? '',
                'section_headline' => $row['value'] ?? '',
                'position_order' => $order,
            ];
        }, $request);

        $activities = $this->updateParent($sections->get('activities'), $experienceId, 'activities', [
            'section_headline' => $input['activities']['section_headline'] ?? null,
            'section_subtitle' => $input['activities']['section_subtitle'] ?? null,
        ]);
        $this->syncRepeater($activities, $experienceId, $input['activities']['items'] ?? [], function ($row, $index, $order) use ($request) {
            return [
                'section_headline' => $row['title'] ?? '',
                'description' => htmlspecialchars($row['desc'] ?? '', ENT_QUOTES),
                'section_image' => $this->resolveRowImage($request, "sections.activities.items.{$index}.image", $row['existing_image'] ?? null),
                'position_order' => $order,
            ];
        }, $request, 'sections.activities.items');

        $timeline = $this->updateParent($sections->get('day_timeline'), $experienceId, 'day_timeline', [
            'section_headline' => $input['day_timeline']['section_headline'] ?? null,
            'section_subtitle' => $input['day_timeline']['section_subtitle'] ?? null,
        ]);
        $this->syncRepeater($timeline, $experienceId, $input['day_timeline']['items'] ?? [], function ($row, $index, $order) {
            return [
                'section_subtitle' => $row['time'] ?? '',
                'section_headline' => $row['title'] ?? '',
                'description' => htmlspecialchars($row['desc'] ?? '', ENT_QUOTES),
                'position_order' => $order,
            ];
        }, $request);

        $months = $this->updateParent($sections->get('best_months'), $experienceId, 'best_months', [
            'section_headline' => $input['best_months']['section_headline'] ?? null,
        ]);
        $this->syncRepeater($months, $experienceId, $input['best_months']['items'] ?? [], function ($row, $index, $order) {
            return [
                'section_subheading' => $row['month'] ?? '',
                'section_subtitle' => $row['status'] ?? 'off',
                'position_order' => $order,
            ];
        }, $request);

        $gallery = $this->updateParent($sections->get('gallery'), $experienceId, 'gallery', [
            'section_headline' => $input['gallery']['section_headline'] ?? null,
            'section_subtitle' => $input['gallery']['section_subtitle'] ?? null,
        ]);
        $this->syncRepeater($gallery, $experienceId, $input['gallery']['items'] ?? [], function ($row, $index, $order) use ($request) {
            return [
                'section_headline' => $row['caption'] ?? '',
                'section_subheading' => $row['layout'] ?? 'default',
                'section_image' => $this->resolveRowImage($request, "sections.gallery.items.{$index}.image", $row['existing_image'] ?? null),
                'position_order' => $order,
            ];
        }, $request, 'sections.gallery.items');

        $this->updateParent($sections->get('booking_sidebar'), $experienceId, 'booking_sidebar', [
            'section_subheading' => $input['booking_sidebar']['tag'] ?? null,
            'section_headline' => $input['booking_sidebar']['title'] ?? null,
            'description' => htmlspecialchars($input['booking_sidebar']['subtitle'] ?? '', ENT_QUOTES),
        ]);

        $this->updateParent($sections->get('exp_cta'), $experienceId, 'exp_cta', [
            'section_headline' => $input['exp_cta']['section_headline'] ?? null,
            'description' => htmlspecialchars($input['exp_cta']['description'] ?? '', ENT_QUOTES),
            'button_name' => $input['exp_cta']['button_name'] ?? null,
            'button_link' => $input['exp_cta']['button_link'] ?? null,
        ]);
    }

    private function updateParent(?ExperienceSection $section, int $experienceId, string $key, array $data): ExperienceSection
    {
        $section = $section ?? $this->createParent($experienceId, $key, array_search($key, self::SECTION_KEYS) + 1);
        $section->fill(array_filter($data, fn ($v) => $v !== null));
        $section->status = 'active';
        $section->save();

        return $section;
    }

    private function createParent(int $experienceId, string $key, int $order): ExperienceSection
    {
        return ExperienceSection::create([
            'experience_id' => $experienceId,
            'default_section_name' => $key,
            'parent_id' => null,
            'position_order' => $order,
            'status' => 'active',
        ]);
    }

    private function syncRepeater(?ExperienceSection $parent, int $experienceId, array $rows, callable $mapper, ?Request $request = null, ?string $filePrefix = null): void
    {
        if (!$parent) {
            return;
        }

        $keptIds = [];
        $order = 0;

        foreach ($rows as $index => $row) {
            $fileKey = $filePrefix ? "{$filePrefix}.{$index}.image" : null;

            if ($this->isEmptyRow($row, $request, $fileKey)) {
                continue;
            }

            $order++;
            $data = array_merge($mapper($row, $index, $order), [
                'experience_id' => $experienceId,
                'parent_id' => $parent->id,
                'status' => 'active',
            ]);

            if (!empty($row['id'])) {
                $existing = ExperienceSection::where('id', $row['id'])
                    ->where('parent_id', $parent->id)
                    ->first();
                if ($existing) {
                    if (empty($data['section_image']) && $existing->section_image) {
                        $data['section_image'] = $existing->section_image;
                    }
                    $existing->fill($data);
                    $existing->save();
                    $keptIds[] = $existing->id;
                    continue;
                }
            }

            $created = ExperienceSection::create($data);
            $keptIds[] = $created->id;
        }

        ExperienceSection::where('parent_id', $parent->id)
            ->whereNotIn('id', $keptIds)
            ->delete();
    }

    private function isEmptyRow(array $row, ?Request $request = null, ?string $imageKey = null): bool
    {
        if ($request && $imageKey && $request->hasFile($imageKey)) {
            return false;
        }
        if (!empty($row['existing_image'])) {
            return false;
        }

        unset($row['id'], $row['existing_image'], $row['layout'], $row['status']);
        foreach ($row as $value) {
            if (filled($value)) {
                return false;
            }
        }

        return true;
    }

    private function resolveRowImage(Request $request, string $fileKey, ?string $existing): ?string
    {
        if ($request->hasFile($fileKey)) {
            return $this->storeImage($request->file($fileKey), 'images/experiences/sections/', $existing);
        }

        return $existing;
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $slug = Str::slug($value);
        $original = $slug;
        $suffix = 1;

        while (true) {
            $query = Experience::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            if (!$query->exists()) {
                break;
            }
            $slug = $original . '-' . $suffix++;
        }

        return $slug;
    }

    private function parseHighlights(?string $raw): ?array
    {
        if (!$raw) {
            return null;
        }

        $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $raw)));

        return array_values($lines);
    }

    private function seedDefaultSections(int $experienceId): void
    {
        foreach (self::SECTION_KEYS as $index => $name) {
            ExperienceSection::firstOrCreate(
                [
                    'experience_id' => $experienceId,
                    'default_section_name' => $name,
                    'parent_id' => null,
                ],
                [
                    'position_order' => $index + 1,
                    'status' => 'active',
                ]
            );
        }
    }
}
