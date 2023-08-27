<?php

namespace App\Models;

use App\Models\Meeting;
use App\Models\Customer;
use App\Models\Settings\QuotationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    public function meetings(): BelongsTo
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id')->withTrashed();
    }
    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withTrashed();
    }
    public function quotationTypes(): BelongsTo
    {
        return $this->belongsTo(QuotationType::class, 'quotation_type_id', 'id')->withTrashed();
    }
}
