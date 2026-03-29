<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseHoldMember extends Model
{
    //

    use SoftDeletes;

    protected $fillable = ['name', 'household_head_id', 'gender'];
}
