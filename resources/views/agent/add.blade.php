@extends('agent.layouts.mainbase')

@section('my_title')
供应商添加 - 
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
<!-- <Divider orientation="left">供应商添加</Divider> -->

	<i-row :gutter="16">

		<i-col span="7">
			<Divider orientation="left">供应商属性</Divider>
			<i-form :label-width="100">
				<Form-Item label="名称" required style="margin-bottom:0px">
					<i-input v-model.lazy="add_title" size="small"></i-input>
				</Form-Item>
				<Form-Item label="类型" required style="margin-bottom:0px">
					<i-select v-model.lazy="add_type_select" size="small" multiple clearable placeholder="">
						<i-option v-for="item in add_type_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
					</i-select>
					<Tooltip max-width="460" placement="bottom">
						<span style="color: rgb(158, 167, 180);font-size:10px;">
						* 此项可多选。
						</span>
						<div slot="content">
							<p>售卖方及购买方将出现在发票及合同模块中；</p>
							<p>硬件销售商将出现的物品模块中；</p>
							<p>软件销售商将出现在合同模块中；</p>
							<p>承包商将出现的合同模块中。</p>
						</div>
					</Tooltip>
				</Form-Item>
				<Form-Item label="备注" style="margin-bottom:0px">
					<i-input v-model.lazy="add_contactinfo" size="small" type="textarea" placeholder="地址、电话号码以及其他信息..."></i-input>
				</Form-Item>
				<Form-Item label="联系方式" style="margin-bottom:0px">
					<i-input v-model.lazy="add_contacts" size="small"></i-input>
				</Form-Item>
				<Form-Item label="URLs" style="margin-bottom:0px">
					<i-input v-model.lazy="add_urls" size="small"></i-input>
				</Form-Item>

			</i-form>

		</i-col>

		<i-col span="1">
		&nbsp;
		</i-col>

		<i-col span="16">
			<Divider orientation="left">供应商联系方式</Divider>

			↓ 批量录入&nbsp;&nbsp;
			<Input-number v-model.lazy="piliangluruxiang_contracts" @on-change="value=>piliangluru_generate_contracts(value)" :min="1" :max="10" size="small" style="width: 60px"></Input-number>
			&nbsp;项（最多10项）&nbsp;&nbsp;<br>

			<span v-for="(item, index) in piliangluru_contracts">
			<br>
			<i-form :label-width="90">
			<i-row>
				<i-col span="1">
					<label class="ivu-form-item-label">
						No.@{{index+1}}
					</label>
				</i-col>
				<i-col span="8">
					<Form-Item label="名称" style="margin-bottom:0px">
						<i-input v-model.lazy="item.name" size="small"></i-input>
					</Form-Item>
					<Form-Item label="电话号码" style="margin-bottom:0px">
						<i-input v-model.lazy="item.phonenumber" size="small"></i-input>
					</Form-Item>
				</i-col>
				<i-col span="8">
					<Form-Item label="角色" style="margin-bottom:0px">
						<i-input v-model.lazy="item.role" size="small"></i-input>
					</Form-Item>
					<Form-Item label="电子邮件" style="margin-bottom:0px">
						<i-input v-model.lazy="item.email" size="small"></i-input>
					</Form-Item>
				</i-col>
				<i-col span="7">
					<Form-Item label="备注" style="margin-bottom:0px">
						<i-input v-model.lazy="item.comments" size="small" type="textarea"></i-input>
					</Form-Item>
				</i-col>
			</i-row>
			</i-form>&nbsp;
			</span>





			<!-- <i-form :label-width="100">
				<Form-Item label="联系方式" style="margin-bottom:0px">
						<i-input v-model.lazy="add_contacts" size="small"></i-input>
				</Form-Item>
			</i-form> -->
<br>&nbsp;<br><br><br><br>

			<Divider orientation="left">供应商网站</Divider>
			<i-form :label-width="100">
				<Form-Item label="URLs" style="margin-bottom:0px">
					<i-input v-model.lazy="add_urls" size="small"></i-input>
				</Form-Item>
			</i-form>
		</i-col>


	</i-row>





<Divider dashed></Divider>

<i-button @click="add_create()" :disabled="add_create_disabled" size="large" type="primary">添加</i-button>

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
		
		sideractivename: '5-2',
		sideropennames: ['5'],
		
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
		add_type_select: [],
		add_type_options: [
			{label: '售卖方 - Vendoer', value: 1},
			{label: '软件销售商 - S/W Manufacturer', value: 2},
			{label: '硬件销售商 - H/W Manufacturer', value: 3},
			{label: '购买方 - Buyer', value: 4},
			{label: '承包商 - Contractor', value: 5},
		],
		add_contactinfo: '',
		add_contacts: '',
		add_urls: '',

		// 批量录入项 - 联络方式
		piliangluruxiang_contracts: 1,
		// 批量录入 - 联络方式
		piliangluru_contracts: [
			{
				name: '',
				phonenumber: '',
				email: '',
				role: '',
				comments: ''
			},
		],

		// 批量录入项 - URLs
		piliangluruxiang_urls: 1,
		// 批量录入 - URLs
		piliangluru_urls: [
			{
				description: '',
				url: '',
			},
		],





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
			for (var key in json) {
				// alert(key);
				// alert(json[key]);
				// arr.push({ obj.['value'] = key, obj.['label'] = json[key] });
				arr.push({ value: key, label: json[key] });
			}
			return arr;
			// return arr.reverse();
		},


		// 清除所有变量
		add_clear_var () {
			var _this = this;
			_this.add_title = '';
			_this.add_type_select = [];
			_this.add_contactinfo = '';
			_this.add_contacts = '';
			_this.add_urls = '';
		},


		//新增
		add_create () {
			var _this = this;
			_this.add_create_disabled = true;

			var add_title = _this.add_title;
			var add_type_select = _this.add_type_select;
			var add_contactinfo = _this.add_contactinfo;
			var add_contacts = _this.add_contacts;
			var add_urls = _this.add_urls;

			if (add_title == '' || add_title == undefined) {
				_this.error(false, '错误', '内容为空或不正确！');
				_this.add_create_disabled = false;
				return false;
			}
// console.log(add_type_select);return false;

			var url = "{{ route('agent.create') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				add_title: add_title,
				add_type_select: add_type_select,
				add_contactinfo: add_contactinfo,
				add_contacts: add_contacts,
				add_urls: add_urls,
			})
			.then(function (response) {
				// console.log(response.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
 				if (response.data) {
					_this.add_clear_var();
					// _this.itemtypesgets(_this.page_current, _this.page_last);
					_this.success(false, '成功', '新建成功！');
				} else {
					_this.error(false, '失败', '新建失败！');
				}
				_this.add_create_disabled = false;
			})
			.catch(function (error) {
				_this.error(false, '错误', '新建失败！');
				_this.add_create_disabled = false;
			})

			

		},


		// 生成piliangluru
		piliangluru_generate_contracts (counts) {
			if (counts == undefined) counts = 1;
			var len = this.piliangluru_contracts.length;
			
			if (counts > len) {
				for (var i=0;i<counts-len;i++) {
					// this.piliangluru.push({value: 'piliangluru'+parseInt(len+i+1)});
					this.piliangluru_contracts.push(
						{
							jianchajileixing: '',
							buliangneirong: '',
							weihao: '',
							shuliang: '',
							jianchazhe: ''
						}
					);
				}
			} else if (counts < len) {
				if (this.piliangluruxiang_contracts != '') {
					for (var i=counts;i<len;i++) {
						if (this.piliangluruxiang_contracts == this.piliangluru_contracts[i].value) {
							this.piliangluruxiang_contracts = '';
							break;
						}
					}
				}
				
				for (var i=0;i<len-counts;i++) {
					this.piliangluru_contracts.pop();
				}
			}			

		},	
		











		

		


	},
	beforeCreated: function(){
		
	},
	mounted: function(){
		var _this = this;
		_this.loadingbarstart();
		_this.current_nav = '代理商';
		_this.current_subnav = '添加';


		

		// for (var i=1;i<=44;i++) {
		// 	_this.add_usize_options.push({label: i, value: i});
		// }

		// for (var i=1;i<=50;i++) {
		// 	_this.add_rackposition_options1.push({label: i, value: i});
		// }

		// ajax 获取物品类型列表
		// _this.itemtypesgets();

		// ajax 获取制造商列表







		_this.loadingbarfinish();

	}
});
</script>
@endsection