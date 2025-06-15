<?php

namespace Modules\ItemColour\Http\Middleware;

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
        //     // ItemColours
        //     $menu->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right"></i> '.__('ItemColours'), [
        //         'route' => 'itemcolour.index',
        //         'class' => 'nav-item',
        //     ])
        //     ->data([
        //         'order'         => 77,
        //         'activematches' => ['itemcolours*'],
        //         'permission'    => ['access_itemcolours'],
        //     ])
        //     ->link->attr([
        //         'class' => 'c-sidebar-nav-link',
        //     ]);
        // })->sortBy('order');

    return $next($request);
    }
}
