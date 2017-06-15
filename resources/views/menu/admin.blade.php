@extends('layouts.admin')

@section('title','菜单管理')
@section('page_title','后台菜单管理')
@section('Optional_description','后台菜单管理')

@section('content')
    <!-- Default box -->
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">后台菜单列表</h3>

            <div class="box-tools pull-right">
                <a href="{{ route('menu.admin.create') }}" class="btn btn-primary">新增菜单</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>菜单名称</th>
                    <th>菜单URL</th>
                    <th class="text-center">排序</th>
                    <th class="text-center">状态</th>
                    <th class="text-center" style="width: 125px;">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($menus as $key => $menu)
                    <tr class="info">
                        <td>{{ $menu['menu_name'] }}</td>
                        <td>{{ $menu['menu_url'] }}</td>
                        <td class="text-center">{{ $menu['sort'] }}</td>
                        <td style="padding: 4px 8px;" class="text-center">
                            <input onchange="changeDisplay('{{ $menu['display'] }}','{{ $menu['id'] }}')"
                                   data-size="small" data-on-text="显示" data-off-text="隐藏" type="checkbox"
                                   @if($menu['display'] == 1) checked @endif/>
                        </td>
                        <td style="padding: 4px 8px;">
                            <a href="{{ route('menu.admin.edit') }}?id={{ $menu['id'] }}"
                               class="btn btn-primary btn-sm mr10">编辑</a>
                            <button onclick="deleteMenu({{ $menu['id'] }})" class="btn btn-danger btn-sm">删除</button>
                        </td>
                    </tr>
                    @if(isset($menu['nodes']))
                        @foreach($menu['nodes'] as $key => $menu)
                            <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;⊢ {{ $menu['menu_name'] }}</td>
                                <td>{{ $menu['menu_url'] }}</td>
                                <td class="text-center">{{ $menu['sort'] }}</td>
                                <td style="padding: 4px 8px;" class="text-center">
                                    <input onchange="changeDisplay('{{ $menu['display'] }}','{{ $menu['id'] }}')"
                                           data-size="small" data-on-text="显示" data-off-text="隐藏" type="checkbox"
                                           @if($menu['display'] == 1) checked @endif/>
                                </td>
                                <td style="padding: 4px 8px;">
                                    <a href="{{ route('menu.admin.edit') }}?id={{ $menu['id'] }}"
                                       class="btn btn-primary btn-sm mr10">编辑</a>
                                    <button onclick="deleteMenu({{ $menu['id'] }})" class="btn btn-danger btn-sm">删除
                                    </button>
                                </td>
                            </tr>
                            @if(isset($menu['nodes']))
                                @foreach($menu['nodes'] as $key => $menu)
                                    <tr>
                                        <td>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;⊢ {{ $menu['menu_name'] }}</td>
                                        <td>{{ $menu['menu_url'] }}</td>
                                        <td class="text-center">{{ $menu['sort'] }}</td>
                                        <td style="padding: 4px 8px;" class="text-center">
                                            <input onchange="changeDisplay('{{ $menu['display'] }}','{{ $menu['id'] }}')"
                                                   data-size="small" data-on-text="显示" data-off-text="隐藏"
                                                   type="checkbox" @if($menu['display'] == 1) checked @endif/>
                                        </td>
                                        <td style="padding: 4px 8px;">
                                            <a href="{{ route('menu.admin.edit') }}?id={{ $menu['id'] }}"
                                               class="btn btn-primary btn-sm mr10">编辑</a>
                                            <button onclick="deleteMenu({{ $menu['id'] }})"
                                                    class="btn btn-danger btn-sm">删除
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>菜单名称</th>
                    <th>菜单URL</th>
                    <th class="text-center">排序</th>
                    <th class="text-center">状态</th>
                    <th class="text-center">操作</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- /.box -->
@endsection

@section('page_style')
    <style>
        .mr10 {
            margin-right: 10px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/highlight.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-switch.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection

@section('page_js')
    <script src="{{ asset('js/highlight.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/bootstrap-switch.js') }}"></script>
    <script>
        function deleteMenu(id) {
            swal({
                title: '确认删除',
                text: '确定要删除吗?',
                type: 'warning',
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                $.ajax({
                    url: '{{ route('menu.delete') }}',
                    type: 'POST',
                    data: {id: id, _token: '{{ csrf_token() }}'},
                    dataType: 'JSON',
                    success: function (res) {
                        if (res.status == 200) {
                            swal({
                                title: '删除成功',
                                text: '点击确定返回',
                                type: 'success'
                            }, function () {
                                window.location.reload();
                            });
                        } else {
                            swal('删除失败', res.message || '出错', 'error');
                        }
                    }
                });
            })
        }

        function changeDisplay(state, id) {

            if (state == 1) {
                var display = 0;
            } else {
                display = 1;
            }

            $.ajax({
                url: '{{ route('menu.changeDisplay') }}',
                type: 'POST',
                data: {
                    id: id,
                    display: display
                },
                dataType: 'JSON',
                success: function (res) {
                    if (res.status == 500) {
                        swal('操作失败', res.message || '出错', 'error');
                        window.location.reload();
                    }
                }
            });
        }
    </script>
@endsection


