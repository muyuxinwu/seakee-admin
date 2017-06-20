@extends('layouts.admin')

@section('title','用户中心')
@section('page_title','用户管理')
@section('Optional_description','')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">用户列表</h3>
            共找到{{ $users->total() }}条结果
            <div class="box-tools pull-right">
                <a href="{{ route('user.admin.create') }}" class="btn btn-primary">新增用户</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>用户名</th>
                    <th>昵称</th>
                    <th>E-mail</th>
                    <th>手机号</th>
                    <th class="text-center">状态</th>
                    <th class="text-center" style="width: 185px;">操作</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <td>{{ $user['user_name'] }}</td>
                            <td>{{ $user['nick_name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['phone'] }}</td>
                            <td style="padding: 4px 8px;" class="text-center">
                                <input onchange="changeStatus('{{ $user['status'] }}','{{ $user['id'] }}')" data-size="small" data-on-text="启用" data-off-text="禁用" type="checkbox" @if($user['status'] == 1) checked @endif/>
                            </td>
                            <td style="padding: 4px 8px;">
                                <a href="{{ route('user.admin.edit') }}?id={{ $user['id'] }}" class="btn btn-primary btn-sm mr10">编辑</a>
                                <a href="{{ route('role.userRoleList') }}?userID={{ $user['id'] }}" class="btn btn-info btn-sm mr10">角色</a>
                                <button onclick="deleteUser({{ $user['id'] }})" class="btn btn-danger btn-sm">删除</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>用户名</th>
                    <th>昵称</th>
                    <th>E-mail</th>
                    <th>手机号</th>
                    <th class="text-center">状态</th>
                    <th class="text-center" style="width: 125px;">操作</th>
                </tr>
                </tfoot>
            </table>
            <div class="pull-right">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection

@section('page_style')
    <style>
        .mr10{
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
        function deleteUser(id) {
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
                    url: '{{ route('user.delete') }}',
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

        function changeStatus(state,id) {

            if (state == 1) {
                var status = 0;
            } else {
                status = 1;
            }

            $.ajax({
                url: '{{ route('user.changeStatus') }}',
                type: 'POST',
                data: {id: id,
                    status: status},
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