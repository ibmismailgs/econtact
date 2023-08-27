<header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>

                <div class="header-search">
                    <div class="input-group">

                        <span class="input-group-addon search-close">
                            <i class="ik ik-x"></i>
                        </span>
                        <input type="text" class="form-control">
                        <span class="input-group-addon search-btn"><i class="ik ik-search"></i></span>
                    </div>
                </div>
                <button class="nav-link" title="clear cache">
                    <a  href="{{url('clear-cache')}}">
                    <i class="ik ik-battery-charging"></i>
                </a>
                </button> &nbsp;&nbsp;
                <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button>
            </div>
            <div class="top-menu d-flex align-items-center">
                <div class="dropdown">
                    <a title="Notification" class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-bell"></i><span class="badge bg-danger">{{ $total ?? '0' }}</span></a>
                    <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="notiDropdown">
                        <h4 class="header">{{ __('Notifications')}}</h4>
                        <div class="notifications-wrap" style="overflow-y: scroll; height:200px !important">
                            @foreach($meeting as $item)
                            <a href="{{ route('client.show', $item->id) }}" class="media">
                                <span class="d-flex">
                                    <img src="@if(isset($item->attachment)){{ asset('img/attachment/'.$item->attachment)}} @else {{asset('img/avatar.png')}}  @endif" alt="Image" width="30" height="30">
                                </span>
                                <span class="media-body">
                                    <span class="heading-font-family media-heading">{{ $item->name }}, </span>
                                    <span class="media-content">{{ Carbon\Carbon::parse($item->date)->format('d F Y') }}, {{ date('g:i a', strtotime($item->time)) }}</span>
                                </span>
                            </a>
                            @endforeach
                            {{-- <a href="#" class="media">
                                <span class="d-flex">
                                    <img src="{{ asset('img/users/1.jpg')}}" class="rounded-circle" alt="">
                                </span>
                                <span class="media-body">
                                    <span class="heading-font-family media-heading">{{ __('Steve Smith')}}</span>
                                    <span class="media-content">{{ __('I slowly updated projects')}}</span>
                                </span>
                            </a> --}}
                            {{-- <a href="#" class="media">
                                <span class="d-flex">
                                    <i class="ik ik-calendar"></i>
                                </span>
                                <span class="media-body">
                                    <span class="heading-font-family media-heading">{{ __('To Do')}}</span>
                                    <span class="media-content">{{ __('Meeting with Nathan on Friday 8 AM ...')}}</span>
                                </span>
                            </a> --}}
                        </div>
                        <div class="footer"><a href="{{ route('client.index') }}">{{ __('See all notification')}}</a></div>
                    </div>
                </div>

                <div class="dropdown">
                    {{ Auth::user()->name }}
                    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="{{ asset('img/logo.png')}}" alt=""></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ url('logout') }}">
                            <i class="ik ik-power dropdown-icon"></i>
                            {{ __('Logout')}}
                        </a>
                        <span class="dropdown-item">
                            {{-- {{ Auth::user()->name }} --}}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>

