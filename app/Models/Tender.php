<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
	use HasFactory;

	protected $fillable = [
		'external_code',
		'number',
		'status',
		'name',
		'change_date'
	];

	protected $casts = [
		'change_date' => 'datetime:Y-m-d\TH:i:s.u\Z',
	];
}
