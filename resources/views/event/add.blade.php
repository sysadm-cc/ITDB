@extends('event.layouts.mainbase')

@section('my_title')
事件添加 - 
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
<!-- <Divider orientation="left">事件添加</Divider> -->

<i-row>

	<i-col span="24">
		<Divider orientation="left">事件属性</Divider>

		↓ 批量录入&nbsp;&nbsp;
		<Input-number v-model.lazy="piliangluruxiang_events" @on-change="value=>piliangluru_generate_events(value)" :min="1" :max="10" size="small" style="width: 60px"></Input-number>
		&nbsp;项（最多10项）&nbsp;&nbsp;<br>

		<span v-for="(item, index) in piliangluru_events">
		<Divider dashed></Divider>
		<i-form :label-width="80" ref="item" :model="item" :rules="ruleValidate">
		<i-row>
			<!-- <i-col span="1">
				<label class="ivu-form-item-label">
					No.@{{index+1}}
				</label>
			</i-col> -->
			<i-col span="5">
				<Form-Item label="事件类型" prop="type" style="margin-bottom:0px">
					<i-input v-model.lazy="item.type" size="small"></i-input>
				</Form-Item>
				<Form-Item label="事件描述" prop="description" style="margin-bottom:0px">
					<i-input v-model.lazy="item.description" size="small"></i-input>
				</Form-Item>
			</i-col>
			<i-col span="5">
				<Form-Item label="开始时间" prop="startdate" style="margin-bottom:0px">
					<i-input v-model="item.startdate" size="small"></i-input>
				</Form-Item>
				<Form-Item label="处理方法" prop="resolution" style="margin-bottom:0px">
					<i-input v-model.lazy="item.resolution" size="small" type="text" :autosize="{minRows: 1,maxRows: 3}"></i-input>
				</Form-Item>
			</i-col>
			<i-col span="5">
				<Form-Item label="结束时间" prop="enddate" style="margin-bottom:0px">
					<i-input v-model="item.enddate" size="small"></i-input>
				</Form-Item>
				<Form-Item label="更换部件" prop="part" style="margin-bottom:0px">
					<i-input v-model.lazy="item.part" size="small"></i-input>
				</Form-Item>
			</i-col>
			<i-col span="5">
				<Form-Item label="维修人员" prop="maintainer" style="margin-bottom:0px">
					<i-input v-model="item.maintainer" size="small"></i-input>
				</Form-Item>
				<Form-Item label="更换部件名称型号" prop="partname" style="margin-bottom:0px">
					<i-input v-model="item.partname" size="small"></i-input>
				</Form-Item>
			</i-col>
			<i-col span="4">
				<Form-Item label="是否修好" style="margin-bottom:0px">
					<i-switch v-model.lazy="item.isok">
						<span slot="open">是</span>
						<span slot="close">否</span>
					</i-switch>
				</Form-Item>
			</i-col>
		</i-row>
		</i-form>
		</span>

	</i-col>

</i-row>


<Divider></Divider>

<i-button @click="add_create()" :disabled="add_create_disabled" icon="md-add" size="large" type="primary">添加</i-button>

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
		
		sideractivename: '10-2',
		sideropennames: ['10'],
		
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
		piliangluruxiang_events: 1,
		// 批量录入 - 联络方式
		piliangluru_events: [
			{
				type: '',
				description: '',
				resolution: '',
				part: '',
				partname: '',
				startdate: '',
				enddate: '',
				maintainer: '',
				isok: true
			},
		],




		ruleValidate: {
			type: [
				{ required: true, message: '事件类型不可为空', trigger: 'blur' }
			],
			description: [

			],
			part: [

			],
			// 变量名和校验规则名必须一致，比如 item.partname 和 partname
			partname: [
				{ type: 'partname', message: '邮件地址格式不正确', trigger: 'blur' }
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
			this.piliangluru_events = [
				{
					type: '',
					description: '',
					resolution: '',
					part: '',
					partname: '',
					startdate: '',
					enddate: '',
					maintainer: '',
					isok: true,
				}
			];
			this.piliangluruxiang_events = 1;
		},


		//新增
		add_create () {
			var _this = this;
			_this.add_create_disabled = true;

			// 删除空json节点
			var piliangluru_tmp_events = [];
			for (var v of _this.piliangluru_events) {
				if (v.type == '' || v.type == undefined) {
				} else {
					// v.isok = v.isok ? 1 : 0;
					piliangluru_tmp_events.push(v);
				}
			}
			var add_events = piliangluru_tmp_events;

			// if (add_title == '' || add_title == undefined) {
			// 	_this.error(false, '错误', '内容为空或不正确！');
			// 	_this.add_create_disabled = false;
			// 	return false;
			// }

			var url = "{{ route('event.create') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				add_events: add_events,
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
		piliangluru_generate_events (counts) {
			if (counts == undefined) counts = 1;
			var len = this.piliangluru_events.length;
			
			if (counts > len) {
				for (var i=0;i<counts-len;i++) {
					this.piliangluru_events.push(
						{
							type: '',
							description: '',
							resolution: '',
							part: '',
							partname: '',
							startdate: '',
							enddate: '',
							maintainer: '',
							isok: true
						}
					);
				}
			} else if (counts < len) {
				if (this.piliangluruxiang_events != '') {
					for (var i=counts;i<len;i++) {
						if (this.piliangluruxiang_events == this.piliangluru_events[i].value) {
							this.piliangluruxiang_events = '';
							break;
						}
					}
				}
				
				for (var i=0;i<len-counts;i++) {
					this.piliangluru_events.pop();
				}
			}			
		},	


		











		

		


	},
	mounted: function(){
		var _this = this;
		_this.loadingbarstart();
		_this.current_nav = '事件';
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