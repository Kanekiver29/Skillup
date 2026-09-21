@extends('sias.admin.layouts.master')

@section('title', $definition['title'] . ' | SIAS Admin')
@section('page_title', $definition['title'])
@section('subtitle', $definition['purpose'])

@section('content')
@if(session('success'))
    <div class="admin-panel" style="margin-bottom:1rem; border-color:#22c55e; color:#15803d;">{{ session('success') }}</div>
@endif

@if($section === 'maintenance')
    <div class="admin-card" style="max-width:900px; display:grid; gap:1rem;">
        <div>
            <h3 style="margin:0 0 .4rem;">Application maintenance</h3>
            <p style="margin:0; color:var(--text-muted);">Clear application caches or temporarily place SIAS in maintenance mode.</p>
        </div>
        <div style="display:flex; gap:.75rem; flex-wrap:wrap;">
            <form method="POST" action="{{ route('admin.settings.cache.clear') }}">
                @csrf
                <input type="hidden" name="type" value="all">
                <button class="btn" type="submit">Clear all caches</button>
            </form>
            <form method="POST" action="{{ route('admin.settings.maintenance') }}">
                @csrf
                <button class="btn btn-secondary" type="submit">{{ app()->isDownForMaintenance() ? 'Disable maintenance mode' : 'Enable maintenance mode' }}</button>
            </form>
        </div>
    </div>
@else
    <div class="admin-card" style="max-width:900px;">
        <form method="POST" action="{{ route('sias.admin.settings.section.update', ['section' => $section]) }}" style="display:grid; gap:1rem;">
            @csrf
            @method('PUT')
            @foreach($definition['fields'] as $field)
                <div style="display:grid; gap:.4rem;">
                    <label for="{{ $field['name'] }}" style="font-weight:600;">{{ __('sias.settings_field_' . $field['name']) }}</label>
                    @if($field['type'] === 'textarea')
                        <textarea id="{{ $field['name'] }}" name="{{ $field['name'] }}" rows="3" style="width:100%; padding:.75rem; border:1px solid var(--card-border); border-radius:8px; background:var(--card-bg); color:var(--text);">{{ old($field['name'], $values[$field['name']] ?? '') }}</textarea>
                    @elseif($field['type'] === 'select')
                        <select id="{{ $field['name'] }}" name="{{ $field['name'] }}" style="width:100%; padding:.75rem; border:1px solid var(--card-border); border-radius:8px; background:var(--card-bg); color:var(--text);">
                            @foreach($field['options'] as $option)
                                <option value="{{ $option }}" @selected(old($field['name'], $values[$field['name']] ?? '') === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    @else
                        <input id="{{ $field['name'] }}" type="{{ $field['type'] }}" name="{{ $field['name'] }}" value="{{ old($field['name'], $values[$field['name']] ?? '') }}" @isset($field['step']) step="{{ $field['step'] }}" @endisset style="width:100%; padding:.75rem; border:1px solid var(--card-border); border-radius:8px; background:var(--card-bg); color:var(--text);">
                    @endif
                    @error($field['name'])<span style="color:var(--danger); font-size:.85rem;">{{ $message }}</span>@enderror
                </div>
            @endforeach
            <div style="display:flex; justify-content:flex-end; margin-top:.5rem;">
                <button class="btn" type="submit" style="width:auto;">Save {{ $definition['title'] }}</button>
            </div>
        </form>
    </div>
@endif
@endsection
