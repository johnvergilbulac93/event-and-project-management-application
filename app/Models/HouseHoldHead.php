<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class HouseHoldHead extends Model
{
    use SoftDeletes, Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'suffix',
        'birth_place',
        'date_of_birth',
        'mobile_no',
        'gender',
        'street',
        'house_no',
        'purok',
        'email',
        'isActive',
    ];

    protected $appends = ['full_name'];
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
