<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
   protected  $table 		= 	'subject';
   protected  $primaryKey 	= 	'sub_id';
   public 	  $timestamps	=	true;
   public 	  $incrementing = 	true;
   protected  $fillable = [
	    'sub_id', 'sub_name'
	];
}
