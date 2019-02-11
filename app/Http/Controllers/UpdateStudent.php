<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Student as StudentModel; 
use App\Model\HistoryUpdate as HistoryUpdateModel; 

class UpdateStudent extends Controller
{
    //

    public function doUpdate(Request $request)
    {
    	$updater = new HistoryUpdateModel();
    	$student = new StudentModel();
    	

    	sleep($updater::DELAY_TO_UPDATE);
    	$month = date('m');
        $year  = date('y');

    	if ($updater->ckeckConditionUpdate() && $request->input('student_will_update') == 1) 
    	{
			if($student->incrementGradeAllStudent())
			{
				try {
					if(!$updater->checkExistsUpdate($year))
					{
						$updater->insert(['year' => $year,'is_update' => 1]);	
					} else {
						if(!$updater->yearIsUpdate($year))
						{
							$updater::where('year',$year)->update('is_update',1);
						}
					}

					return response()->json(['msg'=>'Tăng khối học cho học sinh thành công !', 'success'=>true]);
				} catch (\Exception $e) {
					return response()->json(['msg'=>'Tăng khối học cho học sinh thất bại ! Cập nhật sẽ được thực hiện vào lân đăng nhập sau !', 'success'=>false]);
				}
			}		 
    	}
    }
}
