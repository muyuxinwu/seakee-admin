@extends('layouts.admin')

@section('title','用户管理')
@section('page_title','权限管理')
@section('Optional_description','')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">权限列表</h3>
            共找到{{ $permissions->total() }}条结果
            <div class="box-tools pull-right">
                <button  data-toggle="modal" data-target="#routeList" class="btn btn-default">路由列表</button>
                <button  class="btn btn-success" id="batchCreate">一键新增</button>
                <button  data-toggle="modal" data-target="#createRole" class="btn btn-primary">新增权限</button>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>权限标识</th>
                    <th>权限名称</th>
                    <th>权限描述</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th class="text-center" style="width: 125px;">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $key => $permission)
                    <tr>
                        <td>{{ $permission['name'] }}</td>
                        <td>{{ $permission['display_name'] }}</td>
                        <td>{{ $permission['description'] }}</td>
                        <td>{{ $permission['created_at'] }}</td>
                        <td>{{ $permission['updated_at'] }}</td>
                        <td style="padding: 4px 8px;">
                            <button onclick="getEdit({{ $permission['id'] }})" class="btn btn-primary btn-sm mr10">编辑</button>
                            <button onclick="deleteRole({{ $permission['id'] }})" class="btn btn-danger btn-sm">删除</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>权限标识</th>
                    <th>权限名称</th>
                    <th>权限描述</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th class="text-center">操作</th>
                </tr>
                </tfoot>
            </table>
            <div class="pull-right">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>

    <!-- create user Modal -->
    <div class="modal fade" id="createRole" tabindex="-1" role="dialog" aria-labelledby="newRole">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="newRole">新增权限</h4>
                </div>
                <form class="form-horizontal" id="createForm">
                    <div class="modal-body">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="col-sm-3 control-label">自定义权限</label>
                            <div class="col-sm-8">
                                <div class="radio col-sm-3">
                                    <label>
                                        <input type="radio" name="isCustom" value="0" checked>否
                                    </label>
                                </div>
                                <div class="radio col-sm-3">
                                    <label>
                                        <input type="radio" name="isCustom" value="1">是
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">权限标识</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" placeholder="请输入路由名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">权限名称</label>
                            <div class="col-sm-8">
                                <input type="text" name="display_name" class="form-control" placeholder="请输入权限名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">权限描述</label>
                            <div class="col-sm-8">
                                <input type="text" name="description" class="form-control" placeholder="请输入权限描述">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" id="toCreate">新增权限</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- edit user Modal -->
    <div class="modal fade" id="editRole" tabindex="-1" role="dialog" aria-labelledby="editInfo">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editInfo">编辑权限</h4>
                </div>
                <form class="form-horizontal" id="editForm">
                    <div class="modal-body">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="" id="editID">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">权限标识</label>
                            <div class="col-sm-8">
                                <input type="text" id="editName" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">权限名称</label>
                            <div class="col-sm-8">
                                <input type="text" id="editDisplayName" name="display_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">权限描述</label>
                            <div class="col-sm-8">
                                <input type="text" id="editDescription" name="description" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" id="toEdit">编辑权限</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- route list Modal -->
    <div class="modal fade" id="routeList" tabindex="1" role="dialog" aria-labelledby="routeList">
        <div class="modal-dialog" role="document" style="width:800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">路由列表</h4>
                </div>
                <div class="modal-body">
                    <table id="routeListTable" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Method</th>
                            <th>Name</th>
                            <th>Uri</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($routeList as $key => $route)
                            <tr>
                                <td>{{ $route['method'] }}</td>
                                <td>{{ $route['name'] }}</td>
                                <td>{{ $route['uri'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Method</th>
                            <th>Name</th>
                            <th>Uri</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
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
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('page_js')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function () {
            $("#routeListTable").DataTable(); 
        });
        function getEdit(id) {
            $.ajax({
                url: '{{ route('permission.showEdit') }}',
                type: 'GET',
                data: {id: id},
                dataType: 'JSON',
                success: function (res) {
                    if (res.status == 200) {
                        var data = res.data;
                        $('#editID').val(data['id']);
                        $('#editName').val(data['name']);
                        $('#editDisplayName').val(data['display_name']);
                        $('#editDescription').val(data['description']);
                        $('#editRole').modal('show');
                    } else {
                        swal('请求失败', res.message || '出错', 'error');
                        $('#editRole').modal('hide');
                    }
                }
            });

        }

        $('#toEdit').click(function () {
            $form = $('#editForm');
            $form.find('#toEdit, #draftSave').prop('disabled', true);
            var formData = new FormData($form[0]);
            $.ajax({
                url: '{{ route('permission.edit') }}',
                type: 'POST',
                data: formData,
                processData: false,  // 告诉jQuery不要去处理发送的数据
                contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
                dataType: 'JSON',
                success: function (res) {
                    if(res.status == 200){
                        swal({
                            title: '编辑成功',
                            text: '点击确定返回',
                            type: 'success'
                        }, function () {
                            window.location.href = '{{ route('permission.index') }}';
                        });
                    } else {
                        swal('编辑失败', res.message || '出错', 'error');
                        $form.find('#toEdit, #draftSave').prop('disabled', false);
                    }
                }
            });
        });

        $('#toCreate').click(function () {
            $form = $('#createForm');
            $form.find('#toCreate, #draftSave').prop('disabled', true);
            var formData = new FormData($form[0]);
            $.ajax({
                url: '{{ route('permission.create') }}',
                type: 'POST',
                data: formData,
                processData: false,  // 告诉jQuery不要去处理发送的数据
                contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
                dataType: 'JSON',
                success: function (res) {
                    if(res.status == 200){
                        swal({
                            title: '新增成功',
                            text: '点击确定返回',
                            type: 'success'
                        }, function () {
                            window.location.href = '{{ route('permission.index') }}';
                        });
                    } else {
                        swal('新增失败', res.message || '出错', 'error');
                        $form.find('#toCreate, #draftSave').prop('disabled', false);
                    }
                }
            });
        });

        function deleteRole(id) {
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
                    url: '{{ route('permission.delete') }}',
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

        $('#batchCreate').click(function () {
            swal({
                title: '确认新增吗?',
                text: '此操作只能增加前缀为admin的路由',
                type: 'warning',
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                $.ajax({
                    url: '{{ route('permission.batchCreate') }}',
                    type: 'GET',
                    processData: false,  // 告诉jQuery不要去处理发送的数据
                    contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
                    dataType: 'JSON',
                    success: function (res) {
                        if(res.status == 200){
                            swal({
                                title: '新增成功',
                                text: res.message,
                                type: 'success'
                            }, function () {
                                window.location.href = '{{ route('permission.index') }}';
                            });
                        } else {
                            swal('新增失败', res.message || '出错', 'error');
                            $form.find('#toCreate, #draftSave').prop('disabled', false);
                        }
                    }
                });
            })
        });
    </script>
@endsection