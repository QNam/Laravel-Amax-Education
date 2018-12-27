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

    	return view('dashboard/index')->with($data);

    }
}
