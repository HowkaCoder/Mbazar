<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Searchs extends Model
{
    use HasFactory;
    protected $fillable = [
      'query',
      'user_id',
      'result',
    ];
}
