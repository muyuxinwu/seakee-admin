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
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/flat/blue.css') }}">
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
                                <th>#</th>
                                <th>文件名</th>
                                <th>文件类型</th>
                                <th>文件大小</th>
                                <th>上传者</th>
                                <th>上传日期</th>
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
                                <span class="help-block">
                                    上传文件最大不能超过{{ ini_get('upload_max_filesize') }}
                                 </span>
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

    <!-- iCheck -->
    <script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
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

        $(function () {
            //Enable iCheck plugin for checkboxes
            //iCheck for checkbox and radio inputs
            $('.mailbox-messages input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

            //Enable check and uncheck all functionality
            $(".checkbox-toggle").click(function () {
                var clicks = $(this).data('clicks');
                if (clicks) {
                    //Uncheck all checkboxes
                    $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
                    $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                } else {
                    //Check all checkboxes
                    $(".mailbox-messages input[type='checkbox']").iCheck("check");
                    $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
                }
                $(this).data("clicks", !clicks);
            });

            //Handle starring for glyphicon and font awesome
            $(".mailbox-star").click(function (e) {
                e.preventDefault();
                //detect type
                var $this = $(this).find("a > i");
                var glyph = $this.hasClass("glyphicon");
                var fa = $this.hasClass("fa");

                //Switch states
                if (glyph) {
                    $this.toggleClass("glyphicon-star");
                    $this.toggleClass("glyphicon-star-empty");
                }

                if (fa) {
                    $this.toggleClass("fa-star");
                    $this.toggleClass("fa-star-o");
                }
            });
        });
    </script>
@endsection