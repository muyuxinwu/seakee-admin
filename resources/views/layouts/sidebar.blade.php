<ul class="sidebar-menu">
    <li class="header">HEADER</li>
    <!-- Optionally, you can add icons to the links -->
    @foreach($sidebarMenu as $key => $menu)
        <li class="treeview" id="{{ $menu['id'] }}">
            <a href="{{ $menu['menu_url'] }}"><i class="fa {{ $menu['icon'] }}"></i> <span>{{ $menu['menu_name'] }}</span>
                @if(isset($menu['nodes']))
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                @endif
            </a>
            @if(isset($menu['nodes']))
                <ul class="treeview-menu">
                    @foreach($menu['nodes'] as $key => $menu)
                        <li class="" id="{{ $menu['id'] }}">
                            <a href="{{ $menu['menu_url'] }}"><i class="fa {{ $menu['icon'] }}"></i>
                                <span>{{ $menu['menu_name'] }}</span>
                                @if(isset($menu['nodes']))
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                @endif
                            </a>
                            @if(isset($menu['nodes']))
                                <ul class="treeview-menu">
                                    @foreach($menu['nodes'] as $key => $menu)
                                        <li class="" id="{{ $menu['id'] }}">
                                            <a href="{{ $menu['menu_url'] }}">
                                                <i class="fa {{ $menu['icon'] }}"></i>
                                                <span>{{ $menu['menu_name'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>