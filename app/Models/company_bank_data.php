<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company_bank_data extends Model
{
    use HasFactory;
    protected $table = "company_bank_data";
    public $timestamps = false; //created_at, updated_at 컬럼 사용 안함

}
