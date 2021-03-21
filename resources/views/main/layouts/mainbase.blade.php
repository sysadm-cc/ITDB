<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>
@section('my_title')
{{$config['SITE_TITLE']}}  Ver: {{$config['SITE_VERSION']}}
@show
</title>
<link rel="stylesheet" href="{{ asset('statics/iview/styles/iview.css') }}">
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
.layout-logo{
    width: 100px;
    height: 30px;
    <!--background: #5b6270;-->
    border-radius: 3px;
    float: left;
    position: relative;
    top: 15px;
    left: 20px;
}
.layout-breadcrumb{
	<!-- padding: 10px 15px 0; -->
    width: 100px;
    height: 30px;
    <!--background: #5b6270;-->
    border-radius: 3px;
    float: left;
    position: relative;
    top: 5px;
    left: 20px;
}
.layout-nav{
	float: right;
	<!--position: relative;-->
    <!--width: 420px;-->
    margin: 0 auto;
    margin-right: 10px;
}
.layout-footer-center{
    text-align: center;
}
.ivu-table-cell{
	font-size: 12px;
}
</style>
@yield('my_style')

<script src="{{ asset('js/functions.js') }}"></script>
@yield('my_js')
</head>
<body>
<div id="app" v-cloak>

    <div class="layout">
        <Layout>

			<Layout>
            <!--头部导航-->
			<div style="z-index: 999;">
            <Header :style="{position: 'fixed', width: '100%', marginLeft: '0px'}">
                <Layout>
				<i-menu mode="horizontal" theme="light" :active-name="isfullscreen == true ? '1' : '3'" @on-select="name=>topmenuselect(name)">
					
					<!--面包屑-->
					<div class="layout-breadcrumb">
					@section('my_project')

					@show
					
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
							<Dropdown>
								<Icon type="ios-create-outline" size="24"></Icon>
								<Dropdown-menu slot="list" style="width: 220px">
									<Dropdown-item>
										<strong>嗯... 暂时还没有新的处理信息！</strong>
									</Dropdown-item>
							</Dropdown>
						</Menu-item>

						<!--Item 3-->
						<Submenu name="3">
							<template slot="title">
								<Icon type="ios-contact" size="24"></Icon>{{ $user['displayname'] ?? 'Unknown User'}}
							</template>
							<Menu-Item name="3-1"><Icon type="ios-exit-outline"></Icon>退出登录</Menu-Item>
						</Submenu>
					
                    </div>

                </i-menu>
				</Layout>

            </Header>
			</div>
			</Layout>
            
			
			<div><br><br><br><br></div>
			<Layout :style="{padding: '0 12px 24px', marginLeft: '0px'}">
				<!--内容主体-->
				<Content :style="{padding: '24px 12px', minHeight: '280px', background: '#fff'}">
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
@section('my_js_others')
<script>
function topmenuselect (name) {
	switch(name)
	{
	case '1-1':
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
	  window.location.href = "{{route('main.logout')}}";
	  break;
	case '3-2':
	  window.location.href = "";
	  break;
	case '3-3':
	  window.location.href = "";
	  break;

	}
}
</script>
@show
</body>
</html>
