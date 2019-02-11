<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentLog extends Model
{
    //
	protected $table 		= 	'student_log';
    protected $primaryKey 	= 	'stu_id';
    public 	  $timestamps	=	false;
    public 	  $incrementing = 	true;
    protected $fillable = [
        'stu_id', 'stu_name','stu_address', 'parent_name', 'parent_phone','note','reg_day'
    ];

    public function getListStudentlog($filter = [])
    {
    	return $this::where($filter)->get();
    }
}
