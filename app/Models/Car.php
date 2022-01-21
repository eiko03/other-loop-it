<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
	public function make(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
		return $this->belongsTo('App\Models\Make', 'make_id');
	}
	public function model(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
		return $this->belongsTo('App\Models\Model', 'model_id');
	}
}
