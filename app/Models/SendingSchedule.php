<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class SendingSchedule extends Model
{
    public const STATUS_NOT_SENT    = 0;
    public const STATUS_ACQUIRED    = 1;
    public const STATUS_IN_PROGRESS = 2;
    public const STATUS_SENT        = 3;
    public const STATUS_ERROR       = 4;

    private const STATUS_NAMES = [
        self::STATUS_NOT_SENT    => 'Not sent',
        self::STATUS_ACQUIRED    => 'Acquired',
        self::STATUS_IN_PROGRESS => 'In Progress',
        self::STATUS_SENT        => 'Sent',
        self::STATUS_ERROR       => 'Error',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'customer_group_id',
        'email_template_id',
        'time',
        'status',
        'user_id',
    ];

    public function customerGroup(): Relation
    {
        return $this->belongsTo(CustomerGroup::class)->withTrashed();
    }

    public function emailTemplate(): Relation
    {
        return $this->belongsTo(EmailTemplate::class);
    }

    public function sendingsCustomers(): Relation
    {
        return $this->hasMany(SendingsCustomer::class);
    }

    public function customers(): Relation
    {
        return $this->hasManyThrough(
            Customer::class,
            SendingsCustomer::class,
            'sending_schedule_id',
            'id',
            'id',
            'customer_id'
        );
    }

    public function getTextStatus(): string
    {
        return static::STATUS_NAMES[$this->status];
    }
}
