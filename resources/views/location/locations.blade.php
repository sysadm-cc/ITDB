@extends('location.layouts.mainbase')

@section('my_title')
位置场所 - 
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

.ivu-table td.table-info-column-areas {
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
<!-- <Divider orientation="left">位置场所</Divider> -->
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
			<Poptip confirm word-wrap title="删除将影响已有信息，真的要删除这些记录吗？" @on-ok="locations_delete()">
				<i-button :disabled="locations_delete_disabled" icon="md-remove" type="warning" size="small">删除</i-button>&nbsp;<br>&nbsp;
			</Poptip>
		</i-col>
		<i-col span="3">
			<i-button type="primary" icon="md-add" size="small" @click="locations_add()">添加新位置</i-button>
		</i-col>
		<i-col span="3">
			<i-button type="default" icon="ios-download-outline" size="small" @click="items_export()">导出列表</i-button>
		</i-col>
		<i-col span="15">
			&nbsp;
		</i-col>
	</i-row>



&nbsp;

<i-row :gutter="16">
	<i-col span="24">

		<i-table height="300" size="small" border :columns="tablecolumns" :data="tabledata" @on-selection-change="selection => onselectchange(selection)"></i-table>
		<br><Page :current="page_current" :total="page_total" :page-size="page_size" @on-change="currentpage => oncurrentpagechange(currentpage)" @on-page-size-change="pagesize => onpagesizechange(pagesize)" :page-size-opts="[5, 10, 20, 50]" show-total show-elevator show-sizer></Page>

		</i-col>
	</i-row>

</Tab-pane>


<!-- 以下为各元素编辑窗口 -->

<!-- 主编辑窗口 locations-->
<Modal v-model="modal_edit_locations" @on-ok="update_locations" ok-text="保存" title="编辑 - 位置" width="460">
	<div style="text-align:left">

		<p>
		<i-form :label-width="100">
			<i-row>
				<i-col span="24">
					<Form-Item label="名称" required style="margin-bottom:0px">
						<i-input v-model.lazy="edit_title" size="small"></i-input>
					</Form-Item>
					<Form-Item label="建筑" style="margin-bottom:0px">
						<i-input v-model.lazy="edit_building" size="small"></i-input>
					</Form-Item>
					<Form-Item label="楼层" style="margin-bottom:0px">
						<i-input v-model.lazy="edit_floor" size="small"></i-input>
					</Form-Item>
				</i-col>
			</i-row>
		</i-form>&nbsp;
		</p>
	
	</div>	
</Modal>

<!-- 子编辑窗口 areas-->
<Modal v-model="modal_subedit_areas" @on-ok="subupdate_areas" ok-text="保存" title="编辑 - 区域/房间" width="320">
	<div style="text-align:left">

		<p>
		<i-form :label-width="100">
			<i-row>
				<i-col span="24">
					<Form-Item label="名称" style="margin-bottom:0px">
						<i-input v-model.lazy="subedit_areas_name" size="small"></i-input>
					</Form-Item>
					<Form-Item label="坐标 x1" style="margin-bottom:0px">
						<Input-Number v-model.lazy="subedit_areas_x1" :min="0" :max="10000" size="small"></Input-Number>
					</Form-Item>
					<Form-Item label="坐标 y1" style="margin-bottom:0px">
						<Input-Number v-model.lazy="subedit_areas_y1" :min="0" :max="10000" size="small"></Input-Number>
					</Form-Item>
					<Form-Item label="坐标 x2" style="margin-bottom:0px">
						<Input-Number v-model.lazy="subedit_areas_x2" :min="0" :max="10000" size="small"></Input-Number>
					</Form-Item>
					<Form-Item label="坐标 y2" style="margin-bottom:0px">
						<Input-Number v-model.lazy="subedit_areas_y2" :min="0" :max="10000" size="small"></Input-Number>
					</Form-Item>



				</i-col>
			</i-row>
		</i-form>&nbsp;
		</p>
	
	</div>	
</Modal>

<!-- 子添加窗口 areas-->
<Modal v-model="modal_subadd_areas" @on-ok="subcreate_areas" ok-text="添加" title="添加 - 区域/房间" width="320">
	<div style="text-align:left">

		<p>
		<i-form :label-width="100">
			<i-row>
				<i-col span="24">
				<Form-Item label="名称" style="margin-bottom:0px">
						<i-input v-model.lazy="subadd_areas_name" size="small"></i-input>
					</Form-Item>
					<Form-Item label="坐标 x1" style="margin-bottom:0px">
						<Input-Number v-model.lazy="subadd_areas_x1" :min="0" :max="10000" size="small"></Input-Number>
					</Form-Item>
					<Form-Item label="坐标 y1" style="margin-bottom:0px">
						<Input-Number v-model.lazy="subadd_areas_y1" :min="0" :max="10000" size="small"></Input-Number>
					</Form-Item>
					<Form-Item label="坐标 x2" style="margin-bottom:0px">
						<Input-Number v-model.lazy="subadd_areas_x2" :min="0" :max="10000" size="small"></Input-Number>
					</Form-Item>
					<Form-Item label="坐标 y2" style="margin-bottom:0px">
						<Input-Number v-model.lazy="subadd_areas_y2" :min="0" :max="10000" size="small"></Input-Number>
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
		
		sideractivename: '8-1',
		sideropennames: ['8'],
		
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
		locations_delete_disabled: true,

		// 主编辑变量
		modal_edit_locations: false,
		edit_id: '',
		edit_updated_at: '',
		edit_title: '',
		edit_building: '',
		edit_floor: '',

		// 子编辑 变量
		modal_subedit_areas: false,
		subedit_id: '',
		subedit_subid: '',
		subedit_updated_at: '',
		subedit_areas_name: '',
		subedit_areas_x1: '',
		subedit_areas_y1: '',
		subedit_areas_x2: '',
		subedit_areas_y2: '',

		// 子添加 变量
		modal_subadd_areas: false,
		subadd_id: '',
		subadd_subid: '',
		subadd_updated_at: '',
		subadd_areas_name: '',
		subadd_areas_x1: '',
		subadd_areas_y1: '',
		subadd_areas_x2: '',
		subadd_areas_y2: '',


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
				title: '建筑',
				key: 'building',
				resizable: true,
				width: 180,
			},
			{
				title: '楼层',
				key: 'floor',
				resizable: true,
				width: 180,
			},
			{
				title: '区域/房间',
				align: 'center',
				children: [
					{
						title: '名称',
						key: 'areas',
						align:'center',
						width: 90,
						className: 'table-info-column-areas',
						render: (h, params) => {
							if (params.row.areas!=undefined && params.row.areas!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.areas.map(item => {
										return h('li', {
										}, item.name == null || item.name == '' ? '-' : item.name)
									}))
								]);
							}
						}
					},
					{
						title: '坐标X1',
						key: 'areas',
						align:'center',
						width: 80,
						className: 'table-info-column-areas',
						render: (h, params) => {
							if (params.row.areas!=undefined && params.row.areas!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.areas.map(item => {
										return h('li', {
										}, item.x1 == null || item.x1 == '' ? '-' : item.x1)
									}))
								]);
							}
						}
					},
					{
						title: '坐标Y1',
						key: 'areas',
						align:'center',
						width: 80,
						className: 'table-info-column-areas',
						render: (h, params) => {
							if (params.row.areas!=undefined && params.row.areas!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.areas.map(item => {
										return h('li', {
										}, item.y1 == null || item.y1 == '' ? '-' : item.y1)
									}))
								]);
							}
						}
					},
					{
						title: '坐标X2',
						key: 'areas',
						align:'center',
						width: 80,
						className: 'table-info-column-areas',
						render: (h, params) => {
							if (params.row.areas!=undefined && params.row.areas!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.areas.map(item => {
										return h('li', {
										}, item.x2 == null || item.x2 == '' ? '-' : item.x2)
									}))
								]);
							}
						}
					},
					{
						title: '坐标Y2',
						key: 'areas',
						align:'center',
						width: 80,
						className: 'table-info-column-areas',
						render: (h, params) => {
							if (params.row.areas!=undefined && params.row.areas!=null) {
								return h('div', {
									attrs: {
										class:'subCol'
									},
								}, [
									h('ul', params.row.areas.map(item => {
										return h('li', {
										}, item.y2 == null || item.y2 == '' ? '-' : item.y2)
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
						className: 'table-info-column-areas',
						render: (h, params) => {
							if (params.row.areas!=undefined && params.row.areas!=null) {
								return h('div', {
										attrs: {
											class:'subCol'
										},
									}, [
									h('ul', params.row.areas.map((item, index) => {
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
														vm_app.subedit_areas(params.row, item, index)
													}
												}
											}),


											h('Poptip', {
												props: {
													'word-wrap': true,
													'trigger': 'click',
													'confirm': true,
													'title': '删除将影响已有信息，真的要删除吗？',
													'transfer': true
												},
												on: {
													'on-ok': () => {
														vm_app.subdelete_areas(params.row, item, index)
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
								'content': '编辑位置属性',
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
										vm_app.edit_locations(params.row)
									}
								}
							}),
						]),

						h('Poptip', {
							props: {
								'word-wrap': true,
								'trigger': 'hover',
								'confirm': false,
								'content': '添加区域/房间',
								'transfer': true
							},
						}, [
							h('Button', {
								props: {
									type: 'default',
									size: 'small',
									icon: 'md-locate'
								},
								style: {
									marginRight: '5px'
								},
								on: {
									click: () => {
										vm_app.add_areas(params.row)
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
		locationsgets (page, last_page){
			var _this = this;
			
			if (page > last_page) {
				page = last_page;
			} else if (page < 1) {
				page = 1;
			}
			

			_this.loadingbarstart();
			var url = "{{ route('location.gets') }}";
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
					_this.locations_delete_disabled = true;
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
			this.locationsgets(currentpage, this.page_last);
		},

		// 表格选择
		onselectchange (selection) {
			var _this = this;
			_this.tableselect = [];

			for (var i in selection) {
				_this.tableselect.push(selection[i].id);
			}
			
			_this.locations_delete_disabled = _this.tableselect[0] == undefined ? true : false;
		},

		// 跳转至添加页面
		locations_add () {
			window.location.href = "{{ route('location.add') }}";
		},


		// 删除记录
		locations_delete () {
			var _this = this;
			
			var tableselect = _this.tableselect;
			
			if (tableselect[0] == undefined) return false;

			var url = "{{ route('location.delete') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				tableselect: tableselect
			})
			.then(function (response) {
				if (response.data) {
					_this.locations_delete_disabled = true;
					_this.tableselect = [];
					_this.success(false, '成功', '删除成功！');
					_this.locationsgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '删除失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '删除失败！');
			})
		},


		// 主编辑前查看 - locations
		edit_locations (row) {
			var _this = this;

			_this.edit_id = row.id;
			_this.edit_updated_at = row.updated_at;
			_this.edit_title = row.title;
			_this.edit_building = row.building;
			_this.edit_floor = row.floor;

			_this.modal_edit_locations = true;
		},

		// 主编辑保存 - locations
		update_locations () {
			var _this = this;

			var id = _this.edit_id;
			var updated_at = _this.edit_updated_at;
			var title = _this.edit_title;
			var building = _this.edit_building;
			var floor = _this.edit_floor;

			if (id == undefined || title == undefined || title == '') {
				_this.warning(false, '警告', '内容不能为空！');
				return false;
			}

			var url = "{{ route('location.update') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				id: id,
				updated_at: updated_at,
				title: title,
				building: building,
				floor: floor,
			})
			.then(function (response) {
				// console.log(response.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
				if (response.data) {
					_this.success(false, '成功', '更新成功！');
						_this.locationsgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '更新失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '更新失败！');
			})

		},

		// 子编辑前查看 - areas
		subedit_areas (row, subrow, index) {
			var _this = this;

			_this.subedit_id = row.id;
			_this.subedit_subid = index;
			_this.subedit_updated_at = row.updated_at;
			_this.subedit_areas_name = subrow.name;
			_this.subedit_areas_x1 = subrow.x1;
			_this.subedit_areas_y1 = subrow.y1;
			_this.subedit_areas_x2 = subrow.x2;
			_this.subedit_areas_y2 = subrow.y2;

			_this.modal_subedit_areas = true;
		},

		// 子编辑保存 - areas
		subupdate_areas () {
			var _this = this;

			var id = _this.subedit_id;
			var subid = _this.subedit_subid;
			var updated_at = _this.subedit_updated_at;
			var name = _this.subedit_areas_name;
			var x1 = _this.subedit_areas_x1;
			var y1 = _this.subedit_areas_y1; 
			var x2 = _this.subedit_areas_x2;
			var y2 = _this.subedit_areas_y2;

			if (id == undefined || subid == undefined) {
				_this.warning(false, '警告', '内容选择不正确！');
				return false;
			}

			var url = "{{ route('location.subupdateareas') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				id: id,
				subid: subid,
				updated_at: updated_at,
				name: name,
				x1: x1,
				y1: y1,
				x2: x2,
				y2: y2,
			})
			.then(function (response) {
				// console.log(response.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
				if (response.data) {
					_this.success(false, '成功', '更新成功！');
						_this.locationsgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '更新失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '更新失败！');
			})

		},


		// 子删除 - areas
		subdelete_areas (row, subrow, index) {
			var _this = this;

			var id = row.id;
			var subid = index;

			if (id == undefined || subid == undefined) {
				_this.warning(false, '警告', '内容选择不正确！');
				return false;
			}

			var url = "{{ route('location.subdeleteareas') }}";
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
						_this.locationsgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '删除失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '删除失败！');
			})
		},


		// 添加区域/房间 - 查看
		add_areas (row) {
			var _this = this;
			_this.subadd_id = row.id;
			_this.modal_subadd_areas = true;
		},


		// 添加区域/房间 - 保存
		subcreate_areas () {
			var _this = this;

			var id = _this.subadd_id;
			var name = _this.subadd_areas_name;
			var x1 = _this.subadd_areas_x1;
			var y1 = _this.subadd_areas_y1;
			var x2 = _this.subadd_areas_x2;
			var y2 = _this.subadd_areas_y2;
			
			if (id == undefined) {
				_this.warning(false, '警告', '内容选择不正确！');
				return false;
			}

			var url = "{{ route('location.subcreateareas') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				id: id,
				name: name,
				x1: x1,
				y1: y1,
				x2: x2,
				y2: y2,
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
					_this.locationsgets(_this.page_current, _this.page_last);
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
			_this.subadd_areas_name = '';
			_this.subadd_areas_x1 = '';
 			_this.subadd_areas_y1 = '';
			_this.subadd_areas_x2 = '';
			_this.subadd_areas_y2 = '';
		},


		


	},
	mounted: function(){
		var _this = this;
		_this.current_nav = '位置场所';
		_this.current_subnav = '查询';

		// // 显示所有
		_this.locationsgets(1, 1); // page: 1, last_page: 1
		// _this.loadapplicantgroup();

		// GetCurrentDatetime('getcurrentdatetime');
	}
});
</script>
@endsection