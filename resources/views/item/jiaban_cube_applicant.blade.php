@extends('renshi.layouts.mainbase_cube')

@section('my_title')
Renshi(Jiaban Application) - 
@parent
@endsection

@section('my_style')
<link rel="stylesheet" href="{{ asset('css/camera_cube.css') }}">
<style>
.title-jiaban-applicant {
	position: relative;
	height: 44px;
	line-height: 44px;
	text-align: center;
	background-color: #edf0f4;
	box-shadow: 0 1px 6px #ccc;
	-webkit-backface-visibility: hidden;
	backface-visibility: hidden;
	z-index: 5;
}
</style>
@endsection

@section('my_js')
<script src="{{ asset('js/camera_cube.js') }}"></script>
<script type="text/javascript">
</script>
@endsection

@section('my_body')
@parent

<cube-toolbar :actions="actions_toolbar" @click="clickHandler_toolbar"></cube-toolbar>

<header class="title-jiaban-applicant">
<h1>加班申请单</h1>
</header>
<br>

<cube-form :model="model" @validate="validateHandler" @submit="submitHandler" @reset="resetHandler">
  <cube-form-group>
    <cube-form-item :field="fields[0]">
        <cube-input v-model.lazy="jiaban_add_uid" @blur="onchange_applicant" clearable placeholder="输入工号"></cube-input>
    </cube-form-item>
    <cube-form-item :field="fields[1]">
        <cube-input v-model.lazy="jiaban_add_applicant" placeholder="姓名" readonly></cube-input>
    </cube-form-item>
    <cube-form-item :field="fields[2]">
        <cube-input v-model.lazy="jiaban_add_department" placeholder="部门" readonly></cube-input>
    </cube-form-item>
    <cube-form-item :field="fields[3]">
        <cube-input v-model.lazy="jiaban_add_startdate" @focus="showDateTimePicker_startdate" placeholder="选择开始时间"></cube-input>
        <!-- <cube-button @click="showDateTimePicker">@{{model.dateValue || 'Please select date'}}</cube-button> -->
        <!-- <date-picker ref="datePicker" :min="[2008, 8, 8]" :max="[2020, 10, 20]" @select="dateSelectHandler"></date-picker> -->
    </cube-form-item>
    <cube-form-item :field="fields[4]">
        <cube-input v-model.lazy="jiaban_add_enddate" @focus="showDateTimePicker_enddate" placeholder="选择结束时间"></cube-input>
    </cube-form-item>
    <cube-form-item :field="fields[5]">
        <cube-select v-model.lazy="jiaban_add_duration" :options="jiaban_add_duration_options" title="选择时长（小时）" placeholder="选择时长"></cube-select>
    </cube-form-item>
    <cube-form-item :field="fields[6]">
        <cube-select v-model.lazy="jiaban_add_category" :options="jiaban_add_category_options" title="选择类别" placeholder="选择类别"></cube-select>
    </cube-form-item>
    <cube-form-item :field="fields[7]">
        <cube-textarea v-model.lazy="jiaban_add_reason" maxlength="100" placeholder="在此填写理由..."></cube-textarea>
    </cube-form-item>
    <cube-form-item :field="fields[8]">
        <cube-textarea v-model.lazy="jiaban_add_remark" maxlength="100" placeholder="在些填写备注..."></cube-textarea>
    </cube-form-item>
  </cube-form-group>
  <cube-form-group>
  <br>
    <cube-button  id="startcapture" :light="true" @click="showCamera">* 拍 照 （@{{ camera_imgurl == '' ? 'X' : 'OK' }}） </cube-button>
    <br>
    <cube-button type="submit" :disabled="jiaban_add_submit_disabled">提 交</cube-button>
    <br>
    <cube-button type="reset" :disabled="jiaban_add_reset_disabled">清 除</cube-button>
  </cube-form-group>
</cube-form>


<br>


@endsection

@section('my_footer')
@parent
@endsection

@section('my_js_others')
@parent
<script>
var vm_app = new Vue({
    el: '#app',
	data: {
		// 拍照界面
		// modal_camera_show: false,
        camera_imgurl: '',

        jiaban_add_submit_disabled: false,
        jiaban_add_reset_disabled: false,

        jiaban_add_uid: '',
        jiaban_add_applicant: '',
        jiaban_add_department: '',
        jiaban_add_startdate: '',
        jiaban_add_enddate: '',
        jiaban_add_duration: '',
        jiaban_add_duration_options: [
            0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5, 5.5,
            6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5,
            12, 12.5, 13, 13.5, 14, 14.5, 15, 15.5, 16, 16.5, 17, 17.5,
            18, 18.5, 19, 19.5, 20, 20.5, 21, 21.5, 22, 22.5, 23, 23.5, 24
        ],
        jiaban_add_category: '',
        jiaban_add_category_options: ['平时加班', '双休加班', '节假日加班'],
        jiaban_add_reason: '',
        jiaban_add_remark: '',


        model: {
            inputValue: '',
            pcaValue: [],
            dateValue: ''
        },
        fields: [
            { //0
                // type: 'select',
                // modelKey: 'jiaban_add_uid',
                label: '工号',
                rules: {
                    required: true
                }
            },
            { //1
                // type: 'input',
                // modelKey: 'jiaban_add_applicant',
                label: '申请人姓名',
                rules: {
                    required: false
                },
                // validating when blur
                trigger: 'blur'
            },
            { //2
                // type: 'input',
                // modelKey: 'jiaban_add_department',
                label: '申请人部门',
                rules: {
                    required: false
                },
                trigger: 'blur'
            },
            { //3
                // modelKey: 'jiaban_add_startdate',
                label: '开始时间',
                rules: {
                    required: true
                }
            },
            { //4
                // modelKey: 'dateValue',
                label: '结束时间',
                rules: {
                    required: true
                }
            },
            { //5
                // type: 'input',
                // modelKey: 'inputValue',
                label: '时长',
                rules: {
                    required: true
                }
            },
            { //6
                // type: 'input',
                // modelKey: 'inputValue',
                label: '类别',
                rules: {
                    required: true
                }
            },
            { //7
                // type: 'textarea',
                // modelKey: 'jiaban_add_reason',
                label: '理由',
                rules: {
                    required: true
                },
                // props: {
                //     placeholder: "加班理由",
                //     maxlength: 100,
                //     // autofocus: true
                // },
                // debounce validate
                // if set to true, the default debounce time will be 200(ms)
                // debounce: 100
            },
            { //8
                // type: 'textarea',
                // modelKey: 'jiaban_add_remark',
                label: '备注',
                rules: {
                    required: false
                },
                // props: {
                //     placeholder: "备注",
                //     maxlength: 100,
                //     // autofocus: true
                // },
                // debounce: 100
            },



        ],


        actions_toolbar: [
            {
            text: '<i class="cubeic-home"></i> 返回首页',
            action: 'gotoPortal'
            },
            {
            text: '<i class="cubeic-calendar"></i> 查看加班',
            action: 'gotoJiabanList'
            },
            {
            text: '<i class="cubeic-share"></i> 注销用户',
            action: 'gotoLogoff'
            }
        ],






        







        














	},
	methods: {

        // showDateTimePicker
        showDateTimePicker_startdate() {
            if (!this.dateTimePicker_startdate) {
                this.dateTimePicker_startdate = this.$createDatePicker({
                title: '选择开始时间',
                min: new Date(2018, 12, 1, 0, 0, 0),
                // max: new Date(2020, 9, 20, 20, 59, 59),
                max: new Date(this.jiaban_add_enddate || '2099-12-31 23:59:59'),
                value: new Date(),
                columnCount: 6,
                onSelect: this.selectHandle_startdate,
                onCancel: this.cancelHandle_startdate
                })
            }

            this.dateTimePicker_startdate.show()
        },
        selectHandle_startdate(date, selectedVal, selectedText) {
            this.jiaban_add_startdate = date.Format("yyyy-MM-dd hh:mm:ss")
            // this.$createDialog({
            //     type: 'warn',
            //     content: `Selected Item: <br/> - date: ${date} <br/> - value: ${selectedVal.join(', ')} <br/> - text: ${selectedText.join(' ')}`,
            //     icon: 'cubeic-alert'
            // }).show()
        },
        cancelHandle_startdate() {
            // this.$createToast({
            //     type: 'correct',
            //     txt: 'Picker canceled',
            //     time: 1000
            // }).show()
        },

        // showDateTimePicker
        showDateTimePicker_enddate() {
            if (!this.dateTimePicker_enddate) {
                this.dateTimePicker_enddate = this.$createDatePicker({
                title: '选择结束时间',
                // min: new Date(2008, 7, 8, 8, 0, 0),
                min: new Date(this.jiaban_add_startdate || '2019-01-01 00:00:00'),
                max: new Date(2099, 12, 31, 23, 59, 59),
                value: new Date(),
                columnCount: 6,
                onSelect: this.selectHandle_enddate,
                onCancel: this.cancelHandle_enddate
                })
            }

            this.dateTimePicker_enddate.show()
        },
        selectHandle_enddate(date, selectedVal, selectedText) {
            this.jiaban_add_enddate = date.Format("yyyy-MM-dd hh:mm:ss")
            // this.$createDialog({
            //     type: 'warn',
            //     content: `Selected Item: <br/> - date: ${date} <br/> - value: ${selectedVal.join(', ')} <br/> - text: ${selectedText.join(' ')}`,
            //     icon: 'cubeic-alert'
            // }).show()
        },
        cancelHandle_enddate() {
            // this.$createToast({
            //     type: 'correct',
            //     txt: 'Picker canceled',
            //     time: 1000
            // }).show()
        },


        // form
        submitHandler(e) {
            e.preventDefault()
            // console.log('submit', e)
            // alert('submit');
            var _this = this;

            _this.jiaban_add_submit_disabled = true;
            _this.jiaban_add_reset_disabled = true;

            var uid = _this.jiaban_add_uid;
            var applicant = _this.jiaban_add_applicant;
            var department = _this.jiaban_add_department;
            var startdate = _this.jiaban_add_startdate;
            var enddate = _this.jiaban_add_enddate;
            var duration = _this.jiaban_add_duration;
            var category = _this.jiaban_add_category;
            var reason = _this.jiaban_add_reason;
            var remark = _this.jiaban_add_remark;
            var camera_imgurl = _this.camera_imgurl;

            if (uid == '' || applicant == '' || department == '' || startdate == '' || enddate == '' || category == ''  || duration == '' || reason == '' || camera_imgurl == ''
            || uid == undefined || applicant == undefined || department == undefined || startdate == undefined || enddate == undefined || category == undefined  || duration == undefined || reason == undefined || camera_imgurl == undefined) {
                // _this.warning(false, '警告', '输入内容为空或不正确！');
                const toast = _this.$createToast({
                    txt: '输入内容为空或不正确！',
                    type: 'warn'
                })
                toast.show()
				return false;
			}

			var url = "{{ route('renshi.jiaban.applicantcube.applicantcubecreate') }}";
			axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
			axios.post(url, {
                uid: uid,
                applicant: applicant,
                department: department,
                startdate: startdate,
                enddate: enddate,
                duration: duration,
                category: category,
                reason: reason,
                remark: remark,
                camera_imgurl: camera_imgurl,
			})
			.then(function (response) {
				// console.log(response.data);
				// return false;
				
				if (response.data['jwt'] == 'logout') {
                    _this.$createToast({
                        type: 'warn',
                        txt: '会话超时！正在注销...',
                        time: 1000
                    }).show()
                    window.setTimeout(function(){
                        var url = "{{ route('main.logout') }}";
                        window.location.href = url;
                    }, 1000);
					return false;
				}
				
				if (response.data) {
					_this.resetHandler();
                    const toast = _this.$createToast({
                        txt: '提交成功！',
                        type: 'correct'
                    })
                    toast.show()
				} else {
                    const toast = _this.$createToast({
                        txt: '提交失败！',
                        type: 'warn'
                    })
                    toast.show()
                }

                window.setTimeout(function(){
                    _this.jiaban_add_submit_disabled = false;
                    _this.jiaban_add_reset_disabled = false;
                }, 1000);
                
			})
			.catch(function (error) {
                const toast = _this.$createToast({
                    txt: '发生错误，提交失败！',
                    type: 'error'
                })
                toast.show()

                window.setTimeout(function(){
                    _this.jiaban_add_submit_disabled = false;
                    _this.jiaban_add_reset_disabled = false;
                }, 1000);
            })
            

        },
        validateHandler(result) {
            // this.validity = result.validity
            // this.valid = result.valid
            // console.log('validity', result.validity, result.valid, result.dirty, result.firstInvalidFieldIndex)
        },
        resetHandler(e) {
            // console.log('reset', e)
            this.jiaban_add_uid = '';
            this.jiaban_add_applicant = '';
            this.jiaban_add_department = '';
            this.jiaban_add_startdate = '';
            this.jiaban_add_enddate = '';
            this.jiaban_add_duration = '';
            this.jiaban_add_category = '';
            this.jiaban_add_reason = '';
            this.jiaban_add_remark = '';
            this.camera_imgurl = '';
        },

        // toolbar - start
        gotoPortal(item) {
            var url = "{{ route('portalcube') }}";
            window.location.href = url;
        },

        gotoJiabanList() {
            var url = "{{ route('renshi.jiaban.applicantcube.list') }}";
            window.location.href = url;
        },

        gotoLogoff() {
            this.$createToast({
                type: 'correct',
                txt: '正在注销...',
                time: 1000
            }).show()
            window.setTimeout(function(){
                var url = "{{ route('main.logout') }}";
                window.location.href = url;
            }, 1000);
        },

        clickHandler_toolbar(item) {
            if (item.action) {
                this[item.action](item)
            }
        },
        // toolbar - end


        // 选择uid查看applicant和department
		onchange_applicant() {
			var _this = this;

			var employeeid = _this.jiaban_add_uid;
			// console.log(roleid);return false;
			
			if (employeeid == undefined || employeeid == '') {
                _this.jiaban_add_applicant = '';
                _this.jiaban_add_department = '';
				return false;
			}

			var url = "{{ route('renshi.jiaban.applicant.employeelist') }}";
			axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
			axios.get(url,{
				params: {
					employeeid: employeeid
				}
			})
			.then(function (response) {
				// console.log(response.data);
				// return false;

				if (response.data['jwt'] == 'logout') {
                    _this.$createToast({
                        type: 'warn',
                        txt: '会话超时！正在注销...',
                        time: 1000
                    }).show()
                    window.setTimeout(function(){
                        var url = "{{ route('main.logout') }}";
                        window.location.href = url;
                    }, 1000);
					return false;
				}
				
				if (response.data) {
                    var json = response.data;
                    var arr = [];
                    for (var key in json) {
                        arr.push(json[key]);
                    }
                    _this.jiaban_add_applicant = arr[0];
                    _this.jiaban_add_department = arr[1];
				} else {
                    _this.jiaban_add_applicant = '';
                    _this.jiaban_add_department = '';
                }
			})
			.catch(function (error) {
				_this.error(false, 'Error', error);
			})
			
        },
        
        showCamera() {
            this.$createDialog({
                type: 'prompt',
                showClose: true,
                confirmBtn: {
                    // text: '确定',
                    active: true
                },
                cancelBtn: {
                    // text: '取消',
                    active: true
                },
                onConfirm: () => {
                    // this.$createToast({
                    //     type: 'warn',
                    //     time: 1000,
                    //     txt: '点击确认按钮'
                    // }).show()
                },
                onCancel: () => {
                    // this.$createToast({
                    //     type: 'warn',
                    //     time: 1000,
                    //     txt: '点击取消按钮'
                    // }).show()
                    this.camera_imgurl = '';
                },
                onClose: () => {
                    // this.$createToast({
                    //     type: 'warn',
                    //     time: 1000,
                    //     txt: '点击关闭按钮'
                    // }).show()
                }
            }, (createElement) => {
                return [
                    // 1
                    createElement('div', {
                        'class': {
                            'my-title': true
                        },
                        slot: 'title'
                    }, [
                        createElement('br', {
                        // 'class': {
                        //     'my-title-img': true
                        // }
                        }),
                        createElement('p', '* 请允许开启访问摄像头的权限')
                    ]),

                    // 2
                    createElement('div', {
                        'class': {
                            'camera': true
                        },
                        slot: 'content'
                    }, [
                        // createElement('p', {
                        //     'class': {
                        //         'my-content': true
                        //     },
                        //     slot: 'content'
                        // }, '请允许开启访问摄像头的权限'),
                        createElement('video', {
                            attrs: {
                                'id': 'video'
                            },
                            'class': {
                                // 'my-content': true
                            },
                            slot: 'content'
                        }, ''),
                        createElement('button', {
                            attrs: {
                                'id': 'startbutton'
                            },
                            'class': {
                                // 'my-content': true
                            },
                            slot: 'content'
                        }, '点击拍照'),
                        createElement('canvas', {
                            attrs: {
                                'id': 'canvas'
                            },
                            'class': {
                                // 'my-content': true
                            },
                            slot: 'content'
                        }, ''),
                        createElement('div', {
                            attrs: {
                                'id': 'output'
                            },
                            'class': {
                                // 'my-content': true
                                'output': true
                            },
                            slot: 'content'
                        }, [
                            createElement('img', {
                            attrs: {
                                'id': 'photo',
                                'src': this.camera_imgurl
                            },
                            'class': {
                                // 'my-content': true
                            },
                            slot: 'content'
                        }, ''),
                        ])
                    ]),
                ]
            }).show()
        }


        



		



	},
	mounted: function () {

	}
})
</script>
@endsection