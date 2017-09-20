@extends('layouts.admin')

@section('title','菜单管理')
@section('page_title','后台菜单管理')
@section('Optional_description','')

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">编辑后台菜单</h3>
        </div>
        <form class="form-horizontal" onsubmit="return false;" id="menuForm">
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="menuState" value="1">
                    <input type="hidden" name="id" value="{{ $menu['id'] }}">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">上级菜单</label>
                                <div class="col-xs-8">
                                    <select class="form-control" name="fatherMenu">
                                        <option value="-1" @if($menu['father_id'] == -1) selected @endif>根目录</option>
                                        @foreach($menus as $key => $m)
                                            <option value="{{ $m['id'] }}" @if($menu['father_id'] == $m['id']) selected @endif>⊢ {{ $m['menu_name'] }}</option>
                                            @if(isset($m['nodes']))
                                                @foreach($m['nodes'] as $key => $m)
                                                    <option value="{{ $m['id'] }}" @if($menu['father_id'] == $m['id']) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;⊢ {{ $m['menu_name'] }}</option>
                                                    @if(isset($m['nodes']))
                                                        @foreach($m['nodes'] as $key => $m)
                                                            <option value="{{ $m['id'] }}" disabled="disabled">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;⊢ {{ $m['menu_name'] }}</option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12" style="padding-left: 9px;">
                                <label class="col-xs-2 control-label">显示状态</label>
                                <div class="col-xs-6">
                                    <div class="switch" style="display: table">
                                        <input onchange="displayValue()" data-on-text="显示" data-off-text="隐藏" type="checkbox" @if($menu['display'] == 1) checked @endif/>
                                        <label class="control-label" style="padding-left: 80px;">菜单排序&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="text" name="menuSort" class="form-control" style="width: 80px;display: initial" value="{{ $menu['sort'] }}">
                                    </div>
                                    <input id="display" type="hidden" name="menuDisplay" value="{{ $menu['display'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">菜单图标</label>
                                <div style="display: table" class="col-xs-8">
                                    <input  data-placement="bottomRight" class="form-control icp icp-auto" value="{{ $menu['icon'] }}" type="text" name="icon"/>
                                    <span class="input-group-addon" ></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="menuURL">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">菜单URL</label>
                                <div class="col-xs-8">
                                    <select onchange="customUrl();" class="form-control" id="selectRouteName" >
                                        <option value="0" @if($menu['route_name'] == 0) selected @endif>自定义URL</option>
                                        <option value="#" @if($menu['route_name'] == '#') selected @endif>#</option>
                                        @foreach($routes as $routeName => $url)
                                            <option value="{{ $routeName }}" @if($menu['route_name'] == $routeName) selected @endif>{{ $url }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="routeName" id="routeName" value="{{ $menu['route_name'] }}">
                                    <input type="hidden" name="isCustom" id="isCustom" value="{{ $menu['is_custom'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="display: none" id="customUrl">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label"></label>
                                <div class="col-xs-8">
                                    <input id="customUrlValue" type="text" class="form-control" value="{{ $menu['route_name'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">菜单名称</label>
                                <div class="col-xs-8">
                                    <input type="text" name="menuName" class="form-control" value="{{ $menu['menu_name'] }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <div class="col-xs-4"></div>
                                <div class="col-xs-8">
                                    <button id="editMenu" class="btn btn-primary">
                                       编辑菜单
                                    </button>
                                    <a href="{{ route('menu.admin') }}" class="btn btn-default pull-right">
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
    <link rel="stylesheet" href="{{ asset('css/fontawesome-iconpicker.min.css') }}">
@endsection

@section('page_js')
    <script src="{{ asset('js/highlight.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/bootstrap-switch.js') }}"></script>
    <script src="{{ asset('js/fontawesome-iconpicker.js') }}"></script>
    <script>
        customUrl();
        $('.icp-auto').iconpicker();
        function displayValue() {
            var displayValue = $("input[name='menuDisplay']").val();
            if (displayValue == 1) {
                $('#display').val(0);
            } else {
                $('#display').val(1);
            }
        }
        function customUrl() {
            var routeName = $('#selectRouteName').val();
            if (routeName == 0){
                $('#customUrl').show();
            } else {
                $('#customUrl').hide();
            }
        }
        $('#editMenu').click(function () {

            var routeName = $('#selectRouteName').val();
            var customUrlValue = $('#customUrlValue').val();
            if (routeName == 0){
                $('#routeName').val(customUrlValue);
                $('#isCustom').val(1);
            } else {
                $('#routeName').val(routeName);
                $('#isCustom').val(0);
            }

            $form = $('#menuForm');
            $form.find('#editMenu, #draftSave').prop('disabled', true);
            var formData = new FormData($form[0]);
            $.ajax({
                url: '{{ route('menu.update') }}',
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
                            window.location.href = '{{ route('menu.admin') }}';
                        });
                    } else {
                        swal('编辑失败', res.message || '出错', 'error');
                        $form.find('#editMenu, #draftSave').prop('disabled', false);
                    }
                }
            });
        });
    </script>
@endsection
