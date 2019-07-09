<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class BahanModel extends Model
{
	protected $table = "tb_bahan";
  public $timestamps = false;
	protected $primaryKey = 'id_bahan';
}
