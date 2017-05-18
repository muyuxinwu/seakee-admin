@extends('layouts.admin')

@section('title','用户中心')
@section('page_title','用户管理')
@section('Optional_description','编辑用户')

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">编辑用户</h3>
        </div>
        <form class="form-horizontal" onsubmit="return false;" id="userForm">
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $user['id'] }}">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">用户名</label>
                                <div class="col-xs-8">
                                    <input type="text" value="{{ $user['user_name'] }}" name="user_name" class="form-control" verify-key="notNull">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">昵称</label>
                                <div class="col-xs-8">
                                    <input type="text" value="{{ $user['nick_name'] }}" name="nick_name" class="form-control" verify-key="notNull">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">E-mail</label>
                                <div class="col-xs-8">
                                    <input type="text" value="{{ $user['email'] }}" name="email" class="form-control" verify-key="notNull">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">电话</label>
                                <div class="col-xs-8">
                                    <input type="text" value="{{ $user['phone'] }}" name="phone" class="form-control" verify-key="notNull">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">密码</label>
                                <div class="col-xs-8">
                                    <input type="password" name="password" class="form-control" verify-key="notNull">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">确认密码</label>
                                <div class="col-xs-8">
                                    <input type="password" name="password_confirmation" class="form-control" verify-key="notNull">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <div class="col-xs-4"></div>
                                <div class="col-xs-8">
                                    <button id="editUser" class="btn btn-primary">
                                        编辑用户
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
        </form>
    </div>
    <!-- /.box -->
@endsection

@section('page_style')
    <link rel="stylesheet" href="{{ asset('css/highlight.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-switch.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection

@section('page_js')
    <script>

        $('#editUser').click(function () {
            $form = $('#userForm');
            $form.find('#editUser, #draftSave').prop('disabled', true);
            var formData = new FormData($form[0]);
            $.ajax({
                url: '{{ route('user.edit') }}',
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
                            window.location.href = '{{ route('user.index') }}';
                        });
                    } else {
                        swal('编辑失败', res.message || '出错', 'error');
                        $form.find('#editUser, #draftSave').prop('disabled', false);
                    }
                }
            });
        });
    </script>
@endsection
