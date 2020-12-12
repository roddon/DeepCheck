<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MauticSetting extends Model
{
    protected $guarded = [];

    static public function fetchData($type='mautic'){
    	$aData = MauticSetting::where('type',$type)->select(['settings'])->first();
    	$detail = [];
    	if(!empty($aData)){
    		$detail = json_decode($aData->settings,true);
    	}
    	return $detail;
    } 
}
