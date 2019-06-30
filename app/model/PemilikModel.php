<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class PemilikModel extends Model
{

	protected $table = "tb_pemilik";
  public $timestamps = false;
	protected $primaryKey = 'id_pemilik';
}
