<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommonModel extends Model
{
    protected $table = '';

	protected $fillable = [];

    public function set_config($table=false, $fillable=false){

		// if(!$table && !$fillable) return false;

    	$obj = new CommonModel();

    	if($table)
    		$obj->table = $table;

    	if($fillable)
			$obj->fillable = $fillable;

    	return $obj;

	}

}
