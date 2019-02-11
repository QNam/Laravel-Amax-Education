<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Sudent as StudentModel;

class HistoryUpdate extends Model
{
    //
    protected $table 		= 	'update_history';
    protected $primaryKey 	= 	'id';
    public 	  $incrementing = 	true;
    protected $fillable = [
        'year','is_update'
    ];

    public const MONTH_UPDATE = 1;
    public const DELAY_TO_UPDATE = 10;

    public function yearIsUpdate($year)
    {
    	$checker = $this::where('year',$year)->first();

    	if($checker->is_update == 0) return false;
    	return true;
    }

    public function checkExistsUpdate($year)
    {
    	$checker = $this::where('year',$year)->first();

    	if($checker == null)return false;
    	return true;
    } 

    public function ckeckConditionUpdate()
    {
    	$month = date('m');
        $year  = date('y');

        if( !$this->checkExistsUpdate($year) ) return true;

        if($month > $this::MONTH_UPDATE && !$this->yearIsUpdate($year)) {
        	return true;
        }
        return false;
    }

    // public function doUpdate($year)
    // {
    // 	$student = new StudentModel();

    // 	if($this->yearIsUpdate($year)){
    // 		return $student->incrementGradeAllStudent();
    // 	}

    // }
}
