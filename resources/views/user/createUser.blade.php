@extends('layouts.admin')

@section('title','用户中心')
@section('page_title','新增用户')
@section('Optional_description','')

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        <form class="form-horizontal" onsubmit="return false;" id="userForm">
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">用户名</label>
                                <div class="col-xs-8">
                                    <input type="text" name="user_name" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">昵称</label>
                                <div class="col-xs-8">
                                    <input type="text" name="nick_name" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">E-mail</label>
                                <div class="col-xs-8">
                                    <input type="text" name="email" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">电话</label>
                                <div class="col-xs-8">
                                    <input type="text" name="phone" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">密码</label>
                                <div class="col-xs-8">
                                    <input type="password" name="password" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">确认密码</label>
                                <div class="col-xs-8">
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <div class="col-xs-4"></div>
                                <div class="col-xs-8">
                                    <button id="createUser" class="btn btn-primary">
                                        新增用户
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
@endsection

@section('page_js')
    <script>

        $('#createUser').click(function () {
            $form = $('#userForm');
            $form.find('#createUser, #draftSave').prop('disabled', true);
            var formData = new FormData($form[0]);
            $.ajax({
                url: '{{ route('user.store') }}',
                type: 'POST',
                data: formData,
                processData: false,  // 告诉jQuery不要去处理发送的数据
                contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
                dataType: 'JSON',
                success: function (res) {
                    if (res.status == 200) {
                        swal({
                            title: '新增成功',
                            text: '点击确定返回',
                            type: 'success'
                        }, function () {
                            window.location.href = '{{ route('user.index') }}';
                        });
                    } else {
                        swal('新增失败', res.message || '出错', 'error');
                        $form.find('#createUser, #draftSave').prop('disabled', false);
                    }
                }
            });
        });
    </script>
@endsection
