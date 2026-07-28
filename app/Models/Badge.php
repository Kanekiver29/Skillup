<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'type',
    ];

    public function userBadges()
    {
        return $this->hasMany(UserBadge::class);
    }

    /**
     * Check if a specific user has earned this badge for a given entity.
     */
    public function isEarnedBy($userId, $badgeableType = null, $badgeableId = null)
    {
        $query = $this->userBadges()->where('user_id', $userId);

        if ($badgeableType && $badgeableId) {
            $query->where('badgeable_type', $badgeableType)
                  ->where('badgeable_id', $badgeableId);
        }

        return $query->exists();
    }
}
