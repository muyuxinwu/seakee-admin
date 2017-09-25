@extends('layouts.admin')

@section('title','用户中心')
@section('page_title','角色分配')
@section('Optional_description','')

@section('content')
    <!-- Default box -->


    <form class="form-horizontal" onsubmit="return false;" id="roleForm">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="pull-right">
                            <label class="control-label" style="padding-right: 10px;">用户名</label>{{ $user['user_name'] }} &nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="control-label" style="padding-right: 10px;">E-mail</label>{{ $user['email'] }}
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="userID" value="{{ $user['id'] }}">
                    <input type="hidden" name="rolesID" value="" id="rolesID">
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>角色标识</th>
                                <th>角色名称</th>
                                <th>角色描述</th>
                                <th>授权</th>
                            </tr>
                            @foreach ($roles as $key => $item)
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['display_name'] }}</td>
                                    <td>{{ $item['description'] }}</td>
                                    <td>
                                        <input name="checkbox" type="checkbox" value="{{ $item['id'] }}"
                                               @if(in_array($item['id'], $userRoleID)) checked @endif>
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
                                    <button id="assignRole" class="btn btn-primary">
                                        确认分配
                                    </button>
                                    <a href="{{ route('user.index') }}" class="btn btn-default pull-right">
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

        $('#assignRole').click(function () {

            var idArray = new Array();
            $("input[name=checkbox]:checked").each(function () {
                idArray.push($(this).val());
            });
            var rolesID = "";
            if (idArray.length > 0) {
                rolesID = idArray.join(",");
            }

            $('#rolesID').val(rolesID);

            $form = $('#roleForm');
            $form.find('#assignRole, #draftSave').prop('disabled', true);
            var formData = new FormData($form[0]);
            $.ajax({
                url: '{{ route('role.assignRole') }}',
                type: 'POST',
                data: formData,
                processData: false,  // 告诉jQuery不要去处理发送的数据
                contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
                dataType: 'JSON',
                success: function (res) {
                    if (res.status == 200) {
                        swal({
                            title: '分配成功',
                            text: '点击确定返回',
                            type: 'success'
                        }, function () {
                            window.location.href = '{{ route('user.index') }}';
                        });
                    } else {
                        swal('分配失败', res.message || '出错', 'error');
                        $form.find('#assignRole, #draftSave').prop('disabled', false);
                    }
                }
            });
        });
    </script>
@endsection
