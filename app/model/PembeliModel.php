<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class PembeliModel extends Model
{

	protected $table = "tb_pembeli";
  public $timestamps = false;
	protected $primaryKey = 'id_pembeli';
}
