<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
   protected  $table 		= 	'subject';
   protected  $primaryKey 	= 	'sub_id';
   public 	  $timestamps	=	false;
   public 	  $incrementing = 	true;
   public 	  $created_at = 	false;
   public 	  $updated_at = 	false;
   protected  $fillable = [
	    'sub_id', 'sub_name'
	];
}
