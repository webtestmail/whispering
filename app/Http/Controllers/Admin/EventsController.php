<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Event;
use App\Models\Admin\EventSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class EventsController extends Controller
{
    private const SECTION_KEYS = [
        'event_intro', 'event_stats', 'event_highlights', 'event_experiences', 'event_cta',
    ];

    public function manageEvents()
    {
        return view('admin.manage_events', [
            'currentPageName' => 'Events',
            'currentPageData' => 'event',
            'addNewData' => 'admin.add.event',
            'deleteUrl' => 'admin.event.delete',
        ]);
    }

    public function event_data(Request $request)
    {
        $data = Event::orderBy('position_order')->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('listing_image', function ($row) {
                if (!$row->listing_image) {
                    return '-';
                }

                return '<img src="' . asset($row->listing_image) . '" width="60" height="50" class="rounded">';
            })
            ->addColumn('is_active', fn ($row) => $row->status === 'active' ? 'Active' : 'Inactive')
            ->addColumn('created_at', fn ($row) => $row->created_at ? $row->created_at->format('d M Y') : '-')
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.edit.event', Crypt::encrypt($row->id));
                $deleteId = Crypt::encrypt($row->id);

                return '<div class="dropdown">
                    <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                        <i class="feather-more-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="' . $editUrl . '" class="dropdown-item">Edit</a>
                        <button class="dropdown-item delete" data-id="' . $deleteId . '" data-model="Event">Delete</button>
                    </div>
                </div>';
            })
            ->rawColumns(['listing_image', 'action'])
            ->make(true);
    }

    public function event_delete(Request $request)
    {
        $request->validate(['id' => 'required', 'model' => 'required']);

        try {
            $id = Crypt::decrypt($request->id);
            EventSection::where('event_id', $id)->delete();
            Event::findOrFail($id)->delete();

            return response()->json(['success' => true, 'message' => 'Event deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Invalid ID or event not found.'], 400);
        }
    }

    public function addEvent(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate(['title' => 'required|string', 'slug' => 'nullable|string']);

            $order = Event::max('position_order');
            $event = Event::create($this->eventFields($request, ($order !== null) ? $order + 1 : 1));

            $this->storeEventImages($request, $event);
            $this->seedDefaultSections($event->id);

            return redirect()
                ->route('admin.edit.event', Crypt::encrypt($event->id))
                ->with('success', 'Event created. Fill in the detail sections below and save.');
        }

        return view('admin.event-ops', [
            'currentPageName' => 'Event',
            'allData' => 'admin.manage_events',
        ]);
    }

    public function editEvent(Request $request, $event)
    {
        $id = Crypt::decrypt($event);
        $item = Event::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate(['title' => 'required|string', 'slug' => 'nullable|string']);

            $item->fill($this->eventFields($request, $item->position_order));
            $this->storeEventImages($request, $item);
            $item->save();

            $this->saveSectionsFromRequest($id, $request);

            return redirect()
                ->route('admin.edit.event', $event)
                ->with('success', 'Event saved successfully.');
        }

        $item->encrypted_id = $event;
        $this->seedDefaultSections($id);

        return view('admin.event-ops', [
            'event' => $item,
            'sections' => $this->loadSections($id),
            'currentPageName' => 'Event',
            'allData' => 'admin.manage_events',
        ]);
    }

    private function eventFields(Request $request, int $positionOrder): array
    {
        return [
            'position_order' => $request->filled('position_order') ? (int) $request->position_order : $positionOrder,
            'slug' => $this->uniqueSlug($request->slug ?: $request->title, $request->route('event') ? Crypt::decrypt($request->route('event')) : null),
            'status' => $request->status ?? 'active',
            'title' => $request->title,
            'listing_description' => htmlspecialchars($request->listing_description ?? '', ENT_QUOTES),
            'link_text' => $request->link_text,
            'hero_subtitle' => $request->hero_subtitle,
            'hero_description' => htmlspecialchars($request->hero_description ?? '', ENT_QUOTES),
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => htmlspecialchars($request->meta_description ?? '', ENT_QUOTES),
        ];
    }

    private function storeEventImages(Request $request, Event $event): void
    {
        if ($request->hasFile('listing_image')) {
            $event->listing_image = $this->storeImage($request->file('listing_image'), 'images/events/', $event->listing_image);
        }
        if ($request->hasFile('hero_image')) {
            $event->hero_image = $this->storeImage($request->file('hero_image'), 'images/events/', $event->hero_image);
        }
        $event->save();
    }

    private function loadSections(int $eventId)
    {
        return EventSection::where('event_id', $eventId)
            ->whereNull('parent_id')
            ->with(['subsections' => fn ($q) => $q->orderBy('position_order')])
            ->get()
            ->keyBy('default_section_name');
    }

    private function saveSectionsFromRequest(int $eventId, Request $request): void
    {
        $sections = $this->loadSections($eventId);
        $input = $request->input('sections', []);

        $intro = $this->updateParent($sections->get('event_intro'), $eventId, 'event_intro', [
            'section_subtitle' => $input['event_intro']['section_subtitle'] ?? null,
            'section_headline' => $input['event_intro']['section_headline'] ?? null,
            'section_image' => $this->resolveSectionImage(
                $request,
                'sections.event_intro.image',
                $input['event_intro']['existing_image'] ?? null,
                $sections->get('event_intro')?->section_image
            ),
        ]);
        $this->syncRepeater($intro, $eventId, $input['event_intro']['paragraphs'] ?? [], function ($row, $index, $order) {
            return [
                'description' => htmlspecialchars($row['text'] ?? '', ENT_QUOTES),
                'position_order' => $order,
            ];
        }, $request);

        $stats = $this->updateParent($sections->get('event_stats'), $eventId, 'event_stats', []);
        $this->syncRepeater($stats, $eventId, $input['event_stats']['items'] ?? [], function ($row, $index, $order) {
            return [
                'section_headline' => $row['value'] ?? '',
                'section_subheading' => $row['label'] ?? '',
                'position_order' => $order,
            ];
        }, $request);

        $highlights = $this->updateParent($sections->get('event_highlights'), $eventId, 'event_highlights', [
            'section_subtitle' => $input['event_highlights']['section_subtitle'] ?? null,
            'section_headline' => $input['event_highlights']['section_headline'] ?? null,
        ]);
        $this->syncRepeater($highlights, $eventId, $input['event_highlights']['items'] ?? [], function ($row, $index, $order) {
            return [
                'section_headline' => $row['title'] ?? '',
                'description' => htmlspecialchars($row['desc'] ?? '', ENT_QUOTES),
                'position_order' => $order,
            ];
        }, $request);

        $experiences = $this->updateParent($sections->get('event_experiences'), $eventId, 'event_experiences', [
            'section_subtitle' => $input['event_experiences']['section_subtitle'] ?? null,
            'section_headline' => $input['event_experiences']['section_headline'] ?? null,
        ]);
        $this->syncRepeater($experiences, $eventId, $input['event_experiences']['items'] ?? [], function ($row, $index, $order) use ($request) {
            return [
                'section_headline' => $row['title'] ?? '',
                'description' => htmlspecialchars($row['desc'] ?? '', ENT_QUOTES),
                'section_image' => $this->resolveRowImage($request, "sections.event_experiences.items.{$index}.image", $row['existing_image'] ?? null),
                'position_order' => $order,
            ];
        }, $request, 'sections.event_experiences.items');

        $this->updateParent($sections->get('event_cta'), $eventId, 'event_cta', [
            'section_headline' => $input['event_cta']['section_headline'] ?? null,
            'description' => htmlspecialchars($input['event_cta']['description'] ?? '', ENT_QUOTES),
            'button_name' => $input['event_cta']['button_name'] ?? null,
            'button_link' => $input['event_cta']['button_link'] ?? null,
        ]);
    }

    private function updateParent(?EventSection $section, int $eventId, string $key, array $data): EventSection
    {
        $section = $section ?? $this->createParent($eventId, $key, array_search($key, self::SECTION_KEYS) + 1);
        $section->fill(array_filter($data, fn ($v) => $v !== null));
        $section->status = 'active';
        $section->save();

        return $section;
    }

    private function createParent(int $eventId, string $key, int $order): EventSection
    {
        return EventSection::create([
            'event_id' => $eventId,
            'default_section_name' => $key,
            'parent_id' => null,
            'position_order' => $order,
            'status' => 'active',
        ]);
    }

    private function syncRepeater(?EventSection $parent, int $eventId, array $rows, callable $mapper, ?Request $request = null, ?string $filePrefix = null): void
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
                'event_id' => $eventId,
                'parent_id' => $parent->id,
                'status' => 'active',
            ]);

            if (!empty($row['id'])) {
                $existing = EventSection::where('id', $row['id'])
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

            $created = EventSection::create($data);
            $keptIds[] = $created->id;
        }

        EventSection::where('parent_id', $parent->id)
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

        unset($row['id'], $row['existing_image']);
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
            return $this->storeImage($request->file($fileKey), 'images/events/sections/', $existing);
        }

        return $existing;
    }

    private function resolveSectionImage(Request $request, string $fileKey, ?string $inputExisting, ?string $current): ?string
    {
        if ($request->hasFile($fileKey)) {
            return $this->storeImage($request->file($fileKey), 'images/events/sections/', $current);
        }

        return $inputExisting ?? $current;
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $slug = Str::slug($value);
        $original = $slug;
        $suffix = 1;

        while (true) {
            $query = Event::where('slug', $slug);
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

    private function seedDefaultSections(int $eventId): void
    {
        foreach (self::SECTION_KEYS as $index => $name) {
            EventSection::firstOrCreate(
                [
                    'event_id' => $eventId,
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
