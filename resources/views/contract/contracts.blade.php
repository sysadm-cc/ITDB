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
				<i-button :disabled="contracts_delete_disabled" type="warning" size="small"><Icon type="md-remove"></Icon> 删除</i-button>&nbsp;<br>&nbsp;
			</Poptip>
		</i-col>
		<i-col span="3">
			<i-button type="primary" size="small" @click="contracts_add()"><Icon type="md-add"></Icon> 添加合同</i-button>
		</i-col>
		<i-col span="3">
			<i-button type="default" size="small" @click="items_export()"><Icon type="ios-download-outline"></Icon> 导出</i-button>
		</i-col>
		<i-col span="15">
			&nbsp;
		</i-col>
	</i-row>



&nbsp;

<i-row>
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


		// 变量
		contracts_type_options: [],


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
			// {
			// 	title: '类型',
			// 	key: 'type',
			// 	resizable: true,
			// 	width: 180,
			// },
			{
				title: '类型',
				key: 'type',
				resizable: true,
				width: 210,
				render: (h, params) => {
					return h('span', vm_app.contracts_type_options.map(item => {
						console.log(item.id);
						if (params.row.type == item.id) {
							return h('p', {}, item.name)
						}
						// if (item == 1) return h('p', {}, '售卖方 - Vendoer')
						// if (item == 2) return h('p', {}, '软件销售商 - S/W Manufacturer')
						// if (item == 3) return h('p', {}, '硬件销售商 - H/W Manufacturer')
						// if (item == 4) return h('p', {}, '购买方 - Buyer')
						// if (item == 5) return h('p', {}, '承包商 - Contractor')
						// console.log(item);
					}))
					// console.log(vm_app.contracts_type_options);
					// return h('span', {}, vm_app.contracts_type_options)
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
				width: 180,
			},
			{
				title: '开始日期',
				key: 'startdate',
				resizable: true,
				width: 180,
			},
			{
				title: '当前结束日期',
				key: 'currentenddate',
				resizable: true,
				width: 180,
			},
			{
				title: '合同续约',
				align: 'center',
				children: [
					{
						title: '开始日期',
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
														vm_app.subedit_urls(params.row, item, index)
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
														vm_app.subdelete_urls(params.row, item, index)
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
					// if (params.row.id > 3) {
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
					_this.contractsgets(_this.pagecurrent, _this.pagelast);
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
				}
				
			})
			.catch(function (error) {
				// _this.error(false, 'Error', error);
			})
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