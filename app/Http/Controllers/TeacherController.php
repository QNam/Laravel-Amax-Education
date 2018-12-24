<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

use App\Model\Teacher as TeacherModel;
use App\Model\Course as CourseModel;

class TeacherController extends Controller
{
    public $messages = [
        'teaName.required' => "Vui lòng nhập tên giáo viên!",
        'teaPhone.required' => "Vui lòng nhập số điện thoại !",
        'teaPhone.numeric' => "Số điện thoại phải là số !"
    ];

    public $rules = [
        'teaName' => "required",
        'teaPhone' => "bail|required|numeric",
    ];

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


    public function deleteTeacher(Request $request)
    {
        $tea_id = $request->input('teaId');
        $teacher = new TeacherModel();   

        try{
            $teacher::where('tea_id',$tea_id)->delete();

            Session::flash('success', 'Xóa giáo viên thành công !'); 
            return redirect()->route('TeacherIndex');  
        } catch(\Exception $e) {
            Session::flash('error', 'Xóa giáo viên thất bại !'); 
            return redirect()->route('TeacherIndex'); 
        }
    }
   
   
    public function store(Request $request)
    {
        $tea_id = $request->input('teaId');
        $teacher = new TeacherModel();

        $input = [
            'tea_name' => $request->input('teaName'),
            'tea_phone' => $request->input('teaPhone'),
            'tea_address' => $request->input('teaAddress'),
            'tea_office' => $request->input('teaOffice')
        ];
         $validator = Validator::make($request->all(), $this->rules, $this->messages);

         if ( $validator->fails() ) {
           return redirect()->route('TeacherIndex')->withErrors($validator)->withInput();
        }

        if (isset($tea_id)) {
            try{
                $teacher::where('tea_id',$tea_id)->update($input);

                Session::flash('success', 'Cập nhật giáo viên thành công !'); 
                return redirect()->route('TeacherIndex');    
                
            } catch(\Exception $e){
                 Session::flash('error', 'Cập nhật giáo viên thất bại !'); 
                return redirect()->route('TeacherIndex');  
            }
        }  
        else 
        {
            try{
                $teacher::create($input);

                Session::flash('success', 'Thêm giáo viên thành công !'); 
                return redirect()->route('TeacherIndex');    

            } catch(\Exception $e){
                 Session::flash('error', 'Thêm giáo viên thất bại !'); 
                return redirect()->route('TeacherIndex');  
            }

        }
    }

}
