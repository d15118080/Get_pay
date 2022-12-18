<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction_history extends Model
{
    protected $table = "transaction_historys";
    public $timestamps = false; //created_at, updated_at 컬럼 사용 안함
    use HasFactory;
}
