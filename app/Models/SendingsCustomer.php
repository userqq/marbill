<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class SendingsCustomer extends Model
{
    public const STATUS_NOT_SENT    = 0;
    public const STATUS_ACQUIRED    = 1;
    public const STATUS_IN_PROGRESS = 2;
    public const STATUS_SENT        = 3;
    public const STATUS_ERROR       = 4;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'status',
    ];

    public function customer(): Relation
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
