@extends('layouts.admin')

@section('title','用户中心')
@section('page_title','角色授权')
@section('Optional_description','')

@section('content')
    <!-- Default box -->


    <form class="form-horizontal" onsubmit="return false;" id="permissionForm">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="pull-right">
                            <label class="control-label" style="padding-right: 10px;">角色标识</label>{{ $role['name'] }} &nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="control-label" style="padding-right: 10px;">角色名</label>{{ $role['display_name'] }}
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="roleID" value="{{ $role['id'] }}">
                    <input type="hidden" name="permissionID" value="" id="permissionID">
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>权限标识</th>
                                <th>权限名称</th>
                                <th>权限描述</th>
                                <th>授权</th>
                            </tr>
                            @foreach ($permissions as $key => $item)
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['display_name'] }}</td>
                                    <td>{{ $item['description'] }}</td>
                                    <td>
                                        <input name="checkbox" type="checkbox" value="{{ $item['id'] }}"
                                               @if(in_array($item['id'], $rolePermissionID)) checked @endif>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-xs-8">
                                <div class="col-xs-6"></div>
                                <div class="col-xs-6">
                                    <button id="authorization" class="btn btn-primary">
                                        确认授权
                                    </button>
                                    <a href="{{ route('role.index') }}" class="btn btn-default pull-right">
                                        返回列表
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- /.box -->
@endsection

@section('page_style')
    <link rel="stylesheet" href="{{ asset('css/highlight.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-switch.css') }}">
@endsection

@section('page_js')
    <script>

        $('#authorization').click(function () {

            var idArray = new Array();
            $("input[name=checkbox]:checked").each(function () {
                idArray.push($(this).val());
            });
            var permissionID = "";
            if (idArray.length > 0) {
                permissionID = idArray.join(",");
            }

            $('#permissionID').val(permissionID);

            $form = $('#permissionForm');
            $form.find('#authorization, #draftSave').prop('disabled', true);
            var formData = new FormData($form[0]);
            $.ajax({
                url: '{{ route('permission.authorization') }}',
                type: 'POST',
                data: formData,
                processData: false,  // 告诉jQuery不要去处理发送的数据
                contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
                dataType: 'JSON',
                success: function (res) {
                    if (res.status == 200) {
                        swal({
                            title: '授权成功',
                            text: '点击确定返回',
                            type: 'success'
                        }, function () {
                            window.location.href = '{{ route('role.index') }}';
                        });
                    } else {
                        swal('授权失败', res.message || '出错', 'error');
                        $form.find('#authorization, #draftSave').prop('disabled', false);
                    }
                }
            });
        });
    </script>
@endsection
