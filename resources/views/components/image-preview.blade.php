<!-- resources/views/components/image-preview.blade.php -->

@props(['getState'])

@if ($getState())
    <div style="margin-top: 1rem;">
        <img src="{{ $getState() }}" alt="Image Preview" style="max-width: 100%; height: auto;">
    </div>
@endif
