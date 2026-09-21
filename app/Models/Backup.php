<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Backup extends Model
{
    protected $fillable = [
        'filename',
        'path',
        'size',
        'type',
        'status',
        'checksum',
        'message',
        'started_at',
        'completed_at',
        'created_by',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
            'metadata' => 'array',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function recoveryLogs(): HasMany
    {
        return $this->hasMany(RecoveryLog::class);
    }
}
