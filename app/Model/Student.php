<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table 		= 	'student';
    protected $primaryKey 	= 	'stu_id';
    public 	  $timestamps	=	true;
    public 	  $incrementing = 	true;
     protected $fillable = [
        'stu_id', 'stu_name','stu_class', 'parent_name', 'parent_phone'
    ];

}
