@extends('layouts.admin')

@section('title','系统配置')
@section('page_title','系统参数配置')
@section('Optional_description','系统基础参数设置')

@section('content')
        <div class="row">
            <div class="col-md-8">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#app" onclick="getData('app')" data-toggle="tab">基础配置</a></li>
                        <li><a href="#cache" data-toggle="tab">缓存配置</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="app">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- form start -->
                                    <form id="appForm" onsubmit="return false;">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label>系统名称</label>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <input type="text" class="form-control" name="name" id="name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>系统关键字</label>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <input type="text" class="form-control" name="keywords" id="keywords">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>系统描述</label>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <input type="text" class="form-control" name="description" id="description">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>ICP备案号</label>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <input type="text" class="form-control" name="icp" id="icp">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->

                                            <div class="box-footer">
                                                <button type="button" class="btn btn-primary" onclick="updateData('appForm')">更新配置</button>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="cache">
                            The European languages are members of the same family. Their separate existence is a myth.
                            For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                            in their grammar, their pronunciation and their most common words. Everyone realizes why a
                            new common language would be desirable: one could refuse to pay expensive translators. To
                            achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                            words. If several languages coalesce, the grammar of the resulting language is more simple
                            and regular than that of the individual languages.
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>
        </div>
@endsection

@section('page_js')
    <script>
        getData('app');

        function getData(tab) {

            switch (tab) {
                case 'app':
                    var url = '{{ route('config.app') }}';
                    break;
            }

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'JSON',
                success: function (res) {
                    if(res.status == 200){
                        render(res.data, tab)
                    }
                }
            });
        }
        
        function render(data, tab) {
            if (tab == 'app'){
                $('#name').val(data.name);
                $('#keywords').val(data.keywords);
                $('#description').val(data.description);
                $('#icp').val(data.icp);
            }
        }

        function updateData(tab) {
            var obj = '#' + tab;
            $form = $(obj);
            var formData = new FormData($form[0]);
            $.ajax({
                url: '{{ route('config.update') }}',
                type: 'POST',
                data: formData,
                processData: false,  // 告诉jQuery不要去处理发送的数据
                contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
                dataType: 'JSON',
                success: function (res) {
                    if(res.status == 200){
                        swal({
                            title: '更新成功',
                            type: 'success'
                        });
                    } else {
                        swal('更新失败', res.message || '出错', 'error');
                    }
                }
            });
        }
    </script>
@endsection