<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\Student as StudentModel;
use App\Model\Course as CourseModel;

class Register extends Model
{
    protected $table 		= 	'register';
    protected $primaryKey 	= 	false;
    public 	  $timestamps	=	true;
    public 	  $incrementing = 	true;
    protected $fillable = ['cou_id', 'stu_id'];

    // public function getCourseOfStudent($filter = [],$detail = false)
    // {
    // 	$student = new StudentModel();

    //     $data = $student::where($filter)
    //                     ->join('register','student.stu_id','register.stu_id')
    //                     ->join('course','course.cou_id','register.cou_id')
    //                     ->join('teacher','teacher.tea_id','course.cou_teacher')
    //                     ->join('subject','subject.sub_id','course.cou_subject')
    //                     ->select('student.*')
    //                     ->get(); 

    //     if ($detail) 
    //     {
    //         $data = 
    //     }  

    	
    // }
}
