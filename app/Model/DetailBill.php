<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DetailBill extends Model
{
    protected $table 		= 	'detail_bill';
    public $timestamps 		= 	false;
    public 	  $incrementing = 	true;
    protected $fillable = [
        'bill_id', 'cou_id','discount','total_lesson','cou_price'
    ];

    public function bill()
	{
	    return $this->belongsTo('App\Bill', 'bill_id');
	}
}
