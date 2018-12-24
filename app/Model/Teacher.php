<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
   protected  $table 		= 	'teacher';
   protected  $primaryKey 	= 	'tea_id';
   public 	  $timestamps	=	true;
   public 	  $incrementing = 	true;
   protected  $fillable = [
	    'tea_id', 'tea_name','tea_phone', 'tea_address','tea_office'
	];

}
