<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Support\Htmlable;

use App\Model\Student as StudentModel;
use App\Model\Register as RegModel;
use App\Model\Course as CourseModel;

class StudentController extends Controller
{
    public function _getDocData($filter = [], $detail = false)
    {
        $student   =  new StudentModel();
        $reg       =  new RegModel();
        $data      = array();
        
        foreach ($filter as $key => $value) 
        {
            if (empty($value)) {
                unset( $filter[$key] );
            }
        }
    
        try{
            $data =  $student::where($filter)->get();
        } catch(\Exception $e){}

        if ($detail) {
            $data =  $reg->getCourseOfStudent($filter);         
         }

        return $data;
    }


    public function index()
    {
        $student = new StudentModel();
        $course  = new CourseModel();

        $data['students'] = $this->_getDocData();
        $data['courses'] = $course::get(['cou_id','cou_name']);

        $data['title'] = 'Danh sách học sinh';

            
        return view('student/index')->with($data);
    }



    public function getStudentFromFilter(Request $request)
    {
        $grade  = $request->input('stuGrade');
        $course = $request->input('stuCourse');

        $data['students'] = $this->_getDocData(['stu_grade' => $grade, 'course.cou_id' => $course],true);

         $html = view('student/data')->with($data)->render();

         return $html;
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
   
   
    


    public function store(Request $request)
    {
        $student = new StudentModel();
        $course  = new CourseModel();

        $student->stu_id = $request->input('stuId'); 
        $student->stu_name = $request->input('stuName');
        $student->stu_grade = $request->input('stuGrade');
        $student->stu_address = $request->input('stuAddress');
        $student->parent_phone = $request->input('parentPhone');
        $student->parent_name = $request->input('parentName');
        
        $inpCourse = $request->input('regCourse');

        if ( !isset($student->stu_id) ) 
        {
           \DB::beginTransaction();

           try{
                $student->save();

                $student->courses()->attach('1');

                \DB::commit();

                Session::flash('success', 'Cập nhật khóa học thành công !'); 
                return redirect()->route('StudentIndex');

           } catch (\Throwable  $e) {
                \DB::rollback();
                Session::flash('error', 'Cập nhật khóa học thất bại !'); 
                return redirect()->route('StudentIndex');
           }

        }

    }

        

}
