
<div class="kt-header__topbar">
    <div class="kt-header__topbar-item kt-header__topbar-item--user">
        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
            <span class="kt-header__topbar-icon"><i class="flaticon2-user-outline-symbol"></i></span>
        </div>
        <div
            class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
            <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
                <div class="kt-user-card__name">
{{ \Auth::user()->name ?? '' }}
</div>
</div>
<div class="kt-notification">
    <a href="{{ route('users.index') }}" class="kt-notification__item">
        <div class="kt-notification__item-icon">
            <i class="flaticon2-calendar-3 kt-font-success"></i>
        </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold">
                My Profile
            </div>
        </div>
    </a>
    <div class="kt-notification__custom kt-space-between">
        <a href="{{ route('logout') }}" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>
    </div>
</div>
</div>
</div>
</div>
