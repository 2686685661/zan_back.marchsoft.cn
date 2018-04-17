<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\StarCoin;
use App\Models\order;

class ConsumeController extends Controller
{
    
    public function see_user_consume_coin(Request $request) {
        if($request->isMethod('get')) {
            $user_id = $request->userid;
            $type = $request->type;
            if(is_numeric($user_id) && is_numeric($type)) {
                $select_coins = StarCoin::see_notuse_consume_coin($user_id,$type);
                if($type != 3) {
                    for($i = 0; $i < count($select_coins); $i++) {
                        for($j = 0; $j < count($select_coins[$i]); $j++) {
                            $select_coins[$i][$j]->img_url = get_qqimg_link($select_coins[$i][$j]->qq_account);
                        }
                    }
                }else {
                    for($i = 0; $i < count($select_coins); $i++) {
                        $select_coins[$i]->img_url = get_qqimg_link($select_coins[$i]->qq_account);
                    }
                }
            }
        }
    }
}
