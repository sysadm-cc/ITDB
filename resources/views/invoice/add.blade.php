@extends('invoice.layouts.mainbase')

@section('my_title')
发票添加 - 
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
<!-- <Divider orientation="left">发票添加</Divider> -->
&nbsp;<br>



	<i-row :gutter="16">

		<i-col span="8">
			<Divider orientation="left">发票属性</Divider>

			<i-form :label-width="100">
				<Form-Item label="名称" required style="margin-bottom:0px">
					<i-input v-model.lazy="add_title" size="small"></i-input>
				</Form-Item>
				<Form-Item label="代理商" required style="margin-bottom:0px">
					<!-- <i-select v-model.lazy="add_agent_select" multiple size="small" placeholder=""> -->
					<i-select v-model.lazy="add_agent_select" size="small" placeholder="">
						<i-option v-for="item in add_agent_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
					</i-select>
				</Form-Item>
				<Form-Item label="订单编号" style="margin-bottom:0px">
					<i-input v-model.lazy="add_ordernumber" size="small"></i-input>
				</Form-Item>
				<Form-Item label="购买者" style="margin-bottom:0px">
					<i-input v-model.lazy="add_buyer" size="small"></i-input>
				</Form-Item>
				<Form-Item label="发票日期" style="margin-bottom:0px">
					<Date-picker v-model.lazy="add_invoicedate" type="date" size="small"></Date-picker>
				</Form-Item>
				<Form-Item label="详细描述" style="margin-bottom:0px">
					<i-input v-model.lazy="add_description" type="textarea" size="small"></i-input>
				</Form-Item>

			</i-form>&nbsp;

		</i-col>


		<i-col span="1">
		&nbsp;
		</i-col>

		<i-col span="15">
		<Divider orientation="left">关联信息</Divider>
		&nbsp;
		</i-col>

	</i-row>





<Divider dashed></Divider>

<i-button @click="add_create()" :disabled="add_create_disabled" icon="md-add" size="large" type="primary">添加</i-button>
&nbsp;&nbsp;

<i-button @click="invoices_invoices()" icon="md-search" size="large">跳转至查询</i-button>

<br>




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
		
		sideractivename: '3-2',
		sideropennames: ['3'],
		
		//分页
		page_current: 1,
		page_total: 0, // 记录总数，非总页数
		page_size: {{ $user['configs']['PERPAGE_RECORDS_FOR_APPLICANT'] ?? 10 }},
		page_last: 1,

		// tabs索引
		currenttabs: 0,
		currenttabssub: 0,

		// 添加禁用
		add_create_disabled: false,

		// 参数变量
		add_title: '',
		add_agent_select: '',
		add_agent_options: [
			// {label: 'Lenovo', value: 1},
			// {label: 'Dell', value: 2},
		],
		add_ordernumber: '',
		add_buyer: '',
		add_invoicedate: '',
		add_description: '',






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
				title: '图标',
				key: 'id',
				// sortable: true,
				width: 70,
				render: (h, params) => {
					if (params.row.id == 1) {
						return h('div', {}, [
							h('Icon',{
								props: {
									type: 'md-bookmark',
									size: 14,
									color: 'blue',
									}
								}
							),
						])
					} else if (params.row.id == 2) {
						return h('div', {}, [
							h('Icon',{
								props: {
									type: 'md-bookmark',
									size: 14,
									color: 'green',
									}
								}
							),
						])
					} else if (params.row.id == 3) {
						return h('div', {}, [
							h('Icon',{
								props: {
									type: 'md-bookmark',
									size: 14,
									color: 'red',
									}
								}
							),
						])
					} else if (params.row.id == 4) {
						return h('div', {}, [
							h('Icon',{
								props: {
									type: 'md-bookmark',
									size: 14,
									color: 'gray',
									}
								}
							),
						])
					} else if (params.row.id == 5) {
						return h('div', {}, [
							h('Icon',{
								props: {
									type: 'md-bookmark',
									size: 14,
									color: 'yellow',
									}
								}
							),
						])
					} else if (params.row.id == 6) {
						return h('div', {}, [
							h('Icon',{
								props: {
									type: 'md-bookmark',
									size: 14,
									color: 'black',
									}
								}
							),
						])
					} else {
						return h('div', {}, [
							h('Icon',{
								props: {
									type: 'md-bookmark',
									size: 14,
									}
								}
							),
						])
					}	
				}
			},
			{
				title: '项目描述',
				key: 'typedesc',
				width: 180,
				render: (h, params) => {
					
					return h('div', {}, [
						h('i-input',{
							// style:{
							// 	color: '#ff9900'
							// },
							props: {
								value: params.row.typedesc,
								size: 'small',
							},
							'on': {
								'on-blur':() => {
									// alert(params.row.id);
									// alert(event.target.value);
									if (params.row.typedesc != event.target.value) {
										vm_app.itemtypes_update_typedesc(params.row.id, event.target.value)
									}
								}
							},
						})
					])
				}
			},
			{
				title: '可安装软件',
				key: 'hassoftware',
				align: 'center',
				width: 100,
				// render: (h, params) => {
				// 	if (params.row.hassoftware == true) {
				// 		return h('div', {}, '是')
				// 	} else {
				// 		return h('div', {}, '否')
				// 	}
				// }
				render: (h, params) => {

					return h('div', [
						// params.row.deleted_at.toLocaleString()
						// params.row.deleted_at ? '禁用' : '启用'
						
						h('i-switch', {
							props: {
								type: 'primary',
								size: 'small',
								value: params.row.hassoftware ? true : false
							},
							style: {
								marginRight: '5px'
							},
							on: {
								'on-change': (value) => {//触发事件是on-change,用双引号括起来，
									//参数value是回调值，并没有使用到
									vm_app.itemtypes_update_hassoftware(params.row.id, value) //params.index是拿到table的行序列，可以取到对应的表格值
								}
							}
						}, 'Edit')
						
					]);
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
				render: (h, params) => {
					if (params.row.id > 3) {
						return h('div', [
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
										vm_app.itemtypes_delete(params.row)
									}
								}
							}, '删除'),
							

						]);
					}
				},
				// fixed: 'right'
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
				arr.push({ value: json[k].id, label: json[k].title });
			}
			return arr;
			// return arr.reverse();
		},


		// 清除所有变量
		add_clear_var () {
			var _this = this;
			_this.add_title = '';
			_this.add_agent_select = '';
			_this.add_ordernumber = '';
			_this.add_buyer = '';
			_this.add_invoicedate = '';
			_this.add_description = '';
		},


		//新增
		add_create () {
			var _this = this;
			_this.add_create_disabled = true;

			var add_title = _this.add_title;
			var add_agent_select = _this.add_agent_select;
			var add_ordernumber = _this.add_ordernumber;
			var add_buyer = _this.add_buyer;
			var add_invoicedate = _this.add_invoicedate ? new Date(_this.add_invoicedate).Format("yyyy-MM-dd") : '';
			var add_description = _this.add_description;

			if (add_title == '' || add_title == undefined
				|| add_agent_select == '' || add_agent_select == undefined) {
				_this.error(false, '错误', '内容为空或不正确！');
				_this.add_create_disabled = false;
				return false;
			}
// console.log(add_itemtype_select);return false;

			var url = "{{ route('invoice.create') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				add_title: add_title,
				add_agent_select: add_agent_select,
				add_ordernumber: add_ordernumber,
				add_buyer: add_buyer,
				add_invoicedate: add_invoicedate,
				add_description: add_description,
			})
			.then(function (response) {
				// console.log(response.data);
				// return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
 				if (response.data) {
					_this.add_clear_var();
					// _this.itemtypesgets(_this.page_current, _this.page_last);
					_this.success(false, '成功', '添加成功！');
				} else {
					_this.error(false, '失败', '添加失败！');
				}
				_this.add_create_disabled = false;
			})
			.catch(function (error) {
				_this.error(false, '错误', '添加失败！');
				_this.add_create_disabled = false;
			})

			

		},


		// 获取代理商列表
		agentsgets (page, last_page){
			var _this = this;
			var url = "{{ route('agent.gets') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					perPage: 1000,
					page: 1,
				}
			})
			.then(function (response) {
				// console.log(response.data.data);
				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				if (response.data) {
					_this.add_agent_options = _this.json2selectvalue(response.data.data);
				}
			})
			.catch(function (error) {
				// _this.error(false, 'Error', error);
			})
		},


		// 跳转至查询页面
		invoices_invoices () {
			window.location.href = "{{ route('invoice.invoices') }}";
		},


	
		











		

		


	},
	mounted: function(){
		var _this = this;
		_this.loadingbarstart();
		_this.current_nav = '发票';
		_this.current_subnav = '添加';


		

		// for (var i=1;i<=44;i++) {
		// 	_this.add_usize_options.push({label: i, value: i});
		// }

		// for (var i=1;i<=50;i++) {
		// 	_this.add_rackposition_options1.push({label: i, value: i});
		// }

		// ajax 获取物品类型列表
		// _this.itemtypesgets();

		// 获取制造商列表
		_this.agentsgets();






		_this.loadingbarfinish();

	}
});
</script>
@endsection