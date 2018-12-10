<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Model\Course as CourseModel;
use App\Model\Teacher as TeacherModel;
use App\Model\Subject as SubjectModel;

class CourseController extends Controller
{
 	public function _getDocData($cou_id)
    {
    	 $course = new CourseModel();

        $data = $course::join('teacher','course.cou_teacher','teacher.tea_id')
								->join('subject','course.cou_subject','subject.sub_id')
								->where('cou_id',$cou_id)
								->get(['course.*','sub_name','tea_name']);

		return $data;
    }

    public function getCourseInfo(Request $request)
    {   
    	$cou_id = $request->input('cou_id');
        $course = new CourseModel();

    	$data = $this->_getDocData($cou_id);


        if ( !isset($data) ) {
            return response()->json(['msg'=>'Không tìm thấy thông tin khóa học !', 'success'=>false]);
        }

        return response()->json(['msg'=>'Thành công !', 'success'=>true, 'data' => $data[0]]);
    }


    public function courseRegister()
    {
    	$data = array();

    	$data['title'] = 'Đăng kí khóa học';
    	
    	return view('course/register-course')->with($data);
    }

    public function index()
    {
    	$data = array();

    	$course   = new CourseModel();
    	$teacher  = new TeacherModel();
    	$subject  = new SubjectModel();

    	$data['title'] = 'Danh sách khóa học';
    	$data['courses'] = $course::join('teacher','course.cou_teacher','teacher.tea_id')
    								->join('subject','course.cou_subject','subject.sub_id')
    								->orderBy('updated_at','desc')
    								->get(['course.*','sub_name','tea_name']);

    	$data['subjects'] = $subject::get(['sub_id','sub_name']);
    	$data['teachers'] = $teacher::get(['tea_id','tea_name']);

    	return view('course/list')->with($data);
    }


    public function store(Request $request)
    {
    	$cou_id = $request->input('couId');
    	$course = new CourseModel();

    	$input = [
    		'cou_name' => $request->input('couName'),
    		'cou_teacher' => $request->input('couTeacher'),
    		'cou_subject' => $request->input('couSubject'),
    		'cou_class' => $request->input('couClass'),
    		'cou_price' => $request->input('couPrice'),
    		'cou_desc' => $request->input('couDesc'),
    	];


		if (isset($cou_id)) {
    		if ( $course::where('cou_id',$cou_id)->update($input) ) {
				Session::flash('success', 'Cập nhật khóa học thành công !'); 

             	return redirect()->route('CourseIndex');	
    		} else {
    			Session::flash('error', 'Cập nhật khóa học thất bại !'); 

             	return redirect()->route('CourseIndex');	
    		}	
    	}  
    	else 
    	{
    		if ( $course::create($input) ) {
    			Session::flash('success', 'Thêm khóa học thành công !'); 

             	return redirect()->route('CourseIndex');	
    		} else {
    			Session::flash('error', 'Thêm khóa học thất bại !'); 

             	return redirect()->route('CourseIndex');	
    		}

    	}

    }

    
}
