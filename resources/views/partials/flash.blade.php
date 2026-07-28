@php
    $types = [
        'success' => ['color' => 'var(--success)', 'icon' => 'icon-check'],
        'error'   => ['color' => 'var(--danger)',  'icon' => 'icon-bell'],
        'warning' => ['color' => 'var(--gold)',    'icon' => 'icon-bell'],
        'info'    => ['color' => 'var(--accent)',  'icon' => 'icon-info']
    ];
@endphp

<div id="flashMessages" aria-live="polite" aria-atomic="true">
    @foreach($types as $key => $meta)
        @if(session()->has($key))
            <div class="alert alert-{{ $key }}" role="status" style="border-left:4px solid {{ $meta['color'] }}; background: #fff; padding:12px 14px; margin-bottom:12px; border-radius:8px; box-shadow:var(--shadow-xs); display:flex; gap:12px; align-items:flex-start;">
                <svg class="icon" aria-hidden="true" width="18" height="18" style="flex-shrink:0; color:{{ $meta['color'] }}; margin-top:2px;"><use href="#{{ $meta['icon'] }}"></use></svg>
                <div style="flex:1">
                    <div style="font-weight:700; color:var(--navy-900);">{{ session()->get($key) }}</div>
                </div>
                <button type="button" class="alert-close" aria-label="Dismiss" style="background:none;border:0;color:var(--muted);font-weight:700;padding:6px 8px;">×</button>
            </div>
        @endif
    @endforeach

    @if($errors->any())
        <div class="alert alert-error" role="status" style="border-left:4px solid var(--danger); background:#fff; padding:12px 14px; margin-bottom:12px; border-radius:8px; box-shadow:var(--shadow-xs);">
            <div style="display:flex; gap:10px; align-items:flex-start">
                <svg class="icon" aria-hidden="true" width="18" height="18" style="flex-shrink:0; color:var(--danger); margin-top:2px;"><use href="#icon-bell"></use></svg>
                <div style="flex:1">
                    <div style="font-weight:700; color:var(--navy-900);">There were some problems with your input.</div>
                    <ul style="margin-top:6px; color:var(--muted); list-style:disc; padding-left:18px;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="alert-close" aria-label="Dismiss" style="background:none;border:0;color:var(--muted);font-weight:700;padding:6px 8px;">×</button>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    var container = document.getElementById('flashMessages');
    if (!container) return;
    // Auto-dismiss after 6s
    setTimeout(function(){
        container.querySelectorAll('.alert').forEach(function(a){ a.style.transition = 'opacity .28s ease, transform .28s ease'; a.style.opacity = '0'; a.style.transform = 'translateY(-6px)'; setTimeout(function(){ a.remove(); }, 320); });
    }, 6000);

    container.addEventListener('click', function(e){
        if (e.target && e.target.classList.contains('alert-close')) {
            var el = e.target.closest('.alert'); if (!el) return; el.style.transition = 'opacity .18s ease'; el.style.opacity = '0'; setTimeout(function(){ el.remove(); }, 200);
        }
    });
});
</script>
@endpush
