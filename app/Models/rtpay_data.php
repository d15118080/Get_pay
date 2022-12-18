<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rtpay_data extends Model
{
    use HasFactory;
    protected $table = "rtpay_data";
    public $timestamps = false; //created_at, updated_at 컬럼 사용 안함
}
