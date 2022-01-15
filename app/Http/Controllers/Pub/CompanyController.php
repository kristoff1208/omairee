<?php

namespace App\Http\Controllers\Pub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jisha;
use App\Models\User;
use App\Models\JishaEma;
use App\Models\JishaSaisen;

class CompanyController extends Controller
{
    //
    function index() {
        $jishas= Jisha::paginate(12);
        return view('public.jisha-list',compact('jishas'));
    }

    function detail($id) {
        $jisha=Jisha::where('id',$id)->first();
        if($jisha === null) {
            $jisha=Jisha::create([]);
        }
        $user= \Auth::user();
        return view('public.jisha-detail',compact('jisha','user'));
    }

    function toPray(Request $request) {
        if(\Auth::user() === null) {
            toastr()->success('ログインしてください。','',config('toastr.options'));
            return back();
        }
        $coin = \Auth::user()->coin;
        if($coin === null) {
            $coin = Coin::create([
                'remained'=>0,
            ]);
        }
        $ema=$request->get('ema');
        $saisen=$request->get('saisen');
        $coin->remained = $coin->remained-$ema-$saisen;
        $jishaId = $request->get('jishaId');
        $jisha = Jisha::where('id',$jishaId)->first();
        if($jisha ===  null) {
            $jisha = Jisha::create();
        }
        $jishaEma=$jisha->jishaemas;
        $jishaSaisen=$jisha->jishasaisens;
        $emaCheck = JishaEma::where('ema',$ema)->first();
        if($emaCheck === null) {
            $jishaEma->ema=$ema;
            $jishaEma->ema_count=1;
        }else {
            $emaCheck->ema_count++;
        }
        $saisenCheck = JishaSaisen::where('saisen',$saisen)->first();
        if($saisenCheck === null) {
            $jishaSaisen->saisen=$saisen;
            $jishaSaisen->saisen_count=1;
        }else {
            $saisenCheck->saisen_count++;
        }
        $jishaSaisen=$jisha->jishasaisens;
        $coin->save();$emaCheck->save();$saisenCheck->save();
        return view('public.pray');
    }
}
