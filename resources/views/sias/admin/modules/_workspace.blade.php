<div class="admin-grid" style="grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
    @foreach($items as $index => $item)
        @php
            $item = is_string($item)
                ? ['label' => $item, 'description' => 'This workspace is ready for ' . strtolower($item) . ' management.', 'route' => null, 'action' => null]
                : $item;
            $itemUrl = $item['route'] ? route($item['route'], $item['parameters'] ?? []) : null;
            $actionUrl = ! empty($item['action']) ? route($item['action'], $item['action_parameters'] ?? []) : null;
        @endphp
        <section class="admin-panel" style="--i: {{ $index }};">
            <p style="margin:0 0 .5rem; color:var(--text-muted); font-size:.78rem; text-transform:uppercase; letter-spacing:.08em;">SIAS Admin</p>
            <h3 style="margin:0 0 .65rem;">{{ $item['label'] }}</h3>
            <p style="margin:0; color:var(--text-muted);">{{ $item['description'] }}</p>
            @if($itemUrl)
                <div style="display:flex; gap:.55rem; flex-wrap:wrap; margin-top:1rem;">
                    <a href="{{ $itemUrl }}" class="btn btn-secondary" style="width:auto;">Open workspace</a>
                    @if($actionUrl)
                        <a href="{{ $actionUrl }}" class="btn" style="width:auto;">{{ $item['action_label'] ?? 'Create new' }}</a>
                    @endif
                </div>
            @else
                <span style="display:inline-block; margin-top:1rem; color:var(--text-muted); font-size:.85rem;">No admin workspace is registered yet</span>
            @endif
        </section>
    @endforeach
</div>

<section class="admin-card" style="margin-top:1rem;">
    <h3 style="margin-top:0;">{{ $title }} workspace</h3>
    <p style="margin-bottom:0; color:var(--text-muted);">{{ $purpose }}</p>
</section>
