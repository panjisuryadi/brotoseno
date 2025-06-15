<?php

namespace Modules\GoldCategory\Http\Middleware;

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

        //     // GoldCategories
        //     $menu->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('GoldCategories'), [
        //         'route' => 'goldcategory.index',
        //         'class' => 'nav-item',
        //     ])
        //     ->data([
        //         'order'         => 77,
        //         'activematches' => ['goldcategories*'],
        //         'permission'    => ['access_goldcategories'],
        //     ])
        //     ->link->attr([
        //         'class' => 'c-sidebar-nav-link py-2',
        //     ]);
        // })->sortBy('order');

        return $next($request);
    }
}
