<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class MakananModel extends Model
{
	protected $table = "tb_makanan";
  public $timestamps = false;
	protected $primaryKey = 'id_makanan';
}
