@extends('employee.layouts.mainbase')

@section('my_title')
使用者添加 - 
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
<!-- <Divider orientation="left">使用者添加</Divider> -->

<i-row>

	<i-col span="24">
		<Divider orientation="left">使用者属性</Divider>

		↓ 批量录入&nbsp;&nbsp;
		<Input-number v-model.lazy="piliangluruxiang_employees" @on-change="value=>piliangluru_generate_employees(value)" :min="1" :max="10" size="small" style="width: 60px"></Input-number>
		&nbsp;项（最多10项）&nbsp;&nbsp;<br>
		<br>

		<span v-for="(item, index) in piliangluru_employees">
		<i-form :label-width="80" ref="item" :model="item" :rules="ruleValidate">
		<i-row>
			<i-col span="1">
				<label class="ivu-form-item-label">
					No.@{{index+1}}
				</label>
			</i-col>
			<i-col span="5">
				<Form-Item label="姓名" prop="name" style="margin-bottom:0px">
					<i-input v-model.lazy="item.name" size="small"></i-input>
				</Form-Item>
			</i-col>
			<i-col span="5">
				<Form-Item label="使用者ID" prop="userid" style="margin-bottom:0px">
					<i-input v-model.lazy="item.userid" size="small"></i-input>
				</Form-Item>
			</i-col>
			<i-col span="5">
				<Form-Item label="部门" prop="department" style="margin-bottom:0px">
					<i-input v-model.lazy="item.department" size="small"></i-input>
				</Form-Item>
			</i-col>
			<i-col span="5">
				<Form-Item label="电子邮件" prop="email" style="margin-bottom:0px">
					<i-input v-model="item.email" size="small"></i-input>
				</Form-Item>
			</i-col>
			<i-col span="3">
				<Form-Item label="性别" style="margin-bottom:0px">
					<i-switch v-model.lazy="item.gender">
						<span slot="open">男</span>
						<span slot="close">女</span>
					</i-switch>
				</Form-Item>
			</i-col>
		</i-row>
		</i-form>&nbsp;
		</span>

	</i-col>

</i-row>


<Divider dashed></Divider>

<i-button @click="add_create()" :disabled="add_create_disabled" icon="md-add" size="large" type="primary">添加</i-button>
&nbsp;&nbsp;

<i-button @click="employees_employees()" icon="md-search" size="large">跳转至查询</i-button>

&nbsp;




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
		
		sideractivename: '9-2',
		sideropennames: ['9'],
		
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
			{label: '售卖方 - Vendor', value: 1},
			{label: '软件销售商 - S/W Manufacturer', value: 2},
			{label: '硬件销售商 - H/W Manufacturer', value: 3},
			{label: '购买方 - Buyer', value: 4},
			{label: '承包商 - Contractor', value: 5},
		],
		add_contactinfo: '',
		add_contacts: [],
		add_urls: [],

		// 批量录入项 - 联络方式
		piliangluruxiang_employees: 1,
		// 批量录入 - 联络方式
		piliangluru_employees: [
			{
				name: '',
				userid: '',
				email: '',
				department: '',
				gender: true
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



		ruleValidate: {
			name: [
				{ required: true, message: '姓名不可为空', trigger: 'blur' }
			],
			userid: [

			],
			department: [

			],
			// 变量名和校验规则名必须一致，比如 item.email 和 email
			email: [
				{ type: 'email', message: '邮件地址格式不正确', trigger: 'blur' }
			],
		},

		

		
		
		
		
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
			this.piliangluru_employees = [
				{
					name: '',
					userid: '',
					email: '',
					department: '',
					gender: true,
				}
			];
			this.piliangluruxiang_employees = 1;
		},


		//新增
		add_create () {
			var _this = this;
			_this.add_create_disabled = true;

			// 删除空json节点
			var piliangluru_tmp_employees = [];
			for (var v of _this.piliangluru_employees) {
				if (v.name == '' || v.name == undefined) {
				} else {
					// v.gender = v.gender ? 1 : 0;
					piliangluru_tmp_employees.push(v);
				}
			}
			var add_employees = piliangluru_tmp_employees;

			// if (add_title == '' || add_title == undefined) {
			// 	_this.error(false, '错误', '内容为空或不正确！');
			// 	_this.add_create_disabled = false;
			// 	return false;
			// }

			var url = "{{ route('employee.create') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				add_employees: add_employees,
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
				} else {
					_this.error(false, '失败', '添加失败！姓名或电子邮件可能已存在！');
				}
				_this.add_create_disabled = false;
			})
			.catch(function (error) {
				_this.error(false, '错误', '添加失败！姓名或电子邮件可能已存在！');
				_this.add_create_disabled = false;
			})

			

		},


		// 生成piliangluru 联系方式
		piliangluru_generate_employees (counts) {
			if (counts == undefined) counts = 1;
			var len = this.piliangluru_employees.length;
			
			if (counts > len) {
				for (var i=0;i<counts-len;i++) {
					this.piliangluru_employees.push(
						{
							name: '',
							userid: '',
							email: '',
							department: '',
							gender: true
						}
					);
				}
			} else if (counts < len) {
				if (this.piliangluruxiang_employees != '') {
					for (var i=counts;i<len;i++) {
						if (this.piliangluruxiang_employees == this.piliangluru_employees[i].value) {
							this.piliangluruxiang_employees = '';
							break;
						}
					}
				}
				
				for (var i=0;i<len-counts;i++) {
					this.piliangluru_employees.pop();
				}
			}			
		},	

		// 生成piliangluru 网站
		piliangluru_generate_urls (counts) {
			if (counts == undefined) counts = 1;
			var len = this.piliangluru_urls.length;
			
			if (counts > len) {
				for (var i=0;i<counts-len;i++) {
					// this.piliangluru.push({value: 'piliangluru'+parseInt(len+i+1)});
					this.piliangluru_urls.push(
						{
							description: '',
							url: '',
						}
					);
				}
			} else if (counts < len) {
				if (this.piliangluruxiang_urls != '') {
					for (var i=counts;i<len;i++) {
						if (this.piliangluruxiang_urls == this.piliangluru_urls[i].value) {
							this.piliangluruxiang_urls = '';
							break;
						}
					}
				}
				
				for (var i=0;i<len-counts;i++) {
					this.piliangluru_urls.pop();
				}
			}			

		},	
		

		// 跳转至查询页面
		employees_employees () {
			window.location.href = "{{ route('employee.employees') }}";
		},





		

		


	},
	mounted: function(){
		var _this = this;
		_this.loadingbarstart();
		_this.current_nav = '使用者';
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