<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StallType extends Model
{
    use HasFactory;

    protected $table = 'stall_types';
    public $primaryKey = 'id';
}
