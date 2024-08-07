<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransaksiD
 * 
 * @property int $id
 * @property int $transaksi_h_id
 * @property string $kd_barang
 * @property string $nama_barang
 * @property int $qty
 * @property float $subtotal
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TransaksiH $transaksi_h
 *
 * @package App\Models
 */
class TransaksiD extends Model
{
	protected $table = 'transaksi_d';

	protected $casts = [
		'transaksi_h_id' => 'int',
		'qty' => 'int',
		'subtotal' => 'float'
	];

	protected $fillable = [
		'transaksi_h_id',
		'kd_barang',
		'nama_barang',
		'qty',
		'subtotal'
	];

	public function transaksi_h()
	{
		return $this->belongsTo(TransaksiH::class);
	}
}
