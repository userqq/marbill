<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerGroup extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function customers(): Relation
    {
        return $this->hasManyThrough(
            Customer::class,
            CustomerToGroup::class,
            'customer_group_id',
            'id',
            'id',
            'customer_id'
        );
    }
}
