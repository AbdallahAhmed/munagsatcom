<?php

namespace App\Http\Middleware;

use App\Models\Companies_empolyees;
use Closure;

class RedirectIfCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->route()->parameter('id');
        if (fauth()->check()) {
            $employees = Companies_empolyees::where([
                ['company_id', $id],
                ['employee_id', fauth()->user()->id],
                ['accepted', 1],
                ['status', 1]
            ])->get();
            if (count($employees) > 0) {
                return $next($request);
            }
            return redirect()->route('index');
        } else return redirect()->route('index');
    }
}
