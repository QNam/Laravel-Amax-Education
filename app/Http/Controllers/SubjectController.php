<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

use App\Model\Subject as SubjectModel;

class SubjectController extends Controller
{

    public function index()
    {
    	$subject = new SubjectModel();

		$data['title'] = 'Danh sánh môn học';
		$data['subjects'] = $subject::get();

		return view('subject/index')->with($data);    	
    }

    public function store(Request $request)
    {
    	$subId = $request->input('subId');
    	$subName = $request->input('subName');

    	$subject = new SubjectModel();

    	if (!isset($subId)) 
    	{
    		try{
    			$subject->sub_name = $subName;

				$subject->save();    			

    			Session::flash('success', 'Thêm môn học thành công !'); 
                return redirect()->route('SubjectIndex');
    		} catch(\Exception $e) {
    			Session::flash('error', 'Thêm môn học thất bại !'); 
                return redirect()->route('SubjectIndex');
    		}
    	}

    	try{
    		$subject = $subject::find($subId); 

			$subject->sub_name = $subName;

			$subject->save();    			

			Session::flash('success', 'Cập nhật môn học thành công !'); 
            return redirect()->route('SubjectIndex');
		} catch(\Exception $e) {
			Session::flash('error', 'Cập nhật môn học thất bại !'); 
            return redirect()->route('SubjectIndex');
		}

    }


    public function getSubjectInfo(Request $request)
    {
    	$subId = $request->input('subId');
        $subject = new SubjectModel();

    	$data = $subject::where(['sub_id' => $subId])->get();

        if ( count($data) == 0 ) {
            return response()->json(['msg'=>'Không tìm thấy thông tin khóa học !', 'success'=>false]);
        }

        return response()->json(['msg'=>'Thành công !', 'success'=>true, 'data' => $data[0]]);
    }


    public function deleteSubject(Request $request)
    {
    	$subId = $request->input('subId');
        $subject = new SubjectModel();

    	try{
    		$subject = $subject::where('sub_id',$subId)->delete();   			

			Session::flash('success', 'Xóa Môn học thành công !'); 
            return redirect()->route('SubjectIndex');
		} catch(\Exception $e) {
			Session::flash('error', 'Xóa Môn học thất bại !'); 
            return redirect()->route('SubjectIndex');
		}
    }

}
