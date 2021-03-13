@extends('item.layouts.mainbase')

@section('my_title')
状态类型 - 
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
<Divider orientation="left">状态类型</Divider>



<!-- <my-passwordchange></my-passwordchange>

<my-camera></my-camera> -->

@endsection

@section('my_footer')
@parent

@endsection

@section('my_js_others')
@parent
<script>
var vm_app = new Vue({
	el: '#app',
	// components: {
	// 	'my-passwordchange': httpVueLoader("{{ asset('components/my-passwordchange.vue') }}"),
	// 	'my-camera': httpVueLoader("{{ asset('components/my-camera.vue') }}")
	// },
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
		page_size: {{ $user['configs']['PERPAGE_RECORDS_FOR_APPLICANT'] ?? 5 }},
		page_last: 1,

		// 创建
		jiaban_add_reason: '',
		jiaban_add_remark: '',

		jiaban_add_applicantgroup: '',
		jiaban_add_datetimerange1: [],
		jiaban_add_category1: '',
		jiaban_add_duration1: '',
		jiaban_add_create_disabled1: false,
		jiaban_add_clear_disabled1: false,
		
		// 批量录入applicant表
		piliangluru_applicant: [
			{
				uid: '',
				applicant: '',
				department: '',
				datetimerange: [],
				category: '',
				duration: ''
			},
		],

		// 批量录入项
		piliangluruxiang_applicant2: 1,
		jiaban_add_create_disabled2: false,
		jiaban_add_clear_disabled2: false,

		//加班类别
		option_category: [
			{value: '平时加班', label: '平时加班'},
			{value: '双休加班', label: '双休加班'},
			{value: '节假日加班', label: '节假日加班'}
		],

		// 选择角色查看编辑相应权限
		applicant_select: '',
		applicant_options: [],
		applicant_loading: false,

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
				title: 'UUID',
				key: 'uuid',
				sortable: true,
				width: 110,
				render: (h, params) => {
					return h('div', {}, [
						h('span',{
							// style:{
							// 	color: '#ff9900'
							// }
						}, params.row.uuid.substr(0, 8) + ' ...')
					])
				}
			},
			// {
			// 	title: 'agent',
			// 	key: 'agent',
			// 	width: 160
			// },
			// {
			// 	title: 'department_of_agent',
			// 	key: 'department_of_agent',
			// 	width: 160
			// },
			{
				title: '当前审核人',
				key: 'auditor',
				width: 160,
				render: (h, params) => {
					return h('div', {}, [
						h('Icon',{
							props: {
								type: 'ios-person',
								// size: 14,
								}
							}
						),
						h('span',{
							// style:{
							// 	color: '#ff9900'
							// }
						}, ' '+params.row.auditor)
					])
				}
			},
			{
				title: '当前审核人部门',
				key: 'department_of_auditor',
				width: 160,
				render: (h, params) => {
					return h('div', {}, [
						h('Icon',{
							props: {
								type: 'ios-people',
								// size: 14,
								}
							}
						),
						h('span',{
							// style:{
							// 	color: '#ff9900'
							// }
						}, ' '+params.row.department_of_auditor)
					])
				}
			},
			{
				title: '进度',
				key: 'progress',
				width: 140,
				render: (h, params) => {
					// return h('div', {}, params.row.progress + '%')
					if (params.row.progress == 0) {
						return h('div', {}, [
							h('Progress',{
								props: {
									percent: 99,
									status: 'wrong',
									}
								}
							)
						])
					} else {
						return h('div', {}, [
							h('Progress',{
								props: {
									percent: params.row.progress,
									status: 'active',
									}
								}
							)
						])
					}
				}
			},
			{
				title: '状态',
				key: 'status',
				width: 90,
				render: (h, params) => {
					if (params.row.archived == 1) {
						return h('div', {}, [
							h('Icon',{
								props: {
									type: 'ios-archive-outline',
									// size: 14,
									}
								}
							),
							h('span',' 已归档')
						])
					} else if (params.row.status == 99) {
						return h('div', {}, [
							h('Icon',{
								props: {
									type: 'ios-checkmark-circle-outline',
									// size: 14,
									}
								}
							),
							h('span',{
								style:{
									color: '#19be6b'
								}
							},' 已结案')
						])
					} else if (params.row.status == 0) {
						return h('div', {}, [
							h('Icon',{
								props: {
									type: 'ios-close-circle-outline',
									// size: 14,
									}
								}
							),
							h('span',{
								style:{
									color: '#ed4014'
								}
							},' 已否决')
						])
					} else {
						return h('div', {}, [
							h('Icon',{
								props: {
									type: 'ios-cafe-outline',
									// size: 14,
									}
								}
							),
							h('span',{
								style:{
									color: '#ff9900'
								}
							},' 待处理')
						])
					}
				},
			},
			{
				title: '提交时间',
				key: 'created_at',
				sortable: true,
				width: 160
			},
			{
				title: '操作',
				key: 'action',
				align: 'center',
				@hasanyrole('role_super_admin')
					width: 250,
				@else
					width: 130,
				@endhasanyrole
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
									vm_app.jiaban_edit(params.row)
								}
							}
						}, '查看'),
						h('Button', {
							props: {
								type: 'default',
								size: 'small'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.jiaban_archived(params.row)
								}
							}
						}, '归档'),
						@hasanyrole('role_super_admin')
						h('Button', {
							props: {
								type: 'warning',
								size: 'small'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.onrestore_applicant(params.row)
								}
							}
						}, '恢复'),
						h('Button', {
							props: {
								type: 'error',
								size: 'small'
							},
							style: {
								marginRight: '5px'
							},
							on: {
								click: () => {
									vm_app.ondelete_applicant(params.row)
								}
							}
						}, '彻底删除'),
						@endhasanyrole

					]);
					
				},
				fixed: 'right'
			}
		],
		tabledata: [],
		tableselect: [],
		
		// 编辑
		modal_jiaban_edit: false,
		modal_jiaban_pass_loading: false,
		modal_jiaban_deny_loading: false,
		modal_jiaban_archived_loading: false,
		jiaban_edit_id: '',
		jiaban_edit_uuid: '',
		jiaban_edit_id_of_agent: '',
		jiaban_edit_agent: '',
		jiaban_edit_department_of_agent: '',
		jiaban_edit_application: '',
		jiaban_edit_status: 0,
		jiaban_edit_reason: '',
		jiaban_edit_remark: '',
		jiaban_edit_camera_imgurl: '',
		jiaban_edit_auditing: '',
		jiaban_edit_auditing_circulation: '',
		jiaban_edit_auditing_index: 0,
		jiaban_edit_auditing_id: '',
		jiaban_edit_auditing_uid: '',
		jiaban_edit_created_at: '',
		jiaban_edit_updated_at: '',

		// 归档窗口
		modal_archived: false,

		// 查看人员组
		applicantgroup_select: '',
		applicantgroup_options: [],
		applicantgroup_input: '',

		// 公司组织架构
		treedata: [
			{
				title: '公司',
				loading: false,
				children: []
			}
		],

		// 人员组名称，用于查看成员
		applicantgroup_title: '',


		// 删除
		delete_disabled: true,

		// tabs索引
		currenttabs: 0,
		currenttabssub: 0,
		
		// 查询过滤器
		queryfilter_auditor: '',
		queryfilter_created_at: '',
		queryfilter_trashed: false,
		
		// 查询过滤器下拉
		collapse_query: '',		
		
		
		
		
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

		
	
		









		

		


	},
	mounted: function(){
		// var _this = this;
		// _this.current_nav = '加班管理';
		// _this.current_subnav = '申请';
		// // 显示所有
		// _this.jiabangetsapplicant(1, 1); // page: 1, last_page: 1
		// _this.loadapplicantgroup();

		// GetCurrentDatetime('getcurrentdatetime');
	}
});
</script>
@endsection