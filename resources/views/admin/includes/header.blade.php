<header class="header-top">
    <nav class="navbar navbar-light">
        <div class="navbar-left">
            <a href="" class="sidebar-toggle">
                <img class="svg" src="{{ asset('assets/images/svg/bars.svg') }}" alt="img"></a>
            <a class="navbar-brand header-logo" href="#">
                <img class="light" width="25" src="{{ asset('assets/images/half-logo.jpg') }}" alt="img"></a>
                <h2 class="white">{{ env('APP_NAME') }}</h2>
            <!-- <form action="/" class="search-form">
                <span data-feather="search"></span>
                <input class="form-control mr-sm-2 box-shadow-none" type="text" placeholder="Search...">
            </form> -->
            
        </div>
        <!-- ends: navbar-left -->
        @php 
            $notifications = getNotifications();
            $count = $notifications['count'];
            $nots = $notifications['notifications'];
        @endphp
        <div class="navbar-right">
            <ul class="navbar-right__menu">
                
                <li class="nav-notification">
                    <div class="dropdown-custom">
                        @if($count != 0)
                            <span class="notification"></span>
                        @endif
                        <a href="javascript:;" class="nav-item-toggle ">
                            <span data-feather="bell"></span>
                        </a>
                        
                        <div class="dropdown-wrapper">
                            <h2 class="dropdown-wrapper__title">New Notifications <span
                                    class="badge-circle badge-warning ml-1">{{ $count }}</span></h2>
                            <ul>
                                @if(!empty($nots))
                                    @foreach($nots as $no)
                                        <li class="nav-notification__single nav-notification__single--unread d-flex flex-wrap">
                                            <div class="nav-notification__type nav-notification__type--info">
                                                <span data-feather="bell"></span>
                                            </div>
                                            <div class="nav-notification__details">
                                                <p>
                                                    <span>{!! $no['content'] !!}</span>
                                                </p>
                                                <p>
                                                    <span class="time-posted">{{ timeAgo($no['created_at']) }}</span>
                                                    @if($no['is_read'] == 0)
                                                    <span class="badge badge-success menuItem ml-2">New</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                <li class="nav-notification__single nav-notification__single--unread d-flex flex-wrap">
                                    <div class="nav-notification__details">
                                        <p>
                                            <span>No data found. </span>
                                        </p>
                                    </div>
                                </li>
                                @endif
                            </ul>
                            <a href="{{ route('notifications') }}" class="dropdown-wrapper__more">See all notifications</a>
                        </div>
                    </div>
                </li>
                
                <!-- ends: .nav-notification -->
                
                <!-- ends: .nav-flag-select -->
                <li class="nav-author">
                    <div class="dropdown-custom">
                        <a href="javascript:;" class="nav-item-toggle">
                            @if(Auth::user()->user_details->profile_image != null)
                                <img src="{{ asset(Auth::user()->user_details->profile_image) }}" class="rounded-circle" alt="">
                            @else
                                <img src="{{ asset('assets/images/user.png') }}" alt="" class="rounded-circle">
                            @endif
                        </a>
                        <div class="dropdown-wrapper">
                            <div class="nav-author__info">
                                <div class="author-img">
                                    
                                    @if(Auth::user()->user_details->profile_image != null)
                                        <img src="{{ asset(Auth::user()->user_details->profile_image) }}" class="rounded-circle" alt="">
                                    @else
                                        <img src="{{ asset('assets/images/user.png') }}" alt="" class="rounded-circle">
                                    @endif
                                </div>
                                <div>
                                    <h6>{{ Auth::user()->name }}</h6>
                                    <span>
                                        @php 
                                            setPermissionsTeamId(Auth::user()->user_type);
                                        @endphp
                                        @if(!empty(Auth::user()->getRoleNames()))
                                            @foreach(Auth::user()->getRoleNames() as $v)
                                                {{ $v }}
                                            @endforeach
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="nav-author__options">
                                <!-- <ul>
                                    <li>
                                        <a href="">
                                            <span data-feather="user"></span> Profile</a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <span data-feather="settings"></span> Settings</a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <span data-feather="key"></span> Billing</a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <span data-feather="users"></span> Activity</a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <span data-feather="bell"></span> Help</a>
                                    </li>
                                </ul> -->
                                <a href="{{ route('logout') }}" class="nav-author__signout">
                                    <span data-feather="log-out"></span> Sign Out</a>
                            </div>
                        </div>
                        <!-- ends: .dropdown-wrapper -->
                    </div>
                </li>
                <!-- ends: .nav-author -->
            </ul>
            <!-- ends: .navbar-right__menu -->
            <div class="navbar-right__mobileAction d-md-none">
                <a href="#" class="btn-search">
                    <span data-feather="search"></span>
                    <span data-feather="x"></span></a>
                <a href="#" class="btn-author-action">
                    <span data-feather="more-vertical"></span></a>
            </div>
        </div>
        <!-- ends: .navbar-right -->
    </nav>
</header>