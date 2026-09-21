<?php

namespace App\Http\Controllers;

use App\Models\StudentDocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiasStudentDocumentsController extends Controller
{
    public function index()
    {
        $requests = auth()->user()->studentDocumentRequests()->latest()->get();

        return view('sias.students.documents.index', [
            'requests' => $requests,
            'requestTypes' => StudentDocumentRequest::TYPES,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:' . implode(',', array_keys(StudentDocumentRequest::TYPES))],
            'subject' => ['nullable', 'string', 'max:120'],
            'details' => ['required', 'string', 'min:10', 'max:2000'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment_path'] = $request->file('attachment')->store('student-requests', 'public');
        }

        unset($validated['attachment']);
        auth()->user()->studentDocumentRequests()->create($validated);

        return redirect()->route('sias.student.documents')->with('success', 'Your request was submitted for review.');
    }

    public function destroy(StudentDocumentRequest $studentDocumentRequest)
    {
        abort_unless($studentDocumentRequest->user_id === auth()->id(), 403);
        abort_unless($studentDocumentRequest->status === 'pending', 422);

        $studentDocumentRequest->update(['status' => 'cancelled']);

        return redirect()->route('sias.student.documents')->with('success', 'The request was cancelled.');
    }

    public function download(StudentDocumentRequest $studentDocumentRequest)
    {
        abort_unless($studentDocumentRequest->user_id === auth()->id(), 403);
        abort_unless($studentDocumentRequest->attachment_path, 404);

        return Storage::disk('public')->download($studentDocumentRequest->attachment_path);
    }
}