<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Student as StudentModel;
use App\Model\Teacher as TeacherModel;
use App\Model\Register as RegModel;
use App\Model\Course as CourseModel;
use App\Model\Bill as BillModel;
use App\Model\DetailBill as DetailBillModel;

class DashboardController extends Controller
{
    public $bgColorList = ['#039BE5','#e5033c','#e54803','#333','#7503e5','#252123','#f44336','#e91e63','#4caf50','#795548'];

    public function index()
    {
    	$data = [];
    	$student = new StudentModel();
    	$course = new CourseModel();
    	$teacher = new TeacherModel();

    	$data['title'] = 'Amax Education';

    	$data['tk']['student'] =  $student::count();
    	$data['tk']['course'] =  $course::count();
    	$data['tk']['teacher'] =  $teacher::count();


        $data['courses'] = $course::get()->toArray();

        $i = 0;
        foreach ($data['courses'] as $key => $value) 
        {
            $data['courses'][$key]['cou_time'] = json_decode($value['cou_time'],true);
            $value['cou_time'] = json_decode($value['cou_time'],true);

            if (count($value['cou_time']) > 0 ) 
            {   
                foreach ($value['cou_time'] as $k => $v) 
                {
                    $data['courses'][$key]['cou_time'][$k]['color'] = $this->bgColorList[$i]; 
                }
                $i++;
            }  
        }

        $data['courses']=json_encode($data['courses']);

        
    	return view('dashboard/index')->with($data);
    }
}
