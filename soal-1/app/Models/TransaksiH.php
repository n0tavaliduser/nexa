<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransaksiH
 * 
 * @property int $id
 * @property int $customer_id
 * @property string $nomor_transaksi
 * @property Carbon $tanggal_transaksi
 * @property float $total_transaksi
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property MsCustomer $ms_customer
 * @property Collection|TransaksiD[] $transaksi_ds
 *
 * @package App\Models
 */
class TransaksiH extends Model
{
	use HasFactory;

	protected $table = 'transaksi_h';

	protected $casts = [
		'customer_id' => 'int',
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

	public function transaksi_ds()
	{
		return $this->hasMany(TransaksiD::class);
	}
}
