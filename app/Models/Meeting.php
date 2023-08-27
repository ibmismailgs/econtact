<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Settings\MeetingType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meeting extends Model
{
    use HasFactory, SoftDeletes;

    public function meetingTypes(): BelongsTo
    {
        return $this->belongsTo(MeetingType::class, 'meeting_type_id', 'id')->withTrashed();
    }
    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withTrashed();
    }
}
