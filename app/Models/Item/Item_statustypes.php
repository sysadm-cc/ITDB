<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Item_statustypes extends Model
{
    // use SoftDeletes;

    // protected $dates = ['deleted_at'];

	protected $fillable = [
        'id', 'statusdesc',
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
