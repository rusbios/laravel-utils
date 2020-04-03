<nav id="rb_menu">
    <ul class="nav nav-pills flex-column">
        @foreach(app(\RusBios\LUtils\Services\Menu::class)->get() as $menu)
            <li class="nav-item">
                <a class="nav-link @if($menu['active']) active @endif" href="{{ url($menu['url']) }}" title="{{ $menu['description'] }}">{{ $menu['name'] }}</a>
            </li>
        @endforeach
    </ul>
</nav>