<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStockOpnameStatus
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
        $stockOpnameStatus = config('app.stock_opname_status'); // Or fetch from DB: StockOpname::getStatus();

        if ($stockOpnameStatus === 'A') {
            // If status is 'A', disable the route by redirecting or aborting
            // return redirect('/stock-opname-disabled')->with('error', 'Stock opname is currently in progress. This feature is disabled.');
            return redirect('/home')->with('error', 'Stock opname is currently in progress. This feature is disabled.');
            // Or, to show a 403 Forbidden page:
            // abort(403, 'Stock opname is currently in progress. This action is forbidden.');
        }

        return $next($request);
    }
}
