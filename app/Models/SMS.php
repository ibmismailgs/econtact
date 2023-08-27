<?php

namespace App\Models;

use App\Models\User;
use App\Models\Customer;
use App\Models\Settings\Thana;
use App\Models\Settings\Outlet;
use App\Models\Settings\District;
use App\Models\Settings\Division;
use App\Models\Settings\ClientSource;
use App\Models\Settings\CustomerType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\CustomerCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SMS extends Model
{
    use HasFactory, SoftDeletes;

    public function divisions(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_id', 'id')->withTrashed();
    }
    public function districits(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'id')->withTrashed();
    }
    public function thanas(): BelongsTo
    {
        return $this->belongsTo(Thana::class, 'thana_id', 'id')->withTrashed();
    }
    public function clientSources(): BelongsTo
    {
        return $this->belongsTo(ClientSource::class, 'client_source_id', 'id')->withTrashed();
    }
    public function customerCategories(): BelongsTo
    {
        return $this->belongsTo(CustomerCategory::class, 'customer_category_id', 'id')->withTrashed();
    }
    public function customerSubCategories(): BelongsTo
    {
        return $this->belongsTo(CustomerCategory::class, 'customer_category_id', 'id')->withTrashed();
    }
    public function customerTypes(): BelongsTo
    {
        return $this->belongsTo(CustomerType::class, 'customer_type_id', 'id')->withTrashed();
    }
    public function outlets(): BelongsTo
    {
        return $this->belongsTo(Outlet::class, 'outlet_id', 'id')->withTrashed();
    }
    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withTrashed();
    }
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }
}
