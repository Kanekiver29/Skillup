<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'subject',
        'details',
        'status',
        'attachment_path',
        'reviewed_at',
        'staff_notes',
    ];

    protected function casts(): array
    {
        return ['reviewed_at' => 'datetime'];
    }

    public const TYPES = [
        'enrollment_form' => 'Enrollment form',
        'certificate' => 'Certificate request',
        'transcript' => 'Transcript of records',
        'correction' => 'Student record correction',
        'other' => 'Other request',
    ];

    public const STATUSES = [
        'pending' => 'Pending review',
        'processing' => 'Processing',
        'ready' => 'Ready for release',
        'completed' => 'Completed',
        'rejected' => 'Needs clarification',
        'cancelled' => 'Cancelled',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function typeLabel(): string
    {
        return __('sias.request_' . $this->type, [], app()->getLocale()) !== 'sias.request_' . $this->type
            ? __('sias.request_' . $this->type)
            : (self::TYPES[$this->type] ?? ucfirst(str_replace('_', ' ', $this->type)));
    }

    public function statusLabel(): string
    {
        return __('sias.request_status_' . $this->status, [], app()->getLocale()) !== 'sias.request_status_' . $this->status
            ? __('sias.request_status_' . $this->status)
            : (self::STATUSES[$this->status] ?? ucfirst($this->status));
    }
}