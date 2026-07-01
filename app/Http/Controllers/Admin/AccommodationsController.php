<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Accommodation;
use App\Models\Admin\AccommodationSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class AccommodationsController extends Controller
{
    private const SECTION_KEYS = [
        'overview', 'gallery', 'features', 'inclusions',
        'tariff', 'policies', 'other_stays', 'accom_cta',
    ];

    public function manageAccommodations()
    {
        return view('admin.manage_accommodations', [
            'currentPageName' => 'Accommodations',
            'currentPageData' => 'accommodation',
            'addNewData' => 'admin.add.accommodation',
            'deleteUrl' => 'admin.accommodation.delete',
        ]);
    }

    public function accommodation_data(Request $request)
    {
        $data = Accommodation::orderBy('position_order')->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('tag', fn ($row) => $row->tag ?: '-')
            ->addColumn('listing_image', function ($row) {
                if (!$row->listing_image) {
                    return '-';
                }

                return '<img src="' . asset($row->listing_image) . '" width="60" height="50" class="rounded">';
            })
            ->addColumn('is_active', fn ($row) => $row->status === 'active' ? 'Active' : 'Inactive')
            ->addColumn('created_at', fn ($row) => $row->created_at ? $row->created_at->format('d M Y') : '-')
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.edit.accommodation', Crypt::encrypt($row->id));
                $deleteId = Crypt::encrypt($row->id);

                return '<div class="dropdown">
                    <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                        <i class="feather-more-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="' . $editUrl . '" class="dropdown-item">Edit</a>
                        <button class="dropdown-item delete" data-id="' . $deleteId . '" data-model="Accommodation">Delete</button>
                    </div>
                </div>';
            })
            ->rawColumns(['listing_image', 'action'])
            ->make(true);
    }

    public function accommodation_delete(Request $request)
    {
        $request->validate(['id' => 'required', 'model' => 'required']);

        try {
            $id = Crypt::decrypt($request->id);
            AccommodationSection::where('accommodation_id', $id)->delete();
            Accommodation::findOrFail($id)->delete();

            return response()->json(['success' => true, 'message' => 'Accommodation deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Invalid ID or accommodation not found.'], 400);
        }
    }

    public function addAccommodation(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate(['title' => 'required|string', 'slug' => 'nullable|string']);

            $order = Accommodation::max('position_order');
            $accommodation = Accommodation::create($this->accommodationFields($request, ($order !== null) ? $order + 1 : 1));

            $this->storeAccommodationImages($request, $accommodation);
            $this->seedDefaultSections($accommodation->id);

            return redirect()
                ->route('admin.edit.accommodation', Crypt::encrypt($accommodation->id))
                ->with('success', 'Accommodation created. Fill in the detail sections below and save.');
        }

        return view('admin.accommodation-ops', [
            'currentPageName' => 'Accommodation',
            'allData' => 'admin.manage_accommodations',
        ]);
    }

    public function editAccommodation(Request $request, $accommodation)
    {
        $id = Crypt::decrypt($accommodation);
        $item = Accommodation::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate(['title' => 'required|string', 'slug' => 'nullable|string']);

            $item->fill($this->accommodationFields($request, $item->position_order));
            $this->storeAccommodationImages($request, $item);
            $item->save();

            $this->saveSectionsFromRequest($id, $request);

            return redirect()
                ->route('admin.edit.accommodation', $accommodation)
                ->with('success', 'Accommodation saved successfully.');
        }

        $item->encrypted_id = $accommodation;
        $this->seedDefaultSections($id);

        return view('admin.accommodation-ops', [
            'accommodation' => $item,
            'sections' => $this->loadSections($id),
            'currentPageName' => 'Accommodation',
            'allData' => 'admin.manage_accommodations',
        ]);
    }

    private function accommodationFields(Request $request, int $positionOrder): array
    {
        return [
            'position_order' => $request->filled('position_order') ? (int) $request->position_order : $positionOrder,
            'slug' => $this->uniqueSlug($request->slug ?: $request->title, $request->route('accommodation') ? Crypt::decrypt($request->route('accommodation')) : null),
            'status' => $request->status ?? 'active',
            'tag' => $request->tag,
            'badge' => $request->badge,
            'title' => $request->title,
            'listing_description' => htmlspecialchars($request->listing_description ?? '', ENT_QUOTES),
            'share_basis' => $request->share_basis,
            'reverse_layout' => $request->boolean('reverse_layout'),
            'amenities' => $this->parseAmenities($request->amenities),
            'hero_subtitle' => $request->hero_subtitle,
            'hero_description' => htmlspecialchars($request->hero_description ?? '', ENT_QUOTES),
            'button_name' => $request->button_name,
            'button_link' => $request->button_link,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => htmlspecialchars($request->meta_description ?? '', ENT_QUOTES),
        ];
    }

    private function storeAccommodationImages(Request $request, Accommodation $accommodation): void
    {
        if ($request->hasFile('listing_image')) {
            $accommodation->listing_image = $this->storeImage($request->file('listing_image'), 'images/accommodations/', $accommodation->listing_image);
        }
        if ($request->hasFile('hero_image')) {
            $accommodation->hero_image = $this->storeImage($request->file('hero_image'), 'images/accommodations/', $accommodation->hero_image);
        }
        $accommodation->save();
    }

    private function loadSections(int $accommodationId)
    {
        return AccommodationSection::where('accommodation_id', $accommodationId)
            ->whereNull('parent_id')
            ->with(['subsections' => fn ($q) => $q->orderBy('position_order')])
            ->get()
            ->keyBy('default_section_name');
    }

    private function saveSectionsFromRequest(int $accommodationId, Request $request): void
    {
        $sections = $this->loadSections($accommodationId);
        $input = $request->input('sections', []);

        $this->updateParent($sections->get('overview'), $accommodationId, 'overview', [
            'section_title' => $input['overview']['section_title'] ?? null,
            'section_headline' => $input['overview']['section_headline'] ?? null,
            'description' => htmlspecialchars($input['overview']['description'] ?? '', ENT_QUOTES),
        ]);
        $this->syncRepeater($sections->get('overview'), $accommodationId, $input['overview']['stats'] ?? [], function ($row, $index, $order) {
            return [
                'section_headline' => $row['value'] ?? '',
                'section_subheading' => $row['label'] ?? '',
                'position_order' => $order,
            ];
        }, $request);

        $this->updateParent($sections->get('features'), $accommodationId, 'features', [
            'section_title' => $input['features']['section_title'] ?? null,
            'section_headline' => $input['features']['section_headline'] ?? null,
        ]);
        $this->syncRepeater($sections->get('features'), $accommodationId, $input['features']['items'] ?? [], function ($row, $index, $order) use ($request) {
            return [
                'section_headline' => $row['title'] ?? '',
                'description' => htmlspecialchars($row['desc'] ?? '', ENT_QUOTES),
                'section_image' => $this->resolveRowImage($request, "sections.features.items.{$index}.icon", $row['existing_icon'] ?? null),
                'position_order' => $order,
            ];
        }, $request, 'sections.features.items');

        $inclusionsParent = $this->updateParent($sections->get('inclusions'), $accommodationId, 'inclusions', [
            'section_title' => $input['inclusions']['section_title'] ?? null,
            'section_headline' => $input['inclusions']['section_headline'] ?? null,
            'section_image' => $this->resolveRowImage($request, 'sections.inclusions.section_image', $sections->get('inclusions')?->section_image),
        ]);
        $this->syncRepeater($inclusionsParent, $accommodationId, $input['inclusions']['items'] ?? [], function ($row, $index, $order) {
            return [
                'section_headline' => $row['text'] ?? '',
                'section_subheading' => ($row['type'] ?? 'yes') === 'no' ? 'no' : 'yes',
                'position_order' => $order,
            ];
        }, $request);

        $this->updateParent($sections->get('tariff'), $accommodationId, 'tariff', [
            'section_title' => $input['tariff']['section_title'] ?? null,
            'section_headline' => $input['tariff']['section_headline'] ?? null,
            'description' => htmlspecialchars($input['tariff']['description'] ?? '', ENT_QUOTES),
            'section_subtitle' => $input['tariff']['note'] ?? null,
        ]);
        $this->syncRepeater($sections->get('tariff'), $accommodationId, $input['tariff']['rows'] ?? [], function ($row, $index, $order) {
            return [
                'section_headline' => $row['occupancy'] ?? '',
                'section_subtitle' => $row['weekday'] ?? '',
                'section_subheading' => $row['weekend'] ?? '',
                'description' => htmlspecialchars($row['extra'] ?? '', ENT_QUOTES),
                'position_order' => $order,
            ];
        }, $request);

        $this->updateParent($sections->get('policies'), $accommodationId, 'policies', [
            'section_title' => $input['policies']['section_title'] ?? null,
            'section_headline' => $input['policies']['section_headline'] ?? null,
        ]);
        $this->syncRepeater($sections->get('policies'), $accommodationId, $input['policies']['items'] ?? [], function ($row, $index, $order) {
            return [
                'section_headline' => $row['title'] ?? '',
                'description' => htmlspecialchars($row['desc'] ?? '', ENT_QUOTES),
                'position_order' => $order,
            ];
        }, $request);

        $this->updateParent($sections->get('other_stays'), $accommodationId, 'other_stays', [
            'section_title' => $input['other_stays']['section_title'] ?? null,
            'section_headline' => $input['other_stays']['section_headline'] ?? null,
        ]);
        $this->syncRepeater($sections->get('other_stays'), $accommodationId, $input['other_stays']['items'] ?? [], function ($row, $index, $order) use ($request) {
            return [
                'section_headline' => $row['title'] ?? '',
                'section_subheading' => $row['tag'] ?? '',
                'button_link' => $row['link'] ?? '',
                'section_image' => $this->resolveRowImage($request, "sections.other_stays.items.{$index}.image", $row['existing_image'] ?? null),
                'position_order' => $order,
            ];
        }, $request, 'sections.other_stays.items');

        $this->updateParent($sections->get('accom_cta'), $accommodationId, 'accom_cta', [
            'section_headline' => $input['accom_cta']['section_headline'] ?? null,
            'description' => htmlspecialchars($input['accom_cta']['description'] ?? '', ENT_QUOTES),
            'button_name' => $input['accom_cta']['button_name'] ?? null,
            'button_link' => $input['accom_cta']['button_link'] ?? null,
        ]);

        $galleryParent = $sections->get('gallery') ?? $this->createParent($accommodationId, 'gallery', 2);
        $this->syncRepeater($galleryParent, $accommodationId, $input['gallery']['items'] ?? [], function ($row, $index, $order) use ($request) {
            return [
                'section_headline' => $row['caption'] ?? '',
                'section_subheading' => $row['type'] ?? 'thumb',
                'section_image' => $this->resolveRowImage($request, "sections.gallery.items.{$index}.image", $row['existing_image'] ?? null),
                'position_order' => $order,
            ];
        }, $request, 'sections.gallery.items');
    }

    private function updateParent(?AccommodationSection $section, int $accommodationId, string $key, array $data): AccommodationSection
    {
        $section = $section ?? $this->createParent($accommodationId, $key, array_search($key, self::SECTION_KEYS) + 1);
        $section->fill(array_filter($data, fn ($v) => $v !== null));
        $section->status = 'active';
        $section->save();

        return $section;
    }

    private function createParent(int $accommodationId, string $key, int $order): AccommodationSection
    {
        return AccommodationSection::create([
            'accommodation_id' => $accommodationId,
            'default_section_name' => $key,
            'parent_id' => null,
            'position_order' => $order,
            'status' => 'active',
        ]);
    }

    private function syncRepeater(?AccommodationSection $parent, int $accommodationId, array $rows, callable $mapper, ?Request $request = null, ?string $filePrefix = null): void
    {
        if (!$parent) {
            return;
        }

        $keptIds = [];
        $order = 0;

        foreach ($rows as $index => $row) {
            $fileKey = $filePrefix ? "{$filePrefix}.{$index}.image" : null;
            $iconKey = $filePrefix === 'sections.features.items' ? "{$filePrefix}.{$index}.icon" : null;

            if ($this->isEmptyRow($row, $request, $fileKey, $iconKey)) {
                continue;
            }

            $order++;
            $data = array_merge($mapper($row, $index, $order), [
                'accommodation_id' => $accommodationId,
                'parent_id' => $parent->id,
                'status' => 'active',
            ]);

            if (!empty($row['id'])) {
                $existing = AccommodationSection::where('id', $row['id'])
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

            $created = AccommodationSection::create($data);
            $keptIds[] = $created->id;
        }

        AccommodationSection::where('parent_id', $parent->id)
            ->whereNotIn('id', $keptIds)
            ->delete();
    }

    private function isEmptyRow(array $row, ?Request $request = null, ?string $imageKey = null, ?string $iconKey = null): bool
    {
        if ($request && $imageKey && $request->hasFile($imageKey)) {
            return false;
        }
        if ($request && $iconKey && $request->hasFile($iconKey)) {
            return false;
        }
        if (!empty($row['existing_image']) || !empty($row['existing_icon'])) {
            return false;
        }

        unset($row['id'], $row['existing_image'], $row['existing_icon'], $row['type']);
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
            return $this->storeImage($request->file($fileKey), 'images/accommodations/sections/', $existing);
        }

        return $existing;
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $slug = Str::slug($value);
        $original = $slug;
        $suffix = 1;

        while (true) {
            $query = Accommodation::where('slug', $slug);
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

    private function parseAmenities(?string $raw): ?array
    {
        if (!$raw) {
            return null;
        }

        $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $raw)));

        return array_map(fn ($label) => ['label' => $label], $lines);
    }

    private function seedDefaultSections(int $accommodationId): void
    {
        foreach (self::SECTION_KEYS as $index => $name) {
            AccommodationSection::firstOrCreate(
                [
                    'accommodation_id' => $accommodationId,
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
