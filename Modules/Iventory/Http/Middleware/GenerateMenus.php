<?php

namespace Modules\Iventory\Http\Middleware;

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

        //     $menu->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Iventories'), [
        //         'route' => 'iventory.index',
        //         'class' => 'nav-item',
        //     ])
        //         ->data([
        //             'order'         => 77,
        //             'activematches' => ['iventories*'],
        //             'permission'    => ['access_iventories'],
        //         ])
        //         ->link->attr([
        //             'class' => 'c-sidebar-nav-link py-2',
        //         ]);
        // })->sortBy('order');

        return $next($request);
    }
}
