<?php

namespace App\Models\Settings;

use App\Models\Settings\Division;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory, SoftDeletes;

    public function divisions(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_id', 'id')->withTrashed();
    }
}
