@extends('layouts.default')
@section('title','菜单管理')
@section('pageHeader','系统设置')
@section('pageSmallHeader','菜单管理')
@section('content')

<!-- icheck -->
<link rel="stylesheet" href="/statics/plugin/AdminLTE/plugins/iCheck/all.css">
<script src="/statics/plugin/AdminLTE/plugins/iCheck/icheck.min.js"></script>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <button type="button" onclick="menu_add()" class="btn btn-success">添加菜单</button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                <form action="{{ route('menus.menuBatchDel') }}" method="post">
                    {{ csrf_field() }}
                    <table id="menus" class="table table-bordered table-hover " >
                        <th rowspan="1" colspan="1">#</th>
                        <th rowspan="1" colspan="1">ID</th>
                        <th rowspan="1" colspan="1">菜单名称</th>
                        <th rowspan="1" colspan="1">url</th>
                        <th rowspan="1" colspan="1">父级菜单id</th>
                        <th rowspan="1" colspan="1">icon</th>
                        <th rowspan="1" colspan="1">操作</th>
                        @foreach($key_data->get('datas') as $v)
                        <tr role="row" >
                            <td>
                                <input class="flat-blue this-page-user" type="checkbox" value="{{ $v->id }}" name="checkmenus[]">
                            </td>
                            <td>{{ $v->id }}</td>
                            <td>{{ $v->name }}</td>
                            <td>{{ $v->url }}</td>
                            <td>{{ $v->parent_id }}  ({{ $v->parent_name }}) </td>
                            <td><i class="fa fa-{{ $v->icon }}"></i> {{ $v->icon }}</td>
                            <td style="min-width: 88px">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-warning" onclick="menu_info( {{ $v->id }} )" >查看</button>
                                    <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" class="del-btn" data-id="{{ $v->id }}" data-toggle="modal" data-target="#menu-del">删除</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {!! $key_data->get('datas')->render() !!}
                </div>
                <div class="btn-group">
                    <a href="#0" class="btn btn-default btn-sm" id="checkThisPageUsers">全选/反选</a>
                    <a href="#0" type="button" class="btn btn-sm btn-default" >操作</button>
                    <a href="#0" type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" style="text-align: center">
                        <li>
                            <a href="#0">
                                <button class="btn btn-sm btn-danger" style="width: 100%;" type="submit">删除</button>
                            </a>
                        </li>
                    </ul>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>


<!-- 查看/修改 弹窗 -->
<div class="modal fade" id="main-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <form method="post" action="{{ route('menus.update') }}">
      {{ csrf_field() }}
      {{ method_field('patch') }}
      <div class="modal-body">
            <div class="form-group">
                <input type="hidden" name="id" v-bind:value="object.id">
            </div>

            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>名称:</label>
                    <input type="text" name="name" class="form-control"  v-bind:value="object.name" placeholder="菜单名称">
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>url:</label>
                    <input type="text" name="url" class="form-control" v-bind:value="object.url" placeholder="填写有效的路径">
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>icon: <small><a href="https://adminlte.io/themes/AdminLTE/pages/UI/icons.html" target="_blank">查看相关的图标列表</a></small></label>
                    <input type="text" name="icon" class="form-control" v-bind:value="object.icon" placeholder="填写图标名称">
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>菜单索引：</label>
                    <input type="text" name="name_index" class="form-control" v-bind:value="object.name_index" placeholder="填写英文的菜单索引">
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>父级菜单:</label>
                    <br>
                    <div class="col-sm-6" style="padding: 0">
                        <select class="js-example-basic-single" id='menu-update-select' name="parent_id">
                          <option value="0">一级菜单</option>
                          @foreach( $key_data->get('parent_data') as $v )
                          <option value="{{ $v->id }}">{{ $v->name }}</option>
                          @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-1"></div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-success">提交</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- 删除弹窗 -->
<div class="modal fade" id="menu-del">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">警告信息！</h4>
      </div>
      <div class="modal-body">
      <form method="post" action="{{ route('menus.destroy') }}">
          <input type="hidden" name="id" value="">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
        <p>确定删除这个菜单么，相关功能和模型可能无法使用。</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-danger" >确认删除</button>
      </div>
     </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
// 删除按钮
$('.del-btn').click(function(){
    $('#menu-del').find("input[name='id']").val($(this).data('id'));
});

// vue 对象 
let appData = new Vue({
    el: "#main-modal",
    data: {
        object: {
            id: "", 
            url: "",
            name: "", 
            icon: "", 
            name_index: ""
        }
    }
});

// 设置添加和更新数据公用的modal
let mel = $('#main-modal'); 

// 查看菜单项目
let menu_info = function(id)
{
    $.ajax({
        url: "{{ route('menus.info') }}",
        data: {id: id},
        type: "POST",
        beforeSend: function(){
            $('.pop-background').css('display','flex');
        },
        success: function(data){
            // 修改公用modal title
            mel.find('.modal-title').text(`管理 ${data.name}`);
            // 修改公用modal表单提交地址
            mel.find('form').attr('action',"{{ route('menus.update') }}");

            // 模拟 patch 请求方式
            mel.find('form').append(`{{ method_field('patch') }}`);
            
            // 设置 vue 对象
            Vue.set(appData,'object',data); 

            // 默认选中option和select2的默认值
            let option_value = "option[value='"+data.parent_id+"']";
            mel.find(option_value).attr('selected',true);
            $('#menu-update-select').select2("val",[data.parent_id]);

            mel.modal();            
            $('.pop-background').css('display','none');
        }
    });
}

let menu_add = function()
{
    // 修改公用modal title
    mel.find('.modal-title').text('添加菜单');

    // 修改公用modal表单提交地址
    mel.find('form').attr('action',"{{ route('menus.create') }}");

    // 去除提交方式input
    mel.find('form input[name="_method"]').remove();

    // 重置 select 的选择
    mel.find('option').eq(0).attr('seleted',true);
    $('#menu-update-select').select2("val",[0]);

    // 清空 vue 对象中的数据
    let data = {};
    Vue.set(appData,'object',data); 

    mel.modal();
}

$(document).ready(function() {
    $('.js-example-basic-single').select2();

    $(".flat-blue").iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue',
        increaseArea: '20%' // optional
    });
});

// icheck 全选/反选 操作
$('#checkThisPageUsers').click(function(){
    $(this).toggleClass("selected");
    if($(this).hasClass("selected")){
        $('.this-page-user').iCheck('check');
    }else{
        $('.this-page-user').iCheck('uncheck');
    }
});
</script>


@stop
