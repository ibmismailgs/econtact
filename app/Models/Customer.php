<?php

namespace App\Models;

use App\Models\User;
use App\Models\Settings\Thana;
use App\Models\Settings\Outlet;
use App\Models\Settings\District;
use App\Models\Settings\Division;
use App\Models\Settings\ClientSource;
use App\Models\Settings\CustomerType;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Settings\CustomerCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Customer extends Model implements ToModel, WithHeadingRow
{
    use HasFactory, SoftDeletes;

    protected $table = 'customers';
    protected $fillable = [
        'date',
        'name',
        'designation',
        'address',
        'email',
        'company_name',
        'primary_phone',
        'secondary_phone',
        'division_id',
        'district_id',
        'thana_id',
        'client_source_id',
        'customer_category_id',
        'customer_subcategory_id',
        'customer_subcategory',
        'customer_type_id',
        'outlet_id',
        'is_meeting',
        'is_call',
        'status',
        'assign_to',
        'created_by',
        'note',
       ];

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
        return $this->belongsTo(CustomerCategory::class, 'customer_subcategory_id', 'id')->withTrashed();
    }
    public function customerTypes(): BelongsTo
    {
        return $this->belongsTo(CustomerType::class, 'customer_type_id', 'id')->withTrashed();
    }
    public function outlets(): BelongsTo
    {
        return $this->belongsTo(Outlet::class, 'outlet_id', 'id')->withTrashed();
    }
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assign_to', 'id')->withTrashed();
    }
    public function userName(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->withTrashed();
    }
    public function model(array $row)
    {
        $divisionId = isset($row['division_name']) ? $row['division_name'] : null;
        $districtId = isset($row['district_name']) ? $row['district_name'] : null;
        $thanaId = isset($row['thana_name']) ? $row['thana_name'] : null;
        $customerSourceId = isset($row['customer_source']) ? $row['customer_source'] : null;
        $customerCatId = isset($row['customer_category']) ? $row['customer_category'] : null;
        $customerSubId = isset($row['customer_subcategory']) ? $row['customer_subcategory'] : null;
        $customerType = isset($row['customer_status']) ? $row['customer_status'] : null;
        $outletId = isset($row['outlet_name']) ? $row['outlet_name'] : null;
        $assignId = isset($row['assign_to']) ? $row['assign_to'] : null;
        $createdId = isset($row['created_by']) ? $row['created_by'] : null;

        return new Customer([
            'date' => $row['date'],
            'name' => $row['name'],
            'designation' => $row['designation'],
            'address' => $row['address'],
            'email' => $row['email'],
            'company_name' => $row['company_name'],
            'primary_phone' => $row['primary_phone'],
            'secondary_phone' => $row['secondary_phone'],
            'division_id' => $divisionId != null ? Division::where('name', $divisionId)->firstOrFail()->id : null,
            'district_id' => $districtId != null ? District::where('name', $districtId)->firstOrFail()->id : null,
            'thana_id' => $thanaId != null ? Thana::where('name', $thanaId)->firstOrFail()->id : null,
            'client_source_id' =>  $customerSourceId != null ? ClientSource::where('title', $customerSourceId)->firstOrFail()->id : null,
            'customer_category_id' =>  $customerCatId != null ? CustomerCategory::where('title', $customerCatId)->firstOrFail()->id : null,
            'customer_subcategory_id' =>  $customerSubId != null ? CustomerCategory::where('title', $customerSubId)->firstOrFail()->id : null,
            'customer_type_id' =>  $customerType != null ? CustomerType::where('title', $customerType)->firstOrFail()->id : null,
            'outlet_id' =>  $outletId != null ? Outlet::where('title', $outletId)->firstOrFail()->id : null,
            'assign_to' =>  $assignId != null ? User::where('name', $assignId)->firstOrFail()->id : null,
            'created_by' =>  $createdId != null ? User::where('name', $createdId)->firstOrFail()->id : null,
            'is_meeting' => $row['is_meeting']=='Yes' ? 1 : 0,
            'is_call' => $row['is_call']=='Yes' ? 1 : 0,
            'status' => $row['status']=='Active' ? 1 : 1,
            'note' => $row['note'],
        ]);
    }
}
