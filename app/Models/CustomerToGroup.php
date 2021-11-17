<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerToGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'customer_id',
        'customer_group_id',
        'user_id',
    ];
}
