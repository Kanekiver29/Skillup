<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SystemLogController extends Controller
{
    /** Max number of log lines to display per page. */
    private const LINES_PER_PAGE = 100;

    /**
     * Show the system log viewer page.
     */
    public function index(Request $request)
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Forbidden');
        }

        $logPath = storage_path('logs/laravel.log');

        $logContent  = '';
        $logSize     = 0;
        $lastModified = null;
        $totalLines  = 0;
        $entries     = collect();
        $logExists   = File::exists($logPath);

        if ($logExists) {
            $logSize      = File::size($logPath);
            $lastModified = \Carbon\Carbon::createFromTimestamp(File::lastModified($logPath));

            // Read all lines (tail the file for large logs)
            $allLines = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $totalLines = count($allLines);

            // Parse log entries (each entry starts with [YYYY-MM-DD HH:MM:SS])
            $currentEntry = null;

            foreach ($allLines as $line) {
                // Detect start of a new log entry
                if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.+)$/', $line, $m)) {
                    if ($currentEntry !== null) {
                        $entries->push($currentEntry);
                    }
                    $currentEntry = [
                        'timestamp' => $m[1],
                        'channel'   => $m[2],
                        'level'     => strtolower($m[3]),
                        'message'   => $m[4],
                        'context'   => '',
                    ];
                } elseif ($currentEntry !== null) {
                    // Continuation / stack trace lines
                    $currentEntry['context'] .= "\n" . $line;
                }
            }
            if ($currentEntry !== null) {
                $entries->push($currentEntry);
            }

            // Newest entries first
            $entries = $entries->reverse()->values();
        }

        // --- Filtering ---
        $filterLevel   = $request->query('level', '');
        $filterSearch  = $request->query('search', '');

        if ($filterLevel !== '') {
            $entries = $entries->filter(fn($e) => $e['level'] === $filterLevel)->values();
        }

        if ($filterSearch !== '') {
            $search = strtolower($filterSearch);
            $entries = $entries->filter(
                fn($e) => str_contains(strtolower($e['message']), $search)
                       || str_contains(strtolower($e['context']), $search)
            )->values();
        }

        // --- Pagination ---
        $page       = max(1, (int) $request->query('page', 1));
        $total      = $entries->count();
        $totalPages = max(1, (int) ceil($total / self::LINES_PER_PAGE));
        $page       = min($page, $totalPages);
        $paginated  = $entries->slice(($page - 1) * self::LINES_PER_PAGE, self::LINES_PER_PAGE)->values();

        // --- Level counts (on filtered+non-paginated set for badge accuracy) ---
        $levelCounts  = $entries->countBy('level');

        return view('Admin.systemlog', compact(
            'logExists',
            'logSize',
            'lastModified',
            'totalLines',
            'paginated',
            'total',
            'page',
            'totalPages',
            'filterLevel',
            'filterSearch',
            'levelCounts',
        ));
    }

    /**
     * Clear (truncate) the Laravel log file.
     */
    public function clear(Request $request)
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Forbidden');
        }

        $logPath = storage_path('logs/laravel.log');

        if (File::exists($logPath)) {
            // Truncate (overwrite with empty string) rather than delete
            File::put($logPath, '');
        }

        return redirect()->route('admin.systemlog')->with('success', 'Log file cleared successfully.');
    }

    /**
     * Download the raw log file.
     */
    public function download(Request $request)
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Forbidden');
        }

        $logPath = storage_path('logs/laravel.log');

        if (! File::exists($logPath)) {
            return redirect()->route('admin.systemlog')->with('error', 'Log file not found.');
        }

        return response()->download($logPath, 'laravel-' . now()->format('Ymd-His') . '.log');
    }
}
