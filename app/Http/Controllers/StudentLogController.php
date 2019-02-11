<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\StudentLog as StuLogModel; 
use App\Model\HistoryUpdate as HistoryUpdateM; 

class StudentLogController extends Controller
{
    //

    public function _getDocData($filter = [])
    {
    	$stuLog = new StuLogModel();

    	foreach ($filter as $key => $value) 
        {
            if (empty($value)) {
                unset( $filter[$key] );
            }
        }
        
        try{
            $data =  $stuLog->getListStudentlog($filter);
        } catch(\Exception $e){
            throw $e;
        }

        return $data;
    }

    public function index()
    {
    	$data = [];
    	$data['title'] = "Thông tin lưu trữ";
    	$data['slogs'] = $this->_getDocData();

    	return view('student_log/index')->with($data);
    }
}
