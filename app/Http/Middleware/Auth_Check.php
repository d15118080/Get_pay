<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use App\Models\company;

class auth_check
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (empty($_COOKIE['H-Token'])) {
            return redirect('/login');
        } else {
            $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
             if (!User::where('key', $HToken)->exists()) {
                return redirect('/login');
            } else {
                $user_data = User::where('key', $HToken)->first();
                if($user_data->user_authority != 0 ){
                    if($user_data->user_authority == 1){
                        $position = "본사";
                        $bank_mode = company::where('company_key',$user_data->company_key)->value('bank_mode');

                    }elseif ($user_data->user_authority == 2){
                        $position = "지사";
                        $bank_mode = null;
                    }elseif ($user_data->user_authority == 3){
                        $position = "총판";
                        $bank_mode = null;
                    }elseif ($user_data->user_authority == 4){
                        $position = "가맹점";
                        $bank_mode = null;
                    }
                    session([
                        'state' => $user_data->user_authority,
                        'name' => company::where('company_key',$user_data->company_key)->value('company_name'),
                        'position' =>$position,
                        'bank_mode'=> $bank_mode
                    ]);
                }else{
                    session([
                        'state' => $user_data->user_authority,
                        'name' => $user_data->user_name,
                        'position' => '관리자'
                    ]);
                }
            }
        }

        return $next($request);
    }
}
