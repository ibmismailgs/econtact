<?php

namespace App\Models\Settings;

use App\Models\Settings\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thana extends Model
{
    use HasFactory, SoftDeletes;

    public function districts(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'id')->withTrashed();
    }
}
