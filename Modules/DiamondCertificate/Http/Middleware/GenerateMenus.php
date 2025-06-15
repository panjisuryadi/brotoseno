<?php

namespace Modules\DiamondCertificate\Http\Middleware;

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

        //     // DiamondCertificates
        //     $menu->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right"></i> '.__('Diamond Certificate'), [
        //         'route' => 'diamondcertificate.index',
        //         'class' => 'nav-item',
        //     ])
        //     ->data([
        //         'order'         => 77,
        //         'activematches' => ['diamondcertificates*'],
        //         'permission'    => ['access_diamondcertificates'],
        //     ])
        //     ->link->attr([
        //         'class' => 'c-sidebar-nav-link',
        //     ]);
        // })->sortBy('order');











        return $next($request);
    }
}
