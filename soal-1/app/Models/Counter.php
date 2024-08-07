<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Counter
 * 
 * @property int $id
 * @property string $bulan
 * @property string $tahun
 * @property int $counter
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Counter extends Model
{
	protected $table = 'counter';

	protected $casts = [
		'counter' => 'int'
	];

	protected $fillable = [
		'bulan',
		'tahun',
		'counter'
	];
}
