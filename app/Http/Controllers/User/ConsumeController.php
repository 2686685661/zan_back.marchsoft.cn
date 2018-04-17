<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\star_coin;
use App\Models\order;

class ConsumeController extends Controller
{
    
    public function see_user_consume_coin(Request $request) {
        if($request->isMethod('get')) {
            $user_id = $request->userid;
            $type = $request->type;
            if($type == 1) {
                
            }
            else if($type == 2) {

            }
            else if($type == 3) {
                
            }
        }
        
        

    }

}
