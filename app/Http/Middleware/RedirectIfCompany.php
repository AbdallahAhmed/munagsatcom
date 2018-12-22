<?php

namespace App\Http\Middleware;

use App\Models\Companies_empolyees;
use App\Models\Company;
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
        $slug = $id ? null : $request->route()->parameter('slug');
        if (fauth()->check()) {
            $id = $id ? $id : Company::where('slug', '=', $slug)->firstOrFail()->id;
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
