<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('dashboard')}}">
            <div class="logo-img">
               <img height="30px"
               width="156px" src="{{ asset('img/logo.png')}}" class="header-brand-img" title="E-Contact">
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
        $route = Route::current()->getName();
    @endphp

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ ($segment1 == 'dashboard') ? 'active' : '' }}">
                    <a href="{{route('dashboard')}}"><i class="ik ik-bar-chart-2"></i><span>{{ __('Dashboard')}}</span></a>
                </div>

                @can('manage_user')
                <div class="nav-item {{ ($segment1 == 'users' || $segment1 == 'roles'||$segment1 == 'permission' ||$segment1 == 'user') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-user"></i><span>{{ __('Adminstrator')}}</span></a>
                    <div class="submenu-content">
                        @can('manage_user')
                        <a href="{{url('users')}}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('Users')}}</a>
                        <a href="{{url('user/create')}}" class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add User')}}</a>
                         @endcan
                        @can('manage_roles')
                        <a href="{{url('roles')}}" class="menu-item {{ ($segment1 == 'roles') ? 'active' : '' }}">{{ __('Roles')}}</a>
                        @endcan
                        @can('manage_permission')
                        <a href="{{url('permission')}}" class="menu-item {{ ($segment1 == 'permission') ? 'active' : '' }}">{{ __('Permission')}}</a>
                        @endcan
                    </div>
                </div>
                @endcan

                @can('manage_customers')
                <div class="nav-item {{ ( $route == 'client.index' || $route == 'client.create' || $route == 'client.edit' || $route == 'client.show') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="fa fa-users"></i><span>{{ __('Customer')}}</span></a>
                    <div class="submenu-content">
                       @can('manage_customers')
                            <a href="{{ route('client.index') }}" class="menu-item {{ ( $route == 'client.index' || $route == 'client.create' || $route == 'client.edit' || $route == 'client.show') ? 'active' : '' }}">{{ __('Customer Management')}}</a>
                        @endcan
                    </div>
                 </div>
                 @endcan

                 @can('manage_calls')
                 <div class="nav-item {{ ( $route == 'call-management.index' || $route == 'call-management.create' || $route == 'call-management.edit' || $route == 'call-management.show') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="fa fa-phone"></i><span>{{ __('Call-Management')}}</span></a>
                    <div class="submenu-content">
                        @can('manage_calls')
                            <a href="{{ route('call-management.index') }}" class="menu-item {{ ( $route == 'call-management.index' || $route == 'call-management.create' || $route == 'call-management.edit' || $route == 'call-management.show') ? 'active' : '' }}">{{ __('Call-Management List')}}</a>
                        @endcan
                    </div>
                 </div>
                 @endcan

                 @can('manage_meetings')
                 <div class="nav-item {{ ( $route == 'meeting.index' || $route == 'meeting.create' || $route == 'meeting.edit' || $route == 'meeting.show') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="fa fa-handshake"></i><span>{{ __('Meeting')}}</span></a>
                    <div class="submenu-content">
                        @can('manage_meetings')
                            <a href="{{ route('meeting.index') }}" class="menu-item {{ ( $route == 'meeting.index' || $route == 'meeting.create' || $route == 'meeting.edit' || $route == 'meeting.show') ? 'active' : '' }}">{{ __('Meeting List')}}</a>
                        @endcan
                    </div>
                 </div>
                 @endcan

                 @can('manage_quotations')
                 <div class="nav-item {{ ( $route == 'quotations.index' || $route == 'quotations.create' || $route == 'quotations.edit' || $route == 'quotations.show') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="fa fa-quote-left"></i><span>{{ __('Quotations')}}</span></a>
                    <div class="submenu-content">
                        @can('manage_quotations')
                            <a href="{{ route('quotations.index') }}" class="menu-item {{ ( $route == 'quotations.index' || $route == 'quotations.create' || $route == 'quotations.edit' || $route == 'quotations.show') ? 'active' : '' }}">{{ __('Quotation List')}}</a>
                        @endcan
                    </div>
                 </div>
                 @endcan

                 @can('manage_marketing')
                 <div class="nav-item {{ ( $route == 'sms-marketing.index' || $route == 'sms-marketing.create' || $route == 'sms-marketing.edit' || $route == 'sms-marketing.show' || $route == 'email-marketing.index' || $route == 'email-marketing.create' || $route == 'email-marketing.edit' || $route == 'email-marketing.show' || $route == 'whatsapp-marketing.index' || $route == 'whatsapp-marketing.create' || $route == 'whatsapp-marketing.edit' || $route == 'whatsapp-marketing.show') ? 'active open' : '' }} has-sub">
                    <a href="javascript:void(0)"><i class="ik ik-list"></i><span>{{ __('Marketing')}}</span></a>

                    <div class="submenu-content">
                        <div class="nav-item {{ ( $route == 'sms-marketing.index' || $route == 'sms-marketing.create' || $route == 'sms-marketing.edit' || $route == 'sms-marketing.show') ? 'active open' : '' }} has-sub">
                            <a href="javascript:void(0)" class="menu-item">{{ __('SMS Marketing')}}</a>
                            <div class="submenu-content">
                                @can('manage_sms')
                                    <a href="{{ route('sms-marketing.index') }}" class="menu-item {{ ( $route == 'sms-marketing.index' || $route == 'sms-marketing.create' || $route == 'sms-marketing.edit' || $route == 'sms-marketing.show') ? 'active' : '' }}">{{ __('SMS List')}}</a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="submenu-content">
                        <div class="nav-item {{ ( $route == 'email-marketing.index' || $route == 'email-marketing.create' || $route == 'email-marketing.edit' || $route == 'email-marketing.show') ? 'active open' : '' }} has-sub">
                            <a href="javascript:void(0)" class="menu-item">{{ __('Email Marketing')}}</a>
                            <div class="submenu-content">
                                @can('manage_email')
                                    <a href="{{ route('email-marketing.index') }}" class="menu-item {{ ( $route == 'email-marketing.index' || $route == 'email-marketing.create' || $route == 'email-marketing.edit' || $route == 'email-marketing.show') ? 'active' : '' }}">{{ __('Email List')}}</a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="submenu-content">
                        <div class="nav-item {{ ( $route == 'whatsapp-marketing.index' || $route == 'whatsapp-marketing.create' || $route == 'whatsapp-marketing.edit' || $route == 'whatsapp-marketing.show') ? 'active open' : '' }} has-sub">
                            <a href="javascript:void(0)" class="menu-item">{{ __('Whatsapp Marketing')}}</a>
                            <div class="submenu-content">
                                @can('manage_whatsapp')
                                    <a href="https://web.whatsapp.com/" class="menu-item {{ ( $route == 'whatsapp-marketing.create') ? 'active' : '' }}">{{ __('Create Whatsapp')}}</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('manage_reports')
                <div class="nav-item {{ ( $route == 'client-report' || $route == 'meeting-report' || $route == 'quotation-report' || $route == 'call-management-report') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="fa fa-file"></i><span>{{ __('Reports')}}</span></a>
                    <div class="submenu-content">
                       @can('customer_report')
                            <a href="{{ route('client-report') }}" class="menu-item {{ ( $route == 'client-report') ? 'active' : '' }}">{{ __('Customer Management Report')}}</a>
                        @endcan

                        @can('call_report')
                            <a href="{{ route('call-management-report') }}" class="menu-item {{ ( $route == 'call-management-report') ? 'active' : '' }}">{{ __('Call Management Report')}}</a>
                        @endcan

                        @can('meeting_report')
                            <a href="{{ route('meeting-report') }}" class="menu-item {{ ( $route == 'meeting-report') ? 'active' : '' }}">{{ __('Meeting Report')}}</a>
                        @endcan

                        @can('quotation_report')
                            <a href="{{ route('quotation-report') }}" class="menu-item {{ ( $route == 'quotation-report') ? 'active' : '' }}">{{ __('Quotation Report')}}</a>
                        @endcan
                    </div>
                 </div>
                 @endcan

                 @can('manage_settings')
                 <div class="nav-item {{ ($route == 'general-settings' || $route == 'division.index' || $route == 'district.index' || $route == 'thana.index' || $route == 'client-source.index' || $route == 'customer-type.index' || $route == 'customer-categories.index' || $route == 'outlet.index' || $route == 'meeting-type.index' || $route == 'quotation-type.index' || $route == 'call-type.index' || $route == 'group.index') ? 'active open' : '' }} has-sub">
                    <a href="javascript:void(0)" class="menu-item {{ ( $route == 'general-settings' ) ? 'active' : '' }}"><i class="fa fa-cog"></i>{{ __('Settings')}}</a>
                        <div class="submenu-content">
                            @can('site_settings')
                                <a href="{{route('general-settings')}}" class="menu-item {{ ( $route == 'general-settings') ? 'active' : '' }}">{{ __('General Settings')}}</a>
                            @endcan
                            @can('manage_division')
                                <a href="{{ route('division.index') }}" class="menu-item {{ ( $route == 'division.index') ? 'active' : '' }}">{{ __('Division List')}}</a>
                            @endcan
                            @can('manage_district')
                                <a href="{{ route('district.index') }}" class="menu-item {{ ( $route == 'district.index') ? 'active' : '' }}">{{ __('District List')}}</a>
                            @endcan
                            @can('manage_thana')
                                <a href="{{ route('thana.index') }}" class="menu-item {{ ( $route == 'thana.index') ? 'active' : '' }}">{{ __('Thana List')}}</a>
                            @endcan
                            @can('manage_client_source')
                                <a href="{{ route('client-source.index') }}" class="menu-item {{ ( $route == 'client-source.index') ? 'active' : '' }}">{{ __('Customer Sources')}}</a>
                            @endcan
                            @can('manage_customer_status')
                                <a href="{{ route('customer-type.index') }}" class="menu-item {{ ( $route == 'customer-type.index') ? 'active' : '' }}">{{ __('Customer Status')}}</a>
                            @endcan
                            @can('manage_customer_categories')
                                <a href="{{ route('customer-categories.index') }}" class="menu-item {{ ( $route == 'customer-categories.index') ? 'active' : '' }}">{{ __('Customer Categories')}}</a>
                            @endcan
                            @can('manage_outlet')
                                <a href="{{ route('outlet.index') }}" class="menu-item {{ ( $route == 'outlet.index') ? 'active' : '' }}">{{ __('Outlet List')}}</a>
                            @endcan
                            @can('manage_meeting_type')
                                <a href="{{ route('meeting-type.index') }}" class="menu-item {{ ( $route == 'meeting-type.index') ? 'active' : '' }}">{{ __('Meeting Types')}}</a>
                            @endcan
                            @can('manage_quotation_type')
                                <a href="{{ route('quotation-type.index') }}" class="menu-item {{ ( $route == 'quotation-type.index') ? 'active' : '' }}">{{ __('Quotation Types')}}</a>
                            @endcan
                            @can('manage_call_type')
                                <a href="{{ route('call-type.index') }}" class="menu-item {{ ( $route == 'call-type.index') ? 'active' : '' }}">{{ __('Call Type')}}</a>
                            @endcan
                            @can('manage_group')
                                <a href="{{ route('group.index') }}" class="menu-item {{ ( $route == 'group.index') ? 'active' : '' }}">{{ __('Group List')}}</a>
                            @endcan
                        </div>
                </div>
                @endcan
        </div>
    </div>
</div>
