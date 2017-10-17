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
                        <li class="active"><a href="#base" data-toggle="tab">基础配置</a></li>
                        <li><a href="#cache" data-toggle="tab">缓存配置</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="base">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- form start -->
                                    <form id="baseForm">
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
                                                <button type="submit" class="btn btn-primary" id="submitBase">更新配置</button>
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
        function getData(url) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'JSON',
                success: function (res) {
                    if(res.status == 200){

                    }
                }
            });
        }

    </script>
@endsection