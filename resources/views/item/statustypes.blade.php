@extends('item.layouts.mainbase')

@section('my_title')
状态分类 - 
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
<Divider orientation="left">状态分类</Divider>

<i-row :gutter="16">
	<i-col span="24">

		<i-table height="300" size="small" border :columns="tablecolumns" :data="tabledata" @on-selection-change="selection => onselectchange(selection)"></i-table>
		<br><Page :current="page_current" :total="page_total" :page-size="page_size" @on-change="currentpage => oncurrentpagechange(currentpage)" @on-page-size-change="pagesize => onpagesizechange(pagesize)" :page-size-opts="[5, 10, 20, 50]" show-total show-elevator show-sizer></Page>

		</i-col>
	</i-row>

</Tab-pane>






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
		
		sideractivename: '1-4',
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
				title: 'ID',
				key: 'id',
				sortable: true,
				width: 110,
				// render: (h, params) => {
				// 	return h('div', {}, [
				// 		h('span',{
				// 			// style:{
				// 			// 	color: '#ff9900'
				// 			// }
				// 		}, params.row.id.substr(0, 8) + ' ...')
				// 	])
				// }
			},
			{
				title: '状态描述',
				key: 'statusdesc',
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
						}, ' '+params.row.statusdesc)
					])
				}
			},
			{
				title: '创建时间',
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

		statustypesgets (page, last_page){
			var _this = this;
			
			if (page > last_page) {
				page = last_page;
			} else if (page < 1) {
				page = 1;
			}
			

			_this.loadingbarstart();
			var url = "{{ route('item.statustypesgets') }}";
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
					_this.delete_disabled = true;
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
	
		
		// 切换当前页
		oncurrentpagechange: function (currentpage) {
			this.statustypesgets(currentpage, this.page_last);
		},








		

		


	},
	mounted: function(){
		var _this = this;
		_this.current_nav = '硬件';
		_this.current_subnav = '状态分类';

		// // 显示所有
		_this.statustypesgets(1, 1); // page: 1, last_page: 1
		// _this.loadapplicantgroup();

		// GetCurrentDatetime('getcurrentdatetime');
	}
});
</script>
@endsection