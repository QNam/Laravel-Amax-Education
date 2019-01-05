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
    ];

    public $rules = [
        'couName' => "required",
        'couSubject' => "bail|required|numeric",
        'couGrade' => "numeric",
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
            $value['cou_time']  =   json_decode($value['cou_time'],true);
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

        // $courseList = &$data['courses'];
        // foreach ($data['courses'] as &$value) {

        //     foreach ($value['cou_time'] as &$v) 
        //     {   
        //         $v['date'] = ($v['date'] == 0) ? "Chủ Nhật" : (int)$v['date'] + 1;    
        //     }
        // }
        // $num_course = count($data['courses']);
        // for ($i=0; $i < $num_course; $i++) { 
        //     $num_time = count( $data['courses'][$i]['cou_time'] );
        //     var_dump($num_time);
        //     for ($j=0; $j < $num_time; $j++) { 
        //         $data['courses'][$i]['cou_time'][$j]['date'] = ($data['courses'][$i]['cou_time'][$j]['date'] == 0) ? "Chủ Nhật" : (int)$data['courses'][$i]['cou_time'][$j]['date'] + 1;
        //     }
        // }
        // dd($data['courses']);

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
        $couTime = $request->input('couTime');

        foreach ($couTime as $key => $value) {
            if (count($value) < 3 ) 
            {
                unset($couTime[$key]);    
            }
        }

        $couTimeTemp = [];

        foreach ($couTime as $key => $value) {
            $couTimeTemp[] = $value;                        
        }        

        if (json_encode($couTimeTemp) ) {
            $couTimeTemp = json_encode($couTimeTemp);            
        } else {
            $couTimeTemp = [];
        }
        
    	$input = [
    		'cou_name' => $request->input('couName'),
    		'cou_teacher' => $request->input('couTeacher'),
    		'cou_subject' => $request->input('couSubject'),
    		'cou_price' => $request->input('couPrice'),
            'cou_desc' => $request->input('couDesc'),
            'cou_grade' => $request->input('couGrade'),
            'cou_time' => $couTimeTemp
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
