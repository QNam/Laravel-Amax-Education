<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Model\Student as StudentModel;

class StudentController extends Controller
{
    public function _getDocData()
    {
        
    }

    public function getStudentInfo(Request $request)
    {   
        $id = $request->input('stu_id');
        $student = new StudentModel();

        $data =  $student::where('stu_id',$id)->get();

        if ( !isset($data) ) {
            return response()->json(['msg'=>'Không tìm thấy thông tin học sinh !', 'success'=>false]);
        }

        return response()->json(['msg'=>'Thành công !', 'success'=>true, 'data' => $data[0]]);
        

        
    }

    public function editStudentName(Request $request)
    {
        $stu_id = $request->input('pk');
        $stu_name = $request->input('value');
        
        $student = new StudentModel();

        $student::where('stu_id',$stu_id)->update(['stu_name' => $stu_name]);
    }
   
   
    public function index()
    {
         $student = new StudentModel();

         $data['students'] = $student::orderBy('updated_at', 'desc')->get();

        $data['title'] = 'Danh sách học sinh';
        return view('student/data')->with($data);
    }


    public function store(Request $request)
    {
        $stuId = $request->input('stuId'); 

        $input = array(
            'stu_name' => $request->input('stuName'),
            'stu_class' => $request->input('stuClass'),
            'parent_phone' => $request->input('parentPhone'),
            'parent_name' => $request->input('parentName')
        );

        $student = new StudentModel();

        if ( !isset($stuId) ) 
        {
            if ($student::create($input)) {
                Session::flash('success', 'Thêm học sinh thành công !'); 
                return redirect()->route('StudentIndex');
            } else {
                Session::flash('error', 'Thêm học sinh thất bại !'); 
                return redirect()->route('StudentIndex');
            }

        } else {
            if ($student::where('stu_id',$stuId)->update($input)) {
                 Session::flash('success', 'Cập nhật học sinh thành công !'); 
                return redirect()->route('StudentIndex');
            } else {
                Session::flash('error', 'Cập nhật học sinh thất bại !'); 
                return redirect()->route('StudentIndex');
            }
        }
    }

        

}
