<?php

namespace Modules\JenisGroup\Http\Middleware;

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

        //     // JenisGroups
        //     $menu->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right"></i> '.__('JenisGroups'), [
        //         'route' => 'jenisgroup.index',
        //         'class' => 'nav-item',
        //     ])
        //     ->data([
        //         'order'         => 77,
        //         'activematches' => ['jenisgroups*'],
        //         'permission'    => ['access_jenisgroups'],
        //     ])
        //     ->link->attr([
        //         'class' => 'c-sidebar-nav-link',
        //     ]);
        // })->sortBy('order');


        return $next($request);
    }
}
