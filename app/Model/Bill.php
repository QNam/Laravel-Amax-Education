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

    public function detail_bills()
    {
        return $this->hasMany('App\Model\DetailBill','bill_id','detail_bill_id');
    }

    public function getBillInfo($filter = [])
    {
        $bill = new Bill();

        return $bill::where($filter)
                    ->join('student','student.stu_id','bill.stu_id')
                    ->get(['bill.*','student.stu_id','student.stu_name']);
    }

    public function getDetailBill($bill_id)
    {
        $dBill = new DetailBillModel();

        return $dBill::where('bill_id',$bill_id)
                    ->join('course','course.cou_id','detail_bill.cou_id')
                    ->get(['detail_bill.*','course.cou_id','course.cou_name']);
    }


}
