@extends('layouts.admin')

@section('title','管理中心')
@section('page_title','仪表盘')
@section('Optional_description','系统概述')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-server"></i>

                    <h3 class="box-title">服务器信息</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt>PHP版本</dt>
                        <dd>{{ $serverInfo['phpVersion'] }}</dd>
                        <dt>操作系统</dt>
                        <dd>{{ $serverInfo['os'] }}</dd>
                        <dt>服务器</dt>
                        <dd>{{ $serverInfo['server'] }}</dd>
                        <dt>数据库</dt>
                        <dd>{{ $serverInfo['db'] }}</dd>
                        <dt>项目目录</dt>
                        <dd>{{ $serverInfo['root'] }}</dd>
                        <dt>Laravel版本</dt>
                        <dd>{{ $serverInfo['laravelVersion'] }}</dd>
                        <dt>允许最大上传大小</dt>
                        <dd>{{ $serverInfo['maxUploadSize'] }}</dd>
                        <dt>执行超时时间</dt>
                        <dd>{{ $serverInfo['executeTime'] }}</dd>
                        <dt>服务器时间</dt>
                        <dd>{{ $serverInfo['serverDate'] }}</dd>
                        <dt>项目域名/服务器IP</dt>
                        <dd>{{ $serverInfo['domainIp'] }}</dd>
                        <dt>可用磁盘大小</dt>
                        <dd>{{ $serverInfo['disk'] }}</dd>
                    </dl>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
@endsection
