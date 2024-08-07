<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MsCustomer
 * 
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $phone
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MsCustomer extends Model
{
    use HasFactory;

	protected $table = 'ms_customer';

	protected $fillable = [
		'nama',
		'alamat',
		'phone'
	];
}
