<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RequeteDLRBuzzExpert;
use App\Http\Requests\RequeteReponseBuzzExpert;
use \Illuminate\Http\Response;

use Carbon;


class ControllerBuzzExpert extends Controller
{
        /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RequeteDLRBuzzExpert  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDLR(RequeteDLRBuzzExpert $request)
    {
        $heure = Carbon::now()->format("Y-m-d H:i:s");
        $inputs = $request->all();
        //$log = $heure.' DLR '.$inputs['tx_id'].' '.$inputs['cp_id'].' '.$inputs['response'].' '.$inputs['status'].' '.$inputs['phone'].' '.$inputs['tag'];
        $log = 'test';
        $fp = fopen('../storage/log_BuzzExpert.txt', 'a');//opens file in append mode
        fwrite($fp, $log);   
        fclose($fp); 
        
        return 'Accusé reception bien arrivé !';
        
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RequeteReponseBuzzExpert  $request
     * @return \Illuminate\Http\Response
     */
    public function storeReponse(RequeteReponseBuzzExpert $request)
    {
        $heure = Carbon::now()->format("Y-m-d H:i:s");
        $inputs = $request->all();
        $log = $heure.' Reponse '.$inputs['tx_id'].' '.$inputs['cp_id'].' '.$inputs['response'].' '.$inputs['phone'].' '.$inputs['tag'];
        $fp = fopen('../storage/log_BuzzExpert.txt', 'a');//opens file in append mode
        fwrite($fp, $log);   
        fclose($fp);

        return 'Reponse bein reçue !';
        
    }
}
