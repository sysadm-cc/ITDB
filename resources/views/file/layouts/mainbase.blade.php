<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<!-- @routes -->
<title>
@section('my_title')
{{$config['SITE_TITLE']}}  Ver: {{$config['SITE_VERSION']}}
@show
</title>
<link rel="stylesheet" href="{{ asset('statics/iview/styles/iview.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('statics/print/print.min.css') }}"> -->
<style type="text/css">
	/* 解决闪烁问题的CSS */
	[v-cloak] {	display: none; }
</style>
<style type="text/css">
.layout{
    border: 1px solid #d7dde4;
    background: #f5f7f9;
    position: relative;
    border-radius: 4px;
    overflow: hidden;
}
.layout-header-bar{
	background: #fff;
	box-shadow: 0 1px 1px rgba(0,0,0,.1);
}
.layout-logo0{
    /* width: 100px; */
    /* height: 30px; */
    /* background: #5b6270; */
    border-radius: 3px;
    float: left;
    position: fixed;
    top: 0px;
    left: 10px;
	z-index: 999;
	background: #fff;
}
.layout-logo{
    width: 280px;
    height: 30px;
    border-radius: 3px;
    float: left;
    position: relative;
    top: 0px;
    left: 20px;
}
.layout-breadcrumb{
    width: 260px;
    height: 30px;
    border-radius: 3px;
    float: left;
    position: relative;
    top: 0px;
    left: 20px;
}
.layout-nav{
	float: right;
	position: relative;
    /* width: 420px; */
    margin: 0 auto;
    margin-right: 10px;
}
.layout-footer-center{
    text-align: center;
}
/* 穿梭框 */
.ivu-transfer-list{
	height: 320px;
	width: 260px;
}
/* 打印前显示 */
.print_display{
	display: none !important;
}
.print_auditing{
	position:relative !important;
	width:100% !important;
	height:120px !important;
	overflow-y:scroll !important;
}
.print_application{
	position:relative !important;
	width:100% !important;
	height:120px !important;
	overflow-y:scroll !important;
}
</style>
<style media="print">
/* 打印后显示 */
.print_display{
	display: block !important;

	/* font-size: 32px !important;
	font-weight: bold !important;
	color: rgb(70, 76, 91) !important; */
}
.print_auditing{
	position:relative !important;
	width:100% !important;
	height:120px !important;
	overflow-y:auto !important;
}
.print_application{
	position:relative !important;
	width:100% !important;
	height:120px !important;
	overflow-y:auto !important;
}
</style>
@yield('my_style')
<!-- <script src="{{ asset('js/crypto-js.min.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script> -->
@yield('my_js')
</head>
<body>
<div id="app" v-cloak>
    <div class="layout">
		<Layout>
            <!--头部导航-->
			<div style="z-index: 999;">
				<Header :style="{position: 'fixed', width: '100%', marginLeft: '0px'}">
				<Layout>
				<i-menu mode="horizontal" theme="light" :active-name="isfullscreen == true ? '1' : '3'" @on-select="name=>topmenuselect(name)">
					<div class="layout-logo">
						<a href="{{route('portal')}}">
							<span style="font-size: 16px; font-weight: bold; color: rgb(70, 76, 91);">{{$config['SITE_TITLE']}}</span>
						</a>
						<span style="font-size: 12px; color: rgb(158, 167, 180);">{{$config['SITE_VERSION']}}</span>
					</div>

					<!--面包屑-->
					<div class="layout-breadcrumb">
						<Breadcrumb>
							<Breadcrumb-item to="{{route('portal')}}">系统首页</Breadcrumb-item>
							<Breadcrumb-item to="#">@{{ current_nav }}</Breadcrumb-item>
							<Breadcrumb-item>@{{ current_subnav }}</Breadcrumb-item>
						</Breadcrumb>
					</div>
					
					<!--头部导航菜单-->
					<div class="layout-nav">
						<!--Item 1-->
						<!-- <Menu-item name="1">
						<Dropdown>
							<Badge dot :offset="[20, 0]">
								<Icon type="ios-list-box-outline" size="22"></Icon>
							</Badge>
						</Menu-item> -->

						<Menu-item name="1">
						<div>
							<Tooltip v-if="isfullscreen" placement="bottom" content="关闭全屏" transfer="true">
								<Icon type="ios-contract" size="20" @click.native="handleFullScreen()" style="cursor:pointer;"></Icon>
							</Tooltip>
							<Tooltip v-else placement="bottom" content="全屏" transfer="true">
								<Icon type="ios-expand" size="20" @click.native="handleFullScreen()" style="cursor:pointer;"></Icon>
							</Tooltip>
						</div>
						</Menu-item>
						
						<!--Item 2-->
						<Menu-item name="2">
							<!-- <Dropdown @click.native="event => dropdownuser(event.target.innerText.trim())"> -->
							
							@if (count($info_todo) > 0)
							<Dropdown>
								<Badge :count="{{count($info_todo)}}" :offset="[20, 0]">
									<Icon type="ios-notifications-outline" size="24"></Icon>
								</Badge>

								<Dropdown-menu slot="list" style="width: 240px">
									<Dropdown-item>
										<strong>收到最新 {{count($info_todo)}} 条处理信息，赶快处理吧！</strong>
									</Dropdown-item>
									<Dropdown-item divided></Dropdown-item>

									@foreach ($info_todo as $value)
										<Dropdown-item>
											姓名：{{ $value['agent'] }}<br>部门：{{ $value['department_of_agent'] }}<br>
											<i-progress :percent="{{ $value['progress'] }}" status="active"></i-progress><br>
											<font color="#808695">{{ $value['created_at'] }}</font>
										</Dropdown-item>
										<Dropdown-item divided></Dropdown-item>
									@endforeach
								</Dropdown-menu>
							</Dropdown>
							@else
							<Dropdown>
								<Icon type="ios-create-outline" size="24"></Icon>
								<Dropdown-menu slot="list" style="width: 220px">
									<Dropdown-item>
										<strong>嗯... 暂时还没有新的处理信息！</strong>
									</Dropdown-item>
							</Dropdown>
							@endif

						</Menu-item>

						<!--Item 3-->
						<Submenu name="3">
							<template slot="title">
								<Icon type="ios-contact" size="24"></Icon>{{ $user['displayname'] ?? 'Unknown User'}}
							</template>
							<!--
							<Menu-Group title="使用">
								<Menu-Item name="3-1">新增和启动</Menu-Item>
								<Menu-Item name="3-2">活跃分析</Menu-Item>
								<Menu-Item name="3-3">时段分析</Menu-Item>
							</Menu-Group>
							-->
							<Menu-Item name="3-1">
								名称：{{ $user['name'] }}<br>
								部门：{{ $user['department'] }}
							</Menu-Item>
							<Menu-Item name="3-2"><Icon type="ios-create-outline"></Icon>修改密码</Menu-Item>
							<Menu-Item name="3-3"><Icon type="ios-exit-outline"></Icon>退出登录</Menu-Item>
						</Submenu>
					</div>

				</i-menu>
				</Layout>

				<!--上部标签组-->
				<Layout :style="{padding: '0 2px', marginLeft: '10px'}">
					<div>
						@section('my_tag')
						
						<!--
						<Tag type="dot">标签一</Tag>
						<Tag type="dot" closable>标签三</Tag>
						<Tag v-if="show" @on-close="handleClose" type="dot" closable color="blue">可关闭标签</Tag>
						-->
						@show
					</div>
				</Layout>
				</Header>
			</div>
			
			<div style="height: 60px;">&nbsp;</div>
			<Layout>
				<!--左侧导航菜单-->
				<!-- <div style="height: 60px;">&nbsp;</div> -->
				<Sider hide-trigger :style="{background: '#fff', position: 'fixed', height: 'calc(100vh - 60px)', left: 0, overflow: 'auto'}">
					<!-- <div style="height: 60px;">
						<div class="layout-logo">
							<a href="{{route('portal')}}">
								<span style="font-size: 16px; font-weight: bold; color: rgb(70, 76, 91);">{{$config['SITE_TITLE']}}</span>
								<br>
								<span style="font-size: 12px; font-weight: bold; color: rgb(70, 76, 91);">{{$config['SITE_VERSION']}}</span>
							</a>
						</div>
					</div> -->
					<div id="menu">
						<i-menu :active-name="sideractivename" theme="light" width="auto" :open-names="sideropennames" @on-select="name=>navmenuselect(name)" accordion>

							<Submenu name="1">
								<template slot="title">
										<Icon type="md-laptop" size="20"></Icon> 硬件 <span style="color:rgb(158, 167, 180);font-size:10px;">Hardware</span>
								</template>
								<Menu-item name="1-1"><Icon type="md-search" size="18"></Icon> 查询</Menu-item>
								<Menu-item name="1-2"><Icon type="md-add" size="20"></Icon> 添加</Menu-item>
								<Menu-item name="1-3"><Icon type="md-reorder" size="18"></Icon> 项目分类</Menu-item>
								<Menu-item name="1-4"><Icon type="md-settings" size="18"></Icon> 状态分类</Menu-item>
							</Submenu>

							<Submenu name="2">
								<template slot="title">
										<Icon type="md-folder-open" size="20"></Icon> 软件 <span style="color:rgb(158, 167, 180);font-size:10px;">Software</span>
								</template>
								<Menu-item name="2-1"><Icon type="md-search" size="18"></Icon> 查询</Menu-item>
								<Menu-item name="2-2"><Icon type="md-add" size="20"></Icon> 添加</Menu-item>
							</Submenu>

							<Submenu name="3">
								<template slot="title">
										<Icon type="md-paper" size="20"></Icon> 发票 <span style="color:rgb(158, 167, 180);font-size:10px;">Invoices</span>
								</template>
								<Menu-item name="3-1"><Icon type="md-search" size="18"></Icon> 查询</Menu-item>
								<Menu-item name="3-2"><Icon type="md-add" size="18"></Icon> 添加</Menu-item>
							</Submenu>

							<Submenu name="4">
								<template slot="title">
										<Icon type="md-document" size="20"></Icon> 合同 <span style="color:rgb(158, 167, 180);font-size:10px;">Contracts</span>
								</template>
								<Menu-item name="4-1"><Icon type="md-search" size="18"></Icon> 查询</Menu-item>
								<Menu-item name="4-2"><Icon type="md-add" size="18"></Icon> 添加</Menu-item>
								<Menu-item name="4-3"><Icon type="md-list" size="18"></Icon> 合同类型</Menu-item>
							</Submenu>

							<Submenu name="5">
								<template slot="title">
										<Icon type="md-contacts" size="20"></Icon> 代理商 <span style="color:rgb(158, 167, 180);font-size:10px;">Agents</span>
								</template>
								<Menu-item name="5-1"><Icon type="md-search" size="18"></Icon> 查询</Menu-item>
								<Menu-item name="5-2"><Icon type="md-add" size="18"></Icon> 添加</Menu-item>
							</Submenu>

							<Submenu name="6">
								<template slot="title">
										<Icon type="md-copy" size="20"></Icon> 文件 <span style="color:rgb(158, 167, 180);font-size:10px;">Files</span>
								</template>
								<Menu-item name="6-1"><Icon type="md-search" size="18"></Icon> 查询</Menu-item>
								<Menu-item name="6-2"><Icon type="md-add" size="18"></Icon> 添加</Menu-item>
							</Submenu>

							<Submenu name="7">
								<template slot="title">
										<Icon type="md-cube" size="20"></Icon> 机柜 <span style="color:rgb(158, 167, 180);font-size:10px;">Racks</span>
								</template>
								<Menu-item name="7-1"><Icon type="md-search" size="18"></Icon> 查询</Menu-item>
								<Menu-item name="7-2"><Icon type="md-add" size="18"></Icon> 添加</Menu-item>
							</Submenu>

							<Submenu name="8">
								<template slot="title">
										<Icon type="md-pin" size="20"></Icon> 位置 <span style="color:rgb(158, 167, 180);font-size:10px;">Locations</span>
								</template>
								<Menu-item name="8-1"><Icon type="md-search" size="18"></Icon> 查询</Menu-item>
								<Menu-item name="8-2"><Icon type="md-add" size="18"></Icon> 添加</Menu-item>
							</Submenu>

							<Submenu name="9">
								<template slot="title">
										<Icon type="md-person" size="20"></Icon> 使用者 <span style="color:rgb(158, 167, 180);font-size:10px;">Employees</span>
								</template>
								<Menu-item name="9-1"><Icon type="md-search" size="18"></Icon> 查询</Menu-item>
								<Menu-item name="9-2"><Icon type="md-add" size="18"></Icon> 添加</Menu-item>
							</Submenu>

							<Submenu name="10">
								<template slot="title">
										<Icon type="md-analytics" size="20"></Icon> 事件 <span style="color:rgb(158, 167, 180);font-size:10px;">Events</span>
								</template>
								<Menu-item name="10-1"><Icon type="md-search" size="18"></Icon> 查询</Menu-item>
								<Menu-item name="10-2"><Icon type="md-add" size="18"></Icon> 添加</Menu-item>
							</Submenu>
		
						</i-menu>
					</div>
				</Sider>
			</Layout>
			
			<Layout :style="{padding: '0 12px 24px', marginLeft: '200px'}">
				<!--内容主体-->
				<Content :style="{padding: '0px 12px', minHeight: '500px', background: '#fff'}">
				<!-- 主体 -->
				@section('my_body')
				@show
				<!-- /主体 -->

				</Content>
			</Layout>

 			<!-- 底部 -->
			<Footer class="layout-footer-center">
			@section('my_footer')
			<a href="{{route('portal')}}">{{$config['SITE_TITLE']}}</a>&nbsp;&nbsp;{{$config['SITE_COPYRIGHT']}}
			@can('permission_super_admin')
				<a href="{{route('admin.config.index')}}" target="_blank"><Icon type="ios-cog-outline"></Icon></a>
			@endcan
			
			@show
			</Footer>
			<!-- /底部 -->
			
		</Layout>
		<!-- 返回顶部 -->
		<Back-top></Back-top>
    </div>
</div>

<script src="{{ asset('js/vue.min.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/bluebird.min.js') }}"></script>
<script src="{{ asset('statics/iview/iview.min.js') }}"></script>
<!-- <script src="{{ asset('statics/echarts/echarts.min.js') }}"></script> -->
<!-- <script src="{{ asset('js/httpVueLoader.js') }}"></script> -->
<!-- <script src="{{ asset('statics/print/print.min.js') }}"></script> -->
<script src="{{ asset('js/crypto-js.min.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script>
<script>getdateofsetup("{{route('dateofsetup')}}")</script>
@section('my_js_others')
<script>
function navmenuselect (name) {
	switch(name)
	{
	// 硬件
	case '1-1':
	  window.location.href = "{{route('item.items')}}";
	  break;
	case '1-2':
	  window.location.href = "{{ route('item.add') }}";
	  break;
	case '1-3':
	  window.location.href = "{{ route('item.itemtypes') }}";
	  break;
	case '1-4':
	  window.location.href = "{{ route('item.statustypes') }}";
	  break;

	// 软件
	case '2-1':
	  window.location.href = "{{route('soft.softs')}}";
	  break;
	case '2-2':
	  window.location.href = "{{route('soft.add')}}";
	  break;

	// case '2-2-1':
	//   window.location.href = "";
	//   break;
	// case '2-2-2':
	//   window.location.href = "";
	//   break;

	// case '2-3-1':
	//   window.location.href = "";
	//   break;
	// case '2-3-2':
	//   window.location.href = "";
	//   break;
	// case '2-3-3':
	//   window.location.href = "";
	  break;

	// 发票
	case '3-1':
	  window.location.href = "{{route('invoice.invoices')}}";
	  break;
	case '3-2':
	  window.location.href = "{{route('invoice.add')}}";
	  break;
	case '3-3':
	  window.location.href = "";
	  break;

	// 合同
	case '4-1':
	  window.location.href = "{{route('contract.contracts')}}";
	  break;
	case '4-2':
	  window.location.href = "{{route('contract.add')}}";
	  break;
	case '4-3':
	  window.location.href = "{{route('contract.contracttypes')}}";
	  break;

	// 代理商
	case '5-1':
	  window.location.href = "{{route('agent.agents')}}";
	  break;
	case '5-2':
	  window.location.href = "{{route('agent.add')}}";
	  break;
	case '5-3':
	  window.location.href = "";
	  break;

	// 文件
	case '6-1':
	  window.location.href = "{{route('file.files')}}";
	  break;
	case '6-2':
	  window.location.href = "{{route('file.add')}}";
	  break;
	case '6-3':
	  window.location.href = "";
	  break;

	// 机柜
	case '7-1':
	  window.location.href = "{{route('rack.racks')}}";
	  break;
	case '7-2':
	  window.location.href = "{{route('rack.add')}}";
	  break;
	case '7-3':
	  window.location.href = "";
	  break;

	// 位置
	case '8-1':
	  window.location.href = "{{route('location.locations')}}";
	  break;
	case '8-2':
	  window.location.href = "{{route('location.add')}}";
	  break;
	case '8-3':
	  window.location.href = "";
	  break;

	// 使用者
	case '9-1':
	  window.location.href = "{{route('employee.employees')}}";
	  break;
	case '9-2':
	  window.location.href = "{{route('employee.add')}}";
	  break;
	case '9-3':
	  window.location.href = "";
	  break;

	// 事件
	case '10-1':
	  window.location.href = "{{route('event.events')}}";
	  break;
	case '10-2':
	  window.location.href = "{{route('event.add')}}";
	  break;
	case '10-3':
	  window.location.href = "";
	  break;

	}
}

function topmenuselect (name) {
	switch(name)
	{
	case '1-1':
	  window.location.href = "";
	  break;
	case '1-2':
	  window.location.href = "";
	  break;

	case '2-1-1':
	  window.location.href = "";
	  break;
	case '2-1-2':
	  window.location.href = "";
	  break;
	case '2-1-3':
	  window.location.href = "";
	  break;

	case '2-2-1':
	  window.location.href = "";
	  break;
	case '2-2-2':
	  window.location.href = "";
	  break;

	case '2-3-1':
	  window.location.href = "";
	  break;
	case '2-3-2':
	  window.location.href = "";
	  break;
	case '2-3-3':
	  window.location.href = "";
	  break;

	case '3-1':
	  // window.location.href = "";
	  break;
	case '3-2':
	  vm_app.modal_password_edit = true;
	  break;
	case '3-3':
	  window.location.href = "{{route('main.logout')}}";
	  break;

	}
}
</script>
@show
</body>
</html>
