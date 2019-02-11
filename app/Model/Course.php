<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\Teacher as TeacherModel;
use App\Model\Register as RegModel;
use App\Model\Bill as BillModel;

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


    public function getBaseCourseOfStudent($stu_id)
    {   
        $reg = new RegModel();

        return $reg::where('stu_id',$stu_id)->get();
    }


    public function setRegisterToUnactive($cou_id)
    {
        $reg = new RegModel();

        return $reg::where('cou_id',$cou_id)->update(['status' => $reg::LOCK]);
    }

    public function courseHasTraded($cou_id,$stu_id)
    {
        $bill = new BillModel();

        $counter = $bill::where(['detail_bill.cou_id' => $cou_id,'bill.stu_id' => $stu_id ])
                    ->join('detail_bill','bill.bill_id','detail_bill.bill_id')
                    ->count();

        if($counter > 0) return true;
        return false; 
    }



    public function getCourseOfStudent($stu_id)
    {
        $course = new Course();

        return $course::join('register','register.cou_id','course.cou_id')
                        ->join('student','student.stu_id','register.stu_id')
                        ->join('teacher','course.cou_teacher','teacher.tea_id')
                        ->join('subject','course.cou_subject','subject.sub_id')
                        ->where('student.stu_id', $stu_id)
                        ->get(['course.*','register.status','tea_name','sub_name']);

    }

     public function students()
    {
        return $this->belongsToMany(Student::class,'register','cou_id','stu_id');
    }

}
