@extends('event.layouts.mainbase')

@section('my_title')
事件 - 
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

.ivu-table td.table-info-column-contacts {
	/* background-color: #90A4AE; */
	background-color: #5cadff;
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
<!-- <Divider orientation="left">事件</Divider> -->
&nbsp;<br>

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
			<Poptip confirm word-wrap title="真的要删除这些记录吗？" @on-ok="events_delete()">
				<i-button :disabled="events_delete_disabled" icon="md-remove" type="warning" size="small">删除</i-button>&nbsp;<br>&nbsp;
			</Poptip>
		</i-col>
		<i-col span="3">
			<i-button type="primary" icon="md-add" size="small" @click="events_add()">添加事件</i-button>
		</i-col>
		<i-col span="3">
			<i-button type="default" icon="md-download" size="small" @click="items_export()">导出列表</i-button>
		</i-col>
		<i-col span="15">
			&nbsp;
		</i-col>
	</i-row>

	&nbsp;

	<i-row :gutter="16">
		<i-col span="24">
			<i-table height="460" size="small" border :columns="tablecolumns" :data="tabledata" @on-selection-change="selection => onselectchange(selection)"></i-table>
			<br><Page :current="page_current" :total="page_total" :page-size="page_size" @on-change="currentpage => oncurrentpagechange(currentpage)" @on-page-size-change="pagesize => onpagesizechange(pagesize)" :page-size-opts="[5, 10, 20, 50]" show-total show-elevator show-sizer></Page>
		</i-col>
	</i-row>

</Tab-pane>


<!-- 以下为各元素编辑窗口 -->

<!-- 主编辑窗口 events-->
<Modal v-model="modal_edit_events" @on-ok="update_events" ok-text="保存" title="编辑 - 事件" width="460">
	<div style="text-align:left">

		<p>
		<i-form :label-width="80" ref="edit_event" :model="edit_event" :rules="ruleValidate">
			<i-row>
				<i-col span="12">
					<Form-Item label="姓名" prop="edit_name">
						<i-input v-model.lazy="edit_event.edit_name" size="small"></i-input>
					</Form-Item>
					<Form-Item label="部门" prop="edit_department">
						<i-input v-model.lazy="edit_event.edit_department" size="small"></i-input>
					</Form-Item>
					<Form-Item label="性别">
						<i-switch v-model.lazy="edit_event.edit_gender">
							<span slot="open">男</span>
							<span slot="close">女</span>
						</i-switch>
					</Form-Item>
				</i-col>
				<i-col span="12">
					<Form-Item label="事件ID" prop="edit_userid">
						<i-input v-model.lazy="edit_event.edit_userid" size="small"></i-input>
					</Form-Item>
					<Form-Item label="电子邮件" prop="edit_email">
						<i-input v-model="edit_event.edit_email" size="small"></i-input>
					</Form-Item>
				</i-col>
			</i-row>
		</i-form>&nbsp;
		</p>
	
	</div>	
</Modal>







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
		
		sideractivename: '10-1',
		sideropennames: ['10'],
		
		//分页
		page_current: 1,
		page_total: 0, // 记录总数，非总页数
		page_size: {{ $user['configs']['PERPAGE_RECORDS_FOR_APPLICANT'] ?? 10 }},
		page_last: 1,

		// 查询过滤器
		queryfilter_name: "{{ $config['FILTERS_USER_NAME'] }}",
		queryfilter_email: "{{ $config['FILTERS_USER_EMAIL'] }}",
		queryfilter_logintime: "{{ $config['FILTERS_USER_LOGINTIME'] }}" || [],
		queryfilter_loginip: "{{ $config['FILTERS_USER_LOGINIP'] }}",
		
		// 查询过滤器下拉
		collapse_query: '',

		// 删除按钮禁用
		events_delete_disabled: true,

		// 参数变量
		edit_type_options: [
			{label: '硬件故障', value: 1},
			{label: '软件故障', value: 2},
			{label: '资产移动', value: 3},
			{label: '物品更换', value: 4},
			{label: '其他', value: 5},
		],
		edit_part_options: [
			{label: '硬盘', value: 1},
			{label: '内存', value: 2},
			{label: 'CPU', value: 3},
			{label: '主板', value: 4},
			{label: '其他', value: 5},
		],





		// 主编辑变量
		modal_edit_events: false,
		edit_id: '',
		edit_updated_at: '',

		edit_event: {
			edit_name: '',
			edit_userid: '',
			edit_department: '',
			edit_email: '',
			edit_gender: true,
		},

		ruleValidate: {
			type: [
				{ required: true, message: ' ', trigger: 'blur' }
			],
			description: [
				{ required: true, message: ' ', trigger: 'blur' }
			],
			resolution: [
				{ required: true, message: ' ', trigger: 'blur' }
			],
			startdate: [
				{ type: 'date', message: '', trigger: 'blur' }
			],
			enddate: [
				{ type: 'date', message: '', trigger: 'blur' }
			],
		},






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
				title: '事件类型',
				key: 'type',
				resizable: true,
				width: 90,
				render: (h, params) => {
					return h('span', vm_app.edit_type_options.map((item, index) => {
						return params.row.type == item.value && h('span', {}, item.label)
					}));
				}
			},
			{
				title: '事件描述',
				key: 'description',
				resizable: true,
				width: 180,
			},
			{
				title: '处理方法',
				key: 'resolution',
				resizable: true,
				width: 180,
				render: (h, params) => {
					return h('span', {
						}, [
						h('Poptip', {
							props: {
								'word-wrap': true,
								'width': 600,
								'trigger': 'hover',
								'content': params.row.resolution,
								'transfer': true
							},
						}, params.row.resolution == null ? '' : params.row.resolution.length <=16 ? params.row.resolution : params.row.resolution.substr(0, 16) + '...')
					]);
				}
			},
			{
				title: '更换部件',
				key: 'part',
				resizable: true,
				width: 180,
				render: (h, params) => {
					return h('span', vm_app.edit_part_options.map((item, index) => {
						return params.row.part == item.value && h('span', {}, item.label)
					}));
				}
			},
			{
				title: '更换部件名称或型号',
				key: 'partname',
				resizable: true,
				width: 180,
			},
			{
				title: '开始时间',
				key: 'startdate',
				width: 160,
			},
			{
				title: '结束时间',
				key: 'enddate',
				width: 160,
			},
			{
				title: '维修人员',
				key: 'maintainer',
				width: 140,
			},
			{
				title: '是否修好',
				key: 'isok',
				width: 70,
				render: (h, params) => {
					switch (params.row.isok) {
						case 1:
							return h('span', {}, '是');break;
						case 0:
							return h('span', {}, '否');break;
					}
				}
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
			@hasanyrole('role_super_admin')
			{
				title: '操作',
				key: 'action',
				align: 'center',
				width: 130,
				fixed: 'right',
				render: (h, params) => {
					return h('div', [

						h('Poptip', {
							props: {
								'word-wrap': true,
								'trigger': 'hover',
								'confirm': false,
								'content': '编辑 '+params.row.name+' 的信息',
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
										vm_app.edit_events(params.row)
									}
								}
							}),
						]),



					]);
				},
				
			}
			@endhasanyrole
		],
		tabledata: [],
		tableselect: [],
		


		
		
		
		
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

		//
		eventsgets (page, last_page){
			var _this = this;
			
			if (page > last_page) {
				page = last_page;
			} else if (page < 1) {
				page = 1;
			}
			

			_this.loadingbarstart();
			var url = "{{ route('event.gets') }}";
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
					_this.events_delete_disabled = true;
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
		oncurrentpagechange (currentpage) {
			this.eventsgets(currentpage, this.page_last);
		},

		// 表格选择
		onselectchange (selection) {
			var _this = this;
			_this.tableselect = [];

			for (var i in selection) {
				_this.tableselect.push(selection[i].id);
			}
			
			_this.events_delete_disabled = _this.tableselect[0] == undefined ? true : false;
		},

		// 删除记录
		events_delete () {
			var _this = this;
			
			var tableselect = _this.tableselect;
			
			if (tableselect[0] == undefined) return false;

			var url = "{{ route('event.delete') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				tableselect: tableselect
			})
			.then(function (response) {
				if (response.data) {
					_this.events_delete_disabled = true;
					_this.tableselect = [];
					_this.success(false, '成功', '删除成功！');
					_this.eventsgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '删除失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '删除失败！');
			})
		},

		// 跳转至添加页面
		events_add () {
			window.location.href = "{{ route('event.add') }}";
		},


		// 主编辑前查看 - events
		edit_events (row) {
			var _this = this;

			_this.edit_id = row.id;
			_this.edit_updated_at = row.updated_at;
			_this.edit_event.edit_name = row.name;
			_this.edit_event.edit_userid = row.userid;
			_this.edit_event.edit_department = row.department;
			_this.edit_event.edit_email = row.email;
			_this.edit_event.edit_gender = row.gender == 1 ? true : false;

			_this.modal_edit_events = true;
		},

		// 主编辑保存 - events
		update_events () {
			var _this = this;

			var id = _this.edit_id;
			var updated_at = _this.edit_updated_at;
			var name = _this.edit_event.edit_name;
			var userid = _this.edit_event.edit_userid;
			var department = _this.edit_event.edit_department;
			var email = _this.edit_event.edit_email;
			var gender = _this.edit_event.edit_gender;

			if (id == undefined || name == undefined || name == '') {
				_this.warning(false, '警告', '内容不能为空！');
				return false;
			}

			var url = "{{ route('event.update') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				id: id,
				updated_at: updated_at,
				name: name,
				userid: userid,
				department: department,
				email: email,
				gender: gender,
			})
			.then(function (response) {
				// console.log(response.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
				if (response.data) {
					_this.success(false, '成功', '更新成功！');
						_this.eventsgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '更新失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '更新失败！');
			})

		},




		
		// 清除所有添加变量
		add_clear_var () {
			var _this = this;
			_this.subadd_id = '';
			_this.subadd_subid = '';
			_this.subadd_updated_at = '';
			_this.subadd_contacts_name = '';
			_this.subadd_contacts_role = '';
			_this.subadd_contacts_phonenumber = '';
			_this.subadd_contacts_email = '';
			_this.subadd_contacts_comments = '';
			_this.subadd_urls_url = '';
			_this.subadd_urls_description = '';
		},



	},
	mounted: function(){
		var _this = this;
		_this.current_nav = '事件';
		_this.current_subnav = '查询';

		// // 显示所有
		_this.eventsgets(1, 1); // page: 1, last_page: 1
		// _this.loadapplicantgroup();

		// GetCurrentDatetime('getcurrentdatetime');
	}
});
</script>
@endsection