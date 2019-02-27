<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\DetailBill as DetailBillModel;


class Bill extends Model
{
    protected $table 		= 	'bill';
    protected $primaryKey 	= 	'bill_id';
    public 	  $timestamps	=	true;
    public 	  $incrementing = 	true;
    protected $fillable = [
        'bill_id', 'bill_discount','bill_total', 'month', 'stu_id','note','old_debt','isExcess'
    ];

    private $paginate = 15;

    public function detail_bills()
    {
        return $this->hasMany('App\Model\DetailBill','bill_id','detail_bill_id');
    }

    public function getListBill($filter = [])
    {
        $bill = new Bill();

        return $bill::where($filter)
                    ->join('student','student.stu_id','bill.stu_id')
                    ->join('detail_bill','detail_bill.bill_id','bill.bill_id')
                    ->groupBy('bill.bill_id')
                    ->orderBy('created_at', 'DESC')
                    ->select(['bill.*','student.stu_id','student.stu_wallet','student.stu_name'])
                    ->paginate($this->paginate);
    }

    public function getDebtOfBill($billId)
    {
        $bill = $this::where('bill_id',$billId)->get(['bill_pay','bill_total']);

        if ( isset($bill[0]) ) return $bill[0]['bill_pay'] - $bill[0]['bill_total'];
        return false;
    }

    public function getOneBill($billId, $select = ['*'])
    {
        $bill = $this::where('bill_id',$billId)->get($select);

        if ( isset($bill[0]) ) return $bill[0];
        return false; 
    }
    public function calcDebtOfBill($billId)
    {
        $bill = $this::where('bill_id',$billId)->get();
        
        if ( isset($bill[0]) )
            return $bill[0]['bill_pay'] - $bill[0]['bill_total'];
        return $billId;
    }


    public function billIsFirst($stu_id,$bill_id)
    {
        $first = $this::where(['stu_id' => $stu_id])->orderBy('created_at','DESC')->limit(1)->get(['bill_id']);

        if($first[0]->bill_id == $bill_id)
            return true;
        return false;
    }

    public function getBillOfStudent($stuId)
    {
        $bill = new Bill();

        $listBill = $bill::where(['bill.stu_id' => $stuId])
                    ->join('student','student.stu_id','bill.stu_id')
                    ->get(['bill.*','student.stu_name']);
        $total = 0;
        foreach ($listBill as $key => $value) {
            $value['details'] = $bill->getDetailBill($value['bill_id']);

            foreach ($value['details'] as $k => $v) 
            {
                
                $v['couTotal'] = $v['total_lesson'] * $v['cou_price'] * (1 - $v['discount']/100);
                $total += $v['couTotal'];

            }
            $value['cousTotal'] = $total;
        }

        return $listBill;

    }

    public function courseIsTraded($stuId,$month,$couId)
    {

        // $counterBill = $this::where(['stu_id' => $stuId, 'month' => $month])->count();

        // if($counterBill == 0) return false;
        

        $counter = $this::where(['bill.stu_id' => $stuId, 'month' => $month, 'register.cou_id' => $couId])
                    ->join('detail_bill','detail_bill.bill_id','bill.bill_id')
                    ->join('register','register.reg_id','detail_bill.reg_id')
                    ->count();
        if($counter > 0) return true;
        return false;
    }
    
   

    public function getDetailBill($bill_id)
    {
        $dBill = new DetailBillModel();

        return $dBill::where('bill_id',$bill_id)
                    ->join('register','detail_bill.reg_id','register.reg_id')
                    ->join('course','register.cou_id','course.cou_id')
                    ->get(['detail_bill.*','course.cou_name','course.cou_id']);
    }


}
