<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Settings\CallType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CallManagement extends Model
{
    use HasFactory, SoftDeletes;

    public function callTypes(): BelongsTo
    {
        return $this->belongsTo(CallType::class, 'call_type_id', 'id')->withTrashed();
    }
    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withTrashed();
    }
}
