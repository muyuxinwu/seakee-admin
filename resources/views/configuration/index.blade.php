@extends('layouts.admin')

@section('title','系统配置')
@section('page_title','系统参数配置')
@section('Optional_description','系统基础参数设置')

@section('page_style')
    <style>
        .description {
            color: #999;height: 34px;padding: 6px 12px;
        }
        .pt6{
            padding-top: 6px;
        }
    </style>
@endsection

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
                                                            <input placeholder="请输入系统名称" type="text" class="form-control" name="name" id="name">
                                                        </div>
                                                        <div class="col-xs-8">
                                                            <small><p class="description">系统标题，也是搜索引擎为搜录做筛选标题的重要信息。</p></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>系统关键字</label>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <input placeholder="请输入系统关键字" type="text" class="form-control" name="keywords" id="keywords">
                                                        </div>
                                                        <div class="col-xs-8">
                                                            <small><p class="description">系统关键字，是通过搜索引擎检索网站的重要信息，多个关键词使用英文半角符号“,”分割。</p></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>系统描述</label>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <input placeholder="请输入系统描述" type="text" class="form-control" name="description" id="description">
                                                        </div>
                                                        <div class="col-xs-8">
                                                            <small><p class="description">描述用于简单的介绍站点，在搜索引擎中用于搜索结果的概述。</p></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>ICP备案号</label>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <input placeholder="请输入ICP备案号" type="text" class="form-control" name="icp" id="icp">
                                                        </div>
                                                        <div class="col-xs-8">
                                                            <small><p class="description">填写ICP备案的信息，例如:京ICP备xxxxxxxx号</p></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Bing登录背景图片</label>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <div class="control pt6">
                                                                <input value="0" type="radio" name="bingImage" class="minimal" checked>
                                                                关闭&emsp;&emsp;
                                                                <input id="bingImage" value="1" type="radio" name="bingImage" class="minimal">
                                                                开启
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-8">
                                                            <small><p class="description">控制Bing登录背景图片开关。开启时会随机获取Bing每日图片作为登录背景图片。</p></small>
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

                if (data.bingImage == 1){
                    $('#bingImage').prop("checked",true);
                }
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