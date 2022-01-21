<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
	public function cars(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
		return $this->hasMany('App\Models\Car', 'make_id');
	}
}
