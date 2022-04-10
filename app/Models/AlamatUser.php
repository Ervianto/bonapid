<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatUser extends Model
{
    use HasFactory;
    protected $table = "alamat_user";
    protected $fillable = [
        "province_id",
        "city_id",
        "kode_pos",
        "alamat"
    ];
}
