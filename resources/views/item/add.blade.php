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
						<i-select v-model.lazy="jiaban_add_applicantgroup" size="small" placeholder="选择">
							<i-option v-for="item in applicantgroup_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="* 使用者" style="margin-bottom:0px">
						<i-select v-model.lazy="jiaban_add_applicantgroup" size="small" placeholder="选择">
							<i-option v-for="item in applicantgroup_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="位置场所" style="margin-bottom:0px">
						<i-select v-model.lazy="jiaban_add_applicantgroup" size="small" placeholder="选择">
							<i-option v-for="item in applicantgroup_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="区域/房间" style="margin-bottom:0px">
						<i-select v-model.lazy="jiaban_add_applicantgroup" size="small" placeholder="选择">
							<i-option v-for="item in applicantgroup_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="机架" style="margin-bottom:0px">
						<i-select v-model.lazy="jiaban_add_applicantgroup" size="small" placeholder="选择">
							<i-option v-for="item in applicantgroup_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="机架中位置" style="margin-bottom:0px">
						<i-select v-model.lazy="jiaban_add_applicantgroup" size="small" placeholder="">
							<i-option v-for="item in applicantgroup_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
						<i-select v-model.lazy="jiaban_add_applicantgroup" size="small" placeholder="FMB - 前中后">
							<i-option v-for="item in applicantgroup_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="功能" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>
					<Form-Item label="维护说明" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small" type="textarea"></i-input>
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
						<Date-Picker type="date" placeholder="选择日期" size="small"></Date-Picker>
					</Form-Item>
					<Form-Item label="保修月份" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>
					<Form-Item label="保修信息" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>

				</i-form>

				<br>
				
				<Divider orientation="left">配件</Divider>
				<i-form :label-width="100">
					<Form-Item label="硬盘" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>
					<Form-Item label="内存" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>
					<Form-Item label="CPU型号" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>
					<Form-Item label="CPU数量" style="margin-bottom:0px">
						<i-select v-model.lazy="jiaban_add_applicantgroup" size="small" placeholder="FMB - 前中后">
							<i-option v-for="item in applicantgroup_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="CPU内核数" style="margin-bottom:0px">
						<i-select v-model.lazy="jiaban_add_applicantgroup" size="small" placeholder="FMB - 前中后">
							<i-option v-for="item in applicantgroup_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
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
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>
					<Form-Item label="MAC地址" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>
					<Form-Item label="IPV4" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>
					<Form-Item label="IPV6" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>
					<Form-Item label="远程管理IP" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>
					<Form-Item label="面板端口" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>
					<Form-Item label="交换机" style="margin-bottom:0px">
						<i-select v-model.lazy="jiaban_add_applicantgroup" size="small" placeholder="FMB - 前中后">
							<i-option v-for="item in applicantgroup_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>
					<Form-Item label="交换机端口" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>
					<Form-Item label="网络端口数" style="margin-bottom:0px">
						<i-select v-model.lazy="jiaban_add_applicantgroup" size="small" placeholder="FMB - 前中后">
							<i-option v-for="item in applicantgroup_options" :value="item.value" :key="item.value">@{{ item.label }}</i-option>
						</i-select>
					</Form-Item>

				</i-form>

				<br>

				<Divider size="default" orientation="left">记账</Divider>

				<i-form :label-width="100">
					<Form-Item label="供货商/区域" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
					</Form-Item>
					<Form-Item label="购买价格" style="margin-bottom:0px">
						<i-input v-model.lazy="jiaban_add_applicantgroup" size="small"></i-input>
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

<i-button @click="add_add()" :disabled="add_add_disabled" size="large" type="primary">添加</i-button>

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
		add_add_disabled: false,

		// 参数变量
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





		//新增
		itemtypes_add () {
			var _this = this;

			var typedesc = _this.titemtypes_add_typedesc;
			// var hassoftware = _this.titemtypes_add_hassoftware;

			if (typedesc == '' || typedesc == undefined) {
					// console.log(hassoftware);
				// _this.error(false, '失败', '用户ID为空或不正确！');
				return false;
			}

			var url = "{{ route('item.itemtypescreate') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
				typedesc: typedesc,
				hassoftware: hassoftware,
			})
			.then(function (response) {
				// console.log(response.data);
				// return false;

				if (response.data['jwt'] == 'logout') {
					_this.alert_logout();
					return false;
				}
				
 				if (response.data) {
					_this.titemtypes_add_typedesc = '';
					_this.itemtypesgets(_this.page_current, _this.page_last);
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