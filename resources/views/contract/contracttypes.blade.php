@extends('contract.layouts.mainbase')

@section('my_title')
合同类型 - 
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
<!-- <Divider orientation="left">合同类型</Divider> -->
&nbsp;<br>


<i-row :gutter="16">

	<i-col span="4">
		<i-input v-model.lazy="contracttypes_add_name" placeholder="合同类型名称">
			<i-button slot="append" icon="md-add" @click="contracttypes_create()"></i-button>
		</i-input>
	</i-col>

	<i-col span="1">
	&nbsp;
	</i-col>

	<i-col span="6">
		&nbsp;
	</i-col>

	<i-col span="13">
	&nbsp;
	</i-col>

</i-row>

&nbsp;

<i-row :gutter="16">
	<i-col span="24">

		<i-table height="300" size="small" border :columns="tablecolumns" :data="tabledata"></i-table>
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
		
		sideractivename: '4-3',
		sideropennames: ['4'],
		
		//分页
		page_current: 1,
		page_total: 0, // 记录总数，非总页数
		page_size: {{ $user['configs']['PERPAGE_RECORDS_FOR_APPLICANT'] ?? 10 }},
		page_last: 1,

		//新增
		contracttypes_add_name: '',


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
				title: '合同类型名称',
				key: 'name',
				width: 180,
				render: (h, params) => {
					
					return h('div', {}, [
						h('i-input',{
							// style:{
							// 	color: '#ff9900'
							// },
							props: {
								value: params.row.name,
								size: 'small',
							},
							'on': {
								'on-blur':() => {
									// alert(params.row.id);
									// alert(event.target.value);
									if (params.row.name != event.target.value) {
										vm_app.contracttypes_update_name(params.row.id, event.target.value)
									}
								}
							},
						})
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
				title: '更新时间',
				key: 'updated_at',
				sortable: true,
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
									type: 'error',
									size: 'small',
									icon: 'md-arrow-round-down'
								},
								style: {
									marginRight: '5px'
								},
								on: {
									click: () => {
										vm_app.contracttypes_delete(params.row)
									}
								}
							}, '删除'),
							

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
		contracttypesgets (page, last_page){
			var _this = this;
			
			if (page > last_page) {
				page = last_page;
			} else if (page < 1) {
				page = 1;
			}
			

			_this.loadingbarstart();
			var url = "{{ route('contracttypes.gets') }}";
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
			this.contracttypesgets(currentpage, this.page_last);
		},

		// 表格选择
		onselectchange (selection) {
			var _this = this;
			_this.tableselect = [];

			for (var i in selection) {
				_this.tableselect.push(selection[i].id);
			}
			
			_this.softs_delete_disabled = _this.tableselect[0] == undefined ? true : false;
		},



		// 更新 name
		contracttypes_update_name (id, name) {
			var _this = this;
			
			var id = id;
			var name = name;
			// _this.contracttypes_edit_id = id;
			// _this.contracttypes_edit_statusdesc = row.contracttypes_edit_statusdesc;
			// _this.jiaban_edit_created_at = row.created_at;
			// _this.jiaban_edit_updated_at = row.updated_at;

			var url = "{{ route('contracttypes.update_name') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url,{
				id: id,
				name: name
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
					_this.contracttypesgets(_this.page_current, _this.page_last);
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
		contracttypes_delete (row) {
			var _this = this;
			var id = row.id;
			if (id == undefined) return false;
			var url = "{{ route('contracttypes.delete') }}";
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
					_this.contracttypesgets(_this.page_current, _this.page_last);
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
		contracttypes_create () {
			var _this = this;

			var name = _this.contracttypes_add_name;
			var hassoftware = _this.contracttypes_add_hassoftware;

			if (name == '' || name == undefined) {
					// console.log(hassoftware);
				// _this.error(false, '失败', '用户ID为空或不正确！');
				return false;
			}

			var url = "{{ route('contracttypes.create') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				name: name,
			})
			.then(function (response) {
				// console.log(response.data);
				// return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
 				if (response.data) {
					_this.contracttypes_add_name = '';
					_this.contracttypesgets(_this.page_current, _this.page_last);
					_this.success(false, '成功', '新建成功！');
				} else {
					_this.error(false, '失败', '新建失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '新建失败！');
			})


		},






		


	},
	mounted: function(){
		var _this = this;
		_this.current_nav = '合同类型';
		_this.current_subnav = '编辑';

		// // 显示所有
		_this.contracttypesgets(1, 1); // page: 1, last_page: 1
		// _this.loadapplicantgroup();

		// GetCurrentDatetime('getcurrentdatetime');
	}
});
</script>
@endsection