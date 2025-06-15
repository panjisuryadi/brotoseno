<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Menu::make('admin_sidebar', function ($menu) {
            // Dashboard
            $menu->add('<i class="cil-speedometer c-sidebar-nav-icon"></i> Dashboard', [
                'route' => 'home',
                'class' => 'c-sidebar-nav-item',
            ])
                ->data([
                    'order'         => 1,
                    'activematches' => 'home*',
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link',
                ]);



            // MASTER DATA
            $masterData = $menu->add('<i class="c-sidebar-nav-icon cil-apps"></i> Master Data', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 2,
                    'activematches' => [
                        'products*',
                        'kategoriproduk*',
                        'product-categories*',
                        'diamondcertificates*',
                        'itemrounds*',
                        'itemshapes*',

                    ],
                    'permission' => [
                        'access_masterdata',
                        'access_kategoriproduks',
                        'access_diamondcertificates'
                    ],
                ]);
            $masterData->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);



            // Pelanggan And Supplier
            $customers_suppliers = $masterData->add(
                '<i class="c-sidebar-nav-icon mb-1 bi bi-people-fill"></i>
                ' . __('labels.menu.people') . '',
                [
                    'class' => 'c-sidebar-nav-dropdown',
                ]
            )
                ->data([
                    'order'         => 1,
                    'activematches' => [
                        'customers*',

                    ],
                    'permission'    => ['access_customers', 'access_suppliers'],
                ]);
            $customers_suppliers->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: Pelanggan
            $customers_suppliers->add(
                '<i class="c-sidebar-nav-icon bi bi-person-square mb-1"></i>
                 ' . __('Customers') . '',
                [
                    'route' => 'customers.index',
                    'class' => 'nav-item',
                ]
            )
                ->data([
                    'order'         => 1,
                    'activematches' => 'customers*',
                    'permission'    => ['access_customers'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-3',
                ]);
            // Submenu: customers
            $customers_suppliers->add(
                '<i class="c-sidebar-nav-icon bi bi-person-bounding-box mb-1"></i>
                 ' . __('Suppliers') . '',
                [
                    'route' => 'suppliers.index',
                    'class' => 'nav-item',
                ]
            )
                ->data([
                    'order'         => 2,
                    'activematches' => 'suppliers*',
                    'permission'    => ['access_suppliers'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-3',
                ]);

            // Submenu: Customer Sales
            // $customers_suppliers->add(
            //     '<i class="c-sidebar-nav-icon  bi bi-person-square"></i>
            //      ' . __('Konsumen Sales') . '',
            //     [
            //         'route' => 'customersales.index',
            //         'class' => 'nav-item',
            //     ]
            // )
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => 'customersales*',
            //         'permission'    => ['access_customersales'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-3',
            //     ]);

            


            //menuemas
            $emas = $menu->add('<i class="c-sidebar-nav-icon bi bi-star"></i> Emas', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 3,
                    'activematches' => [
                        'products*',
                        'kategoriproduk*',
                        'product-categories*',
                        'diamondcertificates*',
                        'itemrounds*',
                        'penjualansales*',
                        'retursales*',
                        'itemshapes*',
                        'stokcabangs*',
                        'goodsreceipts*',

                    ],
                    'permission' => [
                        'access_masterdata',
                        'access_penjualansales',
                        'access_kategoriproduks',
                        'access_retursale',
                        'access_buybacktoko',
                        'access_goodsreceipts',
                        'access_stok_cabang',
                        'access_stok_dp',
                        'access_stok_pending',
                        'access_diamondcertificates'
                    ],
                ]);
            $emas->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // EMAS - PEMBELIAN
            $Purchases = $emas->add('<i class="c-sidebar-nav-icon mb-1 bi bi-bag"></i>' . __('Purchases') . '', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 1,
                    'activematches' => [
                        'purchase-payments*',
                        'purchase-goodsreceipts*',

                    ],
                    'permission'    => ['access_purchases', 'access_goodsreceipts'],
                ]);
            $Purchases->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // EMAS - PEMBELIAN - PENERIMAAN BARANG
            $Purchases->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Goods Receipts'), [
                'route' => 'goodsreceipt.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 1,
                    'activematches' => ['goodsreceipts*'],
                    'permission'    => ['access_goodsreceipts'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            // EMAS - PEMBELIAN - TANPA NOTA
            // $Purchases->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Input Barang (Tanpa Nota)'), [
            //     'route' => 'products.list',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => ['goodsreceipts*'],
            //         'permission'    => ['access_goodsreceipts'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // EMAS - PEMBELIAN - Hutang
            $Purchases->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Goods Receipt Debts'), [
                'route' => 'goodsreceipt.debts',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 2,
                    'activematches' => ['goodsreceipts*'],
                    'permission'    => ['access_goodsreceipts'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            // ReturPembelians
            $Purchases->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Retur Pembelian'), [
                'route' => 'returpembelian.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 77,
                    'activematches' => ['returpembelians*'],
                    'permission'    => ['access_returpembelians'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);



            // EMAS - PRODUCT
            $Products = $emas->add('<i class="c-sidebar-nav-icon mb-1 bi bi-bag"></i>' . __('Products') . '', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 1,
                    'activematches' => [
                        'purchase-payments*',
                        'purchase-goodsreceipts*',

                    ],
                    'permission'    => ['access_purchases', 'access_goodsreceipts'],
                ]);
            $Products->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // EMAS - PEMBELIAN - PENERIMAAN BARANG
            // $Products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Products Nota'), [
            //     'route' => 'products.emas',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 1,
            //         'activematches' => ['goodsreceipts*'],
            //         'permission'    => ['access_goodsreceipts'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // EMAS - PEMBELIAN - Hutang
            // $Products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Products Tanpa Nota'), [
            //     'route' => 'products.list',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => ['goodsreceipts*'],
            //         'permission'    => ['access_goodsreceipts'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // ReturPembelians
            $Products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('All Products'), [
                'route' => 'products.all',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 77,
                    'activematches' => ['returpembelians*'],
                    'permission'    => ['access_returpembelians'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            $Products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Barang Luar'), [
                'route' => 'products.luar',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 77,
                    'activematches' => ['returpembelians*'],
                    'permission'    => ['access_returpembelians'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            $Products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Barang Satuan'), [
                'route' => 'products.nota',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 77,
                    'activematches' => ['returpembelians*'],
                    'permission'    => ['access_returpembelians'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            $Products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Products Pending'), [
                'route' => 'products.pending',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 77,
                    'activematches' => ['returpembelians*'],
                    'permission'    => ['access_returpembelians'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            $Products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Products History'), [
                'route' => 'history_product.list',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 77,
                    'activematches' => ['returpembelians*'],
                    'permission'    => ['access_returpembelians'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            $Products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Products Reparasi'), [
                'route' => 'products.reparasis',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 77,
                    'activematches' => ['returpembelians*'],
                    'permission'    => ['access_returpembelians'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            $Products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Products Cuci'), [
                'route' => 'products.cuci',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 77,
                    'activematches' => ['returpembelians*'],
                    'permission'    => ['access_returpembelians'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            $Products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Products Lebur'), [
                'route' => 'products.lebur',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 77,
                    'activematches' => ['returpembelians*'],
                    'permission'    => ['access_returpembelians'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            // $Products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Products Baki'), [
            //     'route' => 'products.baki',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 77,
            //         'activematches' => ['returpembelians*'],
            //         'permission'    => ['access_returpembelians'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // $Products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Products Gudang'), [
            //     'route' => 'products.gudang',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 77,
            //         'activematches' => ['returpembelians*'],
            //         'permission'    => ['access_returpembelians'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            $Products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Buyback'), [
                'route' => 'buyback.list',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 77,
                    'activematches' => ['returpembelians*'],
                    'permission'    => ['access_returpembelians'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);




            // EMAS - PEMBELIAN - RETUR PEMBELIAN
            // $Purchases->add('<i class="c-sidebar-nav-icon bi bi-cash-coin mb-1"></i>
            //  '.__('Purchase Returns').'', [
            //     'route' => 'purchase-returns.index',
            //     'class' => 'nav-item',
            // ])
            // ->data([
            //     'order'         => 3,
            //     'permission'    => ['create_purchase'],
            // ])
            // ->link->attr([
            //     'class' => 'c-sidebar-nav-link',
            // ]);

            $pos = $emas->add('<i class="c-sidebar-nav-icon mb-1 bi bi-shop"></i>' . __('POS/Buyback') . '', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 2,
                    'activematches' => [
                        'penentuanhargas*',
                        'storeemployees*',

                    ],
                    'permission'    => [
                        'access_penentuanharga',
                        'access_storeemployees',
                    ],
                ]);
            $pos->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            $sale = $pos->add('<i class="c-sidebar-nav-icon  bi bi-person text-sm"></i> ' . __('POS'), [
                'route' => 'sale.list',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 1,
                    'activematches' => ['storeemployees*'],
                    'permission'    => ['access_storeemployees'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            $buyback = $pos->add('<i class="c-sidebar-nav-icon  bi bi-person text-sm"></i> ' . __('Buyback'), [
                'route' => 'buyback.list',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 1,
                    'activematches' => ['storeemployees*'],
                    'permission'    => ['access_storeemployees'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            $luar = $pos->add('<i class="c-sidebar-nav-icon  bi bi-person text-sm"></i> ' . __('Barang Luar'), [
                'route' => 'products.luar',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 1,
                    'activematches' => ['storeemployees*'],
                    'permission'    => ['access_storeemployees'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);



            // EMAS - TOKO master menu
            $toko = $emas->add('<i class="c-sidebar-nav-icon mb-1 bi bi-shop"></i>' . __('Toko') . '', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 2,
                    'activematches' => [
                        'penentuanhargas*',
                        'storeemployees*',

                    ],
                    'permission'    => [
                        'access_penentuanharga',
                        'access_storeemployees',
                    ],
                ]);
            $toko->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);


            $pegawai_toko = $toko->add('<i class="c-sidebar-nav-icon  bi bi-person text-sm"></i> ' . __('Data Pegawai Toko'), [
                'route' => 'storeemployee.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 1,
                    'activematches' => ['storeemployees*'],
                    'permission'    => ['access_storeemployees'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            // EMAS - TOKO - PENENTUAN HARGA
            // $penentuan_harga = $toko->add('<i class="c-sidebar-nav-icon  bi bi-cash-stack text-sm"></i>
            //     ' . __('Penentuan Harga'), [
            //     'route' => 'penentuanharga.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => ['penentuanhargas*'],
            //         'permission'    => ['access_penentuanharga'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);





            // EMAS - TOKO - PENERIMAAN
            // $penerimaan = $emas->add('<i class="c-sidebar-nav-icon mb-1 bi bi-journal-check"></i>' . __('Penerimaan') . '', [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => [
            //             'penentuanhargas*',
            //             'buysback*',

            //         ],
            //         'permission'    => [
            //             'access_penentuanhargas',
            //             'access_buys_back_luar',
            //             'access_buysback_nota',
            //             'access_insentif',
            //             'access_buybacktoko'
            //         ],
            //     ]);
            // $penerimaan->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);

            // // EMAS - TOKO - PENERIMAAN - BUYBACK BARANG LUAR
            // $penerimaan->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i>
            //     <div class="break">' . __('Buy Back & Barang Luar') . '</div>', [
            //     'route' => 'goodsreceipt.toko.buyback-barangluar.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 1,

            //         'permission'    => ['access_buys_back_luar'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);


            // // EMAS

            // // EMAS - TOKO - PENERIMAAN - Penerimaan Barang DP
            // $penerimaan->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Barang DP'), [
            //     'route' => 'penerimaanbarangdp.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => ['penerimaanbarangdps*'],
            //         'permission'    => ['access_penerimaanbarangdps'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // $penerimaan->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Barang DP Jatuh Tempo'), [
            //     'route' => 'penerimaanbarangdp.payment',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => ['penerimaanbarangdps*'],
            //         'permission'    => ['access_penerimaanbarangdps'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);



            // $penerimaan->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Insentif'), [
            //     'route' => 'penerimaanbarangluar.index_insentif',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => ['penerimaanbarangluar*'],
            //         'permission'    => ['access_insentif'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);



            // EMAS - TOKO - Distribusi Toko
            // $distribusiToko = $toko->add(
            //     '<i class="c-sidebar-nav-icon mb-1 bi bi-journal-plus"></i>
            //             ' . __('Distribusi Toko') . '',
            //     [
            //         'class' => 'c-sidebar-nav-dropdown',
            //     ]
            // )
            //     ->data([
            //         'order'         => 4,
            //         'activematches' => [

            //             'products*',
            //             'distribusitokos*',
            //         ],
            //         'permission'  => ['access_distribusitoko', 'access_products'],
            //     ]);
            // $distribusiToko->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);


            // $distribusiToko->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Produk'), [
            //     'route' => 'products.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => ['products*'],
            //         'permission'    => ['access_products'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // EMAS - TOKO - Distribusi Toko - LIST DISTRIBUSI TOKO
            // $distribusiToko->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('List Distribusi Toko'), [
            //     'route' => 'distribusitoko.index',
            //     'class' => 'nav-item',
            // ])
            // ->data([
            //     'order'         => 1,
            //     'activematches' => ['distribusitokos*'],
            //     'permission'    => ['access_distribusitoko'],
            // ])
            // ->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2',
            // ]);

            // $distribusiToko->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('List Distribusi Toko'), [
            //     'route' => 'distribusitoko.emas',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 1,
            //         'activematches' => ['distribusitokos*'],
            //         'permission'    => ['access_distribusitoko'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);


            // EMAS - SALES master menu
            // $sales = $emas->add('<i class="c-sidebar-nav-icon bi bi-currency-dollar"></i> Sales Office', [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => [
            //             'datasales*',
            //             'products*',
            //             'distribusitokos*',
            //             'distribusisales*',
            //             'penjualansales*',

            //         ],
            //         'permission'  =>   [
            //             'access_sales_office',
            //             'access_datasales',
            //         ],
            //     ]);
            // $sales->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);


            // // EMAS - SALES - DataSales
            // $sales->add('<i class="c-sidebar-nav-icon  bi-person-lines-fill text-sm"></i> ' . __('Data Sales'), [
            //     'route' => 'datasale.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 1,
            //         'activematches' => ['datasales*'],
            //         'permission'    => ['access_datasales'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);


            // // EMAS - SALES - DISTRIBUSI SALES
            // $distribusisales = $sales->add(
            //     '<i class="c-sidebar-nav-icon mb-1 bi bi-journal-plus"></i>
            //     ' . __('Distribusi Sales') . '',
            //     [
            //         'class' => 'c-sidebar-nav-dropdown',
            //     ]
            // )
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => [
            //             'datasales*',
            //             'distribusitokos*',
            //             'penjualansales*',
            //             'retursales*',

            //         ],
            //         'permission'    => ['access_penjualansales', 'access_retursale'],
            //     ]);
            // $distribusisales->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);




            // // EMAS - SALES - DISTRIBUSI SALES - LIST
            // $distribusisales->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('List Distribusi Sales'), [
            //     'route' => 'distribusisale.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 1,
            //         'activematches' => ['distribusisales*'],
            //         'permission'    => ['access_distribusisales'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);





            // // EMAS - SALES - DISTRIBUSI SALES - PENJUALAN SALES
            // $distribusisales->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Penjualan Sales'), [
            //     'route' => 'penjualansale.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => ['penjualansales*'],
            //         'permission'    => ['access_penjualansales'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);



            // // EMAS - SALES - DISTRIBUSI SALES - Retur Sales
            // $distribusisales->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Retur Sales'), [
            //     'route' => 'retursale.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => ['retursales*'],
            //         'permission'    => ['access_retursale'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);


            // // SALES - DISTRIBUSI SALES - BuyBackSales
            // $distribusisales->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Buy Back Sales'), [
            //     'route' => 'buybacksale.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 4,
            //         'activematches' => ['buybacksales*'],
            //         'permission'    => ['access_buybacksales'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // // EMAS - SALES - DISTRIBUSI SALES - Barang Luar

            // $distribusisales->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Barang Luar'), [
            //     'route' => 'penerimaanbarangluarsale.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 5,
            //         'activematches' => ['penerimaanbarangluarsales*'],
            //         'permission'    => ['access_penerimaanbarangluarsales'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);


            // laporan Sales
            // $laporansales = $sales->add('<i class="c-sidebar-nav-icon bi bi-bar-chart text-sm"></i> ' . __('Laporan Sales'), [
            //     'route' => 'datasale.laporan_sales',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => ['datasale*'],
            //         'permission'    => ['access_laporan_sales'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);




            // EMAS - STOK
            // $stok = $emas->add('<i class="mb-2 c-sidebar-nav-icon bi bi-box-seam"></i> Stok', [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])
            //     ->data([
            //         'order'         => 4,
            //         'activematches' => [
            //             'stoks*',
            //             'stokcabangs*',
            //         ],
            //         'permission' => [
            //             'access_stoks',
            //             'access_stok_cabang',
            //             'access_stok_dp',
            //             'access_stok_pending',
            //             'access_menu_stok'
            //         ],
            //     ]);
            // $stok->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);



            // EMAS - STOK - DAFTAR STOK
            // $stock_office = $stok->add('<i class="mb-2 c-sidebar-nav-icon bi bi-card-checklist"></i> Stok Office', [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])
            //     ->data([
            //         'order'         => 1,
            //         'activematches' => [
            //             'stoks*',
            //         ],
            //         'permission' => ['access_stoks'],
            //     ]);



            // $stock_office->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);



            // // EMAS - STOK - DAFTAR STOK - STOK SALES
            // $stock_office->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Stok Sales'), [
            //     'route' => 'stok.sales',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => ['stoks*'],
            //         'permission'    => ['access_stoks'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // // EMAS - STOK CABANG - STOK PENDING
            // $stock_office->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Stok Pending'), [
            //     'route' => 'stok.pending_office',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => ['stoks*'],
            //         'permission'    => ['access_stoks'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // // EMAS - STOK CABANG - STOK READY OFFICE
            // $stock_office->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Stok Ready'), [
            //     'route' => 'stok.ready_office',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => ['stoks*'],
            //         'permission'    => ['access_stoks'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // // EMAS - STOK - DAFTAR STOK - STOK OFFICE
            // $stock_office->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Stok Gudang'), [
            //     'route' => 'stok.office',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 1,
            //         'activematches' => ['stoks*'],
            //         'permission'    => ['access_stoks'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);




            // // EMAS - STOK - DAFTAR STOK - STOK KROOM
            // $stock_office->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Stok Lantakan'), [
            //     'route' => 'stok.lantakan',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 5,
            //         'activematches' => ['stoks*'],
            //         'permission'    => ['access_stoks'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // $stock_office->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Stok Rongsok'), [
            //     'route' => 'stok.rongsok',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 5,
            //         'activematches' => ['stoks*'],
            //         'permission'    => ['access_stoks'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // EMAS - Stok Cabang
            // $stock_cabang = $stok->add('<i class="c-sidebar-nav-icon  bi-card-checklist"></i> ' . __('Stok Cabang'), [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => ['stokcabangs*'],
            //         'permission'    => [
            //             'access_stok_cabang',
            //             'access_stok_dp',
            //             'show_stock_ready_cabang',
            //             'access_stok_pending'
            //         ],
            //     ]);
            // $stock_cabang->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);

            // // EMAS - STOK CABANG - STOK PENDING
            // $stock_cabang->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Stok Ready'), [
            //     'route' => 'stok.ready',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 1,
            //         'activematches' => ['stoks*'],
            //         'permission'    => ['show_stock_ready_cabang'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // // EMAS - STOK CABANG - STOK PENDING
            // $stock_cabang->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Stok Pending'), [
            //     'route' => 'stok.pending',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => ['stoks*'],
            //         'permission'    => ['access_stok_pending'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // // EMAS - STOK - DAFTAR STOK - STOK DP
            // $stock_cabang->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Stok DP'), [
            //     'route' => 'stok.dp',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => ['stoks*'],
            //         'permission'    => ['access_stok_dp'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);



            // EMAS - STOK - KELOLA STOK
            // $kelola_stok = $stok->add('<i class="mb-2 c-sidebar-nav-icon bi bi-card-checklist"></i> Kelola Stok', [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => [
            //             'stoks*',
            //         ],
            //         'permission' => ['access_kelola_stok'],
            //     ]);
            // $kelola_stok->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);




            // // EMAS - STOK - STOK Opname
            // $adjustments = $kelola_stok->add(
            //     '
            //     <i class="mb-2 c-sidebar-nav-icon bi bi-clipboard-check"></i> ' . __('Stok Opname') . '',
            //     [
            //         'class' => 'nav-item',
            //         'route' => 'adjustments.index'
            //     ]
            // )
            //     ->data([
            //         'order'         => 1,
            //         'activematches' => [
            //             'adjustments*',
            //         ],
            //         'permission' => [
            //             'show_stock_opname',
            //             'create_adjustments'
            //         ],
            //     ]);
            // $adjustments->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2',
            // ]);


            // // EMAS - STOK - KELUAR MASUK
            // $stok->add('<i class="c-sidebar-nav-icon  bi bi-card-checklist"></i> ' . __('Keluar Masuk'), [
            //     'route' => 'keluarmasuk.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => ['keluarmasuks*'],
            //         'permission'    => ['access_keluarmasuks'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);


            // EMAS - STOK - STOK OPNAME - List Adjustment
            // $adjustments->add('
            //     <i class="c-sidebar-nav-icon bi bi-list-task mb-1"></i>'.__('List Adjustments').'',
            //      [
            //     'route' => 'adjustments.index',
            //     'class' => 'nav-item',
            // ])
            // ->data([
            //     'order'         => 1,
            //     'activematches' => 'adjustments*',
            //     'permission'    => ['create_adjustments'],
            // ])
            // ->link->attr([
            //     'class' => 'c-sidebar-nav-link py-3',
            // ]);

            // EMAS - STOK - STOK OPNAME - Create Adjustment
            // $adjustments->add('
            //     <i class="c-sidebar-nav-icon bi bi-list-task mb-1"></i>'.__('Create Adjustments').'',
            //      [
            //     'route' => 'adjustments.create',
            //     'class' => 'nav-item',
            // ])
            // ->data([
            //     'order'         => 2,
            //     'activematches' => 'adjustments*',
            //     'permission'    => ['create_adjustments'],
            // ])
            // ->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2 pb-2',
            // ]);


            // EMAS - STOK - STOK OPNAME - Stoks
            // $adjustments->add('
            //     <i class="c-sidebar-nav-icon bi bi-list-task mb-2"></i>'.__('Stoks').'',
            //      [
            //     'route' => 'stocks.index',
            //     'class' => 'nav-item',
            // ])
            // ->data([
            //     'order'         => 3,
            //     'activematches' => 'stocks*',
            //     'permission'    => ['create_adjustments'],
            // ])
            // ->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2 pb-2',
            // ]);

            // EMAS - STOK - STOK OPNAME - Stok Transfer
            // $adjustments->add('
            //     <i class="c-sidebar-nav-icon bi bi-list-task mb-2"></i>
            //     '.__('Stok Transfer').'',
            //      [
            //     'route' => 'stocktransfer.index',
            //     'class' => 'nav-item',
            // ])
            // ->data([
            //     'order'         => 4,
            //     'activematches' => 'stocktransfer*',
            //     'permission'    => ['create_adjustments'],
            // ])
            // ->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2 pb-2',
            // ]);

            // EMAS - STOK - STOK OPNAME - Stok RFID
            //  $adjustments->add('
            //     <i class="c-sidebar-nav-icon bi bi-list-task mb-2"></i>
            //     '.__('Stok RFID').'',
            //      [
            //     'route' => 'rfid.index',
            //     'class' => 'nav-item',
            // ])
            // ->data([
            //     'order'         => 3,
            //     'activematches' => 'rfid*',
            //     'permission'    => ['create_adjustments'],
            // ])
            // ->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2 pb-2',
            // ]);

            // EMAS - PROSES
            // $proses = $emas->add('<i class="mb-2 c-sidebar-nav-icon bi bi-recycle"></i> Proses', [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])
            //     ->data([
            //         'order'         => 5,
            //         'activematches' => [],
            //         'permission' => ['access_menu_proses'],
            //     ]);
            // $proses->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);

            // // EMAS - PROSES - CUCI
            // $cuci = $proses->add('<i class="mb-2 c-sidebar-nav-icon bi bi-card-checklist"></i> Cuci', [
            //     'class' => 'nav-item',
            //     'route' => 'products.process.cuci'
            // ])
            //     ->data([
            //         'order'         => 1,
            //         'activematches' => [],
            //         'permission' => ['access_menu_proses'],
            //     ]);
            // $cuci->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2',
            // ]);

            // // EMAS - PROSES - Masak
            // $masak = $proses->add('<i class="mb-2 c-sidebar-nav-icon bi bi-card-checklist"></i> Masak', [
            //     'class' => 'nav-item',
            //     'route' => 'products.process.masak'
            // ])
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => [],
            //         'permission' => [],
            //     ]);
            // $masak->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2',
            // ]);

            // // EMAS - PROSES - Rongsok
            // $rongsok = $proses->add('<i class="mb-2 c-sidebar-nav-icon bi bi-card-checklist"></i> Rongsok', [
            //     'class' => 'nav-item',
            //     'route' => 'products.process.rongsok'
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => [],
            //         'permission' => [],
            //     ]);
            // $rongsok->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2',
            // ]);

            // // EMAS - PROSES - Reparasi
            // $reparasi = $proses->add('<i class="mb-2 c-sidebar-nav-icon bi bi-card-checklist"></i> Reparasi', [
            //     'class' => 'nav-item',
            //     'route' => 'products.process.reparasi'
            // ])
            //     ->data([
            //         'order'         => 4,
            //         'activematches' => [],
            //         'permission' => [],
            //     ]);
            // $reparasi->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2',
            // ]);

            // // EMAS - PROSES - Second
            // $second = $proses->add('<i class="mb-2 c-sidebar-nav-icon bi bi-card-checklist"></i> Second', [
            //     'class' => 'nav-item',
            //     'route' => 'products.process.second'
            // ])
            //     ->data([
            //         'order'         => 4,
            //         'activematches' => [],
            //         'permission' => [],
            //     ]);
            // $second->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2',
            // ]);


            $jual = $menu->add('<i class="c-sidebar-nav-icon bi bi-bag"></i> Sales', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 3,
                    'activematches' => [
                        'products*',
                        'kategoriproduk*',
                        'product-categories*',
                        'diamondcertificates*',
                        'itemrounds*',
                        'penjualansales*',
                        'retursales*',
                        'itemshapes*',
                        'stokcabangs*',
                        'goodsreceipts*',

                    ],
                    'permission' => [
                        'access_masterdata',
                        'access_penjualansales',
                        'access_kategoriproduks',
                        'access_retursale',
                        'access_buybacktoko',
                        'access_goodsreceipts',
                        'access_stok_cabang',
                        'access_stok_dp',
                        'access_stok_pending',
                        'access_diamondcertificates'
                    ],
                ]);
            $jual->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);
            $jual->add('<i class="c-sidebar-nav-icon bi-sliders"></i> ' . __('Report') . '', [
                'route' => 'sale.report',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 91,
                    'activematches' => 'settings*',
                    'permission'    => ['access_settings'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link',
                ]);

            // EMAS - PEMBELIAN
            // $Penjualan = $jual->add('<i class="c-sidebar-nav-icon mb-1 bi bi-bag"></i>' . __('Laporan') . '', [
            //     'class' => 'c-sidebar-nav-dropdown',
            //     'route' => 'sale.laporan',
            // ])
            //     ->data([
            //         'order'         => 1,
            //         'activematches' => [
            //             'purchase-payments*',
            //             'purchase-goodsreceipts*',

            //         ],
            //         'permission'    => ['access_purchases', 'access_goodsreceipts'],
            //     ]);
            // $Penjualan->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);



            //==== Access Control Dropdown Categories
            $Categories = $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('labels.menu.categories'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 2,
                    'activematches' => [
                        'kategoriproduk*',
                    ],
                    'permission' => ['access_kategoriproduks'],
                ]);
            $Categories->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);


            // Main Kategori
            $Categories->add(
                '<i class="px-1 text-sm c-sidebar-nav-icon  bi bi-dot text-sm"></i> ' . __('Main Kategori'),
                [
                    'route' => 'kategoriproduk.index',
                    'class' => 'nav-item',
                ]
            )
                ->data([
                    'order'         => 3,
                    'activematches' => ['kategoriproduk*'],
                    'permission'    => ['access_kategoriproduks'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            // Submenu: Categories
            $Categories->add(
                '<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> ' . __('labels.menu.kategori_produk'),
                [
                    'route' => 'product-categories.index',
                    'class' => 'nav-item',
                ]
            )
                ->data([
                    'order'         => 3,
                    'activematches' => 'product-categories*',
                    'permission'    => ['access_product_categories'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);


            // GoldCategories
            $Categories->add('<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> ' . __('Gold Categories'), [
                'route' => 'goldcategory.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 3,
                    'activematches' => ['goldcategories*'],
                    'permission'    => ['access_goldcategories'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);


            // JenisPerhiasans
            // $Categories->add('<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> '.__('Jenis Perhiasan'), [
            //     'route' => 'jenisperhiasan.index',
            //     'class' => 'nav-item',
            // ])
            // ->data([
            //     'order'         => 3,
            //     'activematches' => ['jenisperhiasans*'],
            //     'permission'    => ['access_jenisperhiasans'],
            // ])
            // ->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2',
            // ]);





            // DiamondCertificates
            // $Categories->add(
            //     // '<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> '.__('labels.menu.diamond_certificate'), [
            //     '<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> ' . __('Sertifikat Logam'),
            //     [
            //         'route' => 'diamondcertificate.index',
            //         'class' => 'nav-item',
            //     ]
            // )
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => ['diamondcertificates*'],
            //         'permission'    => ['access_diamondcertificates'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);



            //=========================== end menu kategori

            //==== Access Control Dropdown Categories
            $jenisGropus = $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Group'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 2,
                    'activematches' => [
                        'jenisgroups*',
                        'groups*',
                    ],
                    'permission' => ['access_jenisgroups', 'access_groups'],
                ]);
            $jenisGropus->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);



            // JenisGroups
            $jenisGropus->add('<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> ' . __('Jenis Group'), [
                'route' => 'jenisgroup.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 3,
                    'activematches' => ['jenisgroups*'],
                    'permission'    => ['access_jenisgroups'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);


            // Groups
            $jenisGropus->add('<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> ' . __('Group'), [
                'route' => 'group.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 3,
                    'activematches' => ['groups*'],
                    'permission'    => ['access_groups'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);


            // JenisBuyBacks
            // $jenisGropus->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Jenis Buy Backs'), [
            //         'route' => 'jenisbuyback.index',
            //         'class' => 'nav-item',
            //     ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => ['jenisbuybacks*'],
            //         'permission'    => ['access_jenisbuybacks'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // Cabangs
            // $jenisGropus->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Cabang'), [
            //     'route' => 'cabang.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => ['cabangs*'],
            //         'permission'    => ['access_cabangs'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);




            /// === end menu group --------------------------------------------------




            //==== Access Control Dropdown data master
            $dataMaster = $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Data Master'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 2,
                    'activematches' => [
                        'datarekenings*',
                        'datasales*',
                        'datarekenings*',
                        'dataetalases*',
                        'kodetransaksis*',
                        'marketplaces*',
                        'access_produkmodels*',
                    ],
                    'permission' => [
                        'access_datasales',
                        'access_datarekenings',
                        'access_datarekenings',
                        'access_marketplaces',
                        'access_kodetransaksis',
                        'access_produkmodels',
                        'access_dataetalases'
                    ],
                ]);
            $dataMaster->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // ProdukModels
            $dataMaster->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Produk Models'), [
                'route' => 'produkmodel.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 3,
                    'activematches' => ['produkmodels*'],
                    'permission'    => ['access_produkmodels'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            $dataMaster->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Baki'), [
                'route' => 'bakis.list',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 3,
                    'activematches' => ['produkmodels*'],
                    'permission'    => ['access_produkmodels'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);



            // DataEtalases


            //================ end menu data master ----------------------





            //==== Access Control Dropdown data Parameter
            $Parameters = $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Data Parameters'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 2,
                    'activematches' => [
                        'paramaterpoins*',
                        'goldparameters*',
                        'costparameters*',
                        'databanks*',

                    ],
                    'permission' => [
                        'access_paramaterpoins',
                        'access_goldparameters',
                        'costparameters',
                        'access_databanks'
                    ],
                ]);
            $Parameters->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);



            // ParamaterPoins

            // Karats
            $Parameters->add(
                '<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> ' . __('Karat Emas'),
                [
                    'route' => 'karats.list',
                    'class' => 'nav-item',
                ]
            )
                ->data([
                    'order'         => 3,
                    'activematches' => ['karats*'],
                    'permission'    => ['access_karats'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            $Parameters->add(
                '<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i> ' . __('Diskon'),
                [
                    'route' => 'discounts.list',
                    'class' => 'nav-item',
                ]
            )
                ->data([
                    'order'         => 3,
                    'activematches' => ['karats*'],
                    'permission'    => ['access_karats'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);




            //==== Access Control Dropdown data Parameter
            $databank = $masterData->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Data Bank'), [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 2,
                    'activematches' => [
                        'datarekening*',
                        'databank*',

                    ],
                    'permission' => [
                        'access_datarekenings',
                        'access_databanks'
                    ],
                ]);
            $databank->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);


            $databank->add(
                '<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i>
                 ' . __('List Bank Transfer'),
                [
                    'route' => 'databank.index',
                    'class' => 'nav-item',
                ]
            )
                ->data([
                    'order'         => 3,
                    'activematches' => ['databanks*'],
                    'permission'    => ['access_databanks'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);


            $databank->add(
                '<i class="c-sidebar-nav-icon  bi bi-dot text-sm"></i>
                     ' . __('List EDC'),
                [
                    'route' => 'datarekening.index',
                    'class' => 'nav-item',
                ]
            )
                ->data([
                    'order'         => 3,
                    'activematches' => ['datarekenings*'],
                    'permission'    => ['access_datarekenings'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);




















            // ================ Start of Berlian =================

            // $berlian = $menu->add('<i class="c-sidebar-nav-icon bi bi-gem"></i> ' . __('Berlian'), [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])->data([
            //     'order'         => 3,
            //     'activematches' => [
            //         'products*',
            //         'goodsreceipt*',
            //         'product-categories*',
            //         'diamondcertificates*',
            //         'itemrounds*',
            //         'itemshapes*',

            //     ],
            //     'permission' => [],
            // ]);
            // $berlian->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);

            // // // BERLIAN - PEMBELIAN
            // $purchase_berlian = $berlian->add('<i class="c-sidebar-nav-icon mb-1 bi bi-bag"></i>' . __('Purchases') . '', [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])->data([
            //     'order'         => 1,
            //     'activematches' => [
            //         'purchase-payments*',

            //     ],
            //     'permission'    => ['access_purchases'],
            // ]);
            // $purchase_berlian->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);

            // // BERLIAN - PEMBELIAN - PENERIMAAN QC
            // $purchase_berlian->add('<i class="c-sidebar-nav-icon mb-1 bi bi-card-checklist"></i>' . __('Goods Receipts QC'), [
            //     'route' => 'goodsreceiptberlian.qc.index',
            //     'class' => 'nav-item ',
            // ])->data([
            //     'order'         => 1,
            //     'activematches' => ['goodsreceiptsberlian*'],
            //     'permission'    => ['access_goodsreceipts'],
            // ])->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2',
            // ]);

            // // EMAS - PEMBELIAN - Hutang
            // $purchase_berlian->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Goods Receipt Debts'), [
            //     'route' => 'goodsreceiptberlian.debts',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => ['goodsreceipts*'],
            //         'permission'    => ['access_goodsreceipts'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);



            // // Berlian - PRODUKSI

            // $produksi = $berlian->add('<i class="c-sidebar-nav-icon mb-1 bi bi-card-checklist"></i>' . __('Produksi'), [
            //     'route' => 'produksi.index',
            //     'class' => 'nav-item ',
            // ])->data([
            //     'order'         => 2,
            //     'activematches' => ['produksis*'],
            //     'permission'    => ['access_produksis'],
            // ])->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2',
            // ]);

            // // Berlian - TOKO
            // $berlianToko = $berlian->add('<i class="c-sidebar-nav-icon mb-1 bi bi-shop"></i>' . __('Toko') . '', [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])
            // ->data([
            //     'order'         => 2,
            //     'activematches' => ['produksis*'],
            //     'permission'    => ['access_produksis'],
            // ]);
            // $berlianToko->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);

            // // Berlian - TOKO - Distribusi Toko
            // $distribusiTokoBerlian = $berlianToko->add(
            //     '<i class="c-sidebar-nav-icon mb-1 bi bi-journal-plus"></i>
            //     ' . __('Distribusi Toko') . '',
            //     [
            //         'class' => 'c-sidebar-nav-dropdown',
            //     ]
            // )
            //     ->data([
            //         'order'         => 4,
            //         'activematches' => [
            //             'datasales*',
            //             'distribusitokos*',

            //         ],
            //         'permission'    => ['access_distribusitoko'],
            //     ]);
            // $distribusiTokoBerlian->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);

            // // EMAS - TOKO - Distribusi Toko - PRODUK
            // $distribusiTokoBerlian->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Produk'), [
            //     'route' => 'products.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => ['products*'],
            //         'permission'    => ['access_products'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // // EMAS - TOKO - Distribusi Toko - LIST DISTRIBUSI TOKO
            // $distribusiTokoBerlian->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('List Distribusi Toko'), [
            //     'route' => 'distribusitoko.berlian',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 1,
            //         'activematches' => ['distribusitokos*'],
            //         'permission'    => ['access_distribusitoko'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // // Berlian - STOK
            // $stok_berlian = $berlian->add('<i class="mb-2 c-sidebar-nav-icon bi bi-box-seam"></i> Stok', [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])
            //     ->data([
            //         'order'         => 4,
            //         'activematches' => [
            //             'stoks*',
            //             'stokcabangs*',
            //         ],
            //         'permission' => [
            //             'access_stoks',
            //             'access_stok_cabang',
            //             'access_stok_dp',
            //             'access_stok_pending',
            //             'access_menu_stok'
            //         ],
            //     ]);
            // $stok_berlian->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);
            // // EMAS - Stok Cabang
            // $stock_cabang_berlian = $stok_berlian->add('<i class="c-sidebar-nav-icon  bi-card-checklist"></i> ' . __('Stok Cabang'), [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])
            //     ->data([
            //         'order'         => 2,
            //         'activematches' => [],
            //         'permission'    => ['access_stok_cabang'],
            //     ]);
            // $stock_cabang_berlian->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);

            // // EMAS - STOK CABANG - STOK PENDING
            // $stock_cabang_berlian->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Stok Ready'), [
            //     'route' => 'stok.berlian.ready',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 1,
            //         'activematches' => ['stoks*'],
            //         'permission'    => ['show_stock_ready_cabang'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // ================ End of Berlian =================








            //end master parameter
            //==== Access Control Status Iventory




            //end status iventory====



            //==== Access Control Dropdown Gudang


            // end gudang menu =======================






            // Riwayat Penerimaan
            //  $Purchases->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i>
            //             '.__('Riwayat Penerimaan'), [
            //             'route' => 'goodsreceipt.riwayat_penerimaan',
            //             'class' => 'nav-item',
            //         ])
            //         ->data([
            //             'order'         => 2,
            //             'activematches' => ['goodsreceipts*'],
            //             'permission'    => ['access_goodsreceipts'],
            //         ])
            //         ->link->attr([
            //             'class' => 'c-sidebar-nav-link py-2',
            //         ]);




            // Penjualan
            // $Penjualan = $menu->add('<i class="c-sidebar-nav-icon mb-1 bi bi-cart"></i>' . __('Penjualan') . '', [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => [
            //             'sales*',

            //         ],
            //         'permission'    => ['access_sales'],
            //     ]);
            // $Penjualan->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);

            // //  LIST PENJUALAN
            // $Penjualan->add(
            //     '
            //     <i class="c-sidebar-nav-icon bi bi-chevron-right mb-2"></i>
            //     ' . __('List Penjualan') . '',
            //     [
            //         'route' => 'sales.index',
            //         'class' => 'nav-item',
            //     ]
            // )
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => 'sales*',
            //         'permission'    => ['access_sales'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);

            // //  LIST PRODUK CUSTOM
            // $Penjualan->add(
            //     '
            //     <i class="c-sidebar-nav-icon bi bi-chevron-right mb-2"></i>
            //     ' . __('List Produk Custom') . '',
            //     [
            //         'route' => 'sale.custom.index',
            //         'class' => 'nav-item',
            //     ]
            // )
            //     ->data([
            //         'order'         => 3,
            //         'activematches' => 'sales*',
            //         'permission'    => ['access_sales'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);


            //============================Access Control Dropdown


            // // Submenu: products
            // $products->add('
            //     <i class="c-sidebar-nav-icon bi bi-list-task mb-2"></i>'.__('Products Transfer').'',
            //      [
            //     'route' => 'product-transfer.index',
            //     'class' => 'nav-item',
            // ])
            // ->data([
            //     'order'         => 3,
            //     'activematches' => 'product-transfer*',
            //     'permission'    => ['access_product_transfer'],
            // ])
            // ->link->attr([
            //     'class' => 'c-sidebar-nav-link py-2',
            // ]);

            // PenentuanHargas


            // Timbangans
            // $products->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> '.__('Timbangan'), [
            //             'route' => 'timbangan.index',
            //             'class' => 'nav-item',
            //         ])
            //         ->data([
            //             'order'         => 3,
            //             'activematches' => ['timbangans*'],
            //             'permission'    => ['access_timbangans'],
            //         ])
            //         ->link->attr([
            //             'class' => 'c-sidebar-nav-link py-2',
            //         ]);




            // // Submenu: products
            //      $products->add(
            //          '<i class="c-sidebar-nav-icon bi bi-upc-scan mb-2"></i>'.__('Print Barcode').'',
            //       [
            //          'route' => 'barcode.print',
            //          'class' => 'nav-item',
            //      ])
            //      ->data([
            //          'order'         => 3,
            //          'activematches' => 'barcode*',
            //          'permission'    => ['print_barcodes'],
            //      ])
            //      ->link->attr([
            //          'class' => 'c-sidebar-nav-link py-2 pb-2',
            //      ]);



            // // Submenu: SORTIR
            //   $products->add(
            //       '<i class="c-sidebar-nav-icon bi bi-credit-card-2-back mb-2"></i>'.__('Sortir').'',
            //    [
            //       'route' => 'products.sortir',
            //       'class' => 'nav-item',
            //   ])
            //   ->data([
            //       'order'         => 3,
            //       'activematches' => 'sortir*',
            //       'permission'    => ['access_products'],
            //   ])
            //   ->link->attr([
            //       'class' => 'c-sidebar-nav-link py-2 pb-2',
            //   ]);



            // Submenu: Gudang Utama


            // // Submenu: Reparasi
            //   $products->add(
            //       '<i class="c-sidebar-nav-icon bi bi-tools mb-2"></i>'.__('Reparasi').'',
            //    [
            //       'route' => 'products.reparasi',
            //       'class' => 'nav-item',
            //   ])
            //   ->data([
            //       'order'         => 3,
            //       'activematches' => 'reparasi*',
            //       'permission'    => ['access_products'],
            //   ])
            //   ->link->attr([
            //       'class' => 'c-sidebar-nav-link py-2 pb-2',
            //   ]);











            // customers Access Control Dropdown ==================================
            // $access_expenses = $menu->add(
            //     '<i class="c-sidebar-nav-icon mb-1 bi bi-journal-plus"></i>
            //     ' . __('Kas Toko') . '',
            //     [
            //         'class' => 'c-sidebar-nav-dropdown',
            //     ]
            // )
            //     ->data([
            //         'order'         => 77,
            //         'activematches' => [
            //             'expense*',

            //         ],
            //         'permission'    => ['access_expenses', 'access_expense_categories'],
            //     ]);
            // $access_expenses->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);


            // // Submenu: expenses
            // $access_expenses->add(
            //     '<i class="c-sidebar-nav-icon bi bi-journal-arrow-up mb-1"></i>
            //      ' . __('Keluar Masuk Kas') . '',
            //     [
            //         'route' => 'expenses.index',
            //         'class' => 'nav-item',
            //     ]
            // )
            //     ->data([
            //         'order'         => 77,
            //         'activematches' => 'expenses*',
            //         'permission'    => ['access_expenses'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-3 mt-1',
            //     ]);


            // // Submenu: expense_categories
            // $access_expenses->add(
            //     '<i class="c-sidebar-nav-icon bi bi-journal-bookmark-fill mb-1"></i>
            //      ' . __('Kategori Kas Toko') . '',
            //     [
            //         'route' => 'expense-categories.index',
            //         'class' => 'nav-item',
            //     ]
            // )
            //     ->data([
            //         'order'         => 77,
            //         'activematches' => 'expense-categories*',
            //         'permission'    => ['access_expense_categories'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-3',
            //     ]);


            // customers Access Control Dropdown ==================================



            // Separator: Access Management
            $menu->add('Management', [
                'class' => 'c-sidebar-nav-title text-gray-100',
            ])
                ->data([
                    'order'         => 89,
                    'permission'    =>
                    [
                        'access_user_management',
                        'access_settings',
                        'access_currencies'
                    ],
                ]);


            // Access Control Dropdown
            // $report = $menu->add('<i class="c-sidebar-nav-icon mb-1 bi bi-journal-check"></i>' . __('Reports') . '', [
            //     'class' => 'c-sidebar-nav-dropdown',
            // ])
            //     ->data([
            //         'order'         => 88,
            //         'activematches' => [
            //             '*-report.index',

            //         ],
            //         'permission'    => ['access_reports'],
            //     ]);
            // $report->link->attr([
            //     'class' => 'c-sidebar-nav-dropdown-toggle',
            //     'href'  => '#',
            // ]);


            // // Submenu: Users
            // $report->add('<i class="c-sidebar-nav-icon bi bi-cash-coin mb-1"></i> ' . __('Profit Loss Report') . '', [
            //     'route' => 'profit-loss-report.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 88,
            //         'permission'    => ['access_laporan_laba_rugi'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link',
            //     ]);


            // // Submenu: Users
            // $report->add('<i class="c-sidebar-nav-icon bi bi-wallet2 mb-1"></i> ' . __('Payments Report') . '', [
            //     'route' => 'payments-report.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 88,
            //         'permission'    => ['access_laporan_pembayaran'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link',
            //     ]);

            // // Submenu: laporan Piutang
            // $report->add('<i class="c-sidebar-nav-icon bi bi-wallet2 mb-1"></i> ' . __('Laporan Piutang') . '', [
            //     'route' => 'piutang-report.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 88,
            //         'permission'    => ['access_laporan_piutang'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link',
            //     ]);

            // // Submenu: laporan hutang
            // $report->add('<i class="c-sidebar-nav-icon bi bi-wallet2 mb-1"></i> ' . __('Laporan Hutang') . '', [
            //     'route' => 'hutang-report.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 88,
            //         'permission'    => ['access_laporan_hutang'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link',
            //     ]);


            // // Submenu: Users
            // $report->add('<i class="c-sidebar-nav-icon bi bi-bag-check mb-2"></i> ' . __('Laporan Penjualan') . '', [
            //     'route' => 'sales-report.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 88,
            //         'permission'    => ['access_laporan_penjualan'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link',
            //     ]);


            // // Submenu: Users
            // $report->add('<i class="c-sidebar-nav-icon bi bi-receipt mb-2"></i> ' . __('Purchases Report') . '', [
            //     'route' => 'purchases-report.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 88,
            //         'permission'    => ['access_laporan_pembelian'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link',
            //     ]);


            // // Submenu: Users
            // $report->add('<i class="c-sidebar-nav-icon bi bi-bag-fill mb-2"></i> ' . __('Laporan Retur Sales') . '', [
            //     'route' => 'sales-return-report.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 88,
            //         'permission'    => ['access_laporan_retur_sales'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link',
            //     ]);



            // Submenu: Users
            // $report->add('<i class="c-sidebar-nav-icon bi bi-bag-x mb-2"></i> ' . __('Purchases Return Report') . '', [
            //     'route' => 'purchases-return-report.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 88,
            //         'permission'    => ['access_laporan_retur_pembelian'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link',
            //     ]);


            // LaporanAssets
            // $report->add('<i class="c-sidebar-nav-icon  bi bi-file-earmark-bar-graph text-sm"></i> ' . __('Laporan Assets'), [
            //     'route' => 'laporanasset.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 88,
            //         'activematches' => ['laporanassets*'],
            //         'permission'    => ['access_laporanassets'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);




            // STOCK OPNAME
            $stockopname = $menu->add('<i class="c-sidebar-nav-icon mb-1 bi bi-gear"></i>' . __('Stock Opname') . '', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 90,
                    'activematches' => [
                        'currencies*',

                    ],
                    'permission'    => ['access_currencies', 'access_settings'],
                ]);
            $stockopname->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            $stockopname->add('<i class="c-sidebar-nav-icon bi bi-currency-exchange"></i> ' . __('Opname') . '', [
                'route' => 'stock_opname.data',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 91,
                    'activematches' => 'currencies*',
                    'permission'    => ['access_currencies'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link',
                ]);

            // $stockopname->add('<i class="c-sidebar-nav-icon bi bi-currency-exchange"></i> ' . __('History') . '', [
            //     'route' => 'stock_opname.data',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 91,
            //         'activematches' => 'currencies*',
            //         'permission'    => ['access_currencies'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link',
            //     ]);

            // Access Control Dropdown

            $setting = $menu->add('<i class="c-sidebar-nav-icon mb-1 bi bi-gear"></i>' . __('Setting') . '', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 90,
                    'activematches' => [
                        'currencies*',

                    ],
                    'permission'    => ['access_currencies', 'access_settings'],
                ]);
            $setting->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: Users

            $setting->add('<i class="c-sidebar-nav-icon bi bi-currency-exchange"></i> ' . __('currencies') . '', [
                'route' => 'currencies.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 91,
                    'activematches' => 'currencies*',
                    'permission'    => ['access_currencies'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link',
                ]);


            $setting->add('<i class="c-sidebar-nav-icon bi bi-config"></i> ' . __('Config') . '', [
                'route' => 'config.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 91,
                    'activematches' => 'settings*',
                    'permission'    => ['access_settings'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link',
                ]);

            $setting->add('<i class="c-sidebar-nav-icon bi bi-config"></i> ' . __('Petty Cash') . '', [
                'route' => 'pettycash.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 91,
                    'activematches' => 'settings*',
                    'permission'    => ['access_settings'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link',
                ]);

            $setting->add('<i class="c-sidebar-nav-icon bi bi-config"></i> ' . __('Webcam') . '', [
                'route' => 'webcam.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 91,
                    'activematches' => 'settings*',
                    'permission'    => ['access_settings'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link',
                ]);

            // $setting->add('<i class="c-sidebar-nav-icon bi bi-config"></i> ' . __('Stock Opname') . '', [
            //         'route' => 'stock_opname.list',
            //         'class' => 'nav-item',
            //     ])
            //         ->data([
            //             'order'         => 91,
            //             'activematches' => 'settings*',
            //             'permission'    => ['access_settings'],
            //         ])
            //         ->link->attr([
            //             'class' => 'c-sidebar-nav-link',
            //         ]);
    

            $setting->add('<i class="c-sidebar-nav-icon bi-sliders"></i> ' . __('System Settings') . '', [
                'route' => 'settings.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 91,
                    'activematches' => 'settings*',
                    'permission'    => ['access_settings'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link',
                ]);




            // Access Control Dropdown
            $accessControl = $menu->add('<i class="c-sidebar-nav-icon cil-people"></i>' . __('Users Management') . '', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
                ->data([
                    'order'         => 101,
                    'activematches' => [
                        'users*',

                    ],
                    'permission'    => ['access_user_management'],
                ]);
            $accessControl->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: Users

            $accessControl->add('<i class="c-sidebar-nav-icon cil-people"></i> ' . __('Users') . '', [
                'route' => 'users.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 102,
                    'activematches' => 'users*',
                    'permission'    => ['access_user_management'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link',
                ]);

            $accessControl->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Roles') . '', [
                'route' => 'roles.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 102,
                    'activematches' => 'roles*',
                    'permission'    => ['access_user_management'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link',
                ]);


            // UserCabangs
            $accessControl->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('User Cabang'), [
                'route' => 'usercabang.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 102,
                    'activematches' => ['usercabangs*'],
                    'permission'    => ['access_usercabangs'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            // UserLogins
            $accessControl->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('User Login'), [
                'route' => 'userlogin.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 102,
                    'activematches' => ['userlogins*'],
                    'permission'    => ['access_userlogins'],
                ])
                ->link->attr([
                    'class' => 'c-sidebar-nav-link py-2',
                ]);

            // Companies
            // $menu->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Company'), [
            //     'route' => 'company.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 102,
            //         'activematches' => ['companies*'],
            //         'permission'    => ['access_companies'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);


            // LogActivities
            // $menu->add('<i class="c-sidebar-nav-icon  bi bi-chevron-right text-sm"></i> ' . __('Log Activities'), [
            //     'route' => 'logactivity.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order'         => 102,
            //         'activematches' => ['logactivities*'],
            //         'permission'    => ['access_logactivities'],
            //     ])
            //     ->link->attr([
            //         'class' => 'c-sidebar-nav-link py-2',
            //     ]);











            // Access Permission Check
            $menu->filter(function ($item) {
                if ($item->data('permission')) {
                    if (auth()->check()) {
                        if (auth()->user()->hasRole('Super Admin')) {
                            return true;
                        } elseif (auth()->user()->hasAnyPermission($item->data('permission'))) {
                            return true;
                        }
                    }

                    return false;
                } else {
                    return true;
                }
            });

            // Set Active Menu
            $menu->filter(function ($item) {
                if ($item->activematches) {
                    $matches = is_array($item->activematches) ? $item->activematches : [$item->activematches];

                    foreach ($matches as $pattern) {
                        if (Str::is($pattern, \Request::path())) {
                            $item->activate();
                            $item->active();
                            if ($item->hasParent()) {
                                $item->parent()->activate();
                                $item->parent()->active();
                            }
                            // dd($pattern);
                        }
                    }
                }

                return true;
            });
        })->sortBy('order');

        return $next($request);
    }
}
