<?php

namespace Modules\Adjustment\DataTables;

use Modules\Product\Entities\ProductLocation;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StocksDatatable extends DataTable
{

    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                return view('adjustment::partials.actions', compact('data'));
            })
             ->editColumn('name', function ($data) {
                return $data->product->product_name.' '.$data->product->product_code;
            })
             ->editColumn('type', function ($data) {
                return $data->product->category->category_name;
            })
             ->editColumn('stock', function ($data) {
                return $data->stock .' '.$data->product->unit->name;
            })
             ->editColumn('location', function ($data) {
                return $data->location->name;
            });
    }

    public function query(ProductLocation $model) {
        return $model->with('product')->newQuery();
    }

    public function html() {
        return $this->builder()
            ->setTableId('stock-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                        'tr' .
                                        <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(4)
            ->buttons(
                Button::make('excel')
                    ->text('<i class="bi bi-file-earmark-excel-fill"></i> Excel'),
                Button::make('pdf')
                    ->text('<i class="bi bi-file-earmark-excel-fill"></i> Excel'),
                Button::make('print')
                    ->text('<i class="bi bi-printer-fill"></i> Print'),
                Button::make('reset')
                    ->text('<i class="bi bi-x-circle"></i> Reset'),
                Button::make('reload')
                    ->text('<i class="bi bi-arrow-repeat"></i> Reload')
            );
    }

    protected function getColumns() {
        return [
            Column::make('name'),

            Column::make('type')->title('Jenis Kain'),

            Column::make('location')
                ->title('Lokasi Product'),

            Column::make('stock')
                ->title('Stock'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->className('aksi text-center align-middle'),

            Column::make('created_at')
                ->visible(false)
        ];
    }

    protected function filename() {
        return 'Stocks_' . date('YmdHis');
    }
}
