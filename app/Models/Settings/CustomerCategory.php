<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerCategory extends Model
{
    use HasFactory, SoftDeletes;

    public function categories(): BelongsTo
    {
        return $this->belongsTo(CustomerCategory::class, 'category_id', 'id')->withTrashed();
    }
}
