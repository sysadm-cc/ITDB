@extends('soft.layouts.mainbase')

@section('my_title')
软件添加 - 
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
<!-- <Divider orientation="left">软件添加</Divider> -->
&nbsp;<br>



	<i-row :gutter="16">

		<i-col span="8">
			
			<i-form :label-width="100">
				<Form-Item label="* 名称" style="margin-bottom:0px">
					<i-input v-model.lazy="add_title" size="small"></i-input>
				</Form-Item>
				<Form-Item label="制造商" style="margin-bottom:0px">
					<!-- <i-select v-model.lazy="add_type_select" multiple size="small" placeholder=""> -->
					<i-select v-model.lazy="add_agent_select" size="small" placeholder="">
						<i-option v-for="item in add_agent_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
					</i-select>
				</Form-Item>
				<Form-Item label="发票" style="margin-bottom:0px">
					<!-- <i-select v-model.lazy="add_type_select" multiple size="small" placeholder=""> -->
					<i-select v-model.lazy="add_invoice_select" size="small" placeholder="">
						<i-option v-for="item in add_invoice_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
					</i-select>
				</Form-Item>
				<Form-Item label="类型" style="margin-bottom:0px">
					<i-input v-model.lazy="add_type" size="small"></i-input>
				</Form-Item>
				<Form-Item label="版本" style="margin-bottom:0px">
					<i-input v-model.lazy="add_version" size="small"></i-input>
				</Form-Item>
				<Form-Item label="购买日期" style="margin-bottom:0px">
					<Date-picker v-model.lazy="add_purchasedate" type="daterange" size="small"></Date-picker>
				</Form-Item>
				<Form-Item label="数量" style="margin-bottom:0px">
					<Input-Number v-model.lazy="add_quantity" size="small" :min="1"></Input-Number>
				</Form-Item>
				<Form-Item label="License信息" style="margin-bottom:0px">
					<i-input v-model.lazy="add_licenseinfo" size="small" type="textarea"></i-input>
				</Form-Item>
				<Form-Item label="备注" style="margin-top:5px" >
					<i-input v-model.lazy="add_comments" size="small" type="textarea"></i-input>
				</Form-Item>

			</i-form>


		</i-col>





		<i-col span="16">
		&nbsp;
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
		
		sideractivename: '2-2',
		sideropennames: ['2'],
		
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
			// {label: 'lenovo', value: 1},
			// {label: 'dell', value: 2},
		],
		add_invoice_select: '',
		add_invoice_options: [
			// {label: 'invoice1', value: 1},
			// {label: 'invoice2', value: 2},
		],
		add_purchasedate: '',
		add_version: '',
		add_quantity: '1',
		add_type: '',
		add_licenseinfo: '',
		add_comments: '',







		

		
		
		
		
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
			_this.add_type_select = '';
			_this.add_purchasedate = '';
			_this.add_version = '';
			_this.add_quantity = '';
		},


		//新增
		add_create () {
			var _this = this;
			_this.add_create_disabled = true;

			var add_title = _this.add_title;
			var add_type_select = _this.add_type_select;
			var add_purchasedate = _this.add_purchasedate;
			var add_version = _this.add_version;
			var add_quantity = _this.add_quantity;

			if (add_title == '' || add_title == undefined) {
				_this.error(false, '错误', '内容为空或不正确！');
				_this.add_create_disabled = false;
				return false;
			}
// console.log(add_itemtype_select);return false;

			var url = "{{ route('agent.create') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				add_title: add_title,
				add_type_select: add_type_select,
				add_purchasedate: add_purchasedate,
				add_version: add_version,
				add_quantity: add_quantity,
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

		// 获取发票列表
		invoicesgets (page, last_page){
			var _this = this;
			var url = "{{ route('invoice.gets') }}";
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
					_this.add_invoice_options = _this.json2selectvalue(response.data.data);
				}
			})
			.catch(function (error) {
				// _this.error(false, 'Error', error);
			})
		},




	
		











		

		


	},
	mounted: function(){
		var _this = this;
		_this.loadingbarstart();
		_this.current_nav = '软件';
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

		// 获取发票列表
		_this.invoicesgets();





		_this.loadingbarfinish();

	}
});
</script>
@endsection