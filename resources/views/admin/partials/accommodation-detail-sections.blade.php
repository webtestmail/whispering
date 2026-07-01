@php
    $s = fn(string $key) => $sections[$key] ?? null;
    $decode = fn($section, string $field) => $section && filled($section->{$field}) ? htmlspecialchars_decode($section->{$field}) : '';
@endphp

{{-- Overview --}}
@php $overview = $s('overview'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Overview Section</h6></div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4"><label class="form-label">Subtitle</label><input type="text" name="sections[overview][section_title]" class="form-control" value="{{ old('sections.overview.section_title', $overview?->section_title ?? 'Overview') }}"></div>
            <div class="col-md-8"><label class="form-label">Headline</label><input type="text" name="sections[overview][section_headline]" class="form-control" value="{{ old('sections.overview.section_headline', $overview?->section_headline ?? '') }}"></div>
            <div class="col-12"><label class="form-label">Description</label><textarea name="sections[overview][description]" class="form-control" rows="4">{{ old('sections.overview.description', $decode($overview, 'description')) }}</textarea></div>
        </div>
        <label class="form-label">Stats (value + label)</label>
        <div data-repeater-list="overview-stats">
            <div id="overview-stats-list">
                @forelse(($overview?->subsections ?? collect()) as $i => $stat)
                <div class="row g-2 mb-2 align-items-end" data-repeater-item>
                    <input type="hidden" name="sections[overview][stats][{{ $i }}][id]" value="{{ $stat->id }}">
                    <div class="col-md-5"><input type="text" name="sections[overview][stats][{{ $i }}][value]" class="form-control" placeholder="Value (e.g. 8)" value="{{ $stat->section_headline }}"></div>
                    <div class="col-md-5"><input type="text" name="sections[overview][stats][{{ $i }}][label]" class="form-control" placeholder="Label (e.g. Total Units)" value="{{ $stat->section_subheading }}"></div>
                    <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
                </div>
                @empty
                @for($i = 0; $i < 4; $i++)
                <div class="row g-2 mb-2 align-items-end" data-repeater-item>
                    <div class="col-md-5"><input type="text" name="sections[overview][stats][{{ $i }}][value]" class="form-control" placeholder="Value"></div>
                    <div class="col-md-5"><input type="text" name="sections[overview][stats][{{ $i }}][label]" class="form-control" placeholder="Label"></div>
                    <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
                </div>
                @endfor
                @endforelse
            </div>
            <button type="button" class="btn btn-sm btn-light-brand mt-2" data-repeater-add data-target="#overview-stats-list" data-template="#tpl-overview-stat">+ Add Stat</button>
        </div>
    </div>
</div>

{{-- Gallery --}}
@php $gallery = $s('gallery'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Gallery Section</h6></div>
    <div class="card-body">
        <p class="text-muted small">Add images with caption. Set type to <strong>main</strong>, <strong>thumb</strong>, or <strong>more</strong> (last tile).</p>
        <div id="gallery-items-list">
            @forelse(($gallery?->subsections ?? collect()) as $i => $item)
            <div class="border rounded p-3 mb-3" data-repeater-item>
                <input type="hidden" name="sections[gallery][items][{{ $i }}][id]" value="{{ $item->id }}">
                <input type="hidden" name="sections[gallery][items][{{ $i }}][existing_image]" value="{{ $item->section_image }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3"><label class="form-label">Image</label><input type="file" name="sections[gallery][items][{{ $i }}][image]" class="form-control" accept="image/*">@if($item->section_image)<img src="{{ asset($item->section_image) }}" class="mt-2 rounded" width="80">@endif</div>
                    <div class="col-md-4"><label class="form-label">Caption</label><input type="text" name="sections[gallery][items][{{ $i }}][caption]" class="form-control" value="{{ $item->section_headline }}"></div>
                    <div class="col-md-3"><label class="form-label">Type</label><select name="sections[gallery][items][{{ $i }}][type]" class="form-select"><option value="main" {{ strtolower($item->section_subheading ?? '') === 'main' ? 'selected' : '' }}>Main</option><option value="thumb" {{ strtolower($item->section_subheading ?? 'thumb') === 'thumb' ? 'selected' : '' }}>Thumb</option><option value="more" {{ strtolower($item->section_subheading ?? '') === 'more' ? 'selected' : '' }}>More</option></select></div>
                    <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
                </div>
            </div>
            @empty
            <div class="border rounded p-3 mb-3" data-repeater-item>
                <div class="row g-3 align-items-end">
                    <div class="col-md-3"><label class="form-label">Image</label><input type="file" name="sections[gallery][items][0][image]" class="form-control" accept="image/*"></div>
                    <div class="col-md-4"><label class="form-label">Caption</label><input type="text" name="sections[gallery][items][0][caption]" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Type</label><select name="sections[gallery][items][0][type]" class="form-select"><option value="main">Main</option><option value="thumb" selected>Thumb</option><option value="more">More</option></select></div>
                    <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
                </div>
            </div>
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand" data-repeater-add data-target="#gallery-items-list" data-template="#tpl-gallery-item">+ Add Gallery Image</button>
    </div>
</div>

{{-- Features --}}
@php $features = $s('features'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Features & Amenities Section</h6></div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4"><label class="form-label">Subtitle</label><input type="text" name="sections[features][section_title]" class="form-control" value="{{ old('sections.features.section_title', $features?->section_title ?? 'Inside Your Tent') }}"></div>
            <div class="col-md-8"><label class="form-label">Headline</label><input type="text" name="sections[features][section_headline]" class="form-control" value="{{ old('sections.features.section_headline', $features?->section_headline ?? '') }}"></div>
        </div>
        <div id="features-items-list">
            @forelse(($features?->subsections ?? collect()) as $i => $item)
            <div class="border rounded p-3 mb-3" data-repeater-item>
                <input type="hidden" name="sections[features][items][{{ $i }}][id]" value="{{ $item->id }}">
                <input type="hidden" name="sections[features][items][{{ $i }}][existing_icon]" value="{{ $item->section_image }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3"><label class="form-label">Icon Image</label><input type="file" name="sections[features][items][{{ $i }}][icon]" class="form-control" accept="image/*">@if($item->section_image)<img src="{{ asset($item->section_image) }}" class="mt-2 rounded" width="40">@endif</div>
                    <div class="col-md-3"><label class="form-label">Title</label><input type="text" name="sections[features][items][{{ $i }}][title]" class="form-control" value="{{ $item->section_headline }}"></div>
                    <div class="col-md-4"><label class="form-label">Description</label><input type="text" name="sections[features][items][{{ $i }}][desc]" class="form-control" value="{{ htmlspecialchars_decode($item->description) }}"></div>
                    <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand" data-repeater-add data-target="#features-items-list" data-template="#tpl-feature-item">+ Add Feature</button>
    </div>
</div>

{{-- Inclusions --}}
@php $inclusions = $s('inclusions'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Inclusions Section</h6></div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4"><label class="form-label">Subtitle</label><input type="text" name="sections[inclusions][section_title]" class="form-control" value="{{ old('sections.inclusions.section_title', $inclusions?->section_title ?? "What's Included") }}"></div>
            <div class="col-md-4"><label class="form-label">Headline</label><input type="text" name="sections[inclusions][section_headline]" class="form-control" value="{{ old('sections.inclusions.section_headline', $inclusions?->section_headline ?? '') }}"></div>
            <div class="col-md-4"><label class="form-label">Side Image</label><input type="file" name="sections[inclusions][section_image]" class="form-control" accept="image/*">@if($inclusions && $inclusions->section_image)<img src="{{ asset($inclusions->section_image) }}" class="mt-2 rounded" width="80">@endif</div>
        </div>
        <div id="inclusions-items-list">
            @forelse(($inclusions?->subsections ?? collect()) as $i => $item)
            <div class="row g-2 mb-2 align-items-end" data-repeater-item>
                <input type="hidden" name="sections[inclusions][items][{{ $i }}][id]" value="{{ $item->id }}">
                <div class="col-md-7"><input type="text" name="sections[inclusions][items][{{ $i }}][text]" class="form-control" placeholder="Inclusion text" value="{{ $item->section_headline }}"></div>
                <div class="col-md-3"><select name="sections[inclusions][items][{{ $i }}][type]" class="form-select"><option value="yes" {{ strtolower($item->section_subheading ?? 'yes') !== 'no' ? 'selected' : '' }}>Included</option><option value="no" {{ strtolower($item->section_subheading ?? '') === 'no' ? 'selected' : '' }}>Not Included</option></select></div>
                <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
            </div>
            @empty
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand mt-2" data-repeater-add data-target="#inclusions-items-list" data-template="#tpl-inclusion-item">+ Add Inclusion</button>
    </div>
</div>

{{-- Tariff --}}
@php $tariff = $s('tariff'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Tariff Section</h6></div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4"><label class="form-label">Subtitle</label><input type="text" name="sections[tariff][section_title]" class="form-control" value="{{ old('sections.tariff.section_title', $tariff?->section_title ?? 'Pricing') }}"></div>
            <div class="col-md-4"><label class="form-label">Headline</label><input type="text" name="sections[tariff][section_headline]" class="form-control" value="{{ old('sections.tariff.section_headline', $tariff?->section_headline ?? '') }}"></div>
            <div class="col-md-4"><label class="form-label">Intro Text</label><input type="text" name="sections[tariff][description]" class="form-control" value="{{ old('sections.tariff.description', $decode($tariff, 'description')) }}"></div>
            <div class="col-12"><label class="form-label">Footnote</label><input type="text" name="sections[tariff][note]" class="form-control" value="{{ old('sections.tariff.note', $tariff?->section_subtitle ?? '') }}"></div>
        </div>
        <div class="table-responsive mb-2">
            <table class="table table-bordered">
                <thead><tr><th>Occupancy</th><th>Weekday</th><th>Weekend</th><th>Extra Person</th><th></th></tr></thead>
                <tbody id="tariff-rows-list">
                    @forelse(($tariff?->subsections ?? collect()) as $i => $row)
                    <tr data-repeater-item>
                        <td>
                            <input type="hidden" name="sections[tariff][rows][{{ $i }}][id]" value="{{ $row->id }}">
                            <input type="text" name="sections[tariff][rows][{{ $i }}][occupancy]" class="form-control" value="{{ $row->section_headline }}">
                        </td>
                        <td><input type="text" name="sections[tariff][rows][{{ $i }}][weekday]" class="form-control" value="{{ $row->section_subtitle }}"></td>
                        <td><input type="text" name="sections[tariff][rows][{{ $i }}][weekend]" class="form-control" value="{{ $row->section_subheading }}"></td>
                        <td><input type="text" name="sections[tariff][rows][{{ $i }}][extra]" class="form-control" value="{{ htmlspecialchars_decode($row->description) }}"></td>
                        <td><button type="button" class="btn btn-sm btn-light-danger" data-repeater-remove>×</button></td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-sm btn-light-brand" data-repeater-add data-target="#tariff-rows-list" data-template="#tpl-tariff-row">+ Add Row</button>
    </div>
</div>

{{-- Policies --}}
@php $policies = $s('policies'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Policies Section</h6></div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-6"><label class="form-label">Subtitle</label><input type="text" name="sections[policies][section_title]" class="form-control" value="{{ old('sections.policies.section_title', $policies?->section_title ?? 'Good To Know') }}"></div>
            <div class="col-md-6"><label class="form-label">Headline</label><input type="text" name="sections[policies][section_headline]" class="form-control" value="{{ old('sections.policies.section_headline', $policies?->section_headline ?? '') }}"></div>
        </div>
        <div id="policies-items-list">
            @forelse(($policies?->subsections ?? collect()) as $i => $item)
            <div class="border rounded p-3 mb-3" data-repeater-item>
                <input type="hidden" name="sections[policies][items][{{ $i }}][id]" value="{{ $item->id }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4"><label class="form-label">Title</label><input type="text" name="sections[policies][items][{{ $i }}][title]" class="form-control" value="{{ $item->section_headline }}"></div>
                    <div class="col-md-6"><label class="form-label">Description</label><textarea name="sections[policies][items][{{ $i }}][desc]" class="form-control" rows="2">{{ htmlspecialchars_decode($item->description) }}</textarea></div>
                    <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand" data-repeater-add data-target="#policies-items-list" data-template="#tpl-policy-item">+ Add Policy</button>
    </div>
</div>

{{-- Other Stays --}}
@php $otherStays = $s('other_stays'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Other Stays Section</h6></div>
    <div class="card-body">
        <p class="text-muted small">Leave items empty to auto-show other active accommodations on the frontend.</p>
        <div class="row g-3 mb-3">
            <div class="col-md-6"><label class="form-label">Subtitle</label><input type="text" name="sections[other_stays][section_title]" class="form-control" value="{{ old('sections.other_stays.section_title', $otherStays?->section_title ?? 'Explore More') }}"></div>
            <div class="col-md-6"><label class="form-label">Headline</label><input type="text" name="sections[other_stays][section_headline]" class="form-control" value="{{ old('sections.other_stays.section_headline', $otherStays?->section_headline ?? '') }}"></div>
        </div>
        <div id="other-stays-list">
            @forelse(($otherStays?->subsections ?? collect()) as $i => $item)
            <div class="border rounded p-3 mb-3" data-repeater-item>
                <input type="hidden" name="sections[other_stays][items][{{ $i }}][id]" value="{{ $item->id }}">
                <input type="hidden" name="sections[other_stays][items][{{ $i }}][existing_image]" value="{{ $item->section_image }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3"><label class="form-label">Image</label><input type="file" name="sections[other_stays][items][{{ $i }}][image]" class="form-control" accept="image/*">@if($item->section_image)<img src="{{ asset($item->section_image) }}" class="mt-2 rounded" width="80">@endif</div>
                    <div class="col-md-2"><label class="form-label">Tag</label><input type="text" name="sections[other_stays][items][{{ $i }}][tag]" class="form-control" value="{{ $item->section_subheading }}"></div>
                    <div class="col-md-3"><label class="form-label">Title</label><input type="text" name="sections[other_stays][items][{{ $i }}][title]" class="form-control" value="{{ $item->section_headline }}"></div>
                    <div class="col-md-2"><label class="form-label">Link</label><input type="text" name="sections[other_stays][items][{{ $i }}][link]" class="form-control" value="{{ $item->button_link }}" placeholder="/accommodation/slug"></div>
                    <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand" data-repeater-add data-target="#other-stays-list" data-template="#tpl-other-stay">+ Add Card</button>
    </div>
</div>

{{-- CTA --}}
@php $cta = $s('accom_cta'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Bottom CTA Section</h6></div>
    <div class="card-body row g-3">
        <div class="col-12"><label class="form-label">Headline</label><input type="text" name="sections[accom_cta][section_headline]" class="form-control" value="{{ old('sections.accom_cta.section_headline', $cta?->section_headline ?? '') }}"></div>
        <div class="col-12"><label class="form-label">Description</label><textarea name="sections[accom_cta][description]" class="form-control" rows="3">{{ old('sections.accom_cta.description', $decode($cta, 'description')) }}</textarea></div>
        <div class="col-md-6"><label class="form-label">Button Text</label><input type="text" name="sections[accom_cta][button_name]" class="form-control" value="{{ old('sections.accom_cta.button_name', $cta?->button_name ?? 'Enquire & Book') }}"></div>
        <div class="col-md-6"><label class="form-label">Button Link</label><input type="text" name="sections[accom_cta][button_link]" class="form-control" value="{{ old('sections.accom_cta.button_link', $cta?->button_link ?? route('enquire')) }}"></div>
    </div>
</div>

{{-- Repeater templates --}}
<template id="tpl-overview-stat">
    <div class="row g-2 mb-2 align-items-end" data-repeater-item>
        <div class="col-md-5"><input type="text" name="sections[overview][stats][0][value]" class="form-control" placeholder="Value"></div>
        <div class="col-md-5"><input type="text" name="sections[overview][stats][0][label]" class="form-control" placeholder="Label"></div>
        <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
    </div>
</template>
<template id="tpl-gallery-item">
    <div class="border rounded p-3 mb-3" data-repeater-item>
        <div class="row g-3 align-items-end">
            <div class="col-md-3"><label class="form-label">Image</label><input type="file" name="sections[gallery][items][0][image]" class="form-control" accept="image/*"></div>
            <div class="col-md-4"><label class="form-label">Caption</label><input type="text" name="sections[gallery][items][0][caption]" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Type</label><select name="sections[gallery][items][0][type]" class="form-select"><option value="main">Main</option><option value="thumb" selected>Thumb</option><option value="more">More</option></select></div>
            <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
        </div>
    </div>
</template>
<template id="tpl-feature-item">
    <div class="border rounded p-3 mb-3" data-repeater-item>
        <div class="row g-3 align-items-end">
            <div class="col-md-3"><label class="form-label">Icon Image</label><input type="file" name="sections[features][items][0][icon]" class="form-control" accept="image/*"></div>
            <div class="col-md-3"><label class="form-label">Title</label><input type="text" name="sections[features][items][0][title]" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Description</label><input type="text" name="sections[features][items][0][desc]" class="form-control"></div>
            <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
        </div>
    </div>
</template>
<template id="tpl-inclusion-item">
    <div class="row g-2 mb-2 align-items-end" data-repeater-item>
        <div class="col-md-7"><input type="text" name="sections[inclusions][items][0][text]" class="form-control" placeholder="Inclusion text"></div>
        <div class="col-md-3"><select name="sections[inclusions][items][0][type]" class="form-select"><option value="yes">Included</option><option value="no">Not Included</option></select></div>
        <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
    </div>
</template>
<template id="tpl-tariff-row">
    <tr data-repeater-item>
        <td><input type="text" name="sections[tariff][rows][0][occupancy]" class="form-control"></td>
        <td><input type="text" name="sections[tariff][rows][0][weekday]" class="form-control"></td>
        <td><input type="text" name="sections[tariff][rows][0][weekend]" class="form-control"></td>
        <td><input type="text" name="sections[tariff][rows][0][extra]" class="form-control"></td>
        <td><button type="button" class="btn btn-sm btn-light-danger" data-repeater-remove>×</button></td>
    </tr>
</template>
<template id="tpl-policy-item">
    <div class="border rounded p-3 mb-3" data-repeater-item>
        <div class="row g-3 align-items-end">
            <div class="col-md-4"><label class="form-label">Title</label><input type="text" name="sections[policies][items][0][title]" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Description</label><textarea name="sections[policies][items][0][desc]" class="form-control" rows="2"></textarea></div>
            <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
        </div>
    </div>
</template>
<template id="tpl-other-stay">
    <div class="border rounded p-3 mb-3" data-repeater-item>
        <div class="row g-3 align-items-end">
            <div class="col-md-3"><label class="form-label">Image</label><input type="file" name="sections[other_stays][items][0][image]" class="form-control" accept="image/*"></div>
            <div class="col-md-2"><label class="form-label">Tag</label><input type="text" name="sections[other_stays][items][0][tag]" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Title</label><input type="text" name="sections[other_stays][items][0][title]" class="form-control"></div>
            <div class="col-md-2"><label class="form-label">Link</label><input type="text" name="sections[other_stays][items][0][link]" class="form-control"></div>
            <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
        </div>
    </div>
</template>
