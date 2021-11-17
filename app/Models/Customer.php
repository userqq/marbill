<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public const SEX_FEMALE = 0;
    public const SEX_MALE   = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'sex',
        'birth_date',
        'user_id',
    ];

    public static function getPlacholderProperties(): array
    {
        return ['email', 'first_name', 'last_name', 'sex', 'birth_date'];
    }
}
