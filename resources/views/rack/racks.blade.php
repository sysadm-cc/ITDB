@extends('rack.layouts.mainbase')

@section('my_title')
机架 - 
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
<!-- <Divider orientation="left">机架</Divider> -->
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
			<Poptip confirm word-wrap title="真的要删除这些记录吗？" @on-ok="racks_delete()">
				<i-button :disabled="racks_delete_disabled" icon="md-remove" type="warning" size="small">删除</i-button>&nbsp;<br>&nbsp;
			</Poptip>
		</i-col>
		<i-col span="3">
			<i-button type="primary" size="small" @click="racks_add()" icon="md-add">添加机架</i-button>
		</i-col>
		<i-col span="3">
			<i-button type="default" size="small" @click="items_export()" icon="ios-download-outline">导出列表</i-button>
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

<!-- 主编辑窗口 racks-->
<Modal v-model="modal_edit_racks" @on-ok="update_racks" ok-text="保存" title="编辑 - 机架" width="460">
	<div style="text-align:left">

		<p>
		<i-form :label-width="100">
			<i-row>
				<i-col span="24">
					<Form-Item label="名称" required style="margin-bottom:0px">
						<i-input v-model.lazy="edit_title" size="small"></i-input>
					</Form-Item>
					<Form-Item label="型号" style="margin-bottom:0px">
						<i-input v-model.lazy="edit_model" size="small"></i-input>
					</Form-Item>
					<Form-Item label="尺寸（U）" style="margin-bottom:0px">
						<i-select v-model.lazy="edit_usize_select" size="small" placeholder="">
							<i-option v-for="item in edit_usize_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="深度（mm）" style="margin-bottom:0px">
						<Input-Number v-model.lazy="edit_depth" size="small" :min="1"></Input-Number>
					</Form-Item>
					<Form-Item label="U数起始顺序" style="margin-bottom:0px">
						<i-select v-model.lazy="edit_revnums_select" size="small" placeholder="">
							<i-option v-for="item in edit_revnums_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="位置" style="margin-bottom:0px">
						<i-select v-model.lazy="edit_location_select" size="small" placeholder="">
							<i-option v-for="item in edit_location_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<!-- <Form-Item label="区域/房间" style="margin-bottom:0px">
						<i-select v-model.lazy="edit_locarea_select" size="small" placeholder="">
							<i-option v-for="item in edit_locarea_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item> -->
					<Form-Item label="标签" style="margin-bottom:0px">
						<i-input v-model.lazy="edit_label" size="small"></i-input>
					</Form-Item>
					<Form-Item label="备注" style="margin-bottom:0px">
						<i-input v-model.lazy="edit_comments" size="small" type="textarea"></i-input>
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
		
		sideractivename: '7-1',
		sideropennames: ['7'],
		
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
		racks_delete_disabled: true,

		// 主编辑变量
		modal_edit_racks: false,
		edit_id: '',
		edit_updated_at: '',
		edit_title: '',
		edit_model: '',
		edit_usize_select: '',
		edit_usize_options: [],
		edit_depth: '',
		edit_revnums_select: '',
		edit_revnums_options: [
			{label: '1-Bottom (从下向上计数)', value: 0},
			{label: '1-Top (从上向下计数)', value: 1},
		],
		edit_location_select: '',
		edit_location_options: [],
		edit_label: '',
		edit_comments: '',



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
				title: '型号',
				key: 'model',
				resizable: true,
				width: 180,
			},
			{
				title: '尺寸（U）',
				key: 'usize',
				resizable: true,
				width: 180,
			},
			{
				title: '深度（mm）',
				key: 'depth',
				resizable: true,
				width: 180,
			},
			{
				title: 'U数起始顺序',
				key: 'revnums',
				resizable: true,
				width: 90,
				render: (h, params) => {
					return params.row.revnums ? h('span', {}, '1=Top') : h('span', {}, '1=Bottom')
				},
			},
			{
				title: '位置',
				key: 'locationid',
				resizable: true,
				width: 180,
				render: (h, params) => {
					return h('span', vm_app.edit_location_options.map(item => {
						if (params.row.locationid == item.value) {
							return h('p', {}, item.label)
						}
					}))
				}
			},
			{
				title: '标签',
				key: 'label',
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
								'content': '编辑机架信息',
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
										vm_app.edit_racks(params.row)
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
			for (var k in json) {
				// alert(key);
				// alert(json[key]);
				// arr.push({ obj.['value'] = key, obj.['label'] = json[key] });
				arr.push({ value: json[k].id, label: json[k].title+' ('+json[k].building+' / '+json[k].floor+' / '+json[k].area+')' });
			}
			return arr;
			// return arr.reverse();
		},

		//
		racksgets (page, last_page){
			var _this = this;
			
			if (page > last_page) {
				page = last_page;
			} else if (page < 1) {
				page = 1;
			}
			

			_this.loadingbarstart();
			var url = "{{ route('rack.gets') }}";
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
			this.racksgets(currentpage, this.page_last);
		},

		// 表格选择
		onselectchange (selection) {
			var _this = this;
			_this.tableselect = [];

			for (var i in selection) {
				_this.tableselect.push(selection[i].id);
			}
			
			_this.racks_delete_disabled = _this.tableselect[0] == undefined ? true : false;
		},

		// 删除记录
		racks_delete () {
			var _this = this;
			
			var tableselect = _this.tableselect;
			
			if (tableselect[0] == undefined) return false;

			var url = "{{ route('rack.delete') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				tableselect: tableselect
			})
			.then(function (response) {
				if (response.data) {
					_this.racks_delete_disabled = true;
					_this.tableselect = [];
					_this.success(false, '成功', '删除成功！');
					_this.racksgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '删除失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '删除失败！');
			})
		},

		// 跳转至添加页面
		racks_add () {
			window.location.href = "{{ route('rack.add') }}";
		},


		// 获取位置信息列表
		locationsgets () {
			var _this = this;
			var url = "{{ route('location.gets') }}";
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
					_this.edit_location_options = _this.json2selectvalue(response.data.data);
				}
			})
			.catch(function (error) {
				_this.error(false, 'Error', error);
			})
		},


		// 主编辑前查看 - racks
		edit_racks (row) {
			var _this = this;

			_this.edit_id = row.id;
			_this.edit_updated_at = row.updated_at;
			_this.edit_title = row.title;
			_this.edit_model = row.model;
			_this.edit_usize_select = row.usize;
			_this.edit_depth = row.depth;
			_this.edit_revnums_select = row.revnums;
			_this.edit_location_select = row.locationid;
			_this.edit_label = row.label;
			_this.edit_comments = row.comments;

			_this.modal_edit_racks = true;
		},

		// 主编辑保存 - racks
		update_racks () {
			var _this = this;

			var id = _this.edit_id;
			var updated_at = _this.edit_updated_at;
			var title = _this.edit_title;
			var model = _this.edit_model;
			var usize = _this.edit_usize_select;
			var depth = _this.edit_depth;
			var revnums = _this.edit_revnums_select;
			var locationid = _this.edit_location_select;
			var label = _this.edit_label;
			var comments = _this.edit_comments;

			
			if (id == undefined || title == undefined || title == '' || type == undefined || type == '') {
				_this.warning(false, '警告', '内容不能为空！');
				return false;
			}

			var url = "{{ route('rack.update') }}";
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
						_this.racksgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '更新失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '更新失败！');
			})

		},




		


	},
	mounted: function(){
		var _this = this;
		_this.current_nav = '机架';
		_this.current_subnav = '查询';

		// 尺寸选择
		for (var i=50;i>=4;i--) {
			_this.edit_usize_options.push({label: i+'U', value: i});
		}

		_this.locationsgets();

		// // 显示所有
		_this.racksgets(1, 1); // page: 1, last_page: 1
		// _this.loadapplicantgroup();

		// GetCurrentDatetime('getcurrentdatetime');
	}
});
</script>
@endsection