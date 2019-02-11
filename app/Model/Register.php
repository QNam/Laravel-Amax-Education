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
    protected $fillable = ['cou_id', 'stu_id','status'];

     public const ACTIVE = '1';
    public const LOCK = '0';

    public function isRegister($stuId,$couId)
    {
        $checker = $this::where(['stu_id'=> $stuId, 'cou_id' => $couId])
                        ->count();

        return $checker;
    }

    public function isActive($couId,$stuId)
    {
        $checker = $this::where(['cou_id'=>$couId,'stu_id' => $stuId])
                    ->get(['status']);

        if(isset($checker[0]) && $checker[0]->status == $this::ACTIVE) return true;
        return false;
    }

    public function hasTraded($stuId,$couId)
    {
        $checker = $this::where(['register.stu_id'=> $stuId, 'detail_bill.cou_id' => $couId])
                        ->join('bill','bill.stu_id','register.stu_id')
                        ->join('detail_bill','detail_bill.bill_id','bill.bill_id')
                        ->count();

        return $checker;
    }

    public function resetRegisterCourse($stu_id)
    {
        $course = new CourseModel();

        $listCourse = $course->getBaseCourseOfStudent($stu_id);

        foreach ($listCourse as $key => $value) {
            if(!$course->courseHasTraded($value->cou_id,$stu_id) ) 
            {
                $this::where(['cou_id'=>$value->cou_id,'stu_id'=>$stu_id])->delete();
            } else {
                $course->setRegisterToUnactive($value->cou_id);
            }
        }

    }
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
