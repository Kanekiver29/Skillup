@extends('sias.students.layout.master')

@section('title', __('sias.documents_requests'))
@section('page_title', __('sias.documents_requests'))

@section('content')
<style>
    .documents-page { display:grid; gap:1.25rem; }
    .documents-hero { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap; }
    .documents-hero h2 { margin:0; font-size:clamp(1.5rem, 3vw, 2rem); }
    .documents-hero p { margin:.45rem 0 0; color:var(--text-muted); max-width:650px; line-height:1.6; }
    .documents-stats { display:flex; gap:.65rem; flex-wrap:wrap; }
    .document-stat { min-width:92px; padding:.7rem .85rem; border:1px solid var(--card-border); border-radius:12px; background:var(--block-bg); text-align:center; }
    .document-stat strong { display:block; font-size:1.25rem; color:var(--text); }
    .document-stat span { color:var(--text-muted); font-size:.72rem; text-transform:uppercase; letter-spacing:.06em; }
    .documents-layout { display:grid; grid-template-columns:minmax(280px, .8fr) minmax(0, 1.4fr); gap:1rem; align-items:start; }
    .documents-panel { min-width:0; padding:1.2rem; border:1px solid var(--card-border); border-radius:16px; background:var(--card-bg); box-shadow:var(--card-shadow); }
    .documents-panel h3 { margin:0; font-size:1.05rem; }
    .documents-panel > p { margin:.35rem 0 1rem; color:var(--text-muted); font-size:.9rem; line-height:1.5; }
    .document-form { display:grid; gap:.9rem; }
    .document-form label { display:grid; gap:.35rem; color:var(--text); font-size:.82rem; font-weight:700; }
    .document-form input, .document-form select, .document-form textarea { width:100%; border:1px solid var(--block-border); border-radius:10px; padding:.75rem .8rem; background:var(--block-bg); color:var(--text); font:inherit; font-size:.9rem; }
    .document-form textarea { min-height:125px; resize:vertical; }
    .document-form input:focus, .document-form select:focus, .document-form textarea:focus { outline:2px solid var(--focus-ring); outline-offset:2px; }
    .field-hint { color:var(--text-faint); font-size:.75rem; font-weight:400; }
    .form-error { color:#b91c1c; font-size:.78rem; font-weight:500; }
    .notice { padding:.8rem 1rem; border-radius:10px; background:rgba(34,197,94,.1); color:#166534; border:1px solid rgba(34,197,94,.25); }
    .request-toolbar { display:flex; justify-content:space-between; align-items:center; gap:.75rem; flex-wrap:wrap; margin-bottom:.75rem; }
    .request-toolbar input { width:min(260px, 100%); border:1px solid var(--block-border); border-radius:999px; padding:.6rem .85rem; background:var(--block-bg); color:var(--text); }
    .request-list { min-width:0; display:grid; gap:.7rem; }
    .request-item { min-width:0; max-width:100%; overflow:hidden; padding:1rem; border:1px solid var(--card-border); border-radius:12px; background:var(--block-bg); }
    .request-item[hidden] { display:none; }
    .request-head { display:flex; justify-content:space-between; gap:1rem; align-items:flex-start; min-width:0; }
    .request-head > div { min-width:0; }
    .request-title { margin:0; color:var(--text); font-size:.98rem; overflow-wrap:anywhere; }
    .request-subject, .request-details, .request-date { color:var(--text-muted); font-size:.84rem; overflow-wrap:anywhere; word-break:break-word; }
    .request-subject { margin:.25rem 0; }
    .request-details { margin:.7rem 0; white-space:pre-line; line-height:1.5; }
    .status { display:inline-flex; padding:.3rem .55rem; border-radius:999px; background:rgba(201,151,59,.14); color:var(--accent); font-size:.72rem; font-weight:700; white-space:nowrap; }
    .request-actions { display:flex; gap:.6rem; align-items:center; flex-wrap:wrap; }
    .request-actions a, .request-actions button { color:var(--accent); background:none; border:0; padding:0; cursor:pointer; font:inherit; font-size:.8rem; text-decoration:none; }
    .request-actions button { color:#b91c1c; }
    .empty-state { padding:2rem 1rem; text-align:center; color:var(--text-muted); border:1px dashed var(--block-border); border-radius:12px; }
    @media (max-width: 850px) { .documents-layout { grid-template-columns:1fr; } }
</style>

<div class="page-card documents-page">
    <div class="documents-hero">
        <div>
            <h2>{{ __('sias.documents_requests') }}</h2>
            <p>{{ __('sias.submit_documents_requests') }}</p>
        </div>
        <div class="documents-stats" aria-label="Request summary">
            <div class="document-stat"><strong>{{ $requests->whereIn('status', ['pending', 'processing'])->count() }}</strong><span>{{ __('sias.open') }}</span></div>
            <div class="document-stat"><strong>{{ $requests->whereIn('status', ['ready', 'completed'])->count() }}</strong><span>{{ __('sias.ready') }}</span></div>
            <div class="document-stat"><strong>{{ $requests->count() }}</strong><span>{{ __('sias.total') }}</span></div>
        </div>
    </div>

    @if(session('success'))<div class="notice" role="status">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="notice" style="background:rgba(185,28,28,.08);color:#991b1b;border-color:rgba(185,28,28,.2);" role="alert">Please check the highlighted form fields and try again.</div>@endif

    <div class="documents-layout">
        <section class="documents-panel">
            <h3>{{ __('sias.start_request') }}</h3>
            <p>{{ __('sias.submit_documents_requests') }}</p>
            <form class="document-form" method="POST" action="{{ route('sias.student.documents.store') }}" enctype="multipart/form-data">
                @csrf
                <label>{{ __('sias.request_type') }}
                    <select name="type" required><option value="">{{ __('sias.choose_request') }}</option>@foreach($requestTypes as $value => $label)<option value="{{ $value }}" @selected(old('type') === $value)>{{ $label }}</option>@endforeach</select>
                    @error('type')<span class="form-error">{{ $message }}</span>@enderror
                </label>
                <label>{{ __('sias.subject_reference') }} <span class="field-hint">{{ __('sias.optional') }}</span>
                    <input name="subject" value="{{ old('subject') }}" maxlength="120" placeholder="Example: Certificate for scholarship application">
                    @error('subject')<span class="form-error">{{ $message }}</span>@enderror
                </label>
                <label>{{ __('sias.details') }}
                    <textarea name="details" required minlength="10" maxlength="2000" placeholder="Tell us what you need and when you need it.">{{ old('details') }}</textarea>
                    @error('details')<span class="form-error">{{ $message }}</span>@enderror
                </label>
                <label>{{ __('sias.supporting_file') }} <span class="field-hint">PDF, JPG, or PNG up to 5 MB</span>
                    <input type="file" name="attachment" accept=".pdf,.jpg,.jpeg,.png">
                    @error('attachment')<span class="form-error">{{ $message }}</span>@enderror
                </label>
                <button type="submit" class="btn-black">{{ __('sias.submit_request') }}</button>
            </form>
        </section>

        <section class="documents-panel">
            <div class="request-toolbar"><div><h3>{{ __('sias.request_history') }}</h3><p style="margin:0;">{{ __('sias.track_latest_updates') }}</p></div><input id="requestSearch" type="search" placeholder="{{ __('sias.search_requests') }}" aria-label="{{ __('sias.search_requests') }}"></div>
            <div class="request-list" id="requestList">
                @forelse($requests as $documentRequest)
                    <article class="request-item" data-search="{{ strtolower($documentRequest->typeLabel().' '.$documentRequest->subject.' '.$documentRequest->details.' '.$documentRequest->statusLabel()) }}">
                        <div class="request-head"><div><h4 class="request-title">{{ $documentRequest->typeLabel() }}</h4>@if($documentRequest->subject)<p class="request-subject">{{ $documentRequest->subject }}</p>@endif</div><span class="status">{{ $documentRequest->statusLabel() }}</span></div>
                        <p class="request-details">{{ $documentRequest->details }}</p>
                        <div class="request-actions"><span class="request-date">{{ __('sias.submitted') }} {{ $documentRequest->created_at->format('M j, Y g:i A') }}</span>@if($documentRequest->attachment_path)<a href="{{ route('sias.student.documents.download', $documentRequest) }}">{{ __('sias.download_attachment') }}</a>@endif @if($documentRequest->status === 'pending')<form method="POST" action="{{ route('sias.student.documents.destroy', $documentRequest) }}" onsubmit="return confirm('{{ __('sias.cancel') }} this request?');">@csrf @method('DELETE')<button type="submit">{{ __('sias.cancel') }}</button></form>@endif</div>
                        @if($documentRequest->staff_notes)<p class="request-details" style="border-top:1px solid var(--card-border);padding-top:.65rem;margin-bottom:0;"><strong>Staff note:</strong> {{ $documentRequest->staff_notes }}</p>@endif
                    </article>
                @empty<div class="empty-state">{{ __('sias.no_requests') }}</div>@endforelse
            </div>
        </section>
    </div>
</div>

<script>
    document.getElementById('requestSearch')?.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();
        document.querySelectorAll('#requestList .request-item').forEach(function (item) { item.hidden = query !== '' && !item.dataset.search.includes(query); });
    });
</script>
@endsection
