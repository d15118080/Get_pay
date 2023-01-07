<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class system_log extends Model
{
    use HasFactory;
    protected $table = "system_logs";
    public $timestamps = false; //created_at, updated_at 컬럼 사용 안함
}
