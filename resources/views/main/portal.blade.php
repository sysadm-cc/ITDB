@extends('main.layouts.mainbase')

@section('my_title')
Main(Portal) - 
@parent
@endsection

@section('my_style')
<style>
.ivu-table td.tableclass1{
	background-color: #2db7f5;
	color: #fff;
}
</style>
@endsection

@section('my_js')
@endsection

@section('my_project')
<strong>{{$config['SITE_TITLE']}} - Portal</strong>
@endsection

@section('my_body')
@parent

<div id="app" v-cloak>

	<!--第一行-->
	<i-row :gutter="16">
		<i-col span="5">
			<Card>
				<p slot="title">
					硬件 Manage your H/W items PCs, Switches, Phones, etc
					@hasanyrole('role_smt_config|role_super_admin')
					<span style="float:right">
						<a href="#" target="_blank">配置</a>
					</span>
					@endcan
				</p>
				<p v-for="item in CardList_Hardware">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							Percent: @{{ item.percent }}%
						</span>
					</span>
					<span v-else>
					&nbsp;
					</span>
				</p>
			</Card>
		</i-col>

		<i-col span="1">
		&nbsp;
		</i-col>

		<i-col span="5">
			<Card>
				<p slot="title">
					软件（2020版）
					@hasanyrole('role_smt_config|role_super_admin')
					<span style="float:right">
						<a href="#" target="_blank">配置</a>
					</span>
					@endcan
				</p>
				<p v-for="item in CardList_Software">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							Percent: @{{ item.percent }}%
						</span>
					</span>
					<span v-else>
					&nbsp;
					</span>
				</p>
			</Card>
		</i-col>
		
		<i-col span="1">
		&nbsp;
		</i-col>
		
		<i-col span="5">
			<Card>
				<p slot="title">
					发票
				</p>
				<p v-for="item in CardList_Invoices">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							Percent: @{{ item.percent }}%
						</span>
					</span>
					<span v-else>
					&nbsp;
					</span>
				</p>
			</Card>
			&nbsp;
		</i-col>

		<i-col span="1">
		&nbsp;
		</i-col>
		
		<i-col span="5">
			<Card>
				<p slot="title">
					报表
				</p>
				<p v-for="item in CardList_Reports">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							Percent: @{{ item.percent }}%
						</span>
					</span>
					<span v-else>
					&nbsp;
					</span>
				</p>
			</Card>
			&nbsp;
		</i-col>

		<i-col span="1">
		&nbsp;
		</i-col>

	</i-row>


	<!--第二行-->
	<i-row :gutter="16">
		<i-col span="5">
			<Card>
				<p slot="title">
					合同
					@hasanyrole('role_smt_config|role_super_admin')
					<span style="float:right">
						<a href="#" target="_blank">配置</a>
					</span>
					@endcan
				</p>
				<p v-for="item in CardList_Contracts">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							Percent: @{{ item.percent }}%
						</span>
					</span>
					<span v-else>
					&nbsp;
					</span>
				</p>
			</Card>
		</i-col>

		<i-col span="1">
		&nbsp;
		</i-col>

		<i-col span="5">
			<Card>
				<p slot="title">
					代理商
					@hasanyrole('role_smt_config|role_super_admin')
					<span style="float:right">
						<a href="#" target="_blank">配置</a>
					</span>
					@endcan
				</p>
				<p v-for="item in CardList_Agents">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							Percent: @{{ item.percent }}%
						</span>
					</span>
					<span v-else>
					&nbsp;
					</span>
				</p>
			</Card>
		</i-col>
		
		<i-col span="1">
		&nbsp;
		</i-col>
		
		<i-col span="5">
			<Card>
				<p slot="title">
					树形浏览
				</p>
				<p v-for="item in CardList_TreeExplorer">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							Percent: @{{ item.percent }}%
						</span>
					</span>
					<span v-else>
					&nbsp;
					</span>
				</p>
			</Card>
			&nbsp;
		</i-col>

		<i-col span="1">
		&nbsp;
		</i-col>
		
		<i-col span="5">
			<Card>
				<p slot="title">
					文档
				</p>
				<p v-for="item in CardList_Files">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							Percent: @{{ item.percent }}%
						</span>
					</span>
					<span v-else>
					&nbsp;
					</span>
				</p>
			</Card>
			&nbsp;
		</i-col>

		<i-col span="1">
		&nbsp;
		</i-col>

	</i-row>

	<!--第三行-->
	<i-row :gutter="16">
		<i-col span="5">
			<Card>
				<p slot="title">
					机架
					@hasanyrole('role_smt_config|role_super_admin')
					<span style="float:right">
						<a href="#" target="_blank">配置</a>
					</span>
					@endcan
				</p>
				<p v-for="item in CardList_Racks">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							Percent: @{{ item.percent }}%
						</span>
					</span>
					<span v-else>
					&nbsp;
					</span>
				</p>
			</Card>
		</i-col>

		<i-col span="1">
		&nbsp;
		</i-col>

		<i-col span="5">
			<Card>
				<p slot="title">
					位置场所
					@hasanyrole('role_smt_config|role_super_admin')
					<span style="float:right">
						<a href="#" target="_blank">配置</a>
					</span>
					@endcan
				</p>
				<p v-for="item in CardList_Locations">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							Percent: @{{ item.percent }}%
						</span>
					</span>
					<span v-else>
					&nbsp;
					</span>
				</p>
			</Card>
		</i-col>
		
		<i-col span="1">
		&nbsp;
		</i-col>
		
		<i-col span="5">
			<Card>
				<p slot="title">
					打印标签
				</p>
				<p v-for="item in CardList_PrintLabels">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							Percent: @{{ item.percent }}%
						</span>
					</span>
					<span v-else>
					&nbsp;
					</span>
				</p>
			</Card>
			&nbsp;
		</i-col>

		<i-col span="1">
		&nbsp;
		</i-col>
		
		<i-col span="5">
			<Card>
				<p slot="title">
					系统配置
				</p>
				<p v-for="item in CardList_Settings">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							Percent: @{{ item.percent }}%
						</span>
					</span>
					<span v-else>
					&nbsp;
					</span>
				</p>
			</Card>
			&nbsp;
		</i-col>

		<i-col span="1">
		&nbsp;
		</i-col>

	</i-row>







	<br><br><br>
	<p><br></p><p><br></p><p><br></p>
	<p><br></p><p><br></p><p><br></p>
	<p><br></p><p><br></p><p><br></p>
	<p><br></p><p><br></p><p><br></p>
	<p><br></p><p><br></p><p><br></p>
	<p><br></p><p><br></p><p><br></p>
	<p><br></p><p><br></p><p><br></p>
	<p><br></p><p><br></p><p><br></p>
	


</div>
@endsection

@section('my_js_others')
@parent	
<script>
var vm_app = new Vue({
	el: '#app',
	data: {
		// 是否全屏
		isfullscreen: false,

		CardList_Hardware: [
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
		],

		CardList_Software: [
			{
				name: '模块一',
				url: "#",
				percent: 65,
			},
			{
				name: '模块二',
				url: "#",
				percent: 15,
			},
			{
				name: '模块三',
				url: "#",
				percent: 85,
			},
			{
				name: '模块四',
				url: "#",
				percent: 85,
			},
		],

		CardList_Invoices: [
			{
				name: '模块三',
				url: "#",
				percent: 85,
			},
			{
				name: '',
				url: '',
				percent: 0,
			},
			{
				name: '',
				url: '',
				percent: 0,
			},
			{
				name: '',
				url: '',
				percent: 0,
			},
		],

		// 每行最后一个，也就是第四个必须保持4行
		CardList_Reports: [
			{
				name: '模块一',
				url: "#",
				percent: 65,
			},
			{
				name: '模块一',
				url: "#",
				percent: 65,
			},
			{
				name: '',
				url: '',
				percent: 0,
			},
			{
				name: '',
				url: '',
				percent: 0,
			},
		],

		CardList_Contracts: [
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
		],

		CardList_Agents: [
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
		],

		CardList_TreeExplorer: [
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
		],

		CardList_Racks: [
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
		],

		CardList_Locations: [
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
		],

		CardList_Files: [
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
		],

		CardList_PrintLabels: [
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
		],

		CardList_Settings: [
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '模块一',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
			{
				name: '',	url: "#", percent: 65,
			},
		],


		CardList_Admin: [
			{
				name: '后台管理入口',
				url: "{{ route('admin.system.index') }}",
				percent: 99,
			},
		],
		
		
		
			
			
	},
	methods: {
		// 2.Notice 通知提醒
		info (nodesc, title, content) {
			this.$Notice.info({
				title: title,
				desc: nodesc ? '' : content
			});
		},
		success (nodesc, title, content) {
			this.$Notice.success({
				title: title,
				desc: nodesc ? '' : content
			});
		},
		warning (nodesc, title, content) {
			this.$Notice.warning({
				title: title,
				desc: nodesc ? '' : content
			});
		},
		error (nodesc, title, content) {
			this.$Notice.error({
				title: title,
				desc: nodesc ? '' : content
			});
		},
		
		


		
		
		
		
		
			
			
	},
	mounted () {
	}
})
</script>
@endsection