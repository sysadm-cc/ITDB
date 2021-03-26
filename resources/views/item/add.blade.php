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
					<Form-Item label="* 项目类型" style="margin-bottom:0px">
						<i-select v-model.lazy="add_itemtype_select" size="small" placeholder="选择">
							<i-option v-for="item in add_itemtype_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="* 是否部件" style="margin-bottom:0px">
						<i-switch v-model.lazy="add_ispart">
							<span slot="open">是</span>
							<span slot="close">否</span>
						</i-switch>
					</Form-Item>
					<Form-Item label="* 是否机架式" style="margin-bottom:0px">
						<i-switch v-model.lazy="add_rackmountable">
							<span slot="open">是</span>
							<span slot="close">否</span>
						</i-switch>
					</Form-Item>
					<Form-Item label="* 制造商" style="margin-bottom:0px">
						<i-select v-model.lazy="add_manufact_select" size="small" placeholder="选择制造商">
							<i-option v-for="item in add_manufact_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="* 型号" style="margin-bottom:0px">
						<i-input v-model.lazy="add_model" size="small"></i-input>
					</Form-Item>
					<Form-Item label="尺寸(U)" style="margin-bottom:0px">
						<i-select v-model.lazy="add_size_select" size="small" placeholder="选择">
							<i-option v-for="item in add_size_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
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
						<i-input v-model.lazy="add_comments" size="small" type="textarea"></i-input>
					</Form-Item>
					<Form-Item label="标签" style="margin-bottom:0px">
						<i-input v-model.lazy="add_label" size="small"></i-input>
					</Form-Item>

				</i-form>


			</i-col>

			<i-col span="1">
			&nbsp;
			</i-col>

			<i-col span="5">
				<Divider size="default" orientation="left">使用</Divider>
				<i-form :label-width="100">
					<Form-Item label="* 状态" style="margin-bottom:0px">
						<i-select v-model.lazy="add_status_select" size="small" placeholder="选择">
							<i-option v-for="item in add_status_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="使用者" style="margin-bottom:0px">
						<i-select v-model.lazy="add_user_select" size="small" placeholder="选择">
							<i-option v-for="item in add_user_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="位置场所" style="margin-bottom:0px">
						<i-select v-model.lazy="add_location_select" size="small" placeholder="选择">
							<i-option v-for="item in add_location_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="区域/房间" style="margin-bottom:0px">
						<i-select v-model.lazy="add_area_select" size="small" placeholder="选择">
							<i-option v-for="item in add_area_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="机架" style="margin-bottom:0px">
						<i-select v-model.lazy="add_rack_select" size="small" placeholder="选择">
							<i-option v-for="item in add_rack_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="机架中位置" style="margin-bottom:0px">
						<i-select v-model.lazy="add_rackposition_select1" size="small" placeholder="">
							<i-option v-for="item in add_rackposition_options1" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
						<i-select v-model.lazy="add_rackposition_select2" size="small" placeholder="FMB - 前中后">
							<i-option v-for="item in add_rackposition_options2" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="功能" style="margin-bottom:0px">
						<i-input v-model.lazy="add_function" size="small"></i-input>
					</Form-Item>
					<Form-Item label="维护说明" style="margin-bottom:0px">
						<i-input v-model.lazy="add_maintenanceinstructions" size="small" type="textarea"></i-input>
					</Form-Item>

				</i-form>
				
			</i-col>

			<i-col span="1">
			&nbsp;
			</i-col>

			<i-col span="5">
				<Divider orientation="left">保修</Divider>
				<i-form :label-width="100">
					<Form-Item label="购买日期" style="margin-bottom:0px">
						<Date-Picker v-model.lazy="add_dateofpurchase" type="date" placeholder="选择日期" size="small"></Date-Picker>
					</Form-Item>
					<Form-Item label="保修月份" style="margin-bottom:0px">
						<i-input v-model.lazy="add_warrantymonths" size="small"></i-input>
					</Form-Item>
					<Form-Item label="保修信息" style="margin-bottom:0px">
						<i-input v-model.lazy="add_warrantyinfo" size="small"></i-input>
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
					<Form-Item label="MAC地址" style="margin-bottom:0px">
						<i-input v-model.lazy="add_mac" size="small"></i-input>
					</Form-Item>
					<Form-Item label="IPV4" style="margin-bottom:0px">
						<i-input v-model.lazy="add_ipv4" size="small"></i-input>
					</Form-Item>
					<Form-Item label="IPV6" style="margin-bottom:0px">
						<i-input v-model.lazy="add_ipv6" size="small"></i-input>
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

				<Divider size="default" orientation="left">记账</Divider>

				<i-form :label-width="100">
					<Form-Item label="供货商/区域" style="margin-bottom:0px">
						<i-input v-model.lazy="add_shop" size="small"></i-input>
					</Form-Item>
					<Form-Item label="购买价格" style="margin-bottom:0px">
						<i-input v-model.lazy="add_purchaceprice" size="small"></i-input>
					</Form-Item>

				</i-form>
				
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
		add_itemtype_select: '',
		add_itemtype_options: [
			{label: 'fax', value: 1},
			{label: 'pc', value: 2}
		],
		add_ispart: false,
		add_rackmountable: false,
		add_manufact_select: '',
		add_manufact_options: [
			{label: 'lenovo', value: 1},
			{label: 'dell', value: 2},
		],
		add_model: '',
		add_size_select: '',
		add_size_options: [
			{label: 1, value: 1},
			{label: 2, value: 2},
			{label: 3, value: 3},
		],
		add_sn1: '',
		add_sn2: '',
		add_servicetag: '',
		add_comments: '',
		add_label: '',

		// 参数变量 - 使用
		add_status_select: '',
		add_status_options: [
			{label: '使用中', value: 1},
			{label: 2, value: 2},
			{label: 3, value: 3},
		],
		add_user_select: '',
		add_user_options: [
			{label: 'admin', value: 1},
			{label: 'user', value: 2},
			{label: 3, value: 3},
		],
		add_location_select: '',
		add_location_options: [
			{label: '主楼，三楼', value: 1},
			{label: 'user', value: 2},
			{label: 3, value: 3},
		],
		add_area_select: '',
		add_area_options: [
			{label: '6号房间', value: 1},
			{label: 'user', value: 2},
			{label: 3, value: 3},
		],
		add_rack_select: '',
		add_rack_options: [
			{label: '一号机柜', value: 1},
			{label: 'user', value: 2},
			{label: 3, value: 3},
		],
		add_rackposition_select1: '',
		add_rackposition_options1: [
			{label: '1', value: 1},
			{label: '2', value: 2},
			{label: 3, value: 3},
		],
		add_rackposition_select2: '',
		add_rackposition_options2: [
			{label: 'FM-', value: 1},
			{label: 'F-', value: 2},
			{label: '-M-', value: 3},
		],
		add_function: '',
		add_maintenanceinstructions: '',

		// 参数变量 - 保修
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
		add_mac: '',
		add_ipv4: '',
		add_ipv6: '',
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

		// 参数变量 - 记账
		add_shop: '',
		add_purchaceprice: '',






		// 创建
		jiaban_add_reason: '',
		jiaban_add_remark: '',

		jiaban_add_applicantgroup: '',
		jiaban_add_datetimerange1: [],
		jiaban_add_category1: '',
		jiaban_add_duration1: '',
		jiaban_add_create_disabled1: false,
		jiaban_add_clear_disabled1: false,
		
		// 批量录入applicant表
		piliangluru_applicant: [
			{
				uid: '',
				applicant: '',
				department: '',
				datetimerange: [],
				category: '',
				duration: ''
			},
		],

		// 批量录入项
		piliangluruxiang_applicant2: 1,
		jiaban_add_create_disabled2: false,
		jiaban_add_clear_disabled2: false,

		//加班类别
		option_category: [
			{value: '平时加班', label: '平时加班'},
			{value: '双休加班', label: '双休加班'},
			{value: '节假日加班', label: '节假日加班'}
		],

		// 选择角色查看编辑相应权限
		applicant_select: '',
		applicant_options: [],
		applicant_loading: false,

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
		
		// 编辑
		modal_jiaban_edit: false,
		modal_jiaban_pass_loading: false,
		modal_jiaban_deny_loading: false,
		modal_jiaban_archived_loading: false,
		jiaban_edit_id: '',
		jiaban_edit_uuid: '',
		jiaban_edit_id_of_agent: '',
		jiaban_edit_agent: '',
		jiaban_edit_department_of_agent: '',
		jiaban_edit_application: '',
		jiaban_edit_status: 0,
		jiaban_edit_reason: '',
		jiaban_edit_remark: '',
		jiaban_edit_camera_imgurl: '',
		jiaban_edit_auditing: '',
		jiaban_edit_auditing_circulation: '',
		jiaban_edit_auditing_index: 0,
		jiaban_edit_auditing_id: '',
		jiaban_edit_auditing_uid: '',
		jiaban_edit_created_at: '',
		jiaban_edit_updated_at: '',

		// 归档窗口
		modal_archived: false,

		// 查看人员组
		applicantgroup_select: '',
		applicantgroup_options: [],
		applicantgroup_input: '',

		// 公司组织架构
		treedata: [
			{
				title: '公司',
				loading: false,
				children: []
			}
		],

		// 人员组名称，用于查看成员
		applicantgroup_title: '',


		// 删除
		delete_disabled: true,

		
		// 查询过滤器
		queryfilter_auditor: '',
		queryfilter_created_at: '',
		queryfilter_trashed: false,
		
		// 查询过滤器下拉
		collapse_query: '',		
		
		
		
		
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


		//新增
		add_create () {
			var _this = this;

			// 参数变量 - 属性
			var add_itemtype_select = _this.add_itemtype_select;
			var add_ispart = _this.add_ispart;
			var add_rackmountable = _this.add_rackmountable;
			var add_manufact_select = _this.add_manufact_select;
			var add_model = _this.add_model;
			var add_size_select = _this.add_size_select;
			var add_sn1 = _this.add_sn1;
			var add_sn2 = _this.add_sn2;
			var add_servicetag = _this.add_servicetag;
			var add_comments = _this.add_comments;
			var add_label = _this.add_label;

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
			var add_dateofpurchase = _this.add_dateofpurchase;
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
			var add_mac = _this.add_mac;
			var add_ipv4 = _this.add_ipv4;
			var add_ipv6 = _this.add_ipv6;
			var add_remoteadminip = _this.add_remoteadminip;
			var add_panelport = _this.add_panelport;
			var add_switch_select = _this.add_switch_select;
			var add_switchport = _this.add_switchport;
			var add_networkports_select = _this.add_networkports_select;

			// 参数变量 - 记账
			var add_shop = _this.add_shop;
			var add_purchaceprice = _this.add_purchaceprice;

			if (add_itemtype_select == '' || add_itemtype_select == undefined
				|| add_manufact_select == '' || add_manufact_select == undefined
				|| add_model == '' || add_model == undefined
				|| add_status_select == '' || add_status_select == undefined) {
				_this.error(false, '错误', '内容为空或不正确！');
				return false;
			}
// console.log(add_itemtype_select);return false;

			var url = "{{ route('item.addcreate') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				// 参数变量 - 属性
				add_itemtype_select: add_itemtype_select,
				add_ispart: add_ispart,
				add_rackmountable: add_rackmountable,
				add_manufact_select: add_manufact_select,
				add_model: add_model,
				add_size_select: add_size_select,
				add_sn1: add_sn1,
				add_sn2: add_sn2,
				add_servicetag: add_servicetag,
				add_comments: add_comments,
				add_label: add_label,

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
				add_mac: add_mac,
				add_ipv4: add_ipv4,
				add_ipv6: add_ipv6,
				add_remoteadminip: add_remoteadminip,
				add_panelport: add_panelport,
				add_switch_select: add_switch_select,
				add_switchport: add_switchport,
				add_networkports_select: add_networkports_select,

				// 参数变量 - 记账
				add_shop: add_shop,
				add_purchaceprice: add_purchaceprice,




			})
			.then(function (response) {
				console.log(response.data);
				return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
 				if (response.data) {
					_this.titemtypes_add_typedesc = '';
					// _this.itemtypesgets(_this.page_current, _this.page_last);
					_this.success(false, '成功', '新建成功！');
				} else {
					_this.error(false, '失败', '新建失败！');
				}
			})
			.catch(function (error) {
				_this.error(false, '错误', '新建失败！');
			})


		},
















		//
		itemtypesgets (page, last_page){
			var _this = this;
			
			if (page > last_page) {
				page = last_page;
			} else if (page < 1) {
				page = 1;
			}
			

			_this.loadingbarstart();
			var url = "{{ route('item.itemtypesgets') }}";
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
					_this.delete_disabled = true;
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
			this.itemtypesgets(currentpage, this.page_last);
		},







		

		


	},
	mounted: function(){
		var _this = this;
		_this.current_nav = '硬件';
		_this.current_subnav = '物品添加';

		// // 显示所有
		// _this.itemtypesgets(1, 1); // page: 1, last_page: 1
		// _this.loadapplicantgroup();

		// GetCurrentDatetime('getcurrentdatetime');
	}
});
</script>
@endsection