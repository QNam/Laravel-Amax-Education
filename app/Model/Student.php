<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Register as RegModel;

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

    public function courses()
    {
        return $this->belongsToMany(Course::class,'register','stu_id','cou_id');
    }

    public function getStudentInfo($filter = [])
    {

        return $this::where($filter)
                        ->join('register','student.stu_id','register.stu_id')
                        ->join('course','course.cou_id','register.cou_id')
                        ->groupBy('student.stu_id')
                        ->orderBy('updated_at','DESC')
                        ->get(['student.*']);
    }



    public function incrementGradeAllStudent()
    {

        try{
            \DB::beginTransaction();

            $this::where(['stu_grade','<',12])->increment('stu_grade',1);
            
            \DB::commit();  

            return true;
            
        } catch (\Throwable  $e) {
            \DB::rollback();
            return false;
        }
    }
}
