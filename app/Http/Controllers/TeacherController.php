<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Model\Teacher as TeacherModel;
use App\Model\Course as CourseModel;

class TeacherController extends Controller
{
    

    public function _getDocData($where = []) 
    {
        $teacher = new TeacherModel();
        $course  = new CourseModel();

        $data = $teacher::where($where)->get();

        foreach ($data as $key => $value) {
            $value['courses'] = $course->getCourseOfTeacher($value->tea_id);
        }

        return $data;
    }

    public function index()
    {
        //

        $data = array();

        $course = new Coursemodel();

        $data['title'] = 'Danh sách giáo viên';

        $data['teachers'] = $this->_getDocData();


        return view('teacher/index')->with($data);
    }


    public function getTeacherInfo(Request $request)
    {
        $tea_id = $request->input('tea_id');
        $teacher = new TeacherModel();

        $data = $this->_getDocData(['tea_id' => $tea_id]);


        if ( !isset($data) ) {
            return response()->json(['msg'=>'Không tìm thấy thông tin giáo viên !', 'success'=>false]);
        }

        return response()->json(['msg'=>'Thành công !', 'success'=>true, 'data' => $data[0] ]);
    }
   
    public function store(Request $request)
    {
        $tea_id = $request->input('couId');
        $teacher = new TeacherModel();

        $input = [
            'tea_name' => $request->input('teaName'),
            'tea_phone' => $request->input('teaPhone'),
        ];


        if (isset($tea_id)) {
            if ( $teacher::where('tea_id',$tea_id)->update($input) ) {
                Session::flash('success', 'Cập nhật giáo viên thành công !'); 

                return redirect()->route('TeacherIndex');    
            } else {
                Session::flash('error', 'Cập nhật giáo viên thất bại !'); 

                return redirect()->route('TeacherIndex');    
            }   
        }  
        else 
        {
            if ( $teacher::create($input) ) {
                Session::flash('success', 'Thêm giáo viên thành công !'); 

                return redirect()->route('TeacherIndex');    
            } else {
                Session::flash('error', 'Thêm giáo viên thất bại !'); 

                return redirect()->route('TeacherIndex');    
            }

        }
    }

}
