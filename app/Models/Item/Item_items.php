<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Item_items extends Model
{
    // use SoftDeletes;

    // protected $dates = ['deleted_at'];

	protected $fillable = [
        'id', 'itemtypeid', 'function', 'manufacturerid', 'model', 'servicetag', 'sn1', 'sn2', 'origin', 
        'warrantymonths', 'purchasedate', 'purchprice', 'dnsname', 'maintenanceinfo', 
        'comments', 'ispart', 'hd', 'cpu', 'ram', 'locationid', 'userid', 'ipv4', 'ipv6', 
        'usize', 'rackmountable', 'macs', 'remadmip', 'panelport', 'ports', 'switchport', 
        'switchid', 'rackid', 'rackposition', 'label', 'status', 'cpuno', 'corespercpu', 
        'rackposdepth', 'warrinfo', 'locareaid', 
    ];

    /**
     * 这个属性应该被转换为原生类型.
     * 用于json与array互相转换
     * @var array
     */
    // protected $casts = [
    //     'application' => 'array',
    //     // 'actuality' => 'array',
    //     'auditing' => 'array',
    // ];


}
