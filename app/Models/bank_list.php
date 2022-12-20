<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bank_list extends Model
{
    use HasFactory;
    protected $table = "bank_list";
    public $timestamps = false; //created_at, updated_at 컬럼 사용 안함
}
