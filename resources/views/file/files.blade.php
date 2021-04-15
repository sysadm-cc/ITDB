@extends('file.layouts.mainbase')

@section('my_title')
文件 - 
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
<!-- <Divider orientation="left">文件</Divider> -->
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
			<Poptip confirm word-wrap title="真的要删除这些记录吗？" @on-ok="files_delete()">
				<i-button :disabled="files_delete_disabled" icon="md-remove" type="warning" size="small">删除</i-button>&nbsp;<br>&nbsp;
			</Poptip>
		</i-col>
		<i-col span="3">
			<i-button type="primary" icon="md-add" size="small" @click="files_add()">添加文件</i-button>
		</i-col>
		<i-col span="3">
			<i-button type="default" icon="ios-download-outline" size="small" @click="items_export()">导出</i-button>
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
<Modal v-model="modal_edit_files" @on-ok="update_files" ok-text="保存" title="编辑 - 文件" width="460">
	<div style="text-align:left">

		<p>
		<i-form :label-width="100">
			<i-row>
				<i-col span="24">
					<Form-Item label="文件名称" required style="margin-bottom:0px">
						<i-input v-model.lazy="edit_title" size="small"></i-input>
					</Form-Item>
					<Form-Item label="文件类型" style="margin-bottom:0px">
						<!-- <i-select v-model.lazy="add_type_select" multiple size="small" placeholder=""> -->
						<i-select v-model.lazy="edit_type_select" size="small" placeholder="">
							<i-option v-for="item in edit_type_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<!-- <Form-Item label="购买日期" style="margin-bottom:0px">
						<Date-picker v-model.lazy="add_purchdate" type="daterange" size="small"></Date-picker>
					</Form-Item> -->
					<Form-Item label="文件名" style="margin-bottom:0px">
						<i-input v-model.lazy="edit_filename" size="small"></i-input>
					</Form-Item>
					<Form-Item label="上传者" style="margin-bottom:0px">
						<i-input v-model.lazy="edit_uploader" size="small"></i-input>
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
		
		sideractivename: '6-1',
		sideropennames: ['6'],
		
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
		files_delete_disabled: true,

		// 主编辑变量
		modal_edit_files: false,
		edit_id: '',
		edit_updated_at: '',
		edit_title: '',
		edit_type_select: '',
		edit_type_options: [
			{label: '合同 - Contract', value: 1},
			{label: '认证 - License', value: 2},
			{label: '手册 - Manual', value: 3},
			{label: '报价 - Offer', value: 4},
			{label: '订单 - Order', value: 5},
			{label: '图片 - Photo', value: 6},
			{label: '报表 - Report', value: 7},
			{label: '服务 - Service', value: 8},
			{label: '其他 - Other', value: 9},
		],
		edit_filename: '',
		edit_uploader: '',


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
				render: (h, params) => {
					switch (params.row.type) {
						case 1:
							return h('div', {}, [
								h('Icon',{
									props: {
										type: 'md-bookmark',
										size: 14,
										color: 'purple',
										}
									},
								),
								h('span',{
									// style:{
									// 	color: '#ff9900'
									// }
								}, '合同 Contract')
							]);
							break;
						
						case 2:
							return h('div', {}, [
								h('Icon',{
									props: {
										type: 'md-bookmark',
										size: 14,
										color: 'red',
										}
									},
								),
								h('span',{
									// style:{
									// 	color: '#ff9900'
									// }
								}, '认证 License')
							]);
							break;

						case 3:
							return h('div', {}, [
								h('Icon',{
									props: {
										type: 'md-bookmark',
										size: 14,
										color: 'blue',
										}
									}
								),
								h('span',{
									// style:{
									// 	color: '#ff9900'
									// }
								}, '手册 Manual')
							]);
							break;
							
						case 4:
							return h('div', {}, [
								h('Icon',{
									props: {
										type: 'md-bookmark',
										size: 14,
										color: 'silver',
										}
									}
								),
								h('span',{
									// style:{
									// 	color: '#ff9900'
									// }
								}, '报价 Offer')
							]);
							break;

						case 5:
							return h('div', {}, [
								h('Icon',{
									props: {
										type: 'md-bookmark',
										size: 14,
										color: 'maroon',
										}
									}
								),
								h('span',{
									// style:{
									// 	color: '#ff9900'
									// }
								}, '订单 Order')
							]);
							break;

						case 6:
							return h('div', {}, [
								h('Icon',{
									props: {
										type: 'md-bookmark',
										size: 14,
										color: 'yellow',
										}
									}
								),
								h('span',{
									// style:{
									// 	color: '#ff9900'
									// }
								}, '图片 Photo')
							]);
							break;

						case 7:
							return h('div', {}, [
								h('Icon',{
									props: {
										type: 'md-bookmark',
										size: 14,
										color: 'lime',
										}
									}
								),
								h('span',{
									// style:{
									// 	color: '#ff9900'
									// }
								}, '报表 Report')
							]);
							break;

						case 8:
							return h('div', {}, [
								h('Icon',{
									props: {
										type: 'md-bookmark',
										size: 14,
										color: 'green',
										}
									}
								),
								h('span',{
									// style:{
									// 	color: '#ff9900'
									// }
								}, '服务 Service')
							]);
							break;

						case 9:
							return h('div', {}, [
								h('Icon',{
									props: {
										type: 'md-bookmark',
										size: 14,
										color: 'black',
										}
									}
								),
								h('span',{
									// style:{
									// 	color: '#ff9900'
									// }
								}, '其他 Other')
							]);
							break;
					
							default:
								return h('div', {}, '未知');
					}


				}
			},
			{
				title: '文件名',
				key: 'filename',
				resizable: true,
				width: 180,
			},
			{
				title: '上传者',
				key: 'uploader',
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
								'content': '编辑文件属性',
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
										vm_app.edit_files(params.row)
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
		filesgets (page, last_page){
			var _this = this;
			
			if (page > last_page) {
				page = last_page;
			} else if (page < 1) {
				page = 1;
			}
			

			_this.loadingbarstart();
			var url = "{{ route('file.gets') }}";
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
					_this.files_delete_disabled = true;
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
			this.filesgets(currentpage, this.page_last);
		},

		// 表格选择
		onselectchange (selection) {
			var _this = this;
			_this.tableselect = [];

			for (var i in selection) {
				_this.tableselect.push(selection[i].id);
			}
			
			_this.files_delete_disabled = _this.tableselect[0] == undefined ? true : false;
		},

		// 跳转至添加页面
		files_add () {
			window.location.href = "{{ route('file.add') }}";
		},


		// 删除记录
		files_delete () {
			var _this = this;
			
			var tableselect = _this.tableselect;
			
			if (tableselect[0] == undefined) return false;

			var url = "{{ route('file.delete') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				tableselect: tableselect
			})
			.then(function (response) {
				if (response.data) {
					_this.locations_delete_disabled = true;
					_this.tableselect = [];
					_this.success(false, '成功', '删除成功！');
					_this.filesgets(_this.page_current, _this.page_last);
				} else {
					_this.error(false, '失败', '删除失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '删除失败！');
			})
		},


		// 主编辑前查看 - files
		edit_files (row) {
			var _this = this;

			_this.edit_id = row.id;
			_this.edit_updated_at = row.updated_at;
			_this.edit_title = row.title;
			_this.edit_type_select = row.type;
			_this.edit_filename = row.filename;
			_this.edit_uploader = row.uploader;

			_this.modal_edit_files = true;
		},

		// 主编辑保存 - files
		update_files () {
			var _this = this;

			var id = _this.edit_id;
			var updated_at = _this.edit_updated_at;
			var title = _this.edit_title;
			var type = _this.edit_type_select;
			var filename = _this.edit_filename;
			var uploader = _this.edit_uploader;

			if (id == undefined || title == undefined || title == '') {
				_this.warning(false, '警告', '内容不能为空！');
				return false;
			}

			var url = "{{ route('file.update') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				id: id,
				updated_at: updated_at,
				title: title,
				type: type,
				filename: filename,
				uploader: uploader,
			})
			.then(function (response) {
				// console.log(response.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
				if (response.data) {
					_this.success(false, '成功', '更新成功！');
						_this.filesgets(_this.page_current, _this.page_last);
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
		_this.current_nav = '文件';
		_this.current_subnav = '查询';

		// // 显示所有
		_this.filesgets(1, 1); // page: 1, last_page: 1
		// _this.loadapplicantgroup();

		// GetCurrentDatetime('getcurrentdatetime');
	}
});
</script>
@endsection