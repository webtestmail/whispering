@php
    $s = fn(string $key) => $sections[$key] ?? null;
    $decode = fn($section, string $field) => $section && filled($section->{$field}) ? htmlspecialchars_decode($section->{$field}) : '';
    $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
@endphp

{{-- Editorial --}}
@php $editorial = $s('editorial'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Editorial Section</h6></div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Pull Quote</label>
            <textarea name="sections[editorial][quote]" class="form-control" rows="2">{{ old('sections.editorial.quote', $editorial?->section_headline ?? '') }}</textarea>
        </div>
        <label class="form-label">Paragraphs</label>
        <div id="editorial-paragraphs-list">
            @forelse(($editorial?->subsections ?? collect()) as $i => $para)
            <div class="mb-2" data-repeater-item>
                <input type="hidden" name="sections[editorial][paragraphs][{{ $i }}][id]" value="{{ $para->id }}">
                <div class="input-group">
                    <textarea name="sections[editorial][paragraphs][{{ $i }}][text]" class="form-control" rows="2">{{ htmlspecialchars_decode($para->description) }}</textarea>
                    <button type="button" class="btn btn-light-danger" data-repeater-remove>Remove</button>
                </div>
            </div>
            @empty
            @for($i = 0; $i < 3; $i++)
            <div class="mb-2" data-repeater-item>
                <div class="input-group">
                    <textarea name="sections[editorial][paragraphs][{{ $i }}][text]" class="form-control" rows="2"></textarea>
                    <button type="button" class="btn btn-light-danger" data-repeater-remove>Remove</button>
                </div>
            </div>
            @endfor
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand mt-2" data-repeater-add data-target="#editorial-paragraphs-list" data-template="#tpl-editorial-para">+ Add Paragraph</button>
    </div>
</div>

{{-- What To Expect --}}
@php $expect = $s('what_to_expect'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">What To Expect</h6></div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Section Heading</label>
            <input type="text" name="sections[what_to_expect][section_headline]" class="form-control" value="{{ old('sections.what_to_expect.section_headline', $expect?->section_headline ?? 'What To Expect') }}">
        </div>
        <div id="expect-items-list">
            @forelse(($expect?->subsections ?? collect()) as $i => $item)
            <div class="row g-2 mb-2 align-items-end" data-repeater-item>
                <input type="hidden" name="sections[what_to_expect][items][{{ $i }}][id]" value="{{ $item->id }}">
                <div class="col-md-5"><input type="text" name="sections[what_to_expect][items][{{ $i }}][label]" class="form-control" placeholder="Label" value="{{ $item->section_subheading }}"></div>
                <div class="col-md-5"><input type="text" name="sections[what_to_expect][items][{{ $i }}][value]" class="form-control" placeholder="Value" value="{{ $item->section_headline }}"></div>
                <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
            </div>
            @empty
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand mt-2" data-repeater-add data-target="#expect-items-list" data-template="#tpl-expect-item">+ Add Item</button>
    </div>
</div>

{{-- Activities --}}
@php $activities = $s('activities'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Activities Section</h6></div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-6"><label class="form-label">Heading</label><input type="text" name="sections[activities][section_headline]" class="form-control" value="{{ old('sections.activities.section_headline', $activities?->section_headline ?? '') }}"></div>
            <div class="col-md-6"><label class="form-label">Subheading</label><input type="text" name="sections[activities][section_subtitle]" class="form-control" value="{{ old('sections.activities.section_subtitle', $activities?->section_subtitle ?? '') }}"></div>
        </div>
        <div id="activities-items-list">
            @forelse(($activities?->subsections ?? collect()) as $i => $item)
            <div class="border rounded p-3 mb-3" data-repeater-item>
                <input type="hidden" name="sections[activities][items][{{ $i }}][id]" value="{{ $item->id }}">
                <input type="hidden" name="sections[activities][items][{{ $i }}][existing_image]" value="{{ $item->section_image }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3"><label class="form-label">Image</label><input type="file" name="sections[activities][items][{{ $i }}][image]" class="form-control" accept="image/*">@if($item->section_image)<img src="{{ asset($item->section_image) }}" class="mt-2 rounded" width="80">@endif</div>
                    <div class="col-md-3"><label class="form-label">Title</label><input type="text" name="sections[activities][items][{{ $i }}][title]" class="form-control" value="{{ $item->section_headline }}"></div>
                    <div class="col-md-4"><label class="form-label">Description</label><textarea name="sections[activities][items][{{ $i }}][desc]" class="form-control" rows="2">{{ htmlspecialchars_decode($item->description) }}</textarea></div>
                    <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand" data-repeater-add data-target="#activities-items-list" data-template="#tpl-activity-item">+ Add Activity</button>
    </div>
</div>

{{-- Day Timeline --}}
@php $timeline = $s('day_timeline'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">A Day Here (Timeline)</h6></div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-6"><label class="form-label">Heading</label><input type="text" name="sections[day_timeline][section_headline]" class="form-control" value="{{ old('sections.day_timeline.section_headline', $timeline?->section_headline ?? '') }}"></div>
            <div class="col-md-6"><label class="form-label">Subheading</label><input type="text" name="sections[day_timeline][section_subtitle]" class="form-control" value="{{ old('sections.day_timeline.section_subtitle', $timeline?->section_subtitle ?? '') }}"></div>
        </div>
        <div id="timeline-items-list">
            @forelse(($timeline?->subsections ?? collect()) as $i => $item)
            <div class="border rounded p-3 mb-3" data-repeater-item>
                <input type="hidden" name="sections[day_timeline][items][{{ $i }}][id]" value="{{ $item->id }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-2"><label class="form-label">Time</label><input type="text" name="sections[day_timeline][items][{{ $i }}][time]" class="form-control" value="{{ $item->section_subtitle }}" placeholder="6:30 AM"></div>
                    <div class="col-md-3"><label class="form-label">Title</label><input type="text" name="sections[day_timeline][items][{{ $i }}][title]" class="form-control" value="{{ $item->section_headline }}"></div>
                    <div class="col-md-5"><label class="form-label">Description</label><textarea name="sections[day_timeline][items][{{ $i }}][desc]" class="form-control" rows="2">{{ htmlspecialchars_decode($item->description) }}</textarea></div>
                    <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand" data-repeater-add data-target="#timeline-items-list" data-template="#tpl-timeline-item">+ Add Timeline Item</button>
    </div>
</div>

{{-- Best Months --}}
@php $bestMonths = $s('best_months'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Best Time To Visit (Month Strip)</h6></div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Section Heading</label>
            <input type="text" name="sections[best_months][section_headline]" class="form-control" value="{{ old('sections.best_months.section_headline', $bestMonths?->section_headline ?? 'Best Time To Visit') }}">
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead><tr><th>Month</th><th>Status</th></tr></thead>
                <tbody id="months-items-list">
                    @php
                        $existingMonths = ($bestMonths?->subsections ?? collect())->keyBy('section_subheading');
                    @endphp
                    @foreach($monthNames as $i => $month)
                    @php $item = $existingMonths->get($month); @endphp
                    <tr data-repeater-item>
                        @if($item)<input type="hidden" name="sections[best_months][items][{{ $i }}][id]" value="{{ $item->id }}">@endif
                        <td>
                            <input type="hidden" name="sections[best_months][items][{{ $i }}][month]" value="{{ $month }}">
                            {{ $month }}
                        </td>
                        <td>
                            <select name="sections[best_months][items][{{ $i }}][status]" class="form-select">
                                @foreach(['off' => 'Off Season', 'partial' => 'Shoulder', 'active' => 'Good', 'peak' => 'Peak Season'] as $val => $label)
                                <option value="{{ $val }}" {{ old("sections.best_months.items.{$i}.status", $item?->section_subtitle ?? 'off') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Gallery --}}
@php $gallery = $s('gallery'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Gallery Section</h6></div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-6"><label class="form-label">Heading</label><input type="text" name="sections[gallery][section_headline]" class="form-control" value="{{ old('sections.gallery.section_headline', $gallery?->section_headline ?? '') }}"></div>
            <div class="col-md-6"><label class="form-label">Subheading</label><input type="text" name="sections[gallery][section_subtitle]" class="form-control" value="{{ old('sections.gallery.section_subtitle', $gallery?->section_subtitle ?? '') }}"></div>
        </div>
        <p class="text-muted small">Layout: <strong>default</strong>, <strong>tall</strong>, <strong>wide</strong>, or <strong>tall-sm</strong></p>
        <div id="gallery-items-list">
            @forelse(($gallery?->subsections ?? collect()) as $i => $item)
            <div class="border rounded p-3 mb-3" data-repeater-item>
                <input type="hidden" name="sections[gallery][items][{{ $i }}][id]" value="{{ $item->id }}">
                <input type="hidden" name="sections[gallery][items][{{ $i }}][existing_image]" value="{{ $item->section_image }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3"><label class="form-label">Image</label><input type="file" name="sections[gallery][items][{{ $i }}][image]" class="form-control" accept="image/*">@if($item->section_image)<img src="{{ asset($item->section_image) }}" class="mt-2 rounded" width="80">@endif</div>
                    <div class="col-md-4"><label class="form-label">Caption</label><input type="text" name="sections[gallery][items][{{ $i }}][caption]" class="form-control" value="{{ $item->section_headline }}"></div>
                    <div class="col-md-3"><label class="form-label">Layout</label><select name="sections[gallery][items][{{ $i }}][layout]" class="form-select">
                        @foreach(['default', 'tall', 'wide', 'tall-sm'] as $layout)
                        <option value="{{ $layout }}" {{ strtolower($item->section_subheading ?? 'default') === $layout ? 'selected' : '' }}>{{ $layout }}</option>
                        @endforeach
                    </select></div>
                    <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand" data-repeater-add data-target="#gallery-items-list" data-template="#tpl-exp-gallery-item">+ Add Gallery Image</button>
    </div>
</div>

{{-- Booking Sidebar --}}
@php $booking = $s('booking_sidebar'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Booking Sidebar</h6></div>
    <div class="card-body row g-3">
        <div class="col-md-4"><label class="form-label">Tag</label><input type="text" name="sections[booking_sidebar][tag]" class="form-control" value="{{ old('sections.booking_sidebar.tag', $booking?->section_subheading ?? '') }}" placeholder="Summer Stay"></div>
        <div class="col-md-8"><label class="form-label">Title</label><input type="text" name="sections[booking_sidebar][title]" class="form-control" value="{{ old('sections.booking_sidebar.title', $booking?->section_headline ?? 'Plan Your Visit') }}"></div>
        <div class="col-12"><label class="form-label">Subtitle</label><textarea name="sections[booking_sidebar][subtitle]" class="form-control" rows="2">{{ old('sections.booking_sidebar.subtitle', $decode($booking, 'description')) }}</textarea></div>
    </div>
</div>

{{-- CTA --}}
@php $cta = $s('exp_cta'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Bottom CTA Section</h6></div>
    <div class="card-body row g-3">
        <div class="col-12"><label class="form-label">Headline</label><input type="text" name="sections[exp_cta][section_headline]" class="form-control" value="{{ old('sections.exp_cta.section_headline', $cta?->section_headline ?? '') }}"></div>
        <div class="col-12"><label class="form-label">Description</label><textarea name="sections[exp_cta][description]" class="form-control" rows="3">{{ old('sections.exp_cta.description', $decode($cta, 'description')) }}</textarea></div>
        <div class="col-md-6"><label class="form-label">Button Text</label><input type="text" name="sections[exp_cta][button_name]" class="form-control" value="{{ old('sections.exp_cta.button_name', $cta?->button_name ?? 'Enquire Now') }}"></div>
        <div class="col-md-6"><label class="form-label">Button Link</label><input type="text" name="sections[exp_cta][button_link]" class="form-control" value="{{ old('sections.exp_cta.button_link', $cta?->button_link ?? route('enquire')) }}"></div>
    </div>
</div>

<template id="tpl-editorial-para">
    <div class="mb-2" data-repeater-item>
        <div class="input-group">
            <textarea name="sections[editorial][paragraphs][0][text]" class="form-control" rows="2"></textarea>
            <button type="button" class="btn btn-light-danger" data-repeater-remove>Remove</button>
        </div>
    </div>
</template>
<template id="tpl-expect-item">
    <div class="row g-2 mb-2 align-items-end" data-repeater-item>
        <div class="col-md-5"><input type="text" name="sections[what_to_expect][items][0][label]" class="form-control" placeholder="Label"></div>
        <div class="col-md-5"><input type="text" name="sections[what_to_expect][items][0][value]" class="form-control" placeholder="Value"></div>
        <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
    </div>
</template>
<template id="tpl-activity-item">
    <div class="border rounded p-3 mb-3" data-repeater-item>
        <div class="row g-3 align-items-end">
            <div class="col-md-3"><label class="form-label">Image</label><input type="file" name="sections[activities][items][0][image]" class="form-control" accept="image/*"></div>
            <div class="col-md-3"><label class="form-label">Title</label><input type="text" name="sections[activities][items][0][title]" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Description</label><textarea name="sections[activities][items][0][desc]" class="form-control" rows="2"></textarea></div>
            <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
        </div>
    </div>
</template>
<template id="tpl-timeline-item">
    <div class="border rounded p-3 mb-3" data-repeater-item>
        <div class="row g-3 align-items-end">
            <div class="col-md-2"><label class="form-label">Time</label><input type="text" name="sections[day_timeline][items][0][time]" class="form-control" placeholder="6:30 AM"></div>
            <div class="col-md-3"><label class="form-label">Title</label><input type="text" name="sections[day_timeline][items][0][title]" class="form-control"></div>
            <div class="col-md-5"><label class="form-label">Description</label><textarea name="sections[day_timeline][items][0][desc]" class="form-control" rows="2"></textarea></div>
            <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
        </div>
    </div>
</template>
<template id="tpl-exp-gallery-item">
    <div class="border rounded p-3 mb-3" data-repeater-item>
        <div class="row g-3 align-items-end">
            <div class="col-md-3"><label class="form-label">Image</label><input type="file" name="sections[gallery][items][0][image]" class="form-control" accept="image/*"></div>
            <div class="col-md-4"><label class="form-label">Caption</label><input type="text" name="sections[gallery][items][0][caption]" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Layout</label><select name="sections[gallery][items][0][layout]" class="form-select"><option value="default">default</option><option value="tall">tall</option><option value="wide">wide</option><option value="tall-sm">tall-sm</option></select></div>
            <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
        </div>
    </div>
</template>
