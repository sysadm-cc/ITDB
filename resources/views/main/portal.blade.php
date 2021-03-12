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
					<Tooltip placement="top-start" content="Manage your H/W items (PCs, Switches, Phones, etc)" max-width="220"  theme="light">
						<Icon type="ios-desktop"></Icon> 硬件 Hardware
					</Tooltip>
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
					<Tooltip placement="top-start" max-width="220" content="Manage your software" theme="light">
						<Icon type="ios-paper"></Icon> 软件 Software
					</Tooltip>
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
					<Tooltip placement="top-start" max-width="220" content="Manage your Invoices" theme="light">
						发票 Invoices
					</Tooltip>
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
					<Tooltip placement="top-start" max-width="220" content="View Reports" theme="light">
					<Icon type="ios-stats"></Icon> 报表 Reports
					</Tooltip>
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
					<Tooltip placement="top-start" max-width="220" content="Manage your contracts (Support, Licenses, Leases, etc)" theme="light">
						合同 Contracts
					</Tooltip>
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
					<Tooltip placement="top-start" max-width="220" content="Manage Agents (H/W & S/W Manufacturers & Vendors, Buyers, Contractors)" theme="light">
						代理商 Agents
					</Tooltip>
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
					<Tooltip placement="top-start" max-width="220" content="View items by type, by user, by agent" theme="light">
						树形浏览 Tree Explorer
					</Tooltip>
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
					<Tooltip placement="top-start" max-width="220" content="File Maintenance" theme="light">
					<Icon type="ios-document"></Icon> 文件 Files
					</Tooltip>
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
					<Tooltip placement="top-start" max-width="220" content="Add/View Racks" theme="light">
						机架 Racks
					</Tooltip>
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
					<Tooltip placement="top-start" max-width="220" content="Manage item locations" theme="light">
						位置场所 Locations
					</Tooltip>
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
					<Tooltip placement="top-start" max-width="220" content="select and print labels for your items" theme="light">
						<Icon type="ios-pricetags"></Icon> 打印标签 Print Labels
					</Tooltip>
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
					<Tooltip placement="top-start" max-width="220" content="Manage various parameters (Users, Tags, Dates, Currency,...)" theme="light">
					<Icon type="ios-settings"></Icon> 系统配置 Settings
					</Tooltip>
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