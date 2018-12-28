<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\Teacher as TeacherModel;
use App\Model\Register as RegModel;

class Course extends Model
{
    protected $table 		= 	'course';
    protected $primaryKey 	= 	'cou_id';
    public 	  $timestamps	=	true;
    public 	  $incrementing = 	true;
    protected $fillable = [
        'cou_id', 'cou_name','cou_teacher', 'cou_subject', 'cou_price','cou_desc','cou_class','cou_start','cou_end','cou_grade','cou_date'
    ];



    public function getCourseInfo($filter = [])
    {
        $course = new Course();

        return $course::join('teacher','course.cou_teacher','teacher.tea_id')
                        ->join('subject','course.cou_subject','subject.sub_id')
                        ->where($filter)
                        ->get(['course.*','sub_name','tea_name']);
    }

    
    public function getTotalStudentOfCourse($cou_id)
    {
        $reg = new RegModel();

        return $reg::where('cou_id',$cou_id)->count();
    }

    public function getCourseOfTeacher($tea_id)
    {
    	$teacher = new TeacherModel();

    	return $teacher::join('course','course.cou_teacher','teacher.tea_id')
    					->where('tea_id',$tea_id)
    					->get(['course.*','tea_name']);
    }

    public function getCourseOfStudent($stu_id)
    {
        $course = new Course();

        return $course::join('register','register.cou_id','course.cou_id')
                        ->join('student','student.stu_id','register.stu_id')
                        ->select('course.*')
                        ->where('student.stu_id', $stu_id)
                        ->get();

    }

     public function students()
    {
        return $this->belongsToMany(Student::class,'register','cou_id','stu_id');
    }

}
