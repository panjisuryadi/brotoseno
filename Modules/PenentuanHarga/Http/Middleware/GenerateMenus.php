<?php

namespace Modules\PenentuanHarga\Http\Middleware;

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

        //     // PenentuanHargas
        //     $menu->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('PenentuanHargas'), [
        //         'route' => 'penentuanharga.index',
        //         'class' => 'nav-item',
        //     ])
        //     ->data([
        //         'order'         => 77,
        //         'activematches' => ['penentuanhargas*'],
        //         'permission'    => ['access_penentuanhargas'],
        //     ])
        //     ->link->attr([
        //         'class' => 'c-sidebar-nav-link py-2',
        //     ]);
        // })->sortBy('order');

        return $next($request);
    }
}
