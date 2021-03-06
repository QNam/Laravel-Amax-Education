<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

use App\Model\Course as CourseModel;
use App\Model\Student as StudentModel;
use App\Model\Bill as BillModel;
use App\Model\Register as RegModel;
use App\Model\DetailBill as DetailBillModel;

class BillController extends Controller
{

    public $messages = [
        'billMonth.required' => "Đóng học tháng không được bỏ trống !",
        'billDiscount.numeric' => "Khuyến mãi phải là số !",
        'billDiscount.min' => "Khuyến mãi trong khoảng 0 -> 100% !",
        'billDiscount.max' => "Khuyến mãi trong khoảng 0 -> 100% !",
        'billPay.required' => "Tiền đóng học không được bỏ trống !",
        'billPay.numeric' => "Tiền đóng học phải là số !",
        'stuId.required' => "",
        'stuId.numeric' => ""
    ];

    public $rules = [
        'billMonth' => "bail|required",
        'billPay' => "bail|required|numeric",
        'stuId' => "bail|required|numeric",
        'billDiscount' => "bail|max:100|min:0|numeric"
    ];


    public function _getDocData($filter = [], $detail = false)
    {
        $bill = new BillModel();
        $data = array();
        
        foreach ($filter as $key => $value) 
        {
            if (empty($value)) {
                unset( $filter[$key] );
            }
        }

        try{

            $data =  $bill->getListBill($filter);

            $allow_update_checker = "";

            foreach ($data as $key => $value) {
                //Chuyển về từ định dạng trên DB để hiển thị
                $value['month'] = str_replace('-00','',$value['month']);

                //Chỉ có bill mới nhất ms dc cập nhật
                if ($allow_update_checker != $value['stu_id']) {
                    if($bill->billIsFirst($value['stu_id'],$value['bill_id'])) 
                    {
                        $data[$key]['allow_update'] = 1;
                        $allow_update_checker = $value['stu_id'];                    
                    }

                }
            }

            if ($detail) 
            {
                foreach ($data as $key => $value) {
                    $total = 0;

                    $value['details'] = $bill->getDetailBill($value['bill_id']);
                    foreach ($value['details'] as $k => $v) {
                        $v['couTotal'] = $v['total_lesson'] * $v['cou_price'] * (1 - $v['discount']/100);
                        $total += $v['couTotal'];
                    }

                    $value['cousTotal'] = $total;

                }


            }

        } catch(\Exception $e){
            // throw $e;
            return [];
        }

        return $data;
    }

    public function index()
    {   
        $course = new CourseModel();
        $data = [];
        $data['title'] = 'Danh sách hóa đơn';

        $data['bills'] = $this->_getDocData([],true);
        $data['courses'] = $course->get(['cou_id','cou_name']);
        $bill = new BillModel();
        // dd($bill->getOneBill(79,['*']));
        

        return view('bill/index')->with($data);
    }


    public function getBillFromFilter(Request $request)
    {
        $course = $request->input('filterCourse');
        $search = $request->input('filterSearch');
        $wallet = $request->input('filterWallet');

        $data = [];

        $filter = [
            'detail_bill.cou_id' => $course,
            ['stu_name','LIKE',"%$search%"]
        ];

        if (isset($wallet) && $wallet == 0) {
             $filter[] = ['new_debt','=','0'];
        }

        if (isset($wallet) && $wallet > 0) {
             $filter[] = ['new_debt','>','0'];
        }

        if (isset($wallet) && $wallet < 0) {
             $filter[] = ['new_debt','<','0'];
        }
        
        $data['bills'] = $this->_getDocData($filter,true);
        
        // $html = view('student/data')->with($data)->render();        
        return view('bill/data')->with($data);
    }


    public function getBillInfo(Request $request)
    {   
        $bill_id = $request->input('billId');

        $data =  $this->_getDocData(['bill.bill_id' => $bill_id],true);
        

        if ( count($data) == 0 ) {
            return response()->json(['msg'=>'Không tìm thấy thông tin hóa đơn !', 'success'=>false]);
        }

        return response()->json(['msg'=>'Thành công !', 'success'=>true, 'data' => $data]);
    }

    public function deleteBill(Request $request)
    {

        $billId = $request->input('billId');
        $type = $request->input('typeDelete');

        $bill = new BillModel();
        $dBill = new DetailBillModel();
        $student = new StudentModel();

        $billInfo = $bill->getOneBill($billId,['*']);

        try{
            \DB::beginTransaction();
            $debt = $bill->calcDebtOfBill($billId);

            $dBill::where('bill_id',$billId)->delete();
            $bill::where('bill_id',$billId)->delete();
           
           if ($type == 1 ) 
           {
               $student::where('stu_id',$billInfo->stu_id)->decrement('stu_wallet',(int)$debt);
           }
            
            \DB::commit();            

            Session::flash('success', 'Xóa hóa đơn thành công !'); 
            return redirect()->route('BillIndex');   
            
            
            
        } catch(\Exception $e) {
            \DB::rollback(); 

            throw $e;           
            Session::flash('error', 'Xóa hóa đơn thất bại !'); 
            return redirect()->route('BillIndex'); 

        }
    }


    public function store(Request $request)
    {
    	$course  = new CourseModel();
        $student = new StudentModel();
        $bill    = new BillModel();
        $reg     = new RegModel();
        $detailBill    = new DetailBillModel();


        //Lấy dữ liệu
    	$bCourses  =  $request->input('courses');
    	$bMonth    =  $request->input('billMonth').'-00';
    	$bDiscount =  $request->input('billDiscount');
    	$bPay      =  $request->input('billPay');
        $stuId     =  $request->input('stuId');
        $isExcess  =  $request->input('isExcess');
        $billId    =  $request->input('billId');

        if ($isExcess != "1") {
            $isExcess = "0";
        }

        $bTotal  = 0;
    	$bWallet = 0;
        
        // dd($bMonth);
        // validate
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ( $validator->fails() ) {
             return response()->json(['data'=>$err_validate, 'validate'=>false]);
        }


        $cou_duplicate = [];
        foreach ($bCourses as $key => $value) {

            if($reg->isActive($value['couId'],$stuId) )
            {
                $checker = $bill->courseIsTraded($stuId,$bMonth,$value['couId']);

                if ($checker) {
                    $cou_duplicate[] =  $value['couId'];
                }
            }
            
        }

        if($billId != "" && !$bill->billIsFirst($stuId,$billId)) {

            return response()->json(['data'=>[ 'billNotAllowUpdate'=> "Hóa đơn này không được phép Cập nhật !"], 'validate'=>false]);
        }

        if (count($cou_duplicate) > 0 && $billId == "") {
            return response()->json(['data'=>[ 'couDuplicate'=> $cou_duplicate], 'validate'=>false]);
        }

        $stuWallet = $student::where('stu_id',$stuId)->get(['stu_wallet'])['0']['stu_wallet'];

        //Tính toán dữ liệu trong trường hợp update
        if ($billId != "") 
        {
            $oBill    = $this->_getDocData(['bill.bill_id' => $billId]);
            // $oBill_pay = $oBill[0]['bill_pay'];
            // $oBill_total = $oBill[0]['bill_total'];

            // $oBill_debt = $oBill_pay - $oBill_total;

            // $oStudent_wallet = $stuWallet - $oBill_debt;

            //  $student::where('stu_id',$stuId)->update(['stu_wallet' => $oStudent_wallet]);

            $stuWallet = $oBill[0]['old_debt'];

            // dd($oStudent_wallet);
        }
        

        //Tính toán
    	try{ 
            

            // create bill detail
    		foreach ($bCourses as $key => $value) 
    		{
    			$bCourses[$key]['cou_price'] = $course::where('cou_id',$value['couId'])->get(['cou_price'])[0]['cou_price'];

    			if ( empty($value['couDiscount']) ) 
    			{
    				$bCourses[$key]['priceTotal'] = $bCourses[$key]['cou_price'] *  $value['totalLesson'];		
    			} else {
    				$bCourses[$key]['priceTotal'] = $bCourses[$key]['cou_price'] *  $value['totalLesson'] * (1 - $value['couDiscount']/100 );		
    			}

    			$bTotal +=  $bCourses[$key]['priceTotal'];
    		}

            $bTotal = $bTotal * (1 - $bDiscount/100);

            if ($stuWallet >= $bTotal) {
                $bWallet = $stuWallet - $bTotal + $bPay;

                if ($isExcess != 1 && $bWallet > 0 ) 
                {
                    $bWallet = $stuWallet - $bTotal;
                    $bTotal = 0;
                } else {
                    $bTotal = 0;    
                }
               
            } 
            else {
                $bWallet = $bPay - $bTotal + $stuWallet;
                $bTotal = $bTotal - $stuWallet;

                if ($isExcess != 1 && $bWallet > 0 ) 
                {
                    $bWallet = 0;
                }

            }
    		
    	}catch(\Exception $e) {
            throw $e;
    		return response()->json(['msg'=>'Dữ liệu bị lỗi !?', 'success'=>false]);
    	}

       

        //update
        if ($billId != ""){
            try{

                \DB::beginTransaction();
                
                $student::where('stu_id',$stuId)->update(['stu_wallet'=> $bWallet]);

                $bill::where('bill_id',$billId)
                    ->update(['bill_discount' =>  $bDiscount,
                              'bill_total'    =>  $bTotal,
                              'bill_pay'      =>  $bPay,
                              'month'         =>  $bMonth,
                              'old_debt'      =>  $stuWallet,
                              'new_debt'      =>  $bWallet,
                              'isExcess'      =>  $isExcess]);

               
                
                $detailBill::where('bill_id',$billId)->delete();

                foreach ($bCourses as $key => $value) {
                    $reg_id = $reg->getOneRegId($bCourses[$key]['couId'],$stuId);

                    if ( $reg_id != false ) {
                        $data = [
                            'bill_id'       => $billId,
                            'reg_id'        => $reg_id,
                            'total_lesson'  => $bCourses[$key]['totalLesson'],
                            'discount'      => $bCourses[$key]['couDiscount'],
                            'cou_price'     => $bCourses[$key]['cou_price']
                        ];

                        $detailBill = new DetailBillModel($data);
                        $detailBill->save();
                        \DB::commit();
                    } else {
                        \DB::rollback();
                        return response()->json(['msg'=>'Có lỗi trong quá trình xử lý !?', 'success'=>false]);
                    }
                }
                
                \DB::commit();


                Session::flash('success', 'Cập nhật Hóa đơn thành công !'); 
                return response()->json(['msg'=>'Cập nhật hóa đơn thành công !', 'success'=>true]);
            } catch(\Exception $e){
                \DB::rollback();
                throw $e;
                return response()->json(['msg'=>'Có lỗi trong quá trình xử lý !', 'success'=>false]);
            }
        }





        if ($billId == "") 
        {
                    //tạo hóa đơn

            //tạo chi tiết hóa đơn
            try{
                
                \DB::beginTransaction();
                $student::where('stu_id',$stuId)->update(['stu_wallet'=> $bWallet]);

                $bill->bill_discount =  $bDiscount;
                $bill->bill_total    =  $bTotal;
                $bill->bill_pay      =  $bPay;
                $bill->month         =  $bMonth;
                $bill->stu_id        =  $stuId;
                $bill->old_debt      =  $stuWallet;
                $bill->new_debt      =  $bWallet;
                $bill->isExcess      =  $isExcess;

                
                $bill->save();

                foreach ($bCourses as $key => $value) {

                    $reg_id = $reg->getOneRegId($bCourses[$key]['couId'],$stuId);

                    if ( $reg_id != false ) {

                        $data = [
                            'bill_id'       => $bill->bill_id,
                            'reg_id'        => $reg_id,
                            'total_lesson'  => $bCourses[$key]['totalLesson'],
                            'discount'      => $bCourses[$key]['couDiscount'],
                            'cou_price'     => $bCourses[$key]['cou_price']
                        ];


                        $detailBill = new DetailBillModel($data);
                        $detailBill->save();
                        \DB::commit();
                    } else {
                        \DB::rollback();
                        return response()->json(['msg'=>'Có lỗi trong quá trình xử lý !?', 'success'=>false]);
                    }
                    
                }

                return response()->json(['msg'=>'Thanh toán thành công !', 'success'=>true,'data'=>['stu_id' => $stuId, 'stu_wallet'=> $bWallet] ]);
            } catch(\Exception $e){
                \DB::rollback();
                throw $e;
                return response()->json(['msg'=>'Có lỗi trong quá trình xử lý !', 'success'=>false]);
            }
        }


    }
}
