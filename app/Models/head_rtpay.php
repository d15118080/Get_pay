<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class head_rtpay extends Model
{
    use HasFactory;
    protected $table = "head_rtpay";
    public $timestamps = false; //created_at, updated_at 컬럼 사용 안함
}
