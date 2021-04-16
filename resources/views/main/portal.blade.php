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
							<span style="color: rgb(158, 167, 180);font-size:10px;">
								@{{ item.detail }}
							</span>
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
						<Icon type="ios-archive"></Icon> 软件 Software
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
							<span style="color: rgb(158, 167, 180);font-size:10px;">
								@{{ item.detail }}
							</span>
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
					<Icon type="ios-paper"></Icon> 发票 Invoices
					</Tooltip>
				</p>
				<p v-for="item in CardList_Invoices">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							@{{ item.detail }}
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
					<Icon type="ios-pie"></Icon> 报表 Reports
					</Tooltip>
				</p>
				<p v-for="item in CardList_Reports">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							@{{ item.detail }}
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
					<Icon type="ios-document"></Icon> 合同 Contracts
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
							@{{ item.detail }}
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
					<Icon type="ios-person"></Icon> 代理商 Agents
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
							@{{ item.detail }}
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
					<Icon type="ios-browsers"></Icon> 树形浏览 Tree Explorer
					</Tooltip>
				</p>
				<p v-for="item in CardList_TreeExplorer">
					<span v-if="item.name">
						<a :href="item.url" target="_blank"><Icon type="ios-link"></Icon>&nbsp;&nbsp;@{{ item.name }}</a>
						<span style="float:right">
							@{{ item.detail }}
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
							@{{ item.detail }}
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
					<Icon type="ios-cube"></Icon> 机柜 Racks
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
							@{{ item.detail }}
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
					<Icon type="ios-pin"></Icon> 位置/区域 Locations
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
							@{{ item.detail }}
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
							@{{ item.detail }}
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
							@{{ item.detail }}
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
				name: '查询',	url: "{{ route('item.items') }}", detail: '查询硬件信息',
			},
			{
				name: '添加',	url: "{{ route('item.add') }}", detail: '添加硬件信息',
			},
			{
				name: '项目类型',	url: "{{ route('item.itemtypes') }}", detail: '查看/修改项目类型',
			},
			{
				name: '状态类型',	url: "{{ route('item.statustypes') }}", detail: '查看/修改状态类型',
			},
		],

		CardList_Software: [
			{
				name: '查询',	url: "{{ route('soft.softs') }}", detail: '查询软件信息',
			},
			{
				name: '添加',	url: "{{ route('soft.add') }}", detail: '添加软件信息',
			},
			{
				name: '',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
		],

		CardList_Invoices: [
			{
				name: '查询',	url: "{{route('invoice.invoices')}}", detail: '查询发票',
			},
			{
				name: '添加',	url: "{{route('invoice.add')}}", detail: '添加发票',
			},
			{
				name: '',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
		],

		// 每行最后一个，也就是第四个必须保持4行
		CardList_Reports: [
			{
				name: '报表',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
		],

		CardList_Contracts: [
			{
				name: '查询',	url: "{{route('contract.contracts')}}", detail: '查询合同',
			},
			{
				name: '添加',	url: "{{route('contract.add')}}", detail: '添加合同',
			},
			{
				name: '合同类型',	url: "{{route('contract.contracttypes')}}", detail: '编辑合同类型',
			},
			{
				name: '',	url: '#', detail: '',
			},
		],

		CardList_Agents: [
			{
				name: '查询',	url: "{{ route('agent.agents') }}", detail: '查询代理商',
			},
			{
				name: '添加',	url: "{{ route('agent.create') }}", detail: '添加代理商',
			},
			{
				name: '',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
		],

		CardList_TreeExplorer: [
			{
				name: '浏览',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
		],

		CardList_Files: [
			{
				name: '查询',	url: "{{route('file.files')}}", detail: '查询文件',
			},
			{
				name: '添加',	url: "{{route('file.add')}}", detail: '添加文件',
			},
			{
				name: '',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
		],

		CardList_Racks: [
			{
				name: '查询',	url: "{{route('rack.racks')}}", detail: '查询机柜',
			},
			{
				name: '添加',	url: "{{route('rack.add')}}", detail: '添加机柜',
			},
			{
				name: '',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
		],

		CardList_Locations: [
			{
				name: '查询',	url: "{{route('location.locations')}}", detail: '查询位置',
			},
			{
				name: '添加',	url: "{{route('location.add')}}", detail: '添加位置',
			},
			{
				name: '',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
		],

		CardList_PrintLabels: [
			{
				name: '标签',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
		],

		CardList_Settings: [
			{
				name: '系统配置',	url: '#', detail: '',
			},
			{
				name: '用户',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
			},
			{
				name: '',	url: '#', detail: '',
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