@extends('contract.layouts.mainbase')

@section('my_title')
合同添加 - 
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
<!-- <Divider orientation="left">合同添加</Divider> -->
&nbsp;<br>



	<i-row :gutter="16">

		<i-col span="9">
			
			<Divider orientation="left">合同属性</Divider>

			<i-form :label-width="100">
				<Form-Item label="名称" required style="margin-bottom:0px">
					<i-input v-model.lazy="add_title" size="small"></i-input>
				</Form-Item>
				<Form-Item label="类型" required style="margin-bottom:0px">
					<!-- <i-select v-model.lazy="add_type_select" multiple size="small" placeholder=""> -->
					<i-select v-model.lazy="add_type_select" size="small" placeholder="">
						<i-option v-for="item in add_type_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
					</i-select>
				</Form-Item>
				<Form-Item label="合同编号" style="margin-bottom:0px">
					<i-input v-model.lazy="add_number" size="small"></i-input>
				</Form-Item>
				<Form-Item label="备注" style="margin-bottom:0px">
					<i-input v-model.lazy="add_comments" size="small"></i-input>
				</Form-Item>
				<Form-Item label="总价值(¥)" style="margin-bottom:0px">
					<Input-Number v-model.lazy="add_totalcost" size="small" :min="1"></Input-Number>
				</Form-Item>
				<Form-Item label="开始日期" style="margin-bottom:0px">
					<Date-picker v-model.lazy="add_startdate" type="datetime" size="small"></Date-picker>
				</Form-Item>
				<Form-Item label="结束日期" style="margin-bottom:0px">
					<Date-picker v-model.lazy="add_currentenddate" type="datetime" size="small"></Date-picker>
				</Form-Item>
				<Form-Item label="详细内容" style="margin-bottom:0px">
					<i-input v-model.lazy="add_description" size="small" type="textarea"></i-input>
				</Form-Item>
			</i-form>&nbsp;

		</i-col>

		<i-col span="1">
		&nbsp;
		</i-col>

		<i-col span="14">
		
			<Divider orientation="left">合同续约</Divider>

			↓ 批量录入&nbsp;&nbsp;
			<Input-number v-model.lazy="piliangluruxiang_renewals" @on-change="value=>piliangluru_generate_renewals(value)" :min="1" :max="10" size="small" style="width: 60px"></Input-number>
			&nbsp;项（最多10项）&nbsp;&nbsp;<br>

			<span v-for="(item, index) in piliangluru_renewals">
			<br>
			<i-form :label-width="100">
			<i-row>
				<i-col span="1">
					<label class="ivu-form-item-label">
						No.@{{index+1}}
					</label>
				</i-col>
				<i-col span="23">
					<i-row>
						<i-col span="12">
							<Form-Item label="续约开始日期" style="margin-bottom:0px">
								<Date-picker v-model.lazy="item.enddatebefore" type="datetime" size="small"></Date-picker>
							</Form-Item>
							<Form-Item label="续约结束日期" style="margin-bottom:0px">
								<Date-picker v-model.lazy="item.enddateafter" type="datetime" size="small"></Date-picker>
							</Form-Item>
							<Form-Item label="生效日期" style="margin-bottom:0px">
								<Date-picker v-model.lazy="item.effectivedate" type="datetime" size="small"></Date-picker>
							</Form-Item>
						</i-col>
						<i-col span="12">
							<Form-Item label="备注" style="margin-bottom:0px">
								<i-input v-model.lazy="item.notes" size="small" type="textarea" rows="3"></i-input>
							</Form-Item>
						</i-col>
					</i-row>
			</i-row>
			</i-form>

		</i-col>

	</i-row>

&nbsp;

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
		
		sideractivename: '4-2',
		sideropennames: ['4'],
		
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
		add_type_select: '',
		add_type_options: [
			{label: '支持维护', value: 1},
			{label: '维修保养', value: 2},
		],
		add_number: '',
		add_description: '',
		add_comments: '',
		add_totalcost: '',
		add_startdate: '',
		add_currentenddate: '',
		// add_renewals: '',

		// 批量录入项 - Renewals
		piliangluruxiang_renewals: 1,
		// 批量录入 - Renewals
		piliangluru_renewals: [
			{
				enddatebefore: '',
				enddateafter: '',
				effectivedate: '',
				notes: '',
			},
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
		json2selectvalue (json, key) {
			var arr = [];
			for (var k in json) {
				// alert(key);
				// alert(json[key]);
				// arr.push({ obj.['value'] = key, obj.['label'] = json[key] });
				arr.push({ value: ++k, label: json[k].key });
			}
			return arr;
			// return arr.reverse();
		},


		// 清除所有变量
		add_clear_var () {
			var _this = this;
			_this.add_title = '';
			_this.add_type_select = '';
			_this.add_startdate = '';
			_this.add_number = '';
			_this.add_licqty = '';
			_this.add_description = '';
			_this.add_comments = '';
			_this.add_totalcost = '';
			_this.add_startdate = '';
			_this.add_currentenddate = '';
			_this.piliangluruxiang_renewals = 1;
			_this.piliangluru_renewals = [
				{
					enddatebefore: '',
					enddateafter: '',
					effectivedate: '',
					notes: '',
				},
			];
		},


		//新增
		add_create () {
			var _this = this;
			_this.add_create_disabled = true;

			var add_title = _this.add_title;
			var add_type_select = _this.add_type_select;
			var add_number = _this.add_number;
			var add_description = _this.add_description;
			var add_comments = _this.add_comments;
			var add_totalcost = _this.add_totalcost;
			var add_startdate = _this.add_startdate ? new Date(_this.add_startdate).Format("yyyy-MM-dd hh:mm:ss") : '';
			var add_currentenddate = _this.add_currentenddate ? new Date(_this.add_currentenddate).Format("yyyy-MM-dd hh:mm:ss") : '';
			
			// 删除空json节点
			var piliangluru_tmp_renewals = [];
			for (var v of _this.piliangluru_renewals) {
				v.enddatebefore = v.enddatebefore != '' && v.enddatebefore != undefined ? new Date(v.enddatebefore).Format("yyyy-MM-dd hh:mm:ss") : '';
				v.enddateafter = v.enddateafter != '' && v.enddateafter != undefined ? new Date(v.enddateafter).Format("yyyy-MM-dd hh:mm:ss") : '';
				v.effectivedate = v.effectivedate != '' && v.effectivedate != undefined ? new Date(v.effectivedate).Format("yyyy-MM-dd hh:mm:ss") : '';

				// if (v.enddatebefore == '' || v.enddatebefore == undefined
				// 	|| v.enddateafter == '' || v.enddateafter == undefined
				// 	|| v.effectivedate == '' || v.effectivedate == undefined) {
				// } else {
				// 	v.enddatebefore = new Date(v.enddatebefore).Format("yyyy-MM-dd hh:mm:ss");
				// 	v.enddateafter = new Date(v.enddateafter).Format("yyyy-MM-dd hh:mm:ss");
				// 	v.effectivedate = new Date(v.effectivedate).Format("yyyy-MM-dd hh:mm:ss");
					piliangluru_tmp_renewals.push(v);
				// }
			}
			var piliangluru_renewals = piliangluru_tmp_renewals;

			if (add_title == '' || add_title == undefined
				|| add_type_select == '' || add_type_select == undefined) {
				_this.error(false, '错误', '内容为空或不正确！');
				_this.add_create_disabled = false;
				return false;
			}

			var url = "{{ route('contract.create') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				add_title: add_title,
				add_type_select: add_type_select,
				add_number: add_number,
				add_description: add_description,
				add_comments: add_comments,
				add_totalcost: add_totalcost,
				add_startdate: add_startdate,
				add_currentenddate: add_currentenddate,
				add_renewals: piliangluru_renewals,
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


		// 生成piliangluru Renewals
		piliangluru_generate_renewals (counts) {
			if (counts == undefined) counts = 1;
			var len = this.piliangluru_renewals.length;
			
			if (counts > len) {
				for (var i=0;i<counts-len;i++) {
					this.piliangluru_renewals.push(
						{
							enddatebefore: '',
							enddateafter: '',
							effectivedate: '',
							notes: '',
						}
					);
				}
			} else if (counts < len) {
				if (this.piliangluruxiang_urls != '') {
					for (var i=counts;i<len;i++) {
						if (this.piliangluruxiang_urls == this.piliangluru_renewals[i].value) {
							this.piliangluruxiang_urls = '';
							break;
						}
					}
				}
				
				for (var i=0;i<len-counts;i++) {
					this.piliangluru_renewals.pop();
				}
			}			

		},	


		// 获取合同类型列表
		contracttypesgets () {
			var _this = this;
			var url = "{{ route('contracttypes.gets') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					perPage: 1000,
					page: 1,
				}
			})
			.then(function (response) {
				// console.log(response.data.data);return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}

				if (response.data) {
					_this.add_type_options = _this.json2selectvalue(response.data.data, 'name');
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
		_this.current_nav = '合同';
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




		_this.contracttypesgets();


		_this.loadingbarfinish();

	}
});
</script>
@endsection