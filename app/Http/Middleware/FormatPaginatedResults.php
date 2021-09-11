<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use stdClass;

class FormatPaginatedResults
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $response =  $next($request);
        $pagination = new stdClass();
        $data = $response->getData();
        $pagination->total = $data->data->total;
        $pagination->per_page = $data->data->per_page;
        $pagination->current_page = $data->data->current_page;
        $pagination->last_page = $data->data->last_page;
        $pagination->data = $data->data->data;
        unset($data->data);
        $data->pagination = $pagination;
        $response->setData($data);
        return $response;
    }
}
