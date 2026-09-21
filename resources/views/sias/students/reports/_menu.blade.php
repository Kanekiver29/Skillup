@php
    $reportMenuItems = [
        ['route' => 'sias.student.reports.class-offerings', 'title' => 'Class Offerings'],
        ['route' => 'sias.student.reports.enrolled-subjects', 'title' => 'Enrolled Subjects'],
        ['route' => 'sias.student.reports.final-grades-match', 'title' => 'Final Grades (Match)'],
        ['route' => 'sias.student.reports.final-grades-ignore', 'title' => 'Final Grades (Ignore)'],
        ['route' => 'sias.student.reports.gwa-match', 'title' => 'GWA (Match)'],
        ['route' => 'sias.student.reports.gwa-ignore', 'title' => 'GWA (Ignore)'],
        ['route' => 'sias.student.reports.term-grades-match', 'title' => 'Term Grades (Match)'],
        ['route' => 'sias.student.reports.term-grades-ignore', 'title' => 'Term Grades (Ignore)'],
    ];
@endphp

<aside class="col-span-1">
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Reports Menu</h2>
        <nav class="space-y-2">
            @foreach($reportMenuItems as $item)
                <a href="{{ route($item['route']) }}" class="block rounded-xl px-4 py-3 text-sm font-medium transition ease-in-out {{ request()->routeIs($item['route']) ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">
                    {{ $item['title'] }}
                </a>
            @endforeach
        </nav>
    </div>
</aside>
