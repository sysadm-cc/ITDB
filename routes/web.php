<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Events 路由
// Route::group(['prefix'=>'renshi', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {
Route::group(['prefix'=>'event', 'namespace'=>'Event', 'middleware'=>['jwtauth']], function() {

	// 显示 Events 页面
	Route::get('eventEvents', 'EventsController@eventEvents')->name('event.events');

	// Events gets列表
	Route::get('eventGets', 'EventsController@eventGets')->name('event.gets');

	// Events Update
	Route::post('eventUpdate', 'EventsController@eventUpdate')->name('event.update');

	// Events Delete
	Route::post('eventDelete', 'EventsController@eventDelete')->name('event.delete');

	// 显示 Events Add 页面
	Route::get('eventAdd', 'EventsController@eventAdd')->name('event.add');

	// Events Create
	Route::post('eventCreate', 'EventsController@eventCreate')->name('event.create');

});

// Employees 路由
// Route::group(['prefix'=>'renshi', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {
Route::group(['prefix'=>'employee', 'namespace'=>'Employee', 'middleware'=>['jwtauth']], function() {

	// 显示 Employees 页面
	Route::get('employeeEmployees', 'EmployeesController@employeeEmployees')->name('employee.employees');

	// Employees gets列表
	Route::get('employeeGets', 'EmployeesController@employeeGets')->name('employee.gets');

	// Employees Update
	Route::post('employeeUpdate', 'EmployeesController@employeeUpdate')->name('employee.update');

	// Employees Delete
	Route::post('employeeDelete', 'EmployeesController@employeeDelete')->name('employee.delete');

	// 显示 Employees Add 页面
	Route::get('employeeAdd', 'EmployeesController@employeeAdd')->name('employee.add');

	// Employees Create
	Route::post('employeeCreate', 'EmployeesController@employeeCreate')->name('employee.create');

});
	

// Locations 路由
// Route::group(['prefix'=>'renshi', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {
Route::group(['prefix'=>'location', 'namespace'=>'Location', 'middleware'=>['jwtauth']], function() {

	// 显示 Locations 页面
	Route::get('locationLocations', 'LocationsController@locationLocations')->name('location.locations');

	// Locations gets列表
	Route::get('locationGets', 'LocationsController@locationGets')->name('location.gets');

	// Locations Update
	Route::post('locationUpdate', 'LocationsController@locationUpdate')->name('location.update');

	// Locations Delete
	Route::post('locationDelete', 'LocationsController@locationDelete')->name('location.delete');

	// 显示 Locations add 页面
	Route::get('locationAdd', 'LocationsController@locationAdd')->name('location.add');

	// Locations Create
	Route::post('locationCreate', 'LocationsController@locationCreate')->name('location.create');

	// Locations SubUpdate Areas
	Route::post('SubupdateAreas', 'LocationsController@SubupdateAreas')->name('location.subupdateareas');

	// Locations SubDelete Areas
	Route::post('SubdeleteAreas', 'LocationsController@SubdeleteAreas')->name('location.subdeleteareas');

	// Locations SubCreate Areas
	Route::post('SubCreateAreas', 'LocationsController@SubCreateAreas')->name('location.subcreateareas');

});

// Racks 路由
// Route::group(['prefix'=>'renshi', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {
Route::group(['prefix'=>'rack', 'namespace'=>'Rack', 'middleware'=>['jwtauth']], function() {

	// 显示 Racks 页面
	Route::get('rackRacks', 'RacksController@rackRacks')->name('rack.racks');

	// Racks gets列表
	Route::get('rackGets', 'RacksController@rackGets')->name('rack.gets');

	// Agents Update typedesc
	// Route::post('itemItemtypesUpdateTypedesc', 'ItemItemtypesController@itemItemtypesUpdateTypedesc')->name('item.itemtypesupdate_typedesc');

	// Racks Update
	Route::post('rackUpdate', 'RacksController@rackUpdate')->name('rack.update');

	// Racks Delete
	Route::post('rackDelete', 'RacksController@rackDelete')->name('rack.delete');

	// 显示 Racks add 页面
	Route::get('rackAdd', 'RacksController@rackAdd')->name('rack.add');

	// Racks Create
	Route::post('rackCreate', 'RacksController@rackCreate')->name('rack.create');

	// Racks Location2Area
	Route::get('location2Area', 'RacksController@location2Area')->name('rack.location2area');

});

// Files 路由
// Route::group(['prefix'=>'renshi', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {
Route::group(['prefix'=>'file', 'namespace'=>'File', 'middleware'=>['jwtauth']], function() {

	// 显示 Files 页面
	Route::get('fileFiles', 'FilesController@fileFiles')->name('file.files');

	// Files gets列表
	Route::get('fileGets', 'FilesController@fileGets')->name('file.gets');

	// Files Update
	Route::post('fileUpdate', 'FilesController@fileUpdate')->name('file.update');

	// Files Delete
	Route::post('fileDelete', 'FilesController@fileDelete')->name('file.delete');

	// 显示 Files add 页面
	Route::get('fileAdd', 'FilesController@fileAdd')->name('file.add');

	// Files Create
	Route::post('fileCreate', 'FilesController@fileCreate')->name('file.create');

	// Files 上传
	Route::post('fileUpload', 'FilesController@fileUpload')->name('file.upload');

});

// Contracts 路由
// Route::group(['prefix'=>'renshi', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {
Route::group(['prefix'=>'contract', 'namespace'=>'Contract', 'middleware'=>['jwtauth']], function() {

	// 显示 Contracts 页面
	Route::get('contractContracts', 'ContractsController@contractContracts')->name('contract.contracts');

	// Contracts gets列表
	Route::get('contractGets', 'ContractsController@contractGets')->name('contract.gets');

	// Agents Update
	Route::post('contractUpdate', 'ContractsController@contractUpdate')->name('contract.update');

	// 显示 Contracts add 页面
	Route::get('contractAdd', 'ContractsController@contractAdd')->name('contract.add');

	// Contracts Create
	Route::post('contractCreate', 'ContractsController@contractCreate')->name('contract.create');

	// Contracts Delete
	Route::post('contractDelete', 'ContractsController@contractDelete')->name('contract.delete');


	// Contracts SubUpdate Renewals
	Route::post('SubupdateRenewals', 'ContractsController@SubupdateRenewals')->name('contract.subupdaterenewals');
	
	// Contracts SubDelete Renewals
	Route::post('SubdeleteRenewals', 'ContractsController@SubdeleteRenewals')->name('contract.subdeleterenewals');
	
	// Contracts SubCreate Renewals
	Route::post('SubCreateRenewals', 'ContractsController@SubCreateRenewals')->name('contract.subcreaterenewals');






	// 显示 Contracttypes 页面
	Route::get('contractContracttypes', 'ContractsController@contractContracttypes')->name('contract.contracttypes');
	
	// Contracttypes gets列表
	Route::get('ContracttypesGets', 'ContractsController@contracttypesGets')->name('contracttypes.gets');

	// Contracttypes Update name
	Route::post('contracttypesUpdateName', 'ContractsController@contracttypesUpdateName')->name('contracttypes.update_name');

	// Contracttypes Delete
	Route::post('contracttypesDelete', 'ContractsController@contracttypesDelete')->name('contracttypes.delete');

	// Contracts Create
	Route::post('contracttypesCreate', 'ContractsController@contracttypesCreate')->name('contracttypes.create');


});

// Invoices 路由
// Route::group(['prefix'=>'renshi', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {
Route::group(['prefix'=>'invoice', 'namespace'=>'Invoice', 'middleware'=>['jwtauth']], function() {

	// 显示 Invoices 页面
	Route::get('invoiceInvoices', 'InvoicesController@invoiceInvoices')->name('invoice.invoices');

	// Agents gets列表
	Route::get('invoiceGets', 'InvoicesController@invoiceGets')->name('invoice.gets');

	// Agents Update typedesc
	// Route::post('itemItemtypesUpdateTypedesc', 'ItemItemtypesController@itemItemtypesUpdateTypedesc')->name('item.itemtypesupdate_typedesc');

	// Invoices Update
	Route::post('invoiceUpdate', 'InvoicesController@invoiceUpdate')->name('invoice.update');

	// Invoices Delete
	Route::post('invoiceDelete', 'InvoicesController@invoiceDelete')->name('invoice.delete');

	// 显示 Invoices Add 页面
	Route::get('invoiceAdd', 'InvoicesController@invoiceAdd')->name('invoice.add');

	// Invoices Create
	Route::post('invoiceCreate', 'InvoicesController@invoiceCreate')->name('invoice.create');

});


// Softs 路由
// Route::group(['prefix'=>'renshi', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {
Route::group(['prefix'=>'soft', 'namespace'=>'Soft', 'middleware'=>['jwtauth']], function() {

	// 显示 Softs 页面
	Route::get('softSofts', 'SoftsController@softSofts')->name('soft.softs');

	// Softs gets列表
	Route::get('softGets', 'SoftsController@softGets')->name('soft.gets');

	// Softs Update typedesc
	// Route::post('itemItemtypesUpdateTypedesc', 'ItemItemtypesController@itemItemtypesUpdateTypedesc')->name('item.itemtypesupdate_typedesc');

	// Softs Update
	Route::post('softUpdate', 'SoftsController@softUpdate')->name('soft.update');

	// Softs Delete
	Route::post('softDelete', 'SoftsController@softDelete')->name('soft.delete');

	// 显示 Softs add 页面
	Route::get('softAdd', 'SoftsController@softAdd')->name('soft.add');

	// Softs Create
	Route::post('softCreate', 'SoftsController@softCreate')->name('soft.create');

});
	


// Agents 路由
// Route::group(['prefix'=>'renshi', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {
Route::group(['prefix'=>'agent', 'namespace'=>'Agent', 'middleware'=>['jwtauth']], function() {

	// 显示 Agents 页面
	Route::get('agentAgents', 'AgentsController@agentAgents')->name('agent.agents');

	// Agents gets列表
	Route::get('agentGets', 'AgentsController@agentGets')->name('agent.gets');

	// Agents Update
	Route::post('agentUpdate', 'AgentsController@agentUpdate')->name('agent.update');

	// Agents Delete
	Route::post('agentDelete', 'AgentsController@agentDelete')->name('agent.delete');

	// 显示 Agents add 页面
	Route::get('agentAdd', 'AgentsController@agentAdd')->name('agent.add');

	// Agents Create
	Route::post('agentCreate', 'AgentsController@agentCreate')->name('agent.create');

	// Agents SubUpdate Contacts
	Route::post('SubupdateContacts', 'AgentsController@SubupdateContacts')->name('agent.subupdatecontacts');
	
	// Agents SubDelete Contacts
	Route::post('SubdeleteContacts', 'AgentsController@SubDeleteContacts')->name('agent.subdeletecontacts');

	// Agents SubCreate Contacts
	Route::post('SubCreateContacts', 'AgentsController@SubCreateContacts')->name('agent.subcreatecontacts');

	// Agents SubUpdate Urls
	Route::post('SubupdateUrls', 'AgentsController@SubupdateUrls')->name('agent.subupdateurls');
	
	// Agents SubDelete Urls
	Route::post('SubdeleteUrls', 'AgentsController@SubDeleteUrls')->name('agent.subdeleteurls');
	
	// Agents SubCreate Urls
	Route::post('SubCreateUrls', 'AgentsController@SubCreateUrls')->name('agent.subcreateurls');

});
	

// Item items 路由
// Route::group(['prefix'=>'renshi', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {
Route::group(['prefix'=>'item', 'namespace'=>'Item', 'middleware'=>['jwtauth']], function() {

	// 显示 Items 页面
	Route::get('itemItems', 'ItemItemsController@itemItems')->name('item.items');

	// Items gets列表
	Route::get('itemItemsGets', 'ItemItemsController@itemItemsGets')->name('item.itemsgets');

	// Itemstypes Update typedesc
	// Route::post('itemItemtypesUpdateTypedesc', 'ItemItemtypesController@itemItemtypesUpdateTypedesc')->name('item.itemtypesupdate_typedesc');

	// Items Update Properties
	Route::post('itemItemsUpdateProperties', 'ItemItemsController@itemItemsUpdateProperties')->name('item.itemsupdate_properties');

	// Items Update Usage
	Route::post('itemItemsUpdateUsage', 'ItemItemsController@itemItemsUpdateUsage')->name('item.itemsupdate_usage');

	// Items Update Warranty
	Route::post('itemItemsUpdateWarranty', 'ItemItemsController@itemItemsUpdateWarranty')->name('item.itemsupdate_warranty');

	// Items Update Misc
	Route::post('itemItemsUpdateMisc', 'ItemItemsController@itemItemsUpdateMisc')->name('item.itemsupdate_misc');

	// Items Update Network
	Route::post('itemItemsUpdateNetwork', 'ItemItemsController@itemItemsUpdateNetwork')->name('item.itemsupdate_network');

	// Items Delete
	Route::post('itemItemsDelete', 'ItemItemsController@itemItemsDelete')->name('item.itemsdelete');

	// Itemstypes Create
	// Route::post('itemAddCreate', 'ItemAddController@itemAddCreate')->name('item.addcreate');

});

// Item add 路由
// Route::group(['prefix'=>'renshi', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {
Route::group(['prefix'=>'item', 'namespace'=>'Item', 'middleware'=>['jwtauth']], function() {

	// 显示 Add 页面
	Route::get('itemAdd', 'ItemAddController@itemAdd')->name('item.add');

	// Itemstypes gets列表
	// Route::get('itemItemtypesGets', 'ItemItemtypesController@itemItemtypesGets')->name('item.itemtypesgets');

	// Itemstypes Update typedesc
	// Route::post('itemItemtypesUpdateTypedesc', 'ItemItemtypesController@itemItemtypesUpdateTypedesc')->name('item.itemtypesupdate_typedesc');

	// Itemstypes Update
	// Route::post('itemItemtypesUpdateHassoftware', 'ItemItemtypesController@itemItemtypesUpdateHassoftware')->name('item.itemtypesupdate_hassoftware');

	// Itemstypes Delete
	// Route::post('itemItemtypesDelete', 'ItemItemtypesController@itemItemtypesDelete')->name('item.itemtypesdelete');

	// Itemstypes Create
	Route::post('itemAddCreate', 'ItemAddController@itemAddCreate')->name('item.addcreate');

});

// Item itemstypes 路由
// Route::group(['prefix'=>'renshi', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {
Route::group(['prefix'=>'item', 'namespace'=>'Item', 'middleware'=>['jwtauth']], function() {

	// 显示 Itemstypes 页面
	Route::get('itemItemtypes', 'ItemItemtypesController@itemItemtypes')->name('item.itemtypes');

	// Itemstypes gets列表
	Route::get('itemItemtypesGets', 'ItemItemtypesController@itemItemtypesGets')->name('item.itemtypesgets');

	// Itemstypes Update typedesc
	Route::post('itemItemtypesUpdateTypedesc', 'ItemItemtypesController@itemItemtypesUpdateTypedesc')->name('item.itemtypesupdate_typedesc');

	// Itemstypes Update
	Route::post('itemItemtypesUpdateHassoftware', 'ItemItemtypesController@itemItemtypesUpdateHassoftware')->name('item.itemtypesupdate_hassoftware');

	// Itemstypes Delete
	Route::post('itemItemtypesDelete', 'ItemItemtypesController@itemItemtypesDelete')->name('item.itemtypesdelete');

	// Itemstypes Create
	Route::post('itemItemtypesCreate', 'ItemItemtypesController@itemItemtypesCreate')->name('item.itemtypescreate');

});

// Item statustypes 路由
// Route::group(['prefix'=>'renshi', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {
Route::group(['prefix'=>'item', 'namespace'=>'Item', 'middleware'=>['jwtauth']], function() {

	// 显示 Statustypes 页面
	Route::get('itemStatustypes', 'ItemStatustypesController@itemStatustypes')->name('item.statustypes');

	// Statustypes gets列表
	Route::get('itemStatustypesGets', 'ItemStatustypesController@itemStatustypesGets')->name('item.statustypesgets');

	// Statustypes Update
	Route::post('itemStatustypesUpdate', 'ItemStatustypesController@itemStatustypesUpdate')->name('item.statustypesupdate');

	// Statustypes Delete
	Route::post('itemStatustypesDelete', 'ItemStatustypesController@itemStatustypesDelete')->name('item.statustypesdelete');

	// Statustypes Create
	Route::post('itemStatustypesCreate', 'ItemStatustypesController@itemStatustypesCreate')->name('item.statustypescreate');

});


// main模块
Route::group(['prefix'=>'', 'namespace'=>'Main', 'middleware'=>['jwtauth']], function() {
	Route::get('/', 'mainController@mainPortal')->name('portal');
	Route::get('portal', 'mainController@mainPortal')->name('portal');

	// logout
	Route::get('logout', 'mainController@logout')->name('main.logout');

	// dateofsetup
	Route::get('dateofsetup', 'mainController@dateofsetup')->name('dateofsetup');

});


// login模块
Route::group(['prefix' => 'login', 'namespace' =>'Login'], function() {
	Route::get('/', 'LoginController@index')->name('login');
	Route::post('checklogin', 'LoginController@checklogin')->name('login.checklogin');
});

// AdminController路由
Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_super_admin']], function() {

	// 显示system页面
	Route::get('systemIndex', 'AdminController@systemIndex')->name('admin.system.index');
	
	// 获取config数据信息
	Route::get('systemList', 'AdminController@systemList')->name('admin.system.list');

	// 显示config页面
	Route::get('configIndex', 'AdminController@configIndex')->name('admin.config.index');

	// 获取config数据信息
	Route::get('configList', 'AdminController@configList')->name('admin.config.list');

	// 获取group数据信息
	// Route::get('groupList', 'AdminController@groupList')->name('admin.group.list');
	
	// 修改config数据
	Route::post('configChange', 'AdminController@configChange')->name('admin.config.change');

	// logout
	Route::get('logout', 'AdminController@logout')->name('admin.logout');

});



// UserController路由
Route::group(['prefix'=>'user', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_user|permission_super_admin']], function() {

	// 显示user页面
	Route::get('userIndex', 'UserController@userIndex')->name('admin.user.index');

	// 获取user数据信息
	// Route::get('userList', 'UserController@userList')->name('admin.user.list');

	// 创建user
	// Route::post('userCreate', 'UserController@userCreate')->name('admin.user.create');

	// 禁用user（软删除）
	// Route::post('userTrash', 'UserController@userTrash')->name('admin.user.trash');

	// 删除user
	// Route::post('userDelete', 'UserController@userDelete')->name('admin.user.delete');

	// 编辑user
	// Route::post('userUpdate', 'UserController@userUpdate')->name('admin.user.update');

	// 导出用户列表
	// Route::get('exportUser', 'UserController@exportUser')->name('admin.user.exportuser');

	// 导出用户所属角色
	// Route::get('exportroleofuser', 'UserController@exportRoleOfUser')->name('admin.user.exportroleofuser');

	// 清除user的ttl
	// Route::post('userclsttl', 'UserController@userClsttl')->name('admin.user.clsttl');

	// 角色同步到指定用户
	// Route::post('syncRoleToUser', 'UserController@syncRoleToUser')->name('admin.user.syncroletouser');

});


// RoleController路由
Route::group(['prefix'=>'role', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_role|permission_super_admin']], function() {

	// 显示role页面
	Route::get('roleIndex', 'RoleController@roleIndex')->name('admin.role.index');

	// 列出所有用户
	// Route::get('userList', 'RoleController@userList')->name('admin.role.userlist');

	// 列出所有角色
	// Route::get('roleList', 'RoleController@roleList')->name('admin.role.rolelist');

	// 列出所有权限
	// Route::get('permissionList', 'RoleController@permissionList')->name('admin.role.permissionlist');

	// 列出所有待删除的角色
	// Route::get('roleListDelete', 'RoleController@roleListDelete')->name('admin.role.rolelistdelete');

	// 创建role
	// Route::post('roleCreate', 'RoleController@roleCreate')->name('admin.role.create');

	// 编辑role
	// Route::post('roleUpdate', 'RoleController@roleUpdate')->name('admin.role.update');
	
	// 删除角色
	// Route::post('roleDelete', 'RoleController@roleDelete')->name('admin.role.roledelete');

	// 列出当前用户拥有的角色
	// Route::get('userHasRole', 'RoleController@userHasRole')->name('admin.role.userhasrole');

	// 更新当前用户的角色
	// Route::post('userUpdateRole', 'RoleController@userUpdateRole')->name('admin.role.userupdaterole');

	// 列出当前用户可追加的角色
	// Route::get('userGiveRole', 'RoleController@userGiveRole')->name('admin.role.usergiverole');

	// 赋予role
	// Route::post('roleGive', 'RoleController@roleGive')->name('admin.role.give');
	// 移除role
	// Route::post('roleRemove', 'RoleController@roleRemove')->name('admin.role.remove');

	// 根据角色查看哪些用户
	// Route::get('roleToViewUser', 'RoleController@roleToViewUser')->name('admin.role.roletoviewuser');

	// 权限同步到指定角色
	// Route::post('syncPermissionToRole', 'RoleController@syncPermissionToRole')->name('admin.role.syncpermissiontorole');

	// 查询角色列表
	// Route::get('roleGets', 'RoleController@roleGets')->name('admin.role.rolegets');
	
	// 测试excelExport
	// Route::get('excelExport', 'RoleController@excelExport')->name('admin.role.excelexport');
	
});


// PermissionController路由
Route::group(['prefix'=>'permission', 'namespace'=>'Admin', 'middleware'=>['jwtauth','permission:permission_admin_permission|permission_super_admin']], function() {

	// 显示permission页面
	Route::get('permissionIndex', 'PermissionController@permissionIndex')->name('admin.permission.index');

	// 角色列表
	// Route::get('permissionGets', 'PermissionController@permissionGets')->name('admin.permission.permissiongets');

	// 创建permission
	// Route::post('permissionCreate', 'PermissionController@permissionCreate')->name('admin.permission.create');

	// 编辑permission
	// Route::post('permissionUpdate', 'PermissionController@permissionUpdate')->name('admin.permission.update');
	
	// 删除permission
	// Route::post('permissionDelete', 'PermissionController@permissionDelete')->name('admin.permission.permissiondelete');

	// 赋予permission
	// Route::post('permissionGive', 'PermissionController@permissionGive')->name('admin.permission.give');
	// 移除permission
	// Route::post('permissionRemove', 'PermissionController@permissionRemove')->name('admin.permission.remove');

	// 列出当前角色拥有的权限
	// Route::get('roleHasPermission', 'PermissionController@roleHasPermission')->name('admin.permission.rolehaspermission');

	// 更新当前角色的权限
	// Route::post('roleUpdatePermission', 'PermissionController@roleUpdatePermission')->name('admin.permission.roleupdatepermission');
	
	// 列出所有待删除的权限
	// Route::get('permissionListDelete', 'PermissionController@permissionListDelete')->name('admin.permission.permissionlistdelete');

	// 列出所有权限
	// Route::get('permissionList', 'PermissionController@permissionList')->name('admin.permission.permissionlist');

	// 根据权限查看哪些角色
	// Route::get('permissionToViewRole', 'PermissionController@permissionToViewRole')->name('admin.permission.permissiontoviewrole');

	// 角色同步到指定权限
	// Route::post('testUsersPermission', 'PermissionController@testUsersPermission')->name('admin.permission.testuserspermission');
	
	// 测试excelExport
	// Route::get('excelExport', 'PermissionController@excelExport')->name('admin.permission.excelexport');

	// 列出所有角色
	// Route::get('roleList', 'PermissionController@roleList')->name('admin.permission.rolelist');

	// 列出所有用户
	// Route::get('userList', 'PermissionController@userList')->name('admin.permission.userlist');
	
});