<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

use App\Model\Student as StudentModel;
use App\Model\Register as RegModel;
use App\Model\Course as CourseModel;
use App\Model\Bill as BillModel;

class StudentController extends Controller
{
    public $messages = [
        'stuName.required' => "Vui lòng nhập tên !",
        'stuGrade.required' => "Vui lòng chọn một khối !",
        'stuGrade.numeric' => "Khối học phải là một số !",
        'stuAddress.required' => "Vui lòng nhập địa chỉ !",
        'parentName.required' => "Vui lòng nhập tên phụ huynh !",
        'parentPhone.required' => "Vui lòng nhập số điện thoại phụ huynh !",
        'regCourse[].required'=> "Vui lòng chọn một khóa học !",
        'regCourse[].numeric'=> "Khóa học không hợp lệ !"
    ];

    public $rules = [
        'stuName' => "required",
        'stuGrade' => "bail|required|numeric",
        'stuAddress' => "required",
        'parentName' => "required",
        'regCourse.*' => "required|numeric",
        'parentPhone' => "bail|required"
    ];


    public function _getDocData($filter = [], $detail = false)
    {
        $student   =  new StudentModel();
        $course     =  new CourseModel();
        $data      = array();
        
        foreach ($filter as $key => $value) 
        {
            if (empty($value)) {
                unset( $filter[$key] );
            }
        }
        
        try{
            $data =  $student->getStudentInfo($filter);

            if ($detail) 
            {
                foreach ($data as $key => $value) {
                    $value['courses'] = $course->getCourseOfStudent($value['stu_id']);
                }
            }
        } catch(\Exception $e){}

        return $data;
    }


    public function index()
    {
        $student = new StudentModel();
        $course  = new CourseModel();

        //$data['students'] = $this->_getDocData();
        $data['students'] = $student::get();
        $data['courses'] = $course::get(['cou_id','cou_name']);

        $data['title'] = 'Danh sách học sinh';
            
        return view('student/index')->with($data);
    }



    public function getStudentFromFilter(Request $request)
    {
        $grade  = $request->input('stuGrade');
        $course = $request->input('stuCourse');
        $search = $request->input('stuSearch');
        $wallet = $request->input('stuWallet');

        $data = [];

        $filter = [
            'stu_grade' => $grade, 
            'course.cou_id' => $course,
            ['stu_name','LIKE',"%$search%"]
        ];

        if (isset($wallet) && $wallet == 0) {
             $filter[] = ['stu_wallet','=','0'];
        }

        if (isset($wallet) && $wallet > 0) {
             $filter[] = ['stu_wallet','>','0'];
        }

        if (isset($wallet) && $wallet < 0) {
             $filter[] = ['stu_wallet','<','0'];
        }
        
        $data['students'] = $this->_getDocData($filter);
        
        $html = view('student/data')->with($data)->render();        


        return view('student/data')->with($data);
    }



    public function getStudentInfo(Request $request)
    {   
        $id = $request->input('stu_id');

        $data =  $this->_getDocData(['student.stu_id' => $id],true);

        if ( count($data) == 0 ) {
            return response()->json(['msg'=>'Không tìm thấy thông tin học sinh !', 'success'=>false]);
        }

        return response()->json(['msg'=>'Thành công !', 'success'=>true, 'data' => $data]);
        
    }


    public function deleteStudent(Request $request)
    {
        $stu_id = $request->input('stuId');

        $student = new StudentModel();
        $bill    = new BillModel();

        $reg     = new RegModel();

        

        \DB::beginTransaction();

         try{
            $reg::where('stu_id',$stu_id)->delete();
            $student::where('stu_id',$stu_id)->delete();
           
           
            \DB::commit();  
            
            return response()->json(['msg'=>'Xóa thành công !', 'success'=>true]);

        } catch (\Throwable  $e) {
            \DB::rollback();
            throw $e;  
            response()->json(['msg'=>'Xóa không thành công !', 'success'=>false]);
        }
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
        $reg     = new RegModel();

        $student->stu_id = $request->input('stuId');
        $student->stu_name = $request->input('stuName');
        $student->stu_grade = $request->input('stuGrade');
        $student->stu_address = $request->input('stuAddress');
        $student->parent_phone = $request->input('parentPhone');
        $student->parent_name = $request->input('parentName');
        
        $inpCourse = $request->input('regCourse');

        $validator = Validator::make($request->all(), $this->rules, $this->messages);


        if ( $validator->fails() ) {
             return redirect()->route('StudentIndex')->withErrors($validator)->withInput();
        }
        

        if ( !isset($student->stu_id) ) 
        {
           \DB::beginTransaction();

           try{
                $student->save();

                foreach ($inpCourse as $key => $value) {
                    $student->courses()->attach($value);    
                }
                
                \DB::commit();

                Session::flash('success', 'Thêm Học Sinh thành công !'); 
                return redirect()->route('StudentIndex');

           } catch (\Throwable  $e) {
                \DB::rollback();

                Session::flash('error', 'Thêm Học Sinh thất bại !'); 
                return redirect()->route('StudentIndex');
           }

        } 
        else {

            \DB::beginTransaction();

            
            $rulesU    = ['stuId' => 'required|numeric'];
            $messagesU = ['stuId.required' => 'Lỗi hệ thống ! Liên lạc với kỹ thuật viên',
                            'stuId.numeric' => 'Đừng cố phá hoại hệ thống !'];
            
            $validatorU = Validator::make($request->all(), $rulesU, $messagesU);

            if ( $validatorU->fails() ) {
              die("Lỗi ! Đừng cố gắng chỉnh sửa code. ");
            }

           try{

                $student::where('stu_id', $student->stu_id)
                    ->update([
                       'stu_name' => $student->stu_name,
                       'stu_grade' => $student->stu_grade,
                       'stu_address' => $student->stu_address,
                       'parent_phone' => $student->parent_phone,
                       'parent_name' => $student->parent_name
                    ]);

                $reg::where('stu_id',$student->stu_id)->delete();
                

                foreach ($inpCourse as $key => $value) {
                    $student->courses()->attach($value);    
                }    
                
                
                \DB::commit();

                Session::flash('success', 'Cập nhật Học Sinh thành công !'); 
                return redirect()->route('StudentIndex');

           } catch (\Throwable  $e) {
                \DB::rollback();
                Session::flash('error', 'Cập nhật Học Sinh thất bại !'); 
                return redirect()->route('StudentIndex');
           }
        }


    }

        

}
