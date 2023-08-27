<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MeetingMinute extends Model
{
    use HasFactory, SoftDeletes;

    public function meetings(): BelongsTo
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id')->withTrashed();
    }
}
