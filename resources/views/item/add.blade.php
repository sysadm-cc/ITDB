@extends('item.layouts.mainbase')

@section('my_title')
物品添加 - 
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
<!-- <Divider orientation="left">物品添加</Divider> -->
&nbsp;<br>

<Tabs type="card" v-model="currenttabs">
	<Tab-pane label="物品数据">

		<i-row :gutter="16">

			<i-col span="5">
				<Divider size="default" orientation="left">属性</Divider>
				
				<i-form :label-width="100">
					<Form-Item label="物品名称" required style="margin-bottom:0px">
						<i-input v-model.lazy="add_title" size="small"></i-input>
					</Form-Item>
					<Form-Item label="物品类型" required style="margin-bottom:0px">
						<i-select v-model.lazy="add_itemtype_select" size="small" placeholder="">
							<i-option v-for="item in add_itemtype_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="是否部件" required style="margin-bottom:0px">
						<i-switch v-model.lazy="add_ispart">
							<span slot="open">是</span>
							<span slot="close">否</span>
						</i-switch>
					</Form-Item>
					<Form-Item label="是否机架式" required style="margin-bottom:0px">
						<i-switch v-model.lazy="add_rackmountable">
							<span slot="open">是</span>
							<span slot="close">否</span>
						</i-switch>
					</Form-Item>
					<Form-Item label="代理商" required style="margin-bottom:0px">
						<i-select v-model.lazy="add_agent_select" size="small" placeholder="">
							<i-option v-for="item in add_agent_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="型号" required style="margin-bottom:0px">
						<i-input v-model.lazy="add_model" size="small"></i-input>
					</Form-Item>
					<Form-Item label="尺寸(U)" style="margin-bottom:0px">
						<i-select v-model.lazy="add_usize_select" size="small" placeholder="">
							<i-option v-for="item in add_usize_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="资产标签" style="margin-bottom:0px">
						<i-input v-model.lazy="add_assettag" size="small"></i-input>
					</Form-Item>
					<Form-Item label="S/N 1" style="margin-bottom:0px">
						<i-input v-model.lazy="add_sn1" size="small" placeholder="序列号一"></i-input>
					</Form-Item>
					<Form-Item label="S/N 2" style="margin-bottom:0px">
						<i-input v-model.lazy="add_sn2" size="small" placeholder="序列号二"></i-input>
					</Form-Item>
					<Form-Item label="Service Tag" style="margin-bottom:0px">
						<i-input v-model.lazy="add_servicetag" size="small" placeholder="服务编号"></i-input>
					</Form-Item>
					<Form-Item label="备注" style="margin-bottom:0px">
						<i-input v-model.lazy="add_comments" size="small" type="textarea" :rows="4"></i-input>
					</Form-Item>

				</i-form>


			</i-col>

			<i-col span="1">
			&nbsp;
			</i-col>

			<i-col span="5">
				<Divider size="default" orientation="left">使用</Divider>
				<i-form :label-width="100">
					<Form-Item label="状态" required style="margin-bottom:0px">
						<i-select v-model.lazy="add_status_select" size="small" placeholder="">
							<i-option v-for="item in add_status_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="使用者" style="margin-bottom:0px">
						<i-select v-model.lazy="add_user_select" size="small" placeholder="">
							<i-option v-for="item in add_user_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="位置/楼层" style="margin-bottom:0px">
						<i-select v-model.lazy="add_location_select" @on-change="onchange_location" size="small" placeholder="">
							<i-option v-for="item in add_location_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="区域/房间" style="margin-bottom:0px">
						<i-select v-model.lazy="add_area_select" size="small" placeholder="" not-found-text="请先选择位置/楼层">
							<i-option v-for="item in add_area_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="机柜" style="margin-bottom:0px">
						<i-select v-model.lazy="add_rack_select" size="small" placeholder="">
							<i-option v-for="item in add_rack_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="所在机架高度" style="margin-bottom:0px">
						<i-select v-model.lazy="add_rackposition_select1" size="small" placeholder="">
							<i-option v-for="item in add_rackposition_options1" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="所在机架深度" style="margin-bottom:0px">
						<i-select v-model.lazy="add_rackposition_select2" size="small" placeholder="">
							<i-option v-for="item in add_rackposition_options2" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
						<span style="color: rgb(158, 167, 180);font-size:12px;">
							<Icon type="md-information-circle"></Icon> FMB - 前中后
						</span>
					</Form-Item>
					<Form-Item label="功能用途" style="margin-bottom:0px">
						<i-input v-model.lazy="add_function" size="small"></i-input>
					</Form-Item>
					<Form-Item label="具体使用说明" style="margin-bottom:0px">
						<i-input v-model.lazy="add_maintenanceinstructions" size="small" type="textarea" :rows="4"></i-input>
					</Form-Item>

				</i-form>
				
			</i-col>

			<i-col span="1">
			&nbsp;
			</i-col>

			<i-col span="5">
				<Divider orientation="left">保修</Divider>
					<i-form :label-width="100">
					<Form-Item label="供货商" style="margin-bottom:0px">
						<i-input v-model.lazy="add_shop" size="small"></i-input>
					</Form-Item>
					<Form-Item label="购买价格" style="margin-bottom:0px">
						<i-input v-model.lazy="add_purchaceprice" size="small"></i-input>
					</Form-Item>
					<Form-Item label="购买日期" style="margin-bottom:0px">
						<Date-Picker v-model.lazy="add_dateofpurchase" type="date" placeholder="" size="small"></Date-Picker>
					</Form-Item>
					<Form-Item label="保修时长(月)" style="margin-bottom:0px">
						<i-input v-model.lazy="add_warrantymonths" size="small"></i-input>
					</Form-Item>
					<Form-Item label="保修信息" style="margin-bottom:0px">
						<i-input v-model.lazy="add_warrantyinfo" size="small" type="textarea"></i-input>
					</Form-Item>

				</i-form>

				<br>
				
				<Divider orientation="left">配件</Divider>
				<i-form :label-width="100">
					<Form-Item label="硬盘" style="margin-bottom:0px">
						<i-input v-model.lazy="add_harddisk" size="small"></i-input>
					</Form-Item>
					<Form-Item label="内存" style="margin-bottom:0px">
						<i-input v-model.lazy="add_ram" size="small"></i-input>
					</Form-Item>
					<Form-Item label="CPU型号" style="margin-bottom:0px">
						<i-input v-model.lazy="add_cpumodel" size="small"></i-input>
					</Form-Item>
					<Form-Item label="CPU数量" style="margin-bottom:0px">
						<i-select v-model.lazy="add_cpus_select" size="small" placeholder="">
							<i-option v-for="item in add_cpus_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="CPU内核数" style="margin-bottom:0px">
						<i-select v-model.lazy="add_cpucores_select" size="small" placeholder="">
							<i-option v-for="item in add_cpucores_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>

				</i-form>
				
				
			</i-col>

			<i-col span="1">
			&nbsp;
			</i-col>

			<i-col span="5">
				<Divider size="default" orientation="left">网络</Divider>

				<i-form :label-width="100">
					<Form-Item label="域名" style="margin-bottom:0px">
						<i-input v-model.lazy="add_dns" size="small"></i-input>
					</Form-Item>
					<Form-Item label="有线MAC地址" style="margin-bottom:0px">
						<i-input v-model.lazy="add_maclan" size="small"></i-input>
					</Form-Item>
					<Form-Item label="无线MAC地址" style="margin-bottom:0px">
						<i-input v-model.lazy="add_macwl" size="small"></i-input>
					</Form-Item>
					<Form-Item label="有线IPV4" style="margin-bottom:0px">
						<i-input v-model.lazy="add_ipv4lan" size="small"></i-input>
					</Form-Item>
					<Form-Item label="无线IPV4" style="margin-bottom:0px">
						<i-input v-model.lazy="add_ipv4wl" size="small"></i-input>
					</Form-Item>
					<Form-Item label="有线IPV6" style="margin-bottom:0px">
						<i-input v-model.lazy="add_ipv6lan" size="small"></i-input>
					</Form-Item>
					<Form-Item label="无线IPV6" style="margin-bottom:0px">
						<i-input v-model.lazy="add_ipv6wl" size="small"></i-input>
					</Form-Item>
					<Form-Item label="远程管理IP" style="margin-bottom:0px">
						<i-input v-model.lazy="add_remoteadminip" size="small"></i-input>
					</Form-Item>
					<Form-Item label="面板端口" style="margin-bottom:0px">
						<i-input v-model.lazy="add_panelport" size="small"></i-input>
					</Form-Item>
					<Form-Item label="交换机" style="margin-bottom:0px">
						<i-select v-model.lazy="add_switch_select" size="small" placeholder="">
							<i-option v-for="item in add_switch_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="交换机端口" style="margin-bottom:0px">
						<i-input v-model.lazy="add_switchport" size="small"></i-input>
					</Form-Item>
					<Form-Item label="网络端口数" style="margin-bottom:0px">
						<i-select v-model.lazy="add_networkports_select" size="small" placeholder="">
							<i-option v-for="item in add_networkports_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>

				</i-form>

				<br>

				<!-- <Divider size="default" orientation="left">记账</Divider> -->

				<!-- <i-form :label-width="100">
					<Form-Item label="供货商/区域" style="margin-bottom:0px">
						<i-input v-model.lazy="add_shop" size="small"></i-input>
					</Form-Item>
					<Form-Item label="购买价格" style="margin-bottom:0px">
						<i-input v-model.lazy="add_purchaceprice" size="small"></i-input>
					</Form-Item>

				</i-form> -->
				
			</i-col>

			<i-col span="1">
			&nbsp;
			</i-col>

		</i-row>

	</Tab-pane>

	<Tab-pane label="aaa">
		aaa
	</Tab-pane>

</Tabs>


<Divider dashed></Divider>

<i-button @click="add_create()" :disabled="add_create_disabled" icon="md-add" size="large" type="primary">添加</i-button>

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
		
		sideractivename: '1-2',
		sideropennames: ['1'],
		
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

		// 参数变量 - 属性
		add_title: '',
		add_itemtype_select: '',
		add_itemtype_options: [
			// {label: 'fax', value: 1},
			// {label: 'pc', value: 2}
		],
		add_ispart: false,
		add_rackmountable: false,
		add_agent_select: '',
		add_agent_options: [
			// {label: 'lenovo', value: 1},
			// {label: 'dell', value: 2},
		],
		add_model: '',
		add_usize_select: '',
		add_usize_options: [],
		add_sn1: '',
		add_sn2: '',
		add_servicetag: '',
		add_comments: '',
		add_assettag: '',

		// 参数变量 - 使用
		add_status_select: '',
		add_status_options: [
			// {label: '使用中', value: 1},
		],
		add_user_select: '',
		add_user_options: [
			{label: 'admin', value: 1},
			{label: 'user', value: 2},
			{label: 3, value: 3},
		],
		add_location_select: '',
		add_location_options: [
			// {label: '主楼，三楼', value: 1},
		],
		add_area_select: '',
		add_area_options: [
			// {label: '6号房间', value: 1},
		],
		add_rack_select: '',
		add_rack_options: [
			// {label: '一号机柜', value: 1},
		],
		add_rackposition_select1: '',
		add_rackposition_options1: [
			// {label: 1, value: 1},
			// {label: 2, value: 2},
			// {label: 3, value: 3},
		],
		add_rackposition_select2: '',
		add_rackposition_options2: [
			{label: 'FM-', value: 'FM-'},
			{label: '-MB', value: '-MB'},
			{label: 'F--', value: 'F--'},
			{label: '-M-', value: '-M-'},
			{label: '--B', value: '--B'},
			{label: 'FMB', value: 'FMB'},
		],
		add_function: '',
		add_maintenanceinstructions: '',

		// 参数变量 - 保修
		add_shop: '',
		add_purchaceprice: '',
		add_dateofpurchase: '',
		add_warrantymonths: '',
		add_warrantyinfo: '',

		// 参数变量 - 配件
		add_harddisk: '',
		add_ram: '',
		add_cpumodel: '',
		add_cpus_select: '',
		add_cpus_options: [
			{label: 1, value: 1},
			{label: 2, value: 2},
			{label: 3, value: 3},
		],
		add_cpucores_select: '',
		add_cpucores_options: [
			{label: 1, value: 1},
			{label: 2, value: 2},
			{label: 3, value: 3},
		],

		// 参数变量 - 网络
		add_dns: '',
		add_maclan: '',
		add_macwl: '',
		add_ipv4lan: '',
		add_ipv4wl: '',
		add_ipv6lan: '',
		add_ipv6wl: '',
		add_remoteadminip: '',
		add_panelport: '',
		add_switch_select: '',
		add_switch_options: [
			{label: 1, value: 1},
			{label: 2, value: 2},
			{label: 3, value: 3},
		],
		add_switchport: '',
		add_networkports_select: '',
		add_networkports_options: [
			{label: 1, value: 1},
			{label: 2, value: 2},
			{label: 3, value: 3},
		],








		
		
		
		
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

			// 参数变量 - 属性
			_this.add_title = '';
			_this.add_itemtype_select = '';
			_this.add_ispart = false;
			_this.add_rackmountable = false;
			_this.add_agent_select = '';
			_this.add_model = '';
			_this.add_usize_select = '';
			_this.add_sn1 = '';
			_this.add_sn2 = '';
			_this.add_servicetag = '';
			_this.add_comments = '';
			_this.add_assettag = '';

			// 参数变量 - 使用
			_this.add_status_select = '';
			_this.add_user_select = '';
			_this.add_location_select = '';
			_this.add_area_select = '';
			_this.add_rack_select = '';
			_this.add_rackposition_select1 = '';
			_this.add_rackposition_select2 = '';
			_this.add_function = '';
			_this.add_maintenanceinstructions = '';

			// 参数变量 - 保修
			_this.add_shop = '';
			_this.add_purchaceprice ='';	
			_this.add_dateofpurchase = '';
			_this.add_warrantymonths = '';
			_this.add_warrantyinfo = '';

			// 参数变量 - 配件
			_this.add_harddisk = '';
			_this.add_ram = '';
			_this.add_cpumodel = '';
			_this.add_cpus_select = '';
			_this.add_cpucores_select = '';

			// 参数变量 - 网络
			_this.add_dns = '';
			_this.add_maclan = '';
			_this.add_macwl = '';
			_this.add_ipv4lan = '';
			_this.add_ipv4wl = '';
			_this.add_ipv6lan = '';
			_this.add_ipv6wl = '';
			_this.add_remoteadminip = '';
			_this.add_panelport = '';
			_this.add_switch_select = '';
			_this.add_switchport = '';
			_this.add_networkports_select = '';

		},


		//新增
		add_create () {
			var _this = this;
			_this.add_create_disabled = true;

			// 参数变量 - 属性
			var add_title = _this.add_title;
			var add_itemtype_select = _this.add_itemtype_select;
			var add_ispart = _this.add_ispart;
			var add_rackmountable = _this.add_rackmountable;
			var add_agent_select = _this.add_agent_select;
			var add_model = _this.add_model;
			var add_usize_select = _this.add_usize_select;
			var add_sn1 = _this.add_sn1;
			var add_sn2 = _this.add_sn2;
			var add_servicetag = _this.add_servicetag;
			var add_comments = _this.add_comments;
			var add_assettag = _this.add_assettag;

			// 参数变量 - 使用
			var add_status_select = _this.add_status_select;
			var add_user_select = _this.add_user_select;
			var add_location_select = _this.add_location_select;
			var add_area_select = _this.add_area_select;
			var add_rack_select = _this.add_rack_select;
			var add_rackposition_select1 = _this.add_rackposition_select1;
			var add_rackposition_select2 = _this.add_rackposition_select2;
			var add_function = _this.add_function;
			var add_maintenanceinstructions = _this.add_maintenanceinstructions;

			// 参数变量 - 保修
			var add_shop = _this.add_shop;
			var add_purchaceprice = _this.add_purchaceprice;
			var add_dateofpurchase = _this.add_dateofpurchase ? new Date(_this.add_dateofpurchase).Format("yyyy-MM-dd") : '';
			var add_warrantymonths = _this.add_warrantymonths;
			var add_warrantyinfo = _this.add_warrantyinfo;

			// 参数变量 - 配件
			var add_harddisk = _this.add_harddisk;
			var add_ram = _this.add_ram;
			var add_cpumodel = _this.add_cpumodel;
			var add_cpus_select = _this.add_cpus_select;
			var add_cpucores_select = _this.add_cpucores_select;

			// 参数变量 - 网络
			var add_dns = _this.add_dns;
			var add_maclan = _this.add_maclan;
			var add_macwl = _this.add_macwl;
			var add_ipv4lan = _this.add_ipv4lan;
			var add_ipv4wl = _this.add_ipv4wl;
			var add_ipv6lan = _this.add_ipv6lan;
			var add_ipv6wl = _this.add_ipv6wl;
			var add_remoteadminip = _this.add_remoteadminip;
			var add_panelport = _this.add_panelport;
			var add_switch_select = _this.add_switch_select;
			var add_switchport = _this.add_switchport;
			var add_networkports_select = _this.add_networkports_select;

			if (add_title == '' || add_title == undefined
				|| add_itemtype_select == '' || add_itemtype_select == undefined
				|| add_agent_select == '' || add_agent_select == undefined
				|| add_model == '' || add_model == undefined
				|| add_status_select == '' || add_status_select == undefined) {
				_this.error(false, '错误', '内容为空或不正确！');
				_this.add_create_disabled = false;
				return false;
			}
// console.log(add_itemtype_select);return false;

			var url = "{{ route('item.addcreate') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				// 参数变量 - 属性
				add_title: add_title,
				add_itemtype_select: add_itemtype_select,
				add_ispart: add_ispart,
				add_rackmountable: add_rackmountable,
				add_agent_select: add_agent_select,
				add_model: add_model,
				add_usize_select: add_usize_select,
				add_sn1: add_sn1,
				add_sn2: add_sn2,
				add_servicetag: add_servicetag,
				add_comments: add_comments,
				add_assettag: add_assettag,

				// 参数变量 - 使用
				add_status_select: add_status_select,
				add_user_select: add_user_select,
				add_location_select: add_location_select,
				add_area_select: add_area_select,
				add_rack_select: add_rack_select,
				add_rackposition_select1: add_rackposition_select1,
				add_rackposition_select2: add_rackposition_select2,
				add_function: add_function,
				add_maintenanceinstructions: add_maintenanceinstructions,

				// 参数变量 - 保修
				add_shop: add_shop,
				add_purchaceprice: add_purchaceprice,
				add_dateofpurchase: add_dateofpurchase,
				add_warrantymonths: add_warrantymonths,
				add_warrantyinfo: add_warrantyinfo,

				// 参数变量 - 配件
				add_harddisk: add_harddisk,
				add_ram: add_ram,
				add_cpumodel: add_cpumodel,
				add_cpus_select: add_cpus_select,
				add_cpucores_select: add_cpucores_select,

				// 参数变量 - 网络
				add_dns: add_dns,
				add_maclan: add_maclan,
				add_macwl: add_macwl,
				add_ipv4lan: add_ipv4lan,
				add_ipv4wl: add_ipv4wl,
				add_ipv6lan: add_ipv6lan,
				add_ipv6wl: add_ipv6wl,
				add_remoteadminip: add_remoteadminip,
				add_panelport: add_panelport,
				add_switch_select: add_switch_select,
				add_switchport: add_switchport,
				add_networkports_select: add_networkports_select,

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
					_this.error(false, '失败', '添加失败！');
				}
				_this.add_create_disabled = false;
			})
			.catch(function (error) {
				_this.error(false, '错误', '添加失败！');
				_this.add_create_disabled = false;
			})

			

		},


		// 获取物品类型列表
		itemtypesgets () {
			var _this = this;
			var url = "{{ route('item.itemtypesgets') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url)
			.then(function (response) {
				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				if (response.data) {
					response.data.data.map(function (v, i) {
						_this.add_itemtype_options.push({label: v.typedesc, value: v.id});
					});
				}
			})
			.catch(function (error) {
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
					// _this.add_agentid_options = _this.json2selectvalue(response.data.data);
					response.data.data.map(function (v, i) {
						_this.add_agent_options.push({label: v.title, value: v.id});
					});

				}
			})
			.catch(function (error) {
				// _this.error(false, 'Error', error);
			})
		},


		// 获取使用状态
		statustypesgets (page, last_page){
			var _this = this;
			var url = "{{ route('item.statustypesgets') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					perPage: 1000,
					page: 1,
				}
			})
			.then(function (response) {
				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				if (response.data) {
					response.data.data.map(function (v, i) {
						_this.add_status_options.push({label: v.statusdesc, value: v.id});
					});
				}
			})
			.catch(function (error) {
				// _this.error(false, 'Error', error);
			})
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
					response.data.data.map(function (v, i) {
						_this.add_location_options.push({value: v.id, label: v.title+' ('+v.building+' / '+v.floor+')'});
					});
				}
			})
			.catch(function (error) {
				// _this.error(false, 'Error', error);
			})
		},

		// 根据位置查询区域/房间
		onchange_location () {
			var _this = this;
			
			var locationid = _this.add_location_select;
			
			if (locationid == '' || locationid == undefined) {
				return false;
			}
			
			var url = "{{ route('rack.location2area') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					locationid: locationid,
				}
			})
			.then(function (response) {
				// console.log(response.data.areas);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}

				if (response.data) {
					_this.add_area_select = '';
					_this.add_area_options = [];
					response.data.areas.map(function (v, i) {
						_this.add_area_options.push({value: i, label: v.name+' [x1: '+v.x1+',y1: '+v.y2+'], [x2: '+v.x2+',y2: '+v.y2+'])'});
					});
				}
			})
			.catch(function (error) {
				// this.error(false, 'Error', error);
			})
		},
	
		// 获取机柜列表
		racksgets () {
			var _this = this;
			var url = "{{ route('rack.gets') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					perPage: 1000,
					page: 1,
				}
			})
			.then(function (response) {
				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}

				if (response.data) {
					response.data.data.map(function (v, i) {
						_this.add_rack_options.push({label: v.title, value: v.id});
					});
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
		_this.current_nav = '硬件';
		_this.current_subnav = '物品添加';

		// // 显示所有
		// _this.itemtypesgets(1, 1); // page: 1, last_page: 1
		// _this.loadapplicantgroup();

		// GetCurrentDatetime('getcurrentdatetime');

		

		for (var i=1;i<=44;i++) {
			_this.add_usize_options.push({label: i, value: i});
		}

		for (var i=1;i<=50;i++) {
			_this.add_rackposition_options1.push({label: i, value: i});
		}

		// 获取物品类型列表
		_this.itemtypesgets();

		// 获取制造商列表
		_this.agentsgets();

		// 获取使用状态列表
		_this.statustypesgets();

		// 获取位置列表
		_this.locationsgets();

		// 获取机柜列表
		_this.racksgets();




		_this.loadingbarfinish();

	}
});
</script>
@endsection