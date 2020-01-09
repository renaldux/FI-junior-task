<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transfer extends Model
{
    protected $table = 'transfers';

    protected $guarded = ['id'];

}
