@extends('item.layouts.mainbase')

@section('my_title')
物品查询 - 
@parent
@endsection

@section('my_style')
<!-- <link rel="stylesheet" href="{{ asset('css/camera.css') }}"> -->
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
			// {
			// 	title: 'id',
			// 	key: 'id',
			// 	sortable: true,
			// 	width: 80
			// },
			{
				title: 'uid',
				key: 'uid',
				sortable: true,
				width: 100
			},
			{
				title: 'name',
				key: 'name',
				width: 100
			},
			{
				title: 'department',
				key: 'department',
				width: 130
			},
			// {
			// 	title: 'ldapname',
			// 	key: 'ldapname',
			// 	width: 130
			// },
			// {
			// 	title: 'email',
			// 	key: 'email',
			// 	width: 240
			// },
			// {
			// 	title: 'displayname',
			// 	key: 'displayname',
			// 	width: 180
			// },
			{
				title: 'login IP',
				key: 'login_ip',
				width: 130
			},
			{
				title: 'counts',
				key: 'login_counts',
				align: 'center',
				sortable: true,
				width: 100
			},
			{
				title: 'login time',
				key: 'login_time',
				width: 160
			},
			{
				title: 'status',
				key: 'deleted_at',
				align: 'center',
				width: 80,
				render: (h, params) => {
					return h('div', [
						// params.row.deleted_at.toLocaleString()
						// params.row.deleted_at ? '禁用' : '启用'
						
						h('i-switch', {
							props: {
								type: 'primary',
								size: 'small',
								value: ! params.row.deleted_at
							},
							style: {
								marginRight: '5px'
							},
							on: {
								'on-change': (value) => {//触发事件是on-change,用双引号括起来，
									//参数value是回调值，并没有使用到
									vm_app.trash_user(params.row.id) //params.index是拿到table的行序列，可以取到对应的表格值
								}
							}
						}, 'Edit')
						
					]);
				}
			},
			{
				title: 'created_at',
				key: 'created_at',
				width: 160
			},
			{
				title: 'Action',
				key: 'action',
				align: 'center',
				width: 140,
				render: (h, params) => {
					return h('div', [
						h('Button', {
							props: {
								type: 'primary',
								size: 'small'
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
						h('Button', {
							props: {
								type: 'primary',
								size: 'small'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.user_clsttl(params.row)
								}
							}
						}, 'ClsTTL')
					]);
				},
				fixed: 'right'
			}
		],
		tabledata: [],
		tableselect: [],









		tablecolumns_auditing1: [
			{
				type: 'index',
				align: 'center',
				width: 60,
			},
			{
				title: 'uid',
				key: 'uid',
				width: 100
			},
			{
				title: 'name',
				key: 'name',
				width: 100
			},
			{
				title: 'department',
				key: 'department',
				width: 130
			},
			{
				title: 'status',
				key: 'deleted_at',
				align: 'center',
				width: 80,
				render: (h, params) => {
					return h('div', [
						// params.row.deleted_at.toLocaleString()
						// params.row.deleted_at ? '禁用' : '启用'
						
						h('i-switch', {
							props: {
								type: 'primary',
								size: 'small',
								value: ! params.row.deleted_at
							},
							style: {
								marginRight: '5px'
							},
							on: {
								'on-change': (value) => {//触发事件是on-change,用双引号括起来，
									//参数value是回调值，并没有使用到
									vm_app.trash_user(params.row.id) //params.index是拿到table的行序列，可以取到对应的表格值
								}
							}
						}, 'Edit')
						
					]);
				}
			},
			{
				title: 'Action',
				key: 'action',
				align: 'center',
				width: 140,
				render: (h, params) => {
					return h('div', [
						h('Button', {
							props: {
								type: 'default',
								size: 'small',
								icon: 'md-arrow-round-down'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.auditing_down1(params)
								}
							}
						}),
						h('Button', {
							props: {
								type: 'default',
								size: 'small',
								icon: 'md-arrow-round-up'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.auditing_up1(params)
								}
							}
						}),
						h('Button', {
							props: {
								type: 'default',
								size: 'small',
								icon: 'md-close'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.auditing_remove1(params.row)
								}
							}
						}),
					]);
				},
				// fixed: 'right'
			}
		],
		tabledata_auditing1: [],
		tableselect_auditing1: [],


		tablecolumns_auditing2_applicant: [
			{
				type: 'index',
				align: 'center',
				width: 60,
			},
			{
				title: 'uid',
				key: 'uid',
				width: 100
			},
			{
				title: 'name',
				key: 'name',
				width: 100
			},
			{
				title: 'department',
				key: 'department',
				width: 130
			},
			{
				title: 'status',
				key: 'deleted_at',
				align: 'center',
				width: 80,
				render: (h, params) => {
					return h('div', [
						// params.row.deleted_at.toLocaleString()
						// params.row.deleted_at ? '禁用' : '启用'
						
						h('i-switch', {
							props: {
								type: 'primary',
								size: 'small',
								value: ! params.row.deleted_at
							},
							style: {
								marginRight: '5px'
							},
							on: {
								'on-change': (value) => {//触发事件是on-change,用双引号括起来，
									//参数value是回调值，并没有使用到
									vm_app.trash_user(params.row.id) //params.index是拿到table的行序列，可以取到对应的表格值
								}
							}
						}, 'Edit')
						
					]);
				}
			},
			{
				title: 'Action',
				key: 'action',
				align: 'center',
				width: 140,
				render: (h, params) => {
					return h('div', [
						h('Button', {
							props: {
								type: 'default',
								size: 'small',
								icon: 'md-arrow-round-down'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.auditing_down2(params)
								}
							}
						}),
						h('Button', {
							props: {
								type: 'default',
								size: 'small',
								icon: 'md-arrow-round-up'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.auditing_up2(params)
								}
							}
						}),
						h('Button', {
							props: {
								type: 'default',
								size: 'small',
								icon: 'md-close'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.auditing_remove2(params.row)
								}
							}
						}),
					]);
				},
				// fixed: 'right'
			}
		],
		tabledata_auditing2_applicant: [],
		tableselect_auditing2_applicant: [],

		tablecolumns_auditing2_confirm: [
			{
				type: 'index',
				align: 'center',
				width: 60,
			},
			{
				title: 'uid',
				key: 'uid',
				width: 100
			},
			{
				title: 'name',
				key: 'name',
				width: 100
			},
			{
				title: 'department',
				key: 'department',
				width: 130
			},
			{
				title: 'status',
				key: 'deleted_at',
				align: 'center',
				width: 80,
				render: (h, params) => {
					return h('div', [
						// params.row.deleted_at.toLocaleString()
						// params.row.deleted_at ? '禁用' : '启用'
						
						h('i-switch', {
							props: {
								type: 'primary',
								size: 'small',
								value: ! params.row.deleted_at
							},
							style: {
								marginRight: '5px'
							},
							on: {
								'on-change': (value) => {//触发事件是on-change,用双引号括起来，
									//参数value是回调值，并没有使用到
									vm_app.trash_user(params.row.id) //params.index是拿到table的行序列，可以取到对应的表格值
								}
							}
						}, 'Edit')
						
					]);
				}
			},
			{
				title: 'Action',
				key: 'action',
				align: 'center',
				width: 140,
				render: (h, params) => {
					return h('div', [
						h('Button', {
							props: {
								type: 'default',
								size: 'small',
								icon: 'md-arrow-round-down'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.auditing_down2_confirm(params)
								}
							}
						}),
						h('Button', {
							props: {
								type: 'default',
								size: 'small',
								icon: 'md-arrow-round-up'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.auditing_up2_confirm(params)
								}
							}
						}),
						h('Button', {
							props: {
								type: 'default',
								size: 'small',
								icon: 'md-close'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.auditing_remove2_confirm(params.row)
								}
							}
						}),
					]);
				},
				// fixed: 'right'
			}
		],
		tabledata_auditing2_confirm: [],
		tableselect_auditing2_confirm: [],
		
		//分页
		page_current: 1,
		page_total: 1, // 记录总数，非总页数
		page_size: {{ $config['PERPAGE_RECORDS_FOR_USER'] }},
		page_last: 1,		
		
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
		menuselect: function (name) {
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

		alert_logout: function () {
			this.error(false, '会话超时', '会话超时，请重新登录！');
			window.setTimeout(function(){
				window.location.href = "{{ route('portal') }}";
			}, 2000);
			return false;
		},
		
		// 把laravel返回的结果转换成select能接受的格式
		json2selectvalue: function (json) {
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
		oncurrentpagechange: function (currentpage) {
			this.usergets(currentpage, this.page_last);
		},

		
		
		
		
		
		


	},
	mounted: function(){
		var _this = this;
		_this.loadingbarstart();
		_this.current_nav = '硬件';
		_this.current_subnav = '物品查询';
		// 显示所有记录
		// _this.usergets(1, 1); // page: 1, last_page: 1
		_this.loadingbarfinish();
	}
});
</script>
@endsection