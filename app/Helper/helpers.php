<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


// / encrypt primary key of user /
if (!function_exists('encryptid')) {
	function encryptid($string) {
		$encrypted = Crypt::encryptString($string);
		return $encrypted;
	}
}

// / decrypt primary key of user /
if (!function_exists('decryptid')) {
	function decryptid($string) {
		$decrypted = Crypt::decryptString($string);
		return $decrypted;
	}
}

    function active_class($path, $active = 'active') {
      return call_user_func_array('Request::is', (array)$path) ? $active : '';
    }

    function is_active_route($path) {
      return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
    }

    function show_class($path) {
      return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
    }
    if (!function_exists('dashboard_calculation')) {
        function dashboard_calculation($table){
            return DB::table($table)->select('id')->where('status',1)->count();
        }
    }
	
    if(!function_exists('query')) {
        function query($query) {
            $sql = str_replace(array('?'), array('\'%s\''), $query->toSql());
            $query = vsprintf($sql, $query->getBindings());
            dd($query);
        }
    }
    

?>
