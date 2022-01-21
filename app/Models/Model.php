<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
	public function cars(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
		return $this->hasMany('App\Models\Model', 'model_id');
	}
}
