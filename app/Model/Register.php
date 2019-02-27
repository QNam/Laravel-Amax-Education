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
    public const LOCK   = '0';

    public function isRegister($stuId,$couId)
    {
        $checker = $this::where(['stu_id'=> $stuId, 'cou_id' => $couId])
                        ->count();

        return $checker;
    }


    public function getOneRegId($cou_id,$stu_id)
    {
        $checker = $this::where(['cou_id' => $cou_id,'stu_id' => $stu_id])->get(['reg_id']);

        if( isset($checker[0]->reg_id) )
            return $checker[0]->reg_id;
        return false;        
    }

    public function isActive($couId,$stuId)
    {
        $checker = $this::where(['cou_id'=>$couId,'stu_id' => $stuId])
                    ->get(['status']);

        if(isset($checker[0]->status) && $checker[0]->status == $this::ACTIVE) return true;
        return false;
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

}
