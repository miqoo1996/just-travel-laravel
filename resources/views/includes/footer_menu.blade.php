<div class="footer-menu">
    <ul>
        @foreach($menu as $menu_item)
            <li><a href="{{$menu_item['page_url']}}"
                   class="{{strtolower(str_replace(' ', '', $menu_item['page_name_'.app()->getLocale()]))}}">{{$menu_item['page_name_'.app()->getLocale()]}}</a>
            </li>
        @endforeach
    </ul>
</div>