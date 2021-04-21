@extends('item.layouts.mainbase')

@section('my_title')
物品查询 - 
@parent
@endsection

@section('my_style')
<!-- <link rel="stylesheet" href="{{ asset('css/camera.css') }}"> -->
<style type="text/css">
/* 合并单元格样式 */
.subCol>ul>li{
      margin:0 -18px;
      list-style:none;
      text-Align: center;
      padding: 9px;
      border-bottom:1px solid #E8EAEC;
      overflow-x: hidden;
	  line-height: 2.2;
}
.subCol>ul>li:last-child{
  border-bottom: none
}

.ivu-table .table-info-row td{
	background-color: #2db7f5;
	color: #fff;
}
.ivu-table .table-error-row td{
	background-color: #ff6600;
	color: #fff;
}
.ivu-table td.table-info-column{
	background-color: #2db7f5;
	color: #fff;
}
.ivu-table .table-info-cell-name {
	background-color: #2db7f5;
	color: #fff;
}
.ivu-table .table-info-cell-age {
	background-color: #ff6600;
	color: #fff;
}
.ivu-table .table-info-cell-address {
	background-color: #187;
	color: #fff;
}

.ivu-table td.table-info-column-usage {
	background-color: #187;
	color: #fff;
}
.ivu-table td.table-info-column-misc {
	background-color: #696969;
	color: #fff;
}
</style>
@endsection

@section('my_js')
<script type="text/javascript">
</script>
@endsection

@section('my_body')
@parent

<Divider orientation="left">物品查询</Divider>


	
	<Collapse v-model="collapse_query">
		<Panel name="1">
			查询条件
			<p slot="content">
			
				<i-row>
					<i-col span="8">
						* login time&nbsp;&nbsp;
						<Date-picker v-model.lazy="queryfilter_logintime" @on-change="usergets(page_current, page_last);onselectchange();" type="daterange" size="small" placement="top" style="width:200px"></Date-picker>
					</i-col>
					<i-col span="4">
						name&nbsp;&nbsp;
						<i-input v-model.lazy="queryfilter_name" @on-change="usergets(page_current, page_last)" size="small" clearable style="width: 100px"></i-input>
					</i-col>
					<i-col span="4">
						email&nbsp;&nbsp;
						<i-input v-model.lazy="queryfilter_email" @on-change="usergets(page_current, page_last)" size="small" clearable style="width: 100px"></i-input>
					</i-col>
					<i-col span="4">
						login ip&nbsp;&nbsp;
						<i-input v-model.lazy="queryfilter_loginip" @on-change="usergets(page_current, page_last)" size="small" clearable style="width: 100px"></i-input>
					</i-col>
					<i-col span="4">
						&nbsp;
					</i-col>
				</i-row>
			
			
			&nbsp;
			</p>
		</Panel>
	</Collapse>
	
	<i-row :gutter="16">
		<br>
		<i-col span="3">
			<i-button @click="items_delete()" :disabled="items_delete_disabled" type="warning" size="small">删除</i-button>&nbsp;<br>&nbsp;
		</i-col>
		<i-col span="2">
			<i-button type="default" size="small" @click="items_create()"><Icon type="ios-color-wand-outline"></Icon> 新建</i-button>
		</i-col>
		<i-col span="2">
			<i-button type="default" size="small" @click="items_export()"><Icon type="ios-download-outline"></Icon> 导出</i-button>
		</i-col>
		<i-col span="17">
			&nbsp;
		</i-col>
	</i-row>
	
	<i-row :gutter="16">
		<i-col span="24">

			<i-table height="300" size="small" border :columns="tablecolumns" :data="tabledata" @on-selection-change="selection => onselectchange(selection)"></i-table>
			<br><Page :current="page_current" :total="page_total" :page-size="page_size" @on-change="currentpage => oncurrentpagechange(currentpage)" @on-page-size-change="pagesize => onpagesizechange(pagesize)" :page-size-opts="[5, 10, 20, 50]" show-total show-elevator show-sizer></Page>
		

	
		</i-col>
	</i-row>

<!-- 以下为各元素编辑窗口 -->

<!-- 主编辑窗口 properties-->
<Modal v-model="modal_edit_items_properties" @on-ok="update_items_properties" ok-text="保存" title="编辑 - 物品属性" width="540">
	<div style="text-align:left">

		<p>
		<i-form :label-width="100">
		<i-row>
			<i-col span="12">
				
				<Form-Item label="物品名称" required style="margin-bottom:0px">
					<i-input v-model.lazy="edit_title" size="small"></i-input>
				</Form-Item>
				<Form-Item label="物品类型" required style="margin-bottom:0px">
					<i-select v-model.lazy="edit_itemtype_select" size="small" placeholder="">
						<i-option v-for="item in edit_itemtype_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
					</i-select>
				</Form-Item>
				<Form-Item label="是否部件" required style="margin-bottom:0px">
					<i-switch v-model.lazy="edit_ispart">
						<span slot="open">是</span>
						<span slot="close">否</span>
					</i-switch>
				</Form-Item>
				<Form-Item label="是否机架式" required style="margin-bottom:0px">
					<i-switch v-model.lazy="edit_rackmountable">
						<span slot="open">是</span>
						<span slot="close">否</span>
					</i-switch>
				</Form-Item>
				<Form-Item label="代理商" required style="margin-bottom:0px">
					<i-select v-model.lazy="edit_agent_select" size="small" placeholder="">
						<i-option v-for="item in edit_agent_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
					</i-select>
				</Form-Item>
				<Form-Item label="型号" required style="margin-bottom:0px">
					<i-input v-model.lazy="edit_model" size="small"></i-input>
				</Form-Item>
				<Form-Item label="尺寸(U)" style="margin-bottom:0px">
					<i-select v-model.lazy="edit_usize_select" size="small" placeholder="">
						<i-option v-for="item in edit_usize_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
					</i-select>
				</Form-Item>
			</i-col>

			<i-col span="12">
				<Form-Item label="资产标签" style="margin-bottom:0px">
					<i-input v-model.lazy="edit_assettag" size="small"></i-input>
				</Form-Item>
				<Form-Item label="S/N 1" style="margin-bottom:0px">
					<i-input v-model.lazy="edit_sn1" size="small" placeholder="序列号一"></i-input>
				</Form-Item>
				<Form-Item label="S/N 2" style="margin-bottom:0px">
					<i-input v-model.lazy="edit_sn2" size="small" placeholder="序列号二"></i-input>
				</Form-Item>
				<Form-Item label="Service Tag" style="margin-bottom:0px">
					<i-input v-model.lazy="edit_servicetag" size="small" placeholder="服务编号"></i-input>
				</Form-Item>
				<Form-Item label="备注" style="margin-bottom:0px">
					<i-input v-model.lazy="edit_comments" size="small" type="textarea" :rows="4"></i-input>
				</Form-Item>
			</i-col>

		</i-row>
		</i-form>
		</p>
		&nbsp;<br>
	</div>	
</Modal>

@endsection

@section('my_footer')
@parent

@endsection

@section('my_js_others')
@parent
<script>
var vm_app = new Vue({
    el: '#app',
    data: {
		// 是否全屏
		isfullscreen: false,

		// 修改密码界面
		modal_password_edit: false,

		// 拍照界面
		modal_camera_show: false,
        camera_imgurl: '',

		current_nav: '',
		current_subnav: '',
		
		sideractivename: '1-1',
		sideropennames: ['1'],
		
		//分页
		page_current: 1,
		page_total: 0, // 记录总数，非总页数
		page_size: {{ $user['configs']['PERPAGE_RECORDS_FOR_APPLICANT'] ?? 10 }},
		page_last: 1,

		// tabs索引
		currenttabs: 0,
		currenttabssub: 0,

		// 删除按钮禁用
		items_delete_disabled: true,

		// 
		edit_statustype_options: [],

		// 主编辑变量
		modal_edit_items_properties: false,
		modal_edit_items_usage: false,
		modal_edit_items_warranty: false,
		modal_edit_items_misc: false,
		modal_edit_items_network: false,
		edit_id: '',
		edit_updated_at: '',

		edit_title: '',
		edit_itemtype_select: '',
		edit_itemtype_options: [],
		edit_ispart: false,
		edit_rackmountable: false,
		edit_agent_select: '',
		edit_agent_options: [],
		edit_model: '',
		edit_usize_select: '',
		edit_usize_options: [],
		edit_sn1: '',
		edit_sn2: '',
		edit_servicetag: '',
		edit_comments: '',
		edit_assettag: '',

		// 参数变量 - 使用
		edit_status_select: '',
		edit_status_options: [],
		edit_user_select: '',
		edit_user_options: [],
		edit_location_select: '',
		edit_location_options: [],
		edit_area_select: '',
		edit_area_options: [],
		edit_rack_select: '',
		edit_rack_options: [],
		edit_rackposition_select1: '',
		edit_rackposition_options1: [],
		edit_rackposition_select2: '',
		edit_rackposition_options2: [
			{label: 'FM-', value: 'FM-'},
			{label: '-MB', value: '-MB'},
			{label: 'F--', value: 'F--'},
			{label: '-M-', value: '-M-'},
			{label: '--B', value: '--B'},
			{label: 'FMB', value: 'FMB'},
		],
		edit_function: '',
		edit_maintenanceinstructions: '',

		// 参数变量 - 保修
		edit_shop: '',
		edit_purchaceprice: '',
		edit_dateofpurchase: '',
		edit_warrantymonths: '',
		edit_warrantyinfo: '',

		// 参数变量 - 配件
		edit_motherboard: '',
		edit_harddisk: '',
		edit_ram: '',
		edit_cpumodel: '',
		edit_cpus_select: '',
		edit_cpus_options: [
			{label: 1, value: 1},
			{label: 2, value: 2},
			{label: 3, value: 3},
		],
		edit_cpucores_select: '',
		edit_cpucores_options: [
			{label: 1, value: 1},
			{label: 2, value: 2},
			{label: 3, value: 3},
		],

		// 参数变量 - 网络
		edit_dns: '',
		edit_maclan: '',
		edit_macwl: '',
		edit_ipv4lan: '',
		edit_ipv4wl: '',
		edit_ipv6lan: '',
		edit_ipv6wl: '',
		edit_remoteadminip: '',
		edit_panelport: '',
		edit_switch_select: '',
		edit_switch_options: [
			{label: 1, value: 1},
			{label: 2, value: 2},
			{label: 3, value: 3},
		],
		edit_switchport: '',
		edit_networkports_select: '',
		edit_networkports_options: [
			{label: 1, value: 1},
			{label: 2, value: 2},
			{label: 3, value: 3},
		],


		tablecolumns: [
			{
				type: 'selection',
				width: 60,
				align: 'center',
				fixed: 'left'
			},
			{
				title: '序号',
				type: 'index',
				align: 'center',
				width: 70,
				indexMethod: (row) => {
					return row._index + 1 + vm_app.page_size * (vm_app.page_current - 1)
				}
			},
			{
				title: '状态',
				key: 'status',
				align: 'center',
				width: 50,
				render: (h, params) => {
					return h('span', vm_app.edit_statustype_options.map((item, index) => {
						if (params.row.status == item.id) {
							return  h('Tooltip', {
								props: {
									'theme': 'light',
									'placement': 'top',
									'content': item.statusdesc,
								},
							}, [
								h('Icon',{
									props: {
										type: 'md-bookmark',
										size: 14,
										color: item.color,
									}
								}),
							])
						}
					}));
				}
			},
			{
			title: '物品属性',
				align: 'center',
				children: [
					{
						title: '资产标签',
						key: 'assettag',
						// sortable: true,
						resizable: true,
						width: 100
					},
					{
						title: '物品名称',
						key: 'title',
						resizable: true,
						width: 100
					},
					{
						title: '物品类型',
						key: 'itemtypeid',
						resizable: true,
						width: 100,
						render: (h, params) => {
							return h('span', vm_app.edit_itemtype_options.map((item, index) => {
								if (params.row.itemtypeid == item.value) {
									return  h('span', {}, item.label)
								}
							}));
						}
					},
					{
						title: '是否部件',
						key: 'ispart',
						align: 'center',
						width: 70,
						render: (h, params) => {
							params.row.ispart = params.row.ispart ? true : false;
							if (params.row.ispart) {
								return h('icon',{
									props: {
										type: 'md-radio-button-off',
										size: '14'
									}
								})
							} else {
								return h('icon',{
									props: {
										type: 'md-close',
										size: '14'
									}
								})
							}
						}
					},
					{
						title: '是否机架式',
						key: 'rackmountable',
						align: 'center',
						width: 80,
						render: (h, params) => {
							params.row.rackmountable = params.row.rackmountable ? true : false;
							if (params.row.rackmountable) {
								return h('icon',{
									props: {
										type: 'md-radio-button-off',
										size: '14'
									}
								})
							} else {
								return h('icon',{
									props: {
										type: 'md-close',
										size: '14'
									}
								})
							}
						}
					},
					{
						title: '代理商',
						key: 'agentid',
						resizable: true,
						width: 100
					},
					{
						title: '尺寸(U)',
						key: 'usize',
						resizable: true,
						width: 80
					},
					{
						title: '序列号一',
						key: 'sn1',
						resizable: true,
						width: 160
					},
					{
						title: '序列号二',
						key: 'sn2',
						resizable: true,
						width: 160
					},
					{
						title: '服务编号',
						key: 'servicetag',
						resizable: true,
						width: 160
					},
					{
						title: '备注',
						key: 'comments',
						resizable: true,
						width: 160
					},
				]
			},
			{
				title: '使用情况',
				align: 'center',
				children: [
					{
						title: '状态',
						key: 'status',
						width: 100,
						className: 'table-info-column-usage',
					},
					{
						title: '使用者',
						key: 'userid',
						width: 100,
						className: 'table-info-column-usage',
					},
					{
						title: '位置/楼层',
						key: 'locationid',
						width: 100,
						className: 'table-info-column-usage',
					},
					{
						title: '区域/房间',
						key: 'areaid',
						width: 100,
						className: 'table-info-column-usage',
					},
					{
						title: '机柜',
						key: 'rackid',
						width: 100,
						className: 'table-info-column-usage',
					},
					{
						title: '所在机架高度',
						key: 'rackposition',
						width: 70,
						className: 'table-info-column-usage',
					},
					{
						title: '所在机架深度',
						key: 'rackdepth',
						width: 70,
						className: 'table-info-column-usage',
					},
					{
						title: '功能用途',
						key: 'function',
						width: 100,
						className: 'table-info-column-usage',
					},
					{
						title: '具体使用说明',
						key: 'maintenanceinstructions',
						width: 100,
						className: 'table-info-column-usage',
					},

				]
			},
			{
				title: '保修信息',
				align: 'center',
				children: [
					{
						title: '经销商',
						key: 'shop',
						width: 100
					},
					{
						title: '购买价格',
						key: 'purchaseprice',
						width: 100
					},
					{
						title: '购买日期',
						key: 'purchasedate',
						width: 100
					},
					{
						title: '保修时长（月）',
						key: 'warrantymonths',
						width: 100
					},
					{
						title: '保修信息',
						key: 'warrantyinfo',
						width: 100
					},

				]
			},
			{
				title: '配件信息',
				align: 'center',
				children: [
					{
						title: '主板',
						key: 'motherboard',
						width: 100,
						className: 'table-info-column-misc',
					},
					{
						title: '硬盘',
						key: 'hd',
						width: 100,
						className: 'table-info-column-misc',
					},
					{
						title: '内存',
						key: 'ram',
						width: 100,
						className: 'table-info-column-misc',
					},
					{
						title: 'CPU',
						key: 'cpu',
						width: 100,
						className: 'table-info-column-misc',
					},
					{
						title: 'CPU数量',
						key: 'cpuno',
						width: 100,
						className: 'table-info-column-misc',
					},
					{
						title: '每CPU内核数量',
						key: 'corespercpu',
						width: 100,
						className: 'table-info-column-misc',
					},
				]
			},
			{
				title: '网络相关',
				align: 'center',
				children: [
					{
						title: '域名',
						key: 'dns',
						width: 100
					},
					{
						title: '有线MAC地址',
						key: 'maclan',
						width: 100
					},
					{
						title: '无线MAC地址',
						key: 'macwl',
						width: 100
					},
					{
						title: '有线IPv4',
						key: 'ipv4lan',
						width: 100
					},
					{
						title: '无线IPv4',
						key: 'ipv4wl',
						width: 100
					},
					{
						title: '有线IPv6',
						key: 'ipv6lan',
						width: 100
					},
					{
						title: '无线IPv6',
						key: 'ipv6wl',
						width: 100
					},
					{
						title: '管理IP',
						key: 'remadmip',
						width: 100
					},
					{
						title: '面板端口',
						key: 'panelport',
						width: 100
					},
					{
						title: '交换机编号',
						key: 'switchid',
						width: 100
					},
					{
						title: '接入交换机端口号',
						key: 'switchport',
						width: 100
					},
					{
						title: '网络端口数量',
						key: 'ports',
						width: 100
					},
				]
			},
			{
				title: '创建时间',
				key: 'created_at',
				width: 160
			},
			{
				title: '更新时间',
				key: 'updated_at',
				width: 160
			},
			{
				title: '操作',
				key: 'action',
				align: 'center',
				width: 100,
				fixed: 'right',
				render: (h, params) => {
					return h('div', [

						h('Poptip', {
							props: {
								'word-wrap': true,
								'trigger': 'hover',
								'confirm': false,
								'content': '编辑'+params.row.title+'的信息',
								'transfer': true
							},
						}, [
							h('Button', {
								props: {
									type: 'primary',
									size: 'small',
									icon: 'md-create'
								},
								style: {
									marginRight: '5px'
								},
								on: {
									click: () => {
										vm_app.edit_items(params.row)
									}
								}
							}),
						]),
					]);
				},
			}
		],
		tabledata: [],
		tableselect: [],










		
		
		// 创建
		modal_user_add: false,
		user_add_id: '',
		user_add_name: '',
		user_add_displayname: '',
		user_add_email: '',
		user_add_department: '',
		user_add_uid: '',
		user_add_password: '',
		
		// 编辑
		modal_user_edit: false,
		user_edit_id: '',
		user_edit_name: '',
		user_edit_email: '',
		user_edit_displayname: '',
		user_edit_department: '',
		user_edit_uid: '',
		user_edit_password: '',
		
		// 删除
		delete_disabled_user: true,

		// tabs索引
		currenttabs: 0,
		currentsubtabs1: 0,
		currentsubtabs2: 0,
		
		// 查询过滤器
		queryfilter_name: "{{ $config['FILTERS_USER_NAME'] }}",
		queryfilter_email: "{{ $config['FILTERS_USER_EMAIL'] }}",
		queryfilter_logintime: "{{ $config['FILTERS_USER_LOGINTIME'] }}" || [],
		queryfilter_loginip: "{{ $config['FILTERS_USER_LOGINIP'] }}",
		
		// 查询过滤器下拉
		collapse_query: '',
		
		// 选择用户查看编辑相应角色 申请
		user_select_current_applicant: '',
		user_options_current_applicant: [],
		user_loading_current_applicant: false,
		user_select_auditing_applicant: '',
		user_select_auditing_uid: '',
		user_options_auditing_applicant: [],
		user_loading_auditing_applicant: false,
		boo_update2_applicant: true,
		username_current2_applicant: '',
		username_auditing2_applicant: '',
		
		// 选择用户查看编辑相应角色 确认
		user_select_current_confirm: '',
		user_options_current_confirm: [],
		user_loading_current_confirm: false,
		user_select_auditing_confirm: '',
		// user_select_auditing_uid: '',
		user_options_auditing_confirm: [],
		user_loading_auditing_confirm: false,
		boo_update2_confirm: true,
		username_current2_confirm: '',
		username_auditing2_confirm: '',

		boo_update1: true,
		username_current1: '',
		username_auditing1: '',
		// 代理用户
		treedata_applicant: [
			{
				title: '请选择代理申请用户',
				loading: false,
				children: []
			}
		],

		// 处理用户
		treedata_auditing: [
			{
				title: '请选择处理用户',
				loading: false,
				children: []
			}
		],

		// 外部数据源用户
		users_external: '',
		
		
		
		
		
		
		
		
		
		
		
		
    },
	methods: {
		menuselect (name) {
			navmenuselect(name);
		},
		// 1.加载进度条
		loadingbarstart () {
			this.$Loading.start();
		},
		loadingbarfinish () {
			this.$Loading.finish();
		},
		loadingbarerror () {
			this.$Loading.error();
		},
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

		alert_logout () {
			this.error(false, '会话超时', '会话超时，请重新登录！');
			window.setTimeout(function(){
				window.location.href = "{{ route('portal') }}";
			}, 2000);
			return false;
		},
		
		// 把laravel返回的结果转换成select能接受的格式
		json2selectvalue (json) {
			var arr = [];
			for (var key in json) {
				// alert(key);
				// alert(json[key]);
				// arr.push({ obj.['value'] = key, obj.['label'] = json[key] });
				arr.push({ value: key, label: json[key] });
			}
			return arr;
			// return arr.reverse();
		},


		// 切换当前页
		oncurrentpagechange (currentpage) {
			this.itemsgets(currentpage, this.page_last);
		},

		
		//
		itemsgets (page, last_page){
			var _this = this;
			
			if (page > last_page) {
				page = last_page;
			} else if (page < 1) {
				page = 1;
			}
			

			_this.loadingbarstart();
			var url = "{{ route('item.itemsgets') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					perPage: _this.page_size,
					page: page,
				}
			})
			.then(function (response) {
				// console.log(response.data);
				// return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}

				if (response.data) {
					_this.items_delete_disabled = true;
					_this.tableselect = [];
					
					_this.page_current = response.data.current_page;
					_this.page_total = response.data.total;
					_this.page_last = response.data.last_page;
					_this.tabledata = response.data.data;
					
				}
				
				_this.loadingbarfinish();
			})
			.catch(function (error) {
				_this.loadingbarerror();
				_this.error(false, 'Error', error);
			})
		},


		// 表格选择
		onselectchange (selection) {
			var _this = this;
			_this.tableselect = [];

			for (var i in selection) {
				_this.tableselect.push(selection[i].id);
			}
			
			_this.items_delete_disabled = _this.tableselect[0] == undefined ? true : false;
		},

		// 获取状态类型
		statustypesgets () {
			var _this = this;
			var url = "{{ route('item.statustypesgets') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					perPage: 1000,
					page: 1,
				}
			})
			.then(function (response) {
				// console.log(response.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}

				if (response.data) {
					// response.data.data.map(function (v, i) {
					// 	_this.edit_statustype_options.push({value: v.id, label: v.statusdesc});
					// });
					_this.edit_statustype_options = response.data.data;
				}

				
			})
			.catch(function (error) {
				// _this.error(false, 'Error', error);
			})
		},
		

		// 获取物品类型列表
		itemtypesgets () {
			var _this = this;
			var url = "{{ route('item.itemtypesgets') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url)
			.then(function (response) {
				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				if (response.data) {
					response.data.data.map(function (v, i) {
						_this.edit_itemtype_options.push({label: v.typedesc, value: v.id});
					});
				}
			})
			.catch(function (error) {
			})
		},


		// 获取代理商列表
		agentsgets () {
			var _this = this;
			var url = "{{ route('agent.gets') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					perPage: 1000,
					page: 1,
				}
			})
			.then(function (response) {
				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				if (response.data) {
					response.data.data.map(function (v, i) {
						_this.edit_agent_options.push({label: v.title, value: v.id});
					});
				}
			})
			.catch(function (error) {
			})
		},


		// 获取位置信息列表
		locationsgets () {
			var _this = this;
			var url = "{{ route('location.gets') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					perPage: 1000,
					page: 1,
				}
			})
			.then(function (response) {
				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				if (response.data) {
					response.data.data.map(function (v, i) {
						_this.edit_location_options.push({value: v.id, label: v.title+' ('+v.building+' / '+v.floor+')'});
					});
				}
			})
			.catch(function (error) {
			})
		},

		// 根据位置查询区域/房间
		onchange_location () {
			var _this = this;
			
			var locationid = _this.add_location_select;
			
			if (locationid == '' || locationid == undefined) {
				return false;
			}
			
			var url = "{{ route('rack.location2area') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					locationid: locationid,
				}
			})
			.then(function (response) {
				// console.log(response.data.areas);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}

				if (response.data) {
					_this.edit_area_select = '';
					_this.edit_area_options = [];
					response.data.areas.map(function (v, i) {
						_this.edit_area_options.push({value: i, label: v.name+' [x1: '+v.x1+',y1: '+v.y2+'], [x2: '+v.x2+',y2: '+v.y2+'])'});
					});
				}
			})
			.catch(function (error) {
			})
		},
	
		// 获取机柜列表
		racksgets () {
			var _this = this;
			var url = "{{ route('rack.gets') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					perPage: 1000,
					page: 1,
				}
			})
			.then(function (response) {
				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				if (response.data) {
					response.data.data.map(function (v, i) {
						_this.edit_rack_options.push({label: v.title, value: v.id});
					});
				}
			})
			.catch(function (error) {
			})
		},


		// 主编辑前查看 - agents
		edit_items (row) {
			var _this = this;

			_this.edit_id = row.id;
			_this.edit_updated_at = row.updated_at;

			// 参数变量 - 属性
			_this.edit_title = row.title;
			_this.edit_itemtype_select = row.itemtypeid;
			_this.edit_ispart = row.ispart;
			_this.edit_rackmountable = row.rackmountable;
			_this.edit_agent_select = row.agentid;
			_this.edit_model = row.model;
			_this.edit_usize_select = row.usize;
			_this.edit_sn1 = row.sn1;
			_this.edit_sn2 = row.sn2;
			_this.edit_servicetag = row.servicetag;
			_this.edit_comments = row.comments;
			_this.edit_assettag = row.assettag;

			// 参数变量 - 使用
			_this.edit_status_select = row.status;
			_this.edit_user_select = row.user;
			_this.edit_location_select = row.location;
			_this.edit_area_select = row.area;
			_this.edit_rack_select = row.rack;
			_this.edit_rackposition_select1 = row.rackposition1;
			_this.edit_rackposition_select2 = row.rackposition2;
			_this.edit_function = row.function;
			_this.edit_maintenanceinstructions = row.maintenanceinstructions;

			// 参数变量 - 保修
			_this.edit_shop = row.shop;
			_this.edit_purchaceprice = row.purchaceprice;
			_this.edit_dateofpurchase = row.dateofpurchase;
			_this.edit_warrantymonths = row.warrantymonths;
			_this.edit_warrantyinfo = row.warrantyinfo;

			// 参数变量 - 配件
			_this.edit_motherboard = row.motherboard;
			_this.edit_harddisk = row.harddisk;
			_this.edit_ram = row.ram;
			_this.edit_cpumodel = row.cpumodel;
			_this.edit_cpus_select = row.cpus;
			_this.edit_cpucores_select = row.cpucores;

			// 参数变量 - 网络
			_this.edit_dns = row.dns;
			_this.edit_maclan = row.maclan;
			_this.edit_macwl = row.macwl;
			_this.edit_ipv4lan = row.ipv4lan;
			_this.edit_ipv4wl = row.ipv4wl;
			_this.edit_ipv6lan = row.ipv6lan;
			_this.edit_ipv6wl = row.ipv6wl;
			_this.edit_remoteadminip = row.remoteadminip;
			_this.edit_panelport = row.panelport;
			_this.edit_switch_select = row.switch;
			_this.edit_switchport = row.switchport;
			_this.edit_networkports_select = row.ports;








			_this.modal_edit_items_properties = true;
		},

		// 主编辑保存 - agents
		update_items_properties () {
			var _this = this;

			var id = _this.edit_id;
			var updated_at = _this.edit_updated_at;

			var title = _this.edit_title;
			var itemtypeid = _this.edit_itemtype_select;
			var ispart = _this.edit_ispart;
			var rackmountable = _this.edit_rackmountable;
			var agentid = _this.edit_agent_select;
			var model = _this.edit_model;
			var usize = _this.edit_usize_select;
			var assettag = _this.edit_assettag;
			var sn1 = _this.edit_sn1;
			var sn2 = _this.edit_sn2;
			var servicetag = _this.edit_servicetag;
			var comments = _this.edit_comments;

			if (id == undefined || title == '' || title == undefined
				|| itemtypeid == '' || itemtypeid == undefined
				|| agentid == '' || agentid == undefined
				|| model == '' || model == undefined) {
				_this.error(false, '错误', '内容为空或不正确！');
				return false;
			}


			var url = "{{ route('item.itemsupdate_properties') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				id: id,
				updated_at: updated_at,
				// 参数变量 - 属性
				title: title,
				itemtypeid: itemtypeid,
				ispart: ispart,
				rackmountable: rackmountable,
				agentid: agentid,
				model: model,
				usize: usize,
				assettag: assettag,
				sn1: add_sn1,
				sn2: add_sn2,
				servicetag: servicetag,
				comments: comments,
			})
			.then(function (response) {
				// console.log(response.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
				if (response.data) {
					_this.success(false, '成功', '更新成功！');
						_this.itemsgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '更新失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '更新失败！');
			})

		},
		
		// 根据位置查询区域/房间
		onchange_location () {
			var _this = this;
			
			var locationid = _this.add_location_select;
			
			if (locationid == '' || locationid == undefined) {
				return false;
			}
			
			var url = "{{ route('rack.location2area') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					locationid: locationid,
				}
			})
			.then(function (response) {
				// console.log(response.data.areas);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}

				if (response.data) {
					_this.edit_area_select = '';
					_this.edit_area_options = [];
					response.data.areas.map(function (v, i) {
						_this.edit_area_options.push({value: i, label: v.name+' [x1: '+v.x1+',y1: '+v.y2+'], [x2: '+v.x2+',y2: '+v.y2+'])'});
					});
				}
			})
			.catch(function (error) {
				// this.error(false, 'Error', error);
			})
		},

		


	},
	mounted: function(){
		var _this = this;
		_this.loadingbarstart();
		_this.current_nav = '硬件';
		_this.current_subnav = '物品查询';

		// 获取状态类型
		_this.statustypesgets();

		// 获取物品类型列表
		_this.itemtypesgets();

		// 获取制造商列表
		_this.agentsgets();

		// 获取位置列表
		_this.locationsgets();

		// 获取机柜列表
		_this.racksgets();



		// 尺寸
		for (var i=1;i<=44;i++) {
			_this.edit_usize_options.push({label: i, value: i});
		}

		// 所在机架高度
		for (var i=1;i<=50;i++) {
			_this.edit_rackposition_options1.push({label: i, value: i});
		}





		// 显示所有记录
		_this.itemsgets(1, 1); // page: 1, last_page: 1
		_this.loadingbarfinish();
	}
});
</script>
@endsection