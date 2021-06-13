<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Exception;


class HackerAlertException extends Exception{


    public function report(){
        //this will store this log in laravel.log file
        Log::critical('hacker tried to hack us today!');
    }

    public function render(){
        //this will be thrown when the exception happend: 
        return response()->json([
            'message' => 'hacker, you got no luck today'
        ]);
        
    }


} 
      