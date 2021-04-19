@extends('contract.layouts.mainbase')

@section('my_title')
合同 - 
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

.ivu-table td.table-info-column-renewals {
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
<!-- <Divider orientation="left">合同</Divider> -->
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
			<Poptip confirm word-wrap title="真的要删除这些记录吗？" @on-ok="contracts_delete()">
				<i-button :disabled="contracts_delete_disabled" icon="md-remove" type="warning" size="small">删除</i-button>&nbsp;<br>&nbsp;
			</Poptip>
		</i-col>
		<i-col span="3">
			<i-button type="primary" icon="md-add" size="small" @click="contracts_add()">添加合同</i-button>
		</i-col>
		<i-col span="3">
			<i-button type="default" icon="ios-download-outline" size="small" @click="items_export()">导出</i-button>
		</i-col>
		<i-col span="15">
			&nbsp;
		</i-col>
	</i-row>

	&nbsp;

	<i-row>
		<i-col span="24">
			<i-table height="460" size="small" border :columns="tablecolumns" :data="tabledata" @on-selection-change="selection => onselectchange(selection)"></i-table>
			<br><Page :current="page_current" :total="page_total" :page-size="page_size" @on-change="currentpage => oncurrentpagechange(currentpage)" @on-page-size-change="pagesize => onpagesizechange(pagesize)" :page-size-opts="[5, 10, 20, 50]" show-total show-elevator show-sizer></Page>
		</i-col>
	</i-row>

</Tab-pane>


<!-- 以下为各元素编辑窗口 -->

<!-- 主编辑窗口 contracts-->
<Modal v-model="modal_edit_contracts" @on-ok="update_contracts" ok-text="保存" title="编辑 - 合同" width="460">
	<div style="text-align:left">

		<p>
		<i-form :label-width="100">
			<i-row>
				<i-col span="24">
					<Form-Item label="名称" required style="margin-bottom:0px">
						<i-input v-model.lazy="edit_title" size="small"></i-input>
					</Form-Item>
					<Form-Item label="类型" required style="margin-bottom:0px">
						<i-select v-model.lazy="edit_type_select" size="small" clearable placeholder="">
							<i-option v-for="item in edit_type_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="合同编号" style="margin-bottom:0px">
						<i-input v-model.lazy="edit_number" size="small"></i-input>
					</Form-Item>
					<Form-Item label="备注" style="margin-bottom:0px">
						<i-input v-model.lazy="edit_comments" size="small"></i-input>
					</Form-Item>
					<Form-Item label="总价值" style="margin-bottom:0px">
						<Input-Number v-model.lazy="edit_totalcost" size="small" :min="1" style="width:50%"></Input-Number>
					</Form-Item>
					<Form-Item label="币种" style="margin-bottom:0px">
						<i-select v-model.lazy="edit_currency_select" size="small" placeholder="">
							<i-option v-for="item in edit_currency_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="开始日期" style="margin-bottom:0px">
						<Date-picker v-model.lazy="edit_startdate" type="datetime" size="small"></Date-picker>
					</Form-Item>
					<Form-Item label="结束日期" style="margin-bottom:0px">
						<Date-picker v-model.lazy="edit_currentenddate" type="datetime" size="small"></Date-picker>
					</Form-Item>
					<Form-Item label="详细内容" style="margin-bottom:0px">
						<i-input v-model.lazy="edit_description" size="small" type="textarea" :rows="5"></i-input>
					</Form-Item>
				</i-col>
			</i-row>
		</i-form>&nbsp;
		</p>
	
	</div>	
</Modal>

<!-- 子编辑窗口 renewals-->
<Modal v-model="modal_subedit_renewals" @on-ok="subupdate_renewals" ok-text="保存" title="编辑 - 续约合同" width="640">
	<div style="text-align:left">

		<p>
		<i-form :label-width="100">
			<i-row>
				<i-col span="12">
					<Form-Item label="续约开始日期" style="margin-bottom:0px">
						<Date-picker v-model.lazy="subedit_renewals_enddatebefore" type="datetime" size="small"></Date-picker>
					</Form-Item>
					<Form-Item label="续约结束日期" style="margin-bottom:0px">
						<Date-picker v-model.lazy="subedit_renewals_enddateafter" type="datetime" size="small"></Date-picker>
					</Form-Item>
					<Form-Item label="生效日期" style="margin-bottom:0px">
						<Date-picker v-model.lazy="subedit_renewals_effectivedate" type="datetime" size="small"></Date-picker>
					</Form-Item>
				</i-col>
				<i-col span="12">
					<Form-Item label="备注" style="margin-bottom:0px">
						<i-input v-model.lazy="subedit_renewals_notes" size="small" type="textarea" rows="3"></i-input>
					</Form-Item>
				</i-col>
			</i-row>
		</i-form>&nbsp;
		</p>
	
	</div>	
</Modal>

<!-- 子添加窗口 renewals-->
<Modal v-model="modal_subadd_renewals" @on-ok="subcreate_renewals" ok-text="添加" title="添加 - 代理商官方网站" width="640">
	<div style="text-align:left">

		<p>
		<i-form :label-width="100">
			<i-row>
				<i-col span="12">
					<Form-Item label="续约开始日期" style="margin-bottom:0px">
						<Date-picker v-model.lazy="subadd_renewals_enddatebefore" type="datetime" size="small"></Date-picker>
					</Form-Item>
					<Form-Item label="续约结束日期" style="margin-bottom:0px">
						<Date-picker v-model.lazy="subadd_renewals_enddateafter" type="datetime" size="small"></Date-picker>
					</Form-Item>
					<Form-Item label="生效日期" style="margin-bottom:0px">
						<Date-picker v-model.lazy="subadd_renewals_effectivedate" type="datetime" size="small"></Date-picker>
					</Form-Item>
				</i-col>
				<i-col span="12">
					<Form-Item label="备注" style="margin-bottom:0px">
						<i-input v-model.lazy="subadd_renewals_notes" size="small" type="textarea" rows="3"></i-input>
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
		
		sideractivename: '4-1',
		sideropennames: ['4'],
		
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
		contracts_delete_disabled: true,

		// 合同类型变量
		contracts_type_options: [],

		// 主编辑变量
		modal_edit_contracts: false,
		edit_id: '',
		edit_updated_at: '',
		edit_title: '',
		edit_type_select: '',
		edit_type_options: [],
		edit_number: '',
		edit_description: '',
		edit_comments: '',
		edit_totalcost: '',
		edit_currency_select: '',
		edit_currency_options: [
			{label: 'RMB(¥)', value: 1},
			{label: 'USD($)', value: 2},
			{label: 'EUR(€)', value: 3},
			{label: 'JPY(Ұ)', value: 4},
		],
		edit_currency: '',
		edit_startdate: '',
		edit_currentenddate: '',
		
		// 子编辑 变量
		modal_subedit_renewals: false,
		subedit_id: '',
		subedit_subid: '',
		subedit_updated_at: '',
		subedit_renewals_enddatebefore: '',
		subedit_renewals_enddateafter: '',
		subedit_renewals_effectivedate: '',
		subedit_renewals_notes: '',

		// 子添加 变量
		modal_subadd_renewals: false,
		subadd_id: '',
		subadd_subid: '',
		subadd_updated_at: '',
		subadd_renewals_enddatebefore: '',
		subadd_renewals_enddateafter: '',
		subadd_renewals_effectivedate: '',
		subadd_renewals_notes: '',



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
				width: 210,
				render: (h, params) => {
					return h('span', vm_app.contracts_type_options.map(item => {
						if (params.row.type == item.id) {
							return h('p', {}, item.name)
						}
					}))
				}
			},

			{
				title: '合同编号',
				key: 'number',
				resizable: true,
				width: 180,
			},
			{
				title: '合同详细描述',
				key: 'description',
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
								'content': params.row.description,
								'transfer': true
							},
						}, params.row.description == null ? '' : params.row.description.substr(0, 16) + '...')
					]);
				}
			},
			{
				title: '备注',
				key: 'comments',
				resizable: true,
				width: 180,
			},
			{
				title: '总价值',
				key: 'totalcost',
				resizable: true,
				width: 130,
				render: (h, params) => {
					var a = params.row.totalcost;

					if (a != null) {
						switch (params.row.currency) {
							case 1:
								return h('span', {}, '¥'+a);break;
							case 2:
								return h('span', {}, '$'+a);break;
							case 3:
								return h('span', {}, '€'+a);break;
							case 4:
								return h('span', {}, 'Ұ'+a);break;
							default:
								return h('span', {}, a);
						}
					} else {

					}
				}
			},
			{
				title: '币种',
				key: 'currency',
				width: 80,
				render: (h, params) => {
					switch (params.row.currency) {
						case 1:
							return h('span', {}, 'RMB(¥)');break;
						case 2:
							return h('span', {}, 'USD($)');break;
						case 3:
							return h('span', {}, 'EUR(€)');break;
						case 4:
							return h('span', {}, 'JPY(Ұ)');break;
						default:
					}
				}
			},
			{
				title: '开始日期',
				key: 'startdate',
				resizable: true,
				width: 160,
			},
			{
				title: '结束日期',
				key: 'currentenddate',
				resizable: true,
				width: 160,
			},
			{
				title: '合同续约',
				align: 'center',
				children: [
					{
						title: '序号',
						key: 'renewals',
						align:'center',
						width: 70,
						className: 'table-info-column-renewals',
						render: (h, params) => {
							if (params.row.renewals!=undefined && params.row.renewals!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.renewals.map((item, index) => {
										return h('li', {
										}, ++index)
									}))
								]);
							}
						}
					},
					{
						title: '开始日期',
						key: 'renewals',
						align:'center',
						width: 160,
						className: 'table-info-column-renewals',
						render: (h, params) => {
							if (params.row.renewals!=undefined && params.row.renewals!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.renewals.map(item => {
										return h('li', {
										}, item.enddatebefore == null || item.enddatebefore == '' ? '-' : item.enddatebefore)
									}))
								]);
							}
						}
					},
					{
						title: '结束日期',
						key: 'renewals',
						align:'center',
						width: 160,
						className: 'table-info-column-renewals',
						render: (h, params) => {
							if (params.row.renewals!=undefined && params.row.renewals!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.renewals.map(item => {
										return h('li', {
										}, item.enddateafter == null || item.enddateafter == '' ? '-' : item.enddateafter)
									}))
								]);
							}
						}
					},
					{
						title: '生效日期',
						key: 'renewals',
						align:'center',
						width: 160,
						className: 'table-info-column-renewals',
						render: (h, params) => {
							if (params.row.renewals!=undefined && params.row.renewals!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.renewals.map(item => {
										return h('li', {
										}, item.effectivedate == null || item.effectivedate == '' ? '-' : item.effectivedate)
									}))
								]);
							}
						}
					},
					{
						title: '备注',
						key: 'renewals',
						align:'center',
						width: 90,
						className: 'table-info-column-renewals',
						render: (h, params) => {
							if (params.row.renewals!=undefined && params.row.renewals!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.renewals.map(item => {
										return h('li', {
										}, item.notes == null || item.notes == '' ? '-' : item.notes)
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
						className: 'table-info-column-renewals',
						render: (h, params) => {
							if (params.row.renewals!=undefined && params.row.renewals!=null) {
								return h('div', {
										attrs: {
											class:'subCol'
										},
									}, [
									h('ul', params.row.renewals.map((item, index) => {
										return h('li', {
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
														vm_app.subedit_renewals(params.row, item, index)
													}
												}
											}),


											h('Poptip', {
												props: {
													'word-wrap': true,
													'trigger': 'click',
													'confirm': true,
													'title': '真的要删除吗？',
													'transfer': true
												},
												on: {
													'on-ok': () => {
														vm_app.subdelete_renewals(params.row, item, index)
													}
												}
											}, [
												h('Button', {
													props: {
														type: 'warning',
														size: 'small',
														icon: 'md-remove'
													},
													style: {
														marginRight: '5px'
													},
												})
											]),

										])
									}))
								]);
							}
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
					return h('div', [

						h('Poptip', {
							props: {
								'word-wrap': true,
								'trigger': 'hover',
								'confirm': false,
								'content': '编辑合同信息',
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
										vm_app.edit_contracts(params.row)
									}
								}
							}),
						]),

						h('Poptip', {
							props: {
								'word-wrap': true,
								'trigger': 'hover',
								'confirm': false,
								'content': '添加合同续约',
								'transfer': true
							},
						}, [
							h('Button', {
								props: {
									type: 'default',
									size: 'small',
									icon: 'md-document'
								},
								style: {
									marginRight: '5px'
								},
								on: {
									click: () => {
										vm_app.add_renewals(params.row)
									}
								}
							})
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
			for (var k in json) {
				// alert(key);
				// alert(json[key]);
				// arr.push({ obj.['value'] = key, obj.['label'] = json[key] });
				arr.push({ value: json[k].id, label: json[k].name });
			}
			return arr;
			// return arr.reverse();
		},

		//
		contractsgets (page, last_page){
			var _this = this;
			
			if (page > last_page) {
				page = last_page;
			} else if (page < 1) {
				page = 1;
			}
			

			_this.loadingbarstart();
			var url = "{{ route('contract.gets') }}";
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
					_this.softs_delete_disabled = true;
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
			this.contractsgets(currentpage, this.page_last);
		},

		// 表格选择
		onselectchange (selection) {
			var _this = this;
			_this.tableselect = [];

			for (var i in selection) {
				_this.tableselect.push(selection[i].id);
			}
			
			_this.contracts_delete_disabled = _this.tableselect[0] == undefined ? true : false;
		},


		// 删除记录
		contracts_delete () {
			var _this = this;
			
			var tableselect = _this.tableselect;
			
			if (tableselect[0] == undefined) return false;

			var url = "{{ route('contract.delete') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				tableselect: tableselect
			})
			.then(function (response) {
				if (response.data) {
					_this.contracts_delete_disabled = true;
					_this.tableselect = [];
					_this.success(false, '成功', '删除成功！');
					_this.contractsgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '删除失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '删除失败！');
			})
		},


		// 跳转至添加页面
		contracts_add () {
			window.location.href = "{{ route('contract.add') }}";
		},


		// 获取合同类型列表
		contracttypesgets () {
			var _this = this;
			var url = "{{ route('contracttypes.gets') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					perPage: 1000,
					page: 1,
				}
			})
			.then(function (response) {
				// console.log(response.data.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}

				if (response.data) {
					// _this.contracts_type_options = _this.json2selectvalue(response.data.data);
					_this.contracts_type_options = response.data.data;
					_this.edit_type_options = _this.json2selectvalue(response.data.data);
				}
				
			})
			.catch(function (error) {
				// _this.error(false, 'Error', error);
			})
		},

		// 主编辑前查看 - contracts
		edit_contracts (row) {
			var _this = this;

			_this.edit_id = row.id;
			_this.edit_updated_at = row.updated_at;
			_this.edit_title = row.title;
			_this.edit_type_select = row.type;
			_this.edit_number = row.number;
			_this.edit_description = row.description;
			_this.edit_comments = row.comments;
			_this.edit_totalcost = row.totalcost;
			_this.edit_currency_select = row.currency;
			_this.edit_startdate = row.startdate;
			_this.edit_currentenddate = row.currentenddate;

			_this.modal_edit_contracts = true;
		},

		// 主编辑保存 - contracts
		update_contracts () {
			var _this = this;

			var id = _this.edit_id;
			var updated_at = _this.edit_updated_at;
			var title = _this.edit_title;
			var type = _this.edit_type_select;
			var number = _this.edit_number;
			var description = _this.edit_description;
			var comments = _this.edit_comments;
			var totalcost = _this.edit_totalcost;
			var currency = _this.edit_currency_select;
			var startdate = _this.edit_startdate != '' && _this.edit_startdate != undefined ? new Date(_this.edit_startdate).Format("yyyy-MM-dd hh:mm:ss") : '';
			var currentenddate = _this.edit_currentenddate != '' && _this.edit_currentenddate != undefined ? new Date(_this.edit_currentenddate).Format("yyyy-MM-dd hh:mm:ss") : '';

			if (id == undefined || title == undefined || title == '' || type == undefined || type == '') {
				_this.warning(false, '警告', '内容不能为空！');
				return false;
			}

			var url = "{{ route('contract.update') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				id: id,
				updated_at: updated_at,
				title: title,
				type: type,
				number: number,
				description: description,
				comments: comments,
				totalcost: totalcost,
				currency: currency,
				startdate: startdate,
				currentenddate: currentenddate,
			})
			.then(function (response) {
				// console.log(response.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
				if (response.data) {
					_this.success(false, '成功', '更新成功！');
						_this.contractsgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '更新失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '更新失败！');
			})

		},


		// 子编辑前查看 - renewals
		subedit_renewals (row, subrow, index) {
			var _this = this;

			_this.subedit_id = row.id;
			_this.subedit_subid = index;
			_this.subedit_updated_at = row.updated_at;
			_this.subedit_renewals_enddatebefore = subrow.enddatebefore;
			_this.subedit_renewals_enddateafter = subrow.enddateafter;
			_this.subedit_renewals_effectivedate = subrow.effectivedate;
			_this.subedit_renewals_notes = subrow.notes;

			_this.modal_subedit_renewals = true;
		},

		// 子编辑保存 - renewals
		subupdate_renewals () {

			var _this = this;

			var id = _this.subedit_id;
			var subid = _this.subedit_subid;
			var updated_at = _this.subedit_updated_at;
			var enddatebefore = _this.subedit_renewals_enddatebefore != '' && _this.subedit_renewals_enddatebefore != undefined ? new Date(_this.subedit_renewals_enddatebefore).Format("yyyy-MM-dd hh:mm:ss") : '';
			var enddateafter = _this.subedit_renewals_enddateafter != '' && _this.subedit_renewals_enddateafter != undefined ? new Date(_this.subedit_renewals_enddateafter).Format("yyyy-MM-dd hh:mm:ss") : '';
			var effectivedate = _this.subedit_renewals_effectivedate != '' && _this.subedit_renewals_effectivedate != undefined ? new Date(_this.subedit_renewals_effectivedate).Format("yyyy-MM-dd hh:mm:ss") : '';
			var notes = _this.subedit_renewals_notes;

			if (id == undefined || subid == undefined
				|| enddatebefore == '' || enddatebefore == undefined
				|| enddateafter == '' || enddateafter == undefined
				|| effectivedate == '' || effectivedate == undefined) {
				_this.warning(false, '警告', '内容选择不正确！');
				return false;
			}

			var url = "{{ route('contract.subupdaterenewals') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				id: id,
				subid: subid,
				updated_at: updated_at,
				enddatebefore: enddatebefore,
				enddateafter: enddateafter,
				effectivedate: effectivedate,
				notes: notes,
			})
			.then(function (response) {
				// console.log(response.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
				if (response.data) {
					_this.success(false, '成功', '更新成功！');
						_this.contractsgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '更新失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '更新失败！');
			})

		},


		// 子删除 - renewals
		subdelete_renewals (row, subrow, index) {
			var _this = this;

			var id = row.id;
			var subid = index;

			if (id == undefined || subid == undefined) {
				_this.warning(false, '警告', '内容选择不正确！');
				return false;
			}

			var url = "{{ route('contract.subdeleterenewals') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				id: id,
				subid: subid,
			})
			.then(function (response) {
				// console.log(response.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
				if (response.data) {
					_this.success(false, '成功', '删除成功！');
						_this.contractsgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '删除失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '删除失败！');
			})
		},




		// 添加续约合同 - 查看
		add_renewals (row) {
			var _this = this;
			_this.subadd_id = row.id;
			_this.modal_subadd_renewals = true;
		},


		// 添加续约合同 - 保存
		subcreate_renewals () {
			var _this = this;

			var id = _this.subadd_id;
			var enddatebefore = _this.subadd_renewals_enddatebefore != '' && _this.subadd_renewals_enddatebefore != undefined ? new Date(_this.subadd_renewals_enddatebefore).Format("yyyy-MM-dd hh:mm:ss") : '';
			var enddateafter = _this.subadd_renewals_enddateafter != '' && _this.subadd_renewals_enddateafter != undefined ? new Date(_this.subadd_renewals_enddateafter).Format("yyyy-MM-dd hh:mm:ss") : '';
			var effectivedate = _this.subadd_renewals_effectivedate != '' && _this.subadd_renewals_effectivedate != undefined ? new Date(_this.subadd_renewals_effectivedate).Format("yyyy-MM-dd hh:mm:ss") : '';
			var notes = _this.subadd_renewals_notes;
			
			if (id == undefined) {
				_this.warning(false, '警告', '内容选择不正确！');
				return false;
			}

			var url = "{{ route('contract.subcreaterenewals') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				id: id,
				enddatebefore: enddatebefore,
				enddateafter: enddateafter,
				effectivedate: effectivedate,
				notes: notes,
			})
			.then(function (response) {
				// console.log(response.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
				if (response.data) {
					_this.add_clear_var();
					_this.success(false, '成功', '添加成功！');
					_this.contractsgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '添加失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '添加失败！');
			})
		},


		add_clear_var () {
			var _this = this;
			_this.subadd_renewals_enddatebefore = '';
 			_this.subadd_renewals_enddateafter = '';
			_this.subadd_renewals_effectivedate = '';
			_this.subadd_renewals_notes = '';
		},


		


	},
	mounted: function(){
		var _this = this;
		_this.current_nav = '合同';
		_this.current_subnav = '查询';

		// // 显示所有
		_this.contractsgets(1, 1); // page: 1, last_page: 1
		_this.contracttypesgets();
		// _this.loadapplicantgroup();

		// GetCurrentDatetime('getcurrentdatetime');
	}
});
</script>
@endsection