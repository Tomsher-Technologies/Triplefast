<aside class="profile-sider">
    <!-- Profile Acoount -->
    <div class="card mb-25">
        <div class="card-body text-center pt-sm-30 pb-sm-0  px-25 pb-0">

            <div class="account-profile">
                <div class="ap-img w-100 d-flex justify-content-center">
                    <!-- Profile picture image-->

                    @if($user->user_details->profile_image != NULL)
                        <img class="ap-img__main rounded-circle mb-3  wh-120 d-flex bg-opacity-primary" src="{{ asset($user->user_details->profile_image) }}" alt="profile">
                    @else
                        <img class="ap-img__main rounded-circle mb-3  wh-120 d-flex bg-opacity-primary"
                        src="{{ asset('assets/images/user.png') }}" alt="profile">
                    @endif
                    
                </div>
                <div class="ap-nameAddress pb-3 pt-1">
                    <h5 class="ap-nameAddress__title">{{ $user->name }}</h5>
                    <p class="ap-nameAddress__subTitle fs-14 m-0">
                        @php 
                            setPermissionsTeamId($user->user_type);
                        @endphp
                        @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                            {{ $v }} ({{ $user->userType[0]->title ?? '' }})
                            @endforeach
                        @endif
                    </p>
                    <p class="ap-nameAddress__subTitle fs-14 m-0">
                        @if($user->is_active == 1)
                            <span class="badge badge-round badge-success badge-lg">Active</span>
                        @else
                            <span class="badge badge-round badge-danger badge-lg">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile Acoount End -->

    <!-- Profile User Bio -->
    <div class="card mb-25">
        <div class="user-info border-bottom">
            <div class="card-header border-bottom-0 pt-sm-25 pb-sm-0  px-md-25 px-3">
                <div class="profile-header-title">
                    Contact info
                </div>
            </div>
            <div class="card-body pt-md-1 pt-0">
                <div class="user-content-info">
                    <p class="user-content-info__item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-mail">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>{{ $user->email }}
                    </p>
                    <p class="user-content-info__item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-phone">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>{{ $user->user_details->phone_number }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile User Bio End -->
</aside>