@inject('MenuPresenter', 'App\Presenters\Admin\MenuPresenter')
<!-- search form (Optional) -->
<form action="#" method="get" class="sidebar-form">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
    </div>
</form>
<!-- /.search form -->
<ul class="sidebar-menu">
    <li class="header">HEADER</li>
    <!-- Optionally, you can add icons to the links -->
    @php $sidebarMenu = $MenuPresenter->sidebarMenu($sidebarMenu) @endphp
    @foreach($sidebarMenu as $key => $menu)
        <li class="treeview @if(isset($menu['class'])) {{ $menu['class'] }} @endif">
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
                        <li class="@if(isset($menu['class'])) {{ $menu['class'] }} @endif">
                            <a href="{{ $menu['menu_url'] }}"><i class="fa {{ $menu['icon'] }}"></i>
                                <span>{{ $menu['menu_name'] }}</span>
                                @if(isset($menu['nodes']))
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>