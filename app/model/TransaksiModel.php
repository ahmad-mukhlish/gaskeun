<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class TransaksiModel extends Model
{
	protected $table = "tb_transaksi";
  public $timestamps = false;
	protected $primaryKey = 'id_transaksi';
}
