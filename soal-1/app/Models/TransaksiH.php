<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransaksiH
 * 
 * @property int $id
 * @property int $customer_id
 * @property Carbon $nomor_transaksi
 * @property Carbon $tanggal_transaksi
 * @property float $total_transaksi
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property MsCustomer $ms_customer
 *
 * @package App\Models
 */
class TransaksiH extends Model
{
	protected $table = 'transaksi_h';

	protected $casts = [
		'customer_id' => 'int',
		'nomor_transaksi' => 'datetime',
		'tanggal_transaksi' => 'datetime',
		'total_transaksi' => 'float'
	];

	protected $fillable = [
		'customer_id',
		'nomor_transaksi',
		'tanggal_transaksi',
		'total_transaksi'
	];

	public function ms_customer()
	{
		return $this->belongsTo(MsCustomer::class, 'customer_id');
	}
}
