<ul>
    @foreach($menu as $menu_item)
        <li><a href="{{$menu_item['url']}}" class="{{strtolower(str_replace(' ', '', $menu_item['name']))}}">{{$menu_item['name']}}</a></li>
    @endforeach
</ul>