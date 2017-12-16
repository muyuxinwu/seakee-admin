@extends('layouts.admin')

@section('title','文件管理')
@section('page_title','文件管理')
@section('Optional_description','管理上传到系统的所有文件')

@section('page_style')
    <style>
        .file input {
            position: absolute;
            right: 11px;
            top: 0;
            opacity: 0;
            width: 90px;
            height: 35px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-2">
            <button data-toggle="modal" data-target="#uploadModal" class="btn btn-primary btn-block margin-bottom">
                上传文件
            </button>

            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">文件分类</h3>

                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="#"><i class="fa fa-files-o"></i> 所有
                                <span class="label label-primary pull-right">12</span></a></li>
                        <li><a href="#"><i class="fa fa-file-image-o"></i> 图片</a></li>
                        <li><a href="#"><i class="fa fa-file-audio-o"></i> 音乐</a></li>
                        <li><a href="#"><i class="fa fa-file-word-o"></i> 文档 <span
                                        class="label label-warning pull-right">65</span></a>
                        </li>
                        <li><a href="#"><i class="fa fa-file-video-o"></i> 视频</a></li>
                        <li><a href="#"><i class="fa fa-file-o"></i> 其它</a></li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">文件列表</h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="mailbox-controls">
                        <!-- Check all button -->
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i
                                    class="fa fa-square-o"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                        </div>
                        <!-- /.btn-group -->
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                        <div class="pull-right">
                            1-50/200
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i>
                                </button>
                            </div>
                            <!-- /.btn-group -->
                        </div>
                        <!-- /.pull-right -->
                    </div>
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <tbody>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"></td>
                                <td class="mailbox-date">5 mins ago</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                <td class="mailbox-date">28 mins ago</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                <td class="mailbox-date">11 hours ago</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"></td>
                                <td class="mailbox-date">15 hours ago</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                <td class="mailbox-date">Yesterday</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                <td class="mailbox-date">2 days ago</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                <td class="mailbox-date">2 days ago</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"></td>
                                <td class="mailbox-date">2 days ago</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"></td>
                                <td class="mailbox-date">2 days ago</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"></td>
                                <td class="mailbox-date">2 days ago</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                <td class="mailbox-date">4 days ago</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"></td>
                                <td class="mailbox-date">12 days ago</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                <td class="mailbox-date">12 days ago</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                <td class="mailbox-date">14 days ago</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to
                                    this problem...
                                </td>
                                <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                <td class="mailbox-date">15 days ago</td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- /.table -->
                    </div>
                    <!-- /.mail-box-messages -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer no-padding">
                    <div class="mailbox-controls">
                        <!-- Check all button -->
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i
                                    class="fa fa-square-o"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                        </div>
                        <!-- /.btn-group -->
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                        <div class="pull-right">
                            1-50/200
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i>
                                </button>
                            </div>
                            <!-- /.btn-group -->
                        </div>
                        <!-- /.pull-right -->
                    </div>
                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>

    <!-- upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editInfo">上传文件</h4>
                </div>
                <form class="form-horizontal" id="uploadForm" onsubmit="return false;">
                    <div class="modal-body">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="col-sm-3 control-label">存储磁盘</label>
                            <div class="col-sm-8">
                                <select name="disk" class="form-control" id="disk">

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">选择文件</label>
                            <div class="col-sm-8">
                                <div class="col-xs-9" style="padding-left: 0">
                                    <input type='text' id='textField' class='form-control ' />
                                </div>
                                <button class="file btn btn-primary" style="float: right">选择文件
                                    <input type="file" name="file" onchange="document.getElementById('textField').value=this.value">
                                </button>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" id="upload" onclick="uploadFile()">立刻上传</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
    <script>
        getDisk();
        function getDisk() {
            $.ajax({
                url: '{{ route('file.getDisk') }}',
                type: 'GET',
                dataType: 'JSON',
                success: function (res) {
                    if (res.status == 200) {
                        var list = res.data;
                        var length = list.length;
                        var html = '<option value="' + '{{ config('filesystems.default') }}' + '">默认磁盘</option>';
                        for (var i = 0; i < length; i++){
                            html += '<option value="'+ list[i] +'">'+ list[i] +'</option>';
                        }

                        $('#disk').html(html);
                    }
                }
            });
        }

        function uploadFile(){
            $form = $('#uploadForm');
            var formData = new FormData($form[0]);
            $.ajax({
                url: '{{ route('file.upload') }}',
                type: 'POST',
                data: formData,
                processData: false,  // 告诉jQuery不要去处理发送的数据
                contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
                dataType: 'JSON',
                success: function (res) {
                    if(res.status == 200){
                        swal({
                            title: '上传成功',
                            type: 'success'
                        }, function () {
                            window.location.href = '{{ route('file.index') }}';
                        });
                    } else {
                        swal('上传失败', res.message || '出错', 'error');
                    }
                }
            });
        }
    </script>
@endsection