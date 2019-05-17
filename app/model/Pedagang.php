<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model
{
	protected $table = "tb_pedagang";
  public $timestamps = false;
	protected $primaryKey = 'id_pedagang';
}
