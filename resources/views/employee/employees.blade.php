@extends('employee.layouts.mainbase')

@section('my_title')
用户 - 
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
<!-- <Divider orientation="left">用户</Divider> -->
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
			<Poptip confirm word-wrap title="真的要删除这些记录吗？" @on-ok="employees_delete()">
				<i-button :disabled="employees_delete_disabled" icon="md-remove" type="warning" size="small">删除</i-button>&nbsp;<br>&nbsp;
			</Poptip>
		</i-col>
		<i-col span="3">
			<i-button type="primary" icon="md-add" size="small" @click="employees_add()">添加用户</i-button>
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

<!-- 主编辑窗口 employees-->
<Modal v-model="modal_edit_employees" @on-ok="update_employees" ok-text="保存" title="编辑 - 代理商" width="640">
	<div style="text-align:left">

		<p>
		<i-form :label-width="90">
			<i-row>
				<i-col span="24">
					<Form-Item label="名称" required style="margin-bottom:0px">
						<i-input v-model.lazy="edit_title" size="small"></i-input>
					</Form-Item>
					<Form-Item label="类型" required style="margin-bottom:0px">
						<Poptip word-wrap trigger="hover" placement="top" width="300" content="售卖方及购买方将出现在发票及合同模块中；售卖方及购买方将出现在发票及合同模块中；硬件销售商将出现的物品模块中；软件销售商将出现在合同模块中；承包商将出现的合同模块中。">
							<i-select v-model.lazy="edit_type_select" size="small" multiple clearable placeholder="">
								<i-option v-for="item in edit_type_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
							</i-select>
						</Poptip>
					</Form-Item>
					<Form-Item label="备注" style="margin-bottom:0px">
						<i-input v-model.lazy="edit_contactinfo" size="small" type="textarea"></i-input>
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
		
		sideractivename: '9-1',
		sideropennames: ['9'],
		
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
		employees_delete_disabled: true,

		// 主编辑变量
		modal_edit_employees: false,
		edit_id: '',
		edit_updated_at: '',
		edit_title: '',
		edit_type_select: [],
		edit_type_options: [
			{label: '售卖方 - Vendoer', value: 1},
			{label: '软件销售商 - S/W Manufacturer', value: 2},
			{label: '硬件销售商 - H/W Manufacturer', value: 3},
			{label: '购买方 - Buyer', value: 4},
			{label: '承包商 - Contractor', value: 5},
		],
		edit_contactinfo: '',


		// 子编辑 变量
		modal_subedit_contacts: false,
		modal_subedit_urls: false,
		subedit_id: '',
		subedit_subid: '',
		subedit_updated_at: '',

		subedit_contacts_name: '',
		subedit_contacts_role: '',
		subedit_contacts_phonenumber: '',
		subedit_contacts_email: '',
		subedit_contacts_comments: '',

		subedit_urls_url: '',
		subedit_urls_description: '',
		

		// 子添加 变量
		modal_subadd_contacts: false,
		modal_subadd_urls: false,
		subadd_id: '',
		subadd_subid: '',
		subadd_updated_at: '',

		subadd_contacts_name: '',
		subadd_contacts_role: '',
		subadd_contacts_phonenumber: '',
		subadd_contacts_email: '',
		subadd_contacts_comments: '',

		subadd_urls_url: '',
		subadd_urls_description: '',



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
				title: '姓名',
				key: 'name',
				resizable: true,
				width: 140,
			},
			{
				title: '用户ID',
				key: 'userid',
				resizable: true,
				width: 180,
			},
			{
				title: '部门',
				key: 'department',
				resizable: true,
				width: 180,
			},
			{
				title: '电子邮件',
				key: 'email',
				resizable: true,
				width: 180,
			},
			{
				title: '性别',
				key: 'gender',
				width: 70,
				render: (h, params) => {
					switch (params.row.gender) {
						case 1:
							return h('span', {}, '男');break;
						case 0:
							return h('span', {}, '女');break;
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
										vm_app.edit_employees(params.row)
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
		employeesgets (page, last_page){
			var _this = this;
			
			if (page > last_page) {
				page = last_page;
			} else if (page < 1) {
				page = 1;
			}
			

			_this.loadingbarstart();
			var url = "{{ route('employee.gets') }}";
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
					_this.employees_delete_disabled = true;
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
			this.employeesgets(currentpage, this.page_last);
		},

		// 表格选择
		onselectchange (selection) {
			var _this = this;
			_this.tableselect = [];

			for (var i in selection) {
				_this.tableselect.push(selection[i].id);
			}
			
			_this.employees_delete_disabled = _this.tableselect[0] == undefined ? true : false;
		},

		// 删除记录
		employees_delete () {
			var _this = this;
			
			var tableselect = _this.tableselect;
			
			if (tableselect[0] == undefined) return false;

			var url = "{{ route('employee.delete') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				tableselect: tableselect
			})
			.then(function (response) {
				if (response.data) {
					_this.employees_delete_disabled = true;
					_this.tableselect = [];
					_this.success(false, '成功', '删除成功！');
					_this.employeesgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '删除失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '删除失败！');
			})
		},

		// 跳转至添加页面
		employees_add () {
			window.location.href = "{{ route('employee.add') }}";
		},


		// 主编辑前查看 - employees
		edit_employees (row) {
			var _this = this;

			_this.edit_id = row.id;
			_this.edit_updated_at = row.updated_at;
			_this.edit_title = row.title;
			_this.edit_type_select = row.type;
			_this.edit_contactinfo = row.contactinfo;

			_this.modal_edit_employees = true;
		},

		// 主编辑保存 - employees
		update_employees () {
			var _this = this;

			var id = _this.edit_id;
			var updated_at = _this.edit_updated_at;
			var title = _this.edit_title;
			var type = _this.edit_type_select;
			var contactinfo = _this.edit_contactinfo;

			if (id == undefined || title == undefined || title == '' || type == undefined || type == '') {
				_this.warning(false, '警告', '内容不能为空！');
				return false;
			}

			var url = "{{ route('employee.update') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				id: id,
				updated_at: updated_at,
				title: title,
				type: type,
				contactinfo: contactinfo,
			})
			.then(function (response) {
				// console.log(response.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
				if (response.data) {
					_this.success(false, '成功', '更新成功！');
						_this.employeesgets(_this.page_current, _this.page_last);
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
		_this.current_nav = '用户';
		_this.current_subnav = '查询';

		// // 显示所有
		_this.employeesgets(1, 1); // page: 1, last_page: 1
		// _this.loadapplicantgroup();

		// GetCurrentDatetime('getcurrentdatetime');
	}
});
</script>
@endsection