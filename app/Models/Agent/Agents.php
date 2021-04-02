<?php

namespace App\Models\Agent;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Agents extends Model
{
    // use SoftDeletes;

    // protected $dates = ['deleted_at'];

	// protected $fillable = [
    //     'id', 'typedesc', 'hassoftware',
    // ];

    protected $guarded = [];

    /**
     * 这个属性应该被转换为原生类型.
     * 用于json与array互相转换
     * @var array
     */
    protected $casts = [
        'type' => 'array',
        'contacts' => 'array',
        'urls' => 'array',
    ];


}
