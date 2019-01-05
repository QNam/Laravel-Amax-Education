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

    public function courses()
    {
        return $this->belongsToMany(Course::class,'register','stu_id','cou_id');
    }

    public function getStudentInfo($filter = [])
    {
        $student = new Student();

        return $student::join('register','student.stu_id','register.stu_id')
                        ->join('course','course.cou_id','register.cou_id')
                        ->where($filter)
                        ->groupBy('student.stu_id')
                        ->orderBy('updated_at','DESC')
                        ->get(['student.*']);
    }
}
