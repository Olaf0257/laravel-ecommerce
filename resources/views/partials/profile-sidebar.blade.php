<div class="sidebar">
    <div class="inner-sidebar">
        <ul>
            @if (request()->url() == route('profile.edit'))
                <li class="active">My Profile</li>
            @else
                <li><a href="{{ route('profile.edit') }}">My Profile</a></li>
            @endif

            @if (request()->url() == route('orders.index'))
                <li class="active">My Orders</li>
            @else
                <li><a href="{{ route('orders.index') }}">My Orders</a></li>
            @endif
        </ul>
    </div>
</div>