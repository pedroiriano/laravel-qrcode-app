<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retribution extends Model
{
    use HasFactory;

    protected $table = 'retributions';
    public $primaryKey = 'id';
}
