<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'name' => 'manage_role',
                'group_name' => 'adminstrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_permission',
                'group_name' => 'adminstrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_user',
                'group_name' => 'adminstrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_customers',
                'group_name' => 'adminstrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_calls',
                'group_name' => 'adminstrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_meetings',
                'group_name' => 'adminstrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_quotations',
                'group_name' => 'adminstrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_marketing',
                'group_name' => 'adminstrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_email',
                'group_name' => 'adminstrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_sms',
                'group_name' => 'adminstrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_whatsapp',
                'group_name' => 'adminstrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_reports',
                'group_name' => 'adminstrator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'site_settings',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_settings',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_division',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'division_create',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'division_edit',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'division_delete',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'division_status',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_district',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'district_create',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'district_edit',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'district_delete',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'district_status',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_thana',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'thana_create',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'thana_edit',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'thana_delete',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'thana_status',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_customer_source',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_source_create',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_source_edit',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_source_delete',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_source_status',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_customer_status',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_status_create',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_status_edit',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_status_delete',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customers_status',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_customer_categories',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_categories_create',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_categories_edit',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_categories_delete',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_categories_status',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_outlet',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'outlet_create',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'outlet_edit',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'outlet_delete',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'outlet_status',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_meeting_type',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meeting_types_create',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meeting_types_edit',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meeting_types_delete',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meeting_types_status',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_quotation_type',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'quotation_types_create',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'quotation_types_edit',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'quotation_types_delete',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'quotation_types_status',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_call_type',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'call_types_create',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'call_types_edit',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'call_types_delete',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'call_types_status',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_group',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'group_create',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'group_edit',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'group_delete',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'group_status',
                'group_name' => 'Settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_create',
                'group_name' => 'Customer Manage',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_edit',
                'group_name' => 'Customer Manage',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_show',
                'group_name' => 'Customer Manage',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_delete',
                'group_name' => 'Customer Manage',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_status',
                'group_name' => 'Customer Manage',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_assign',
                'group_name' => 'Customer Manage',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_import',
                'group_name' => 'Customer Manage',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_export',
                'group_name' => 'Customer Manage',
                'guard_name' => 'web',
            ],
            [
                'name' => 'call_create',
                'group_name' => 'Call Manage',
                'guard_name' => 'web',
            ],
            [
                'name' => 'call_edit',
                'group_name' => 'Call Manage',
                'guard_name' => 'web',
            ],
            [
                'name' => 'call_delete',
                'group_name' => 'Call Manage',
                'guard_name' => 'web',
            ],
            [
                'name' => 'call_show',
                'group_name' => 'Call Manage',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meeting_create',
                'group_name' => 'Meetings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meeting_edit',
                'group_name' => 'Meetings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meeting_show',
                'group_name' => 'Meetings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meeting_delete',
                'group_name' => 'Meetings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meeting_status',
                'group_name' => 'Meetings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meeting_minutes',
                'group_name' => 'Meetings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meeting_reschedule',
                'group_name' => 'Meetings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meeting_quotation',
                'group_name' => 'Meetings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'quotation_create',
                'group_name' => 'Quotations',
                'guard_name' => 'web',
            ],
            [
                'name' => 'quotation_edit',
                'group_name' => 'Quotations',
                'guard_name' => 'web',
            ],
            [
                'name' => 'quotation_show',
                'group_name' => 'Quotations',
                'guard_name' => 'web',
            ],
            [
                'name' => 'quotation_status',
                'group_name' => 'Quotations',
                'guard_name' => 'web',
            ],
            [
                'name' => 'quotation_delete',
                'group_name' => 'Quotations',
                'guard_name' => 'web',
            ],
            [
                'name' => 'sms_create',
                'group_name' => 'Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'sms_edit',
                'group_name' => 'Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'sms_show',
                'group_name' => 'Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'sms_status',
                'group_name' => 'Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'sms_delete',
                'group_name' => 'Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'email_create',
                'group_name' => 'Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'email_edit',
                'group_name' => 'Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'email_show',
                'group_name' => 'Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'email_status',
                'group_name' => 'Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'email_delete',
                'group_name' => 'Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'whatsapp_create',
                'group_name' => 'Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customer_report',
                'group_name' => 'Reports',
                'guard_name' => 'web',
            ],
            [
                'name' => 'call_report',
                'group_name' => 'Reports',
                'guard_name' => 'web',
            ],
            [
                'name' => 'meeting_report',
                'group_name' => 'Reports',
                'guard_name' => 'web',
            ],
            [
                'name' => 'quotation_report',
                'group_name' => 'Reports',
                'guard_name' => 'web',
            ],

        ]);
    }
}
