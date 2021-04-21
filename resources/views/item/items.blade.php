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
	background-color: #5F9EA0;
	color: #fff;
}
.ivu-table td.table-info-column-urls {
	background-color: #187;
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
			
				<i-row :gutter="16">
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
				key: 'itemtypeid',
				align: 'center',
				width: 50,
				render: (h, params) => {
					return h('span', vm_app.edit_statustype_options.map((item, index) => {
						if (params.row.itemtypeid == item.id) {
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
						title: '物品类型',
						key: 'itemtypeid',
						resizable: true,
						width: 100
					},
					{
						title: '是否部件',
						key: 'ispart',
						align: 'center',
						resizable: true,
						width: 70,
						render: (h, params) => {
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
						resizable: true,
						width: 80,
						render: (h, params) => {
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
						title: '尺寸（单位U）',
						key: 'usize',
						resizable: true,
						width: 160
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
						width: 100,
						className: 'table-info-column-usage',
					},
					{
						title: '所在机架深度',
						key: 'rackdepth',
						width: 100,
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
						title: '硬盘',
						key: 'hd',
						width: 100
					},
					{
						title: '内存',
						key: 'ram',
						width: 100
					},
					{
						title: 'CPU',
						key: 'cpu',
						width: 100
					},
					{
						title: 'CPU数量',
						key: 'cpuno',
						width: 100
					},
					{
						title: '每CPU内核数量',
						key: 'corespercpu',
						width: 100
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
				render: (h, params) => {
					return h('div', [
						h('Button', {
							props: {
								type: 'primary',
								size: 'small',
								icon: 'md-arrow-round-down'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.user_edit(params.row)
								}
							}
						}, 'Edit'),
					]);
				},
				fixed: 'right'
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
		
		
		
		


	},
	mounted: function(){
		var _this = this;
		_this.loadingbarstart();
		_this.current_nav = '硬件';
		_this.current_subnav = '物品查询';

		// 获取状态类型
		_this.statustypesgets();



		// 显示所有记录
		_this.itemsgets(1, 1); // page: 1, last_page: 1
		_this.loadingbarfinish();
	}
});
</script>
@endsection