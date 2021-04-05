@extends('agent.layouts.mainbase')

@section('my_title')
代理商 - 
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
<!-- <Divider orientation="left">代理商</Divider> -->
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
			<i-button @click="items_delete()" :disabled="agents_delete_disabled" type="warning" size="small"><Icon type="md-trash"></Icon> 删除</i-button>&nbsp;<br>&nbsp;
		</i-col>
		<i-col span="3">
			<i-button type="primary" size="small" @click="agents_add()"><Icon type="md-add"></Icon> 添加代理商</i-button>
		</i-col>
		<i-col span="3">
			<i-button type="default" size="small" @click="items_export()"><Icon type="md-download"></Icon> 导出列表</i-button>
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
		
		sideractivename: '5-1',
		sideropennames: ['5'],
		
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
		agents_delete_disabled: true,


		//新增
		// itemtypes_add_typedesc: '',
		// itemtypes_add_hassoftware: false,


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
				title: '名称',
				key: 'title',
				resizable: true,
				width: 160,
			},
			{
				title: '类型',
				key: 'type',
				resizable: true,
				width: 180,
			},
			{
				title: '联系信息',
				key: 'contactinfo',
				resizable: true,
				width: 180,
			},
			// {
			// 	title: '联系方式',
			// 	key: 'contacts',
			// 	resizable: true,
			// 	width: 180,
			// },
			{
				title: '联系方式',
				align: 'center',
				children: [
					// {
					// 	title: '序号',
					// 	key: 'contacts',
					// 	align:'center',
					// 	width: 70,
					// 	className: 'table-info-column-contacts',
					// 	render: (h, params) => {
					// 		if (params.row.contacts!=undefined && params.row.contacts!=null) {
					// 			return h('div', {
					// 				attrs: {
					// 					class:'subCol'
					// 				},
					// 			}, [
					// 				h('ul', params.row.contacts.map((item, index) => {
					// 					return h('li', {
					// 					// }, item.id)
					// 					}, ++index)
					// 				}))
					// 			]);
					// 		}
					// 	}
					// },
					{
						title: '联系人',
						key: 'contacts',
						align:'center',
						width: 90,
						className: 'table-info-column-contacts',
						render: (h, params) => {
							if (params.row.contacts!=undefined && params.row.contacts!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.contacts.map(item => {
										return h('li', {
										}, item.name == null || item.name == '' ? '-' : item.name)
									}))
								]);
							}
						}
					},
					{
						title: '角色',
						key: 'contacts',
						align:'center',
						width: 90,
						className: 'table-info-column-contacts',
						render: (h, params) => {
							if (params.row.contacts!=undefined && params.row.contacts!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.contacts.map(item => {
										return h('li', {
										}, item.role == null || item.role == '' ? '-' : item.role)
									}))
								]);
							}
						}
					},
					{
						title: '电话号码',
						key: 'contacts',
						align:'center',
						width: 90,
						className: 'table-info-column-contacts',
						render: (h, params) => {
							if (params.row.contacts!=undefined && params.row.contacts!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.contacts.map(item => {
										return h('li', {
										}, item.phonenumber == null || item.phonenumber == '' ? '-' : item.phonenumber)
									}))
								]);
							}
						}
					},
					{
						title: '电子邮件',
						key: 'contacts',
						align:'center',
						width: 170,
						className: 'table-info-column-contacts',
						render: (h, params) => {
							if (params.row.contacts!=undefined && params.row.contacts!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.contacts.map(item => {
										return h('li', {
										}, item.email == null || item.email == '' ? '-' : item.email)
									}))
								]);
							}
						}
					},
					{
						title: '备注',
						key: 'contacts',
						align:'center',
						width: 170,
						className: 'table-info-column-contacts',
						render: (h, params) => {
							if (params.row.contacts!=undefined && params.row.contacts!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.contacts.map(item => {
										return h('li', {
										}, item.comments == null || item.comments == '' ? '-' : item.comments)
									}))
								]);
							}
						}
					},
					{
						title: '操作',
						key: 'action',
						align: 'center',
						width: 100,
						className: 'table-info-column-contacts',
						render: (h, params) => {
								return h('div', [
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
												vm_app.itemtypes_delete(params.row)
											}
										}
									}),
									h('Button', {
										props: {
											type: 'error',
											size: 'small',
											icon: 'md-trash'
										},
										style: {
											marginRight: '5px'
										},
										on: {
											click: () => {
												vm_app.itemtypes_delete(params.row)
											}
										}
									}),
									

								]);
						},
					}
				]
			},
			// {
			// 	title: 'URLs',
			// 	key: 'urls',
			// 	resizable: true,
			// 	width: 180,
			// },
			{
				title: '官方网站',
				align: 'center',
				children: [
					// {
					// 	title: '序号',
					// 	key: 'urls',
					// 	align:'center',
					// 	width: 70,
					// 	className: 'table-info-column-urls',
					// 	render: (h, params) => {
					// 		if (params.row.urls!=undefined && params.row.urls!=null) {
					// 			return h('div', {
					// 				attrs: {
					// 					class:'subCol'
					// 				},
					// 			}, [
					// 				h('ul', params.row.urls.map((item, index) => {
					// 					return h('li', {
					// 					// }, item.id)
					// 					}, ++index)
					// 				}))
					// 			]);
					// 		}
					// 	}
					// },
					{
						title: '说明',
						key: 'urls',
						align:'center',
						width: 90,
						className: 'table-info-column-urls',
						render: (h, params) => {
							if (params.row.urls!=undefined && params.row.urls!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.urls.map(item => {
										return h('li', {
										}, item.description == null || item.description == '' ? '-' : item.description)
									}))
								]);
							}
						}
					},
					{
						title: 'URL',
						key: 'urls',
						align:'center',
						width: 170,
						className: 'table-info-column-urls',
						render: (h, params) => {
							if (params.row.urls!=undefined && params.row.urls!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.urls.map(item => {
										return h('li', {
										}, item.url == null || item.url == '' ? '-' : item.url)
									}))
								]);
							}
						}
					},
					{
						title: '操作',
						key: 'action',
						align: 'center',
						width: 100,
						className: 'table-info-column-urls',
						render: (h, params) => {
								return h('div', [
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
												vm_app.itemtypes_delete(params.row)
											}
										}
									}),
									h('Button', {
										props: {
											type: 'error',
											size: 'small',
											icon: 'md-trash'
										},
										style: {
											marginRight: '5px'
										},
										on: {
											click: () => {
												vm_app.itemtypes_delete(params.row)
											}
										}
									}),
									

								]);
						},
					}
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
			@hasanyrole('role_super_admin')
			{
				title: '操作',
				key: 'action',
				align: 'center',
				width: 100,
				fixed: 'right',
				render: (h, params) => {
					// if (params.row.id > 3) {
						return h('div', [
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
										vm_app.itemtypes_delete(params.row)
									}
								}
							}, '编辑'),
							

						]);
					// }
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
		agentsgets (page, last_page){
			var _this = this;
			
			if (page > last_page) {
				page = last_page;
			} else if (page < 1) {
				page = 1;
			}
			

			_this.loadingbarstart();
			var url = "{{ route('agent.gets') }}";
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
					_this.agents_delete_disabled = true;
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
			this.agentsgets(currentpage, this.page_last);
		},

		// 表格选择
		onselectchange (selection) {
			var _this = this;
			_this.tableselect = [];

			for (var i in selection) {
				_this.tableselect.push(selection[i].id);
			}
			
			_this.agents_delete_disabled = _this.tableselect[0] == undefined ? true : false;
		},

		// 跳转至添加页面
		agents_add () {
			window.location.href = "{{ route('agent.add') }}";
		},












		// 更新 typedesc
		itemtypes_update_typedesc (id, typedesc) {
			var _this = this;
			
			var id = id;
			var typedesc = typedesc;
			// _this.itemtypes_edit_id = id;
			// _this.itemtypes_edit_statusdesc = row.itemtypes_edit_statusdesc;
			// _this.jiaban_edit_created_at = row.created_at;
			// _this.jiaban_edit_updated_at = row.updated_at;

			var url = "{{ route('item.itemtypesupdate_typedesc') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url,{
				id: id,
				typedesc: typedesc
			})
			.then(function (response) {
                // alert(index);
				// console.log(response.data);
				// return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
				if (response.data) {
					_this.itemtypesgets(_this.page_current, _this.page_last);
                    // _this.$Message.success('保存成功！');
					_this.success(false, '成功', '保存成功！');
                } else {
					// _this.$Message.warning('保存失败！');
					_this.warning(false, '失败', '保存失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, 'Error', error);
			})

			setTimeout(() => {
				_this.modal_jiaban_edit = true;
			}, 500);

			
		},


		// 删除
		itemtypes_delete (row) {
			var _this = this;
			var id = row.id;
			if (id == undefined) return false;
			var url = "{{ route('item.itemtypesdelete') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				id: id
			})
			.then(function (response) {
				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
				if (response.data) {
					_this.itemtypesgets(_this.page_current, _this.page_last);
					_this.success(false, '成功', '删除成功！');
				} else {
					_this.error(false, '失败', '删除失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '删除失败！');
			})
		},


		//新增
		itemtypes_create () {
			var _this = this;

			var typedesc = _this.itemtypes_add_typedesc;
			var hassoftware = _this.itemtypes_add_hassoftware;

			if (typedesc == '' || typedesc == undefined) {
					// console.log(hassoftware);
				// _this.error(false, '失败', '用户ID为空或不正确！');
				return false;
			}

			var url = "{{ route('item.itemtypescreate') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				typedesc: typedesc,
				hassoftware: hassoftware,
			})
			.then(function (response) {
				// console.log(response.data);
				// return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
 				if (response.data) {
					_this.itemtypes_add_typedesc = '';
					_this.itemtypesgets(_this.page_current, _this.page_last);
					_this.success(false, '成功', '新建成功！');
				} else {
					_this.error(false, '失败', '新建失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '新建失败！');
			})


		},

		
		// 更新 hassoftware
		itemtypes_update_hassoftware (id, hassoftware) {
			var _this = this;
			
			var id = id;
			var hassoftware = hassoftware;
// console.log(hassoftware);return false;

			var url = "{{ route('item.itemtypesupdate_hassoftware') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url,{
				id: id,
				hassoftware: hassoftware
			})
			.then(function (response) {
                // alert(index);
				// console.log(response.data);
				// return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
				if (response.data) {
					_this.itemtypesgets(_this.page_current, _this.page_last);
                    // _this.$Message.success('保存成功！');
					_this.success(false, '成功', '保存成功！');
                } else {
					// _this.$Message.warning('保存失败！');
					_this.warning(false, '失败', '保存失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, 'Error', error);
			})

			setTimeout(() => {
				_this.modal_jiaban_edit = true;
			}, 500);

			
		},
		


	},
	mounted: function(){
		var _this = this;
		_this.current_nav = '代理商';
		_this.current_subnav = '查询';

		// // 显示所有
		_this.agentsgets(1, 1); // page: 1, last_page: 1
		// _this.loadapplicantgroup();

		// GetCurrentDatetime('getcurrentdatetime');
	}
});
</script>
@endsection