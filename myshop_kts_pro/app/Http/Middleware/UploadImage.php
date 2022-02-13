<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UploadImage
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
        if ($request->hasFile('image')) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $ext_allow = ['png', 'jpg', 'jpeg', 'gif'];
            if(in_array($ext, $ext_allow)){
                return $next($request);
            }
            return response()->json([
                'status' => 'File image not allowed',
            ], 422
            );
        }
        return response()->json([
            'status' => 'File image is empty',
        ], 400);
    }
}


