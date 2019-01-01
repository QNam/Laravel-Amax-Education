<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

use App\Model\Course as CourseModel;
use App\Model\Student as StudentModel;
use App\Model\Bill as BillModel;
use App\Model\DetailBill as DetailBillModel;

class BillController extends Controller
{

    public $messages = [
        'billMonth.required' => "Đóng học tháng không được bỏ trống !",
        'billMonth.numeric'=> "Tháng đóng học phải là số !",
        'billDiscount.numeric' => "Khuyến mãi phải là số !",
        'billDiscount.min' => "Khuyến mãi trong khoảng 0 -> 100% !",
        'billDiscount.max' => "Khuyến mãi trong khoảng 0 -> 100% !",
        'billPay.required' => "Tiền đóng học không được bỏ trống !",
        'billPay.numeric' => "Tiền đóng học phải là số !",
        'stuId.required' => "",
        'stuId.numeric' => ""
    ];

    public $rules = [
        'billMonth' => "bail|required|numeric",
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
            $data =  $bill->getBillInfo($filter);

            if ($detail) 
            {
                foreach ($data as $key => $value) {
                    $value['details'] = $bill->getDetailBill($value['bill_id']);
                }
            }
        } catch(\Exception $e){}

        return $data;
    }

    public function index()
    {
        $data = [];
        $data['title'] = 'Danh sách hóa đơn';

        $data['bills'] = $this->_getDocData([],true);

        // dd($data['bills']);   
        return view('bill/index')->with($data);
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
        $bill = new BillModel();
        $dBill = new DetailBillModel();

        try{
            $dBill::where('bill_id',$billId)->delete();
            $bill::where('bill_id',$billId)->delete();

            Session::flash('success', 'Xóa hóa đơn thành công !'); 
            return redirect()->route('BillIndex');   
        } catch(\Exception $e) {
            
            Session::flash('error', 'Xóa hóa đơn thất bại !'); 
            return redirect()->route('BillIndex'); 

        }
    }


    public function store(Request $request)
    {
    	$course  = new CourseModel();
        $student = new StudentModel();
        $bill    = new BillModel();
        $detailBill    = new DetailBillModel();

    	$bCourses  =  $request->input('courses');
    	$bMonth    =  $request->input('billMonth');
    	$bDiscount =  $request->input('billDiscount');
    	$bPay      =  $request->input('billPay');
        $stuId     =  $request->input('stuId');
        $isExcess  =  $request->input('isExcess');

        $bTotal  = 0;
    	$bWallet = 0;
        
        // $billId     =  $request->input('billId');

        // validate
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ( $validator->fails() ) {
             return response()->json(['data'=>$err_validate, 'validate'=>false]);
        }


        $cou_duplicate = [];
        foreach ($bCourses as $key => $value) {

            $checker = $bill->courseIsTraded($stuId,$bMonth,$value['couId']);

            if (!$checker) {
                $cou_duplicate[] =  $value['couId'];
            }
        }

        if (count($cou_duplicate) > 0) {
            return response()->json(['data'=>[ 'couDuplicate'=> $cou_duplicate], 'validate'=>false]);
        }

        

    	try{

            $stuWallet = $student::where('stu_id',$stuId)->get(['stu_wallet'])['0']['stu_wallet']; 


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
    		return response()->json(['msg'=>'Dữ liệu bị lỗi !', 'success'=>false]);
    	}


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
            \DB::commit();

        } catch(\Exception $e) {
            \DB::rollback();
            return response()->json(['msg'=>'Có lỗi trong quá trình xử lý !', 'success'=>false]);
        }


        try{
            
            \DB::beginTransaction();

            foreach ($bCourses as $key => $value) {
                $data = [
                    'bill_id'       => $bill->bill_id,
                    'cou_id'        => $bCourses[$key]['couId'],
                    'total_lesson'  => $bCourses[$key]['totalLesson'],
                    'discount'      => $bCourses[$key]['couDiscount'],
                    'cou_price'     => $bCourses[$key]['cou_price']
                ];

                $detailBill = new DetailBillModel($data);
                $detailBill->save();
            }
            
            \DB::commit();

            return response()->json(['msg'=>'Thanh toán thành công !', 'success'=>true,'data'=>['stu_id' => $stuId, 'stu_wallet'=> $bWallet] ]);
        } catch(\Exception $e){
            \DB::rollback();
            return response()->json(['msg'=>'Có lỗi trong quá trình xử lý !', 'success'=>false]);
        }
    }
}
