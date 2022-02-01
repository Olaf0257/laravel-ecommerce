<ul>
    @foreach($items as $menu_item)
        <li>
    		@if ($menu_item->title == 'Follow Us:')
                <span>{{ $menu_item->title }}</span>
            @else
        		<a href="{{ $menu_item->link() }}"><i class="{{ $menu_item->icon_class }}"></i></a>
    		@endif
        </li>
    @endforeach
</ul>