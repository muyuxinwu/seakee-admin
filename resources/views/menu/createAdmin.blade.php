@extends('layouts.admin')

@section('title','菜单管理')
@section('page_title','后台菜单管理')
@section('Optional_description','')

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">创建后台菜单</h3>
        </div>
        <form class="form-horizontal" onsubmit="return false;" id="menuForm">
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="menuState" value="1">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">上级菜单</label>
                                <div class="col-xs-8">
                                    <select class="form-control" verify-key="notNull" name="fatherMenu">
                                        <option value="">选择上级菜单</option>
                                        <option value="-1">根目录</option>
                                        @foreach($menus as $key => $menu)
                                            <option value="{{ $menu['id'] }}">⊢ {{ $menu['menu_name'] }}</option>
                                            @if(isset($menu['nodes']))
                                                @foreach($menu['nodes'] as $key => $menu)
                                                    <option value="{{ $menu['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;⊢ {{ $menu['menu_name'] }}</option>
                                                    @if(isset($menu['nodes']))
                                                        @foreach($menu['nodes'] as $key => $menu)
                                                            <option value="{{ $menu['id'] }}" disabled="disabled">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;⊢ {{ $menu['menu_name'] }}</option>
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
                                    <div class="switch">
                                        <input onchange="displayValue()" data-on-text="显示" data-off-text="隐藏" type="checkbox" checked/>
                                        <label class="control-label" style="padding-left: 77px;">是否节点&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input onchange="menuUrl()" data-on-text="是" data-off-text="否" type="checkbox" checked/>
                                    </div>
                                    <input id="display" type="hidden" name="menuDisplay" value="1">
                                    <input id="node" type="hidden" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="display: none;" id="menuURL">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">菜单URL</label>
                                <div class="col-xs-8">
                                    <select class="form-control" verify-key="notNull" name="menuURL">
                                        <option value="#" selected>选择URL</option>
                                        @foreach($routes as $key => $url)
                                            <option value="{{ $url }}">{{ $url }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">菜单名称</label>
                                <div class="col-xs-8">
                                    <input type="text" name="menuName" class="form-control" verify-key="notNull">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="col-xs-4 control-label">菜单排序</label>
                                <div class="col-xs-8">
                                    <input type="text" name="menuSort" class="form-control" verify-key="notNull">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <div class="col-xs-4"></div>
                                <div class="col-xs-8">
                                    <button id="createMenu" class="btn btn-primary">
                                        创建菜单
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
@endsection

@section('page_js')
    <script src="{{ asset('js/highlight.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/bootstrap-switch.js') }}"></script>
    <script>

        function menuUrl() {
            var node = $('#node').val();
            if (node == 1) {
                $('#menuURL').show();
                $('#node').val(0);
            } else {
                $('#menuURL').hide();
                $('#node').val(1);
            }
        }

        function displayValue() {
            var displayValue = $("input[name='menuDisplay']").val();
            if (displayValue == 1) {
                $('#display').val(0);
            } else {
                $('#display').val(1);
            }
        }

        $('#createMenu').click(function () {
            $form = $('#menuForm');
            $form.find('#createMenu, #draftSave').prop('disabled', true);
            var formData = new FormData($form[0]);
            $.ajax({
                url: '{{ route('menu.create') }}',
                type: 'POST',
                data: formData,
                processData: false,  // 告诉jQuery不要去处理发送的数据
                contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
                dataType: 'JSON',
                success: function (res) {
                    if(res.status == 200){
                        swal({
                            title: '创建成功',
                            text: '点击确定返回',
                            type: 'success'
                        }, function () {
                            window.location.href = '{{ route('menu.admin') }}';
                        });
                    } else {
                        swal('创建失败', res.message || '出错', 'error');
                        $form.find('#createMenu, #draftSave').prop('disabled', false);
                    }
                }
            });
        });
    </script>
@endsection
