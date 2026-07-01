@php
    $s = fn(string $key) => $sections[$key] ?? null;
    $decode = fn($section, string $field) => $section && filled($section->{$field}) ? htmlspecialchars_decode($section->{$field}) : '';
@endphp

{{-- Intro Section --}}
@php $intro = $s('event_intro'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Intro Section</h6></div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-6"><label class="form-label">Subtitle</label><input type="text" name="sections[event_intro][section_subtitle]" class="form-control" value="{{ old('sections.event_intro.section_subtitle', $intro?->section_subtitle ?? 'Experience Overview') }}"></div>
            <div class="col-md-6"><label class="form-label">Heading</label><input type="text" name="sections[event_intro][section_headline]" class="form-control" value="{{ old('sections.event_intro.section_headline', $intro?->section_headline ?? '') }}"></div>
            <div class="col-md-6">
                <label class="form-label">Intro Image</label>
                <input type="hidden" name="sections[event_intro][existing_image]" value="{{ $intro?->section_image }}">
                <input type="file" name="sections[event_intro][image]" class="form-control" accept="image/*">
                @if($intro?->section_image)<img src="{{ asset($intro->section_image) }}" class="mt-2 rounded" width="120">@endif
            </div>
        </div>
        <label class="form-label">Paragraphs</label>
        <div id="intro-paragraphs-list">
            @forelse(($intro?->subsections ?? collect()) as $i => $para)
            <div class="mb-2" data-repeater-item>
                <input type="hidden" name="sections[event_intro][paragraphs][{{ $i }}][id]" value="{{ $para->id }}">
                <div class="input-group">
                    <textarea name="sections[event_intro][paragraphs][{{ $i }}][text]" class="form-control" rows="2">{{ htmlspecialchars_decode($para->description) }}</textarea>
                    <button type="button" class="btn btn-light-danger" data-repeater-remove>Remove</button>
                </div>
            </div>
            @empty
            @for($i = 0; $i < 2; $i++)
            <div class="mb-2" data-repeater-item>
                <div class="input-group">
                    <textarea name="sections[event_intro][paragraphs][{{ $i }}][text]" class="form-control" rows="2"></textarea>
                    <button type="button" class="btn btn-light-danger" data-repeater-remove>Remove</button>
                </div>
            </div>
            @endfor
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand mt-2" data-repeater-add data-target="#intro-paragraphs-list" data-template="#tpl-intro-para">+ Add Paragraph</button>
    </div>
</div>

{{-- Stats --}}
@php $stats = $s('event_stats'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Stats (shown in intro)</h6></div>
    <div class="card-body">
        <div id="stats-items-list">
            @forelse(($stats?->subsections ?? collect()) as $i => $item)
            <div class="row g-2 mb-2 align-items-end" data-repeater-item>
                <input type="hidden" name="sections[event_stats][items][{{ $i }}][id]" value="{{ $item->id }}">
                <div class="col-md-5"><input type="text" name="sections[event_stats][items][{{ $i }}][value]" class="form-control" placeholder="Value (e.g. 50+)" value="{{ $item->section_headline }}"></div>
                <div class="col-md-5"><input type="text" name="sections[event_stats][items][{{ $i }}][label]" class="form-control" placeholder="Label (e.g. Guests)" value="{{ $item->section_subheading }}"></div>
                <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
            </div>
            @empty
            @for($i = 0; $i < 3; $i++)
            <div class="row g-2 mb-2 align-items-end" data-repeater-item>
                <div class="col-md-5"><input type="text" name="sections[event_stats][items][{{ $i }}][value]" class="form-control" placeholder="Value"></div>
                <div class="col-md-5"><input type="text" name="sections[event_stats][items][{{ $i }}][label]" class="form-control" placeholder="Label"></div>
                <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
            </div>
            @endfor
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand mt-2" data-repeater-add data-target="#stats-items-list" data-template="#tpl-stat-item">+ Add Stat</button>
    </div>
</div>

{{-- Highlights --}}
@php $highlights = $s('event_highlights'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Why Choose Us (Highlights)</h6></div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-6"><label class="form-label">Subtitle</label><input type="text" name="sections[event_highlights][section_subtitle]" class="form-control" value="{{ old('sections.event_highlights.section_subtitle', $highlights?->section_subtitle ?? 'Why Choose Us') }}"></div>
            <div class="col-md-6"><label class="form-label">Heading</label><input type="text" name="sections[event_highlights][section_headline]" class="form-control" value="{{ old('sections.event_highlights.section_headline', $highlights?->section_headline ?? '') }}"></div>
        </div>
        <div id="highlights-items-list">
            @forelse(($highlights?->subsections ?? collect()) as $i => $item)
            <div class="row g-2 mb-2 align-items-end" data-repeater-item>
                <input type="hidden" name="sections[event_highlights][items][{{ $i }}][id]" value="{{ $item->id }}">
                <div class="col-md-5"><input type="text" name="sections[event_highlights][items][{{ $i }}][title]" class="form-control" placeholder="Title" value="{{ $item->section_headline }}"></div>
                <div class="col-md-5"><textarea name="sections[event_highlights][items][{{ $i }}][desc]" class="form-control" rows="2" placeholder="Description">{{ htmlspecialchars_decode($item->description) }}</textarea></div>
                <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
            </div>
            @empty
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand mt-2" data-repeater-add data-target="#highlights-items-list" data-template="#tpl-highlight-item">+ Add Highlight</button>
    </div>
</div>

{{-- Experiences --}}
@php $experiences = $s('event_experiences'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Experiences Section</h6></div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-6"><label class="form-label">Subtitle</label><input type="text" name="sections[event_experiences][section_subtitle]" class="form-control" value="{{ old('sections.event_experiences.section_subtitle', $experiences?->section_subtitle ?? 'Experiences') }}"></div>
            <div class="col-md-6"><label class="form-label">Heading</label><input type="text" name="sections[event_experiences][section_headline]" class="form-control" value="{{ old('sections.event_experiences.section_headline', $experiences?->section_headline ?? '') }}"></div>
        </div>
        <div id="experiences-items-list">
            @forelse(($experiences?->subsections ?? collect()) as $i => $item)
            <div class="border rounded p-3 mb-3" data-repeater-item>
                <input type="hidden" name="sections[event_experiences][items][{{ $i }}][id]" value="{{ $item->id }}">
                <input type="hidden" name="sections[event_experiences][items][{{ $i }}][existing_image]" value="{{ $item->section_image }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3"><label class="form-label">Image</label><input type="file" name="sections[event_experiences][items][{{ $i }}][image]" class="form-control" accept="image/*">@if($item->section_image)<img src="{{ asset($item->section_image) }}" class="mt-2 rounded" width="80">@endif</div>
                    <div class="col-md-3"><label class="form-label">Title</label><input type="text" name="sections[event_experiences][items][{{ $i }}][title]" class="form-control" value="{{ $item->section_headline }}"></div>
                    <div class="col-md-4"><label class="form-label">Description</label><textarea name="sections[event_experiences][items][{{ $i }}][desc]" class="form-control" rows="2">{{ htmlspecialchars_decode($item->description) }}</textarea></div>
                    <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
        <button type="button" class="btn btn-sm btn-light-brand" data-repeater-add data-target="#experiences-items-list" data-template="#tpl-event-experience-item">+ Add Experience</button>
    </div>
</div>

{{-- CTA --}}
@php $cta = $s('event_cta'); @endphp
<div class="card mb-4">
    <div class="card-header"><h6 class="mb-0">Bottom CTA Section</h6></div>
    <div class="card-body row g-3">
        <div class="col-12"><label class="form-label">Headline</label><input type="text" name="sections[event_cta][section_headline]" class="form-control" value="{{ old('sections.event_cta.section_headline', $cta?->section_headline ?? '') }}"></div>
        <div class="col-12"><label class="form-label">Description</label><textarea name="sections[event_cta][description]" class="form-control" rows="3">{{ old('sections.event_cta.description', $decode($cta, 'description')) }}</textarea></div>
        <div class="col-md-6"><label class="form-label">Button Text</label><input type="text" name="sections[event_cta][button_name]" class="form-control" value="{{ old('sections.event_cta.button_name', $cta?->button_name ?? 'Enquire Now') }}"></div>
        <div class="col-md-6"><label class="form-label">Button Link</label><input type="text" name="sections[event_cta][button_link]" class="form-control" value="{{ old('sections.event_cta.button_link', $cta?->button_link ?? route('enquire')) }}"></div>
    </div>
</div>

<template id="tpl-intro-para">
    <div class="mb-2" data-repeater-item>
        <div class="input-group">
            <textarea name="sections[event_intro][paragraphs][0][text]" class="form-control" rows="2"></textarea>
            <button type="button" class="btn btn-light-danger" data-repeater-remove>Remove</button>
        </div>
    </div>
</template>
<template id="tpl-stat-item">
    <div class="row g-2 mb-2 align-items-end" data-repeater-item>
        <div class="col-md-5"><input type="text" name="sections[event_stats][items][0][value]" class="form-control" placeholder="Value"></div>
        <div class="col-md-5"><input type="text" name="sections[event_stats][items][0][label]" class="form-control" placeholder="Label"></div>
        <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
    </div>
</template>
<template id="tpl-highlight-item">
    <div class="row g-2 mb-2 align-items-end" data-repeater-item>
        <div class="col-md-5"><input type="text" name="sections[event_highlights][items][0][title]" class="form-control" placeholder="Title"></div>
        <div class="col-md-5"><textarea name="sections[event_highlights][items][0][desc]" class="form-control" rows="2" placeholder="Description"></textarea></div>
        <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
    </div>
</template>
<template id="tpl-event-experience-item">
    <div class="border rounded p-3 mb-3" data-repeater-item>
        <div class="row g-3 align-items-end">
            <div class="col-md-3"><label class="form-label">Image</label><input type="file" name="sections[event_experiences][items][0][image]" class="form-control" accept="image/*"></div>
            <div class="col-md-3"><label class="form-label">Title</label><input type="text" name="sections[event_experiences][items][0][title]" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Description</label><textarea name="sections[event_experiences][items][0][desc]" class="form-control" rows="2"></textarea></div>
            <div class="col-md-2"><button type="button" class="btn btn-light-danger w-100" data-repeater-remove>Remove</button></div>
        </div>
    </div>
</template>
