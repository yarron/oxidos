<?php defined('SYSPATH') OR die('No direct script access.');

class HTTP_Exception extends Kohana_HTTP_Exception {
    public function get_response()
    {
        $attributes = array
        (
            'action'  => $this->code,
            'message' => rawurlencode($this->getMessage()),
        );

        if(Request::current() != "" && Request::current()->directory() == "Admin"){
            $view =  Request::factory(Route::get('admin_errors')->uri($attributes))->execute()->send_headers()->body();
            $response = Response::factory()->status($this->code)->body($view);
            return $response;
        }
        else{
            $view = Request::factory(Route::get('errors')->uri($attributes))->execute()->send_headers()->body();
            $response = Response::factory()->status($this->code)->body($view);
            return $response;
        }
   }
}
