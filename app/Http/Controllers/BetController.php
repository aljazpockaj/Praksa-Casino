<?php

namespace App\Http\Controllers;
use App\Models\Bet;
use Illuminate\Http\Request;

class BetController extends Controller
{
    public function GetData(){
        $bets = Bet::all();
        return view('betview',['bets' => $bets]);
    }
}
