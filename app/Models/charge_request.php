<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class charge_request extends Model
{
    use HasFactory;
    protected $table = "charge_request";
    public $timestamps = false; //created_at, updated_at 컬럼 사용 안함
}
