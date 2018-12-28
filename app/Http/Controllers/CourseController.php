<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

use App\Model\Course as CourseModel;
use App\Model\Teacher as TeacherModel;
use App\Model\Subject as SubjectModel;

class CourseController extends Controller
{
    public $messages = [
        'couName.required' => "Vui lòng nhập tên lớp học!",
        'couSubject.required' => "Vui lòng chọn một môn học !",
        'couSubject.numeric' => "Mã môn học phải là số !",
        'couTeacher.required' => "Vui lòng chọn một giáo viên",
        'couTeacher.numeric' => "Mã giáo viên phải là số !",
        'couGrade.numeric' => "Khối học phải là số !",
        'couGrade.required' => "Khối học là bắt buộc !",
        'couStart.required' => "Giờ bắt đầu là bắt buộc !",
        'couEnd.required' => "Giờ kết thúc học là bắt buộc !"
    ];

    public $rules = [
        'couName' => "required",
        'couSubject' => "bail|required|numeric",
        'couGrade' => "bail|required|numeric",
        'couStart' => "bail|required",
        'couEnd' => "bail|required",
        'couTeacher' => "bail|required|numeric",
        'couPrice' => "bail|required|numeric"
    ];

 	public function _getDocData($filter = [])
    {
    	$course = new CourseModel();

        foreach ($filter as $key => $value) 
        {
            if (empty($value)) {
                unset( $filter[$key] );
            }
        }

        $data = $course->getCourseInfo($filter);

          foreach ($data as $key => $value) {
            $value['num_student'] = $course->getTotalStudentOfCourse($value['cou_id']);
        }

		return $data;
    }

    public function getCourseInfo(Request $request)
    {   
    	$cou_id = $request->input('cou_id');
        $course = new CourseModel();

    	$data = $this->_getDocData(['cou_id' => $cou_id]);

        if ( count($data) == 0 ) {
            return response()->json(['msg'=>'Không tìm thấy thông tin khóa học !', 'success'=>false]);
        }

        return response()->json(['msg'=>'Thành công !', 'success'=>true, 'data' => $data[0]]);
    }



    public function index()
    {
    	$data = array();

    	$course   = new CourseModel();
    	$teacher  = new TeacherModel();
    	$subject  = new SubjectModel();

    	$data['title'] = 'Danh sách khóa học';
    	$data['courses'] = $this->_getDocData();
    	$data['subjects'] = $subject::get(['sub_id','sub_name']);
    	$data['teachers'] = $teacher::get(['tea_id','tea_name']);

    	return view('course/index')->with($data);
    }


    public function deleteCourse(Request $request)
    {
        $course   = new CourseModel();
        $cou_id = $request->input('couId');

        try{

            $course::where('cou_id',$cou_id)->delete();

            return response()->json(['msg'=>'Xóa Khóa học thành công !', 'success'=>true]);
        } catch(\Exception $e) {
            return response()->json(['msg'=>'Xóa Khóa học thất bại !', 'success'=>false]);
        }

           
    }


    public function store(Request $request)
    {
    	$cou_id = $request->input('couId');
    	$course = new CourseModel();

    	$input = [
    		'cou_name' => $request->input('couName'),
    		'cou_teacher' => $request->input('couTeacher'),
    		'cou_subject' => $request->input('couSubject'),
    		'cou_price' => $request->input('couPrice'),
            'cou_desc' => $request->input('couDesc'),
            'cou_start' => $request->input('couStart'),
            'cou_end' => $request->input('couEnd'),
    		'cou_grade' => $request->input('couGrade'),

    	];

        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ( $validator->fails() ) {
           return redirect()->route('CourseIndex')->withErrors($validator)->withInput();
        }
        

		if (isset($cou_id)) {

            try{
                
                $course::where('cou_id',$cou_id)->update($input);

                Session::flash('success', 'Cập nhật khóa học thành công !'); 
                return redirect()->route('CourseIndex');    

            }catch(\Exception $e) 
            {
                Session::flash('error', 'Cập nhật khóa học thất bại !'); 
                return redirect()->route('CourseIndex');
            }
				
    	}  
    	else 
    	{
            try {

    		   $course::create($input);

                Session::flash('success', 'Thêm khóa học thành công !'); 
                return redirect()->route('CourseIndex');    

            }catch(\Exception $e) 
            {
                Session::flash('error', 'Thêm khóa học thất bại !'); 
                return redirect()->route('CourseIndex');
            }

    	}

    }

    
}
