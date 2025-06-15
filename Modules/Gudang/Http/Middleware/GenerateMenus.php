<?php

namespace Modules\Gudang\Http\Middleware;

use Closure;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle($request, Closure $next)
    {
        /*
         *
         * Module Menu for Admin Backend
         *
         * *********************************************************************
         */
        // \Menu::make('admin_sidebar', function ($menu) {

        //     // Gudangs
        //     $menu->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right"></i> '.__('Gudangs'), [
        //         'route' => 'gudang.index',
        //         'class' => 'nav-item',
        //     ])
        //     ->data([
        //         'order'         => 77,
        //         'activematches' => ['gudangs*'],
        //         'permission'    => ['access_gudangs'],
        //     ])
        //     ->link->attr([
        //         'class' => 'c-sidebar-nav-link',
        //     ]);
        // })->sortBy('order');
        return $next($request);
    }
}
