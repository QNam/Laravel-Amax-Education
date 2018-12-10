<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\Teacher as TeacherModel;

class Course extends Model
{
    protected $table 		= 	'course';
    protected $primaryKey 	= 	'cou_id';
    public 	  $timestamps	=	true;
    public 	  $incrementing = 	true;
     protected $fillable = [
        'cou_id', 'cou_name','cou_teacher', 'cou_subject', 'cou_price','cou_desc','cou_class'
    ];


    public function getCourseOfTeacher($tea_id)
    {
    	$teacher = new TeacherModel();

    	return $teacher::join('course','course.cou_teacher','teacher.tea_id')
    					->where('tea_id',$tea_id)
    					->get(['course.*','tea_name']);
    }

}
