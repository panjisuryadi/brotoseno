<?php

namespace Modules\Locations\DataTables;
use Modules\Locations\Entities\Locations;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LocationsDataTable extends DataTable
{

    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                return view('locations::locations.partials.actions', compact('data'));
            })
             ->addColumn('#', function ($data) {
                 return $data->id;
            })
             ->addColumn('type', function ($data) {
                 if($data->type == 'storage'){
                    return 'Penyimpanan';
                 }else{
                    return 'Etalase';
                 }
            })
             ->addColumn('main_location', function ($data) {
                return $data->parent_id != NULL || $data->parent_id != '' ? Locations::find($data->parent_id)->name : '-';
            });
    }



    public function query(Locations $model) {
        return $model->newQuery();
    }

    public function html() {
        return $this->builder()
            ->setTableId('locations-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                       'tr' .
                                 <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(3)
            ->buttons(
                Button::make('excel')
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
            Column::make('#')->title('id')
                ->className('w-5 text-center align-middle'),

                Column::make('name')->title('location')
                ->className('w-20 text-center align-middle'),
                
                Column::make('type')->title('Tipe')
                ->className('w-20 text-center align-middle'),

            Column::make('main_location')
                ->className('w-30 text-left align-middle'),


            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->className('w-15 text-center align-middle'),

            Column::make('created_at')
                ->visible(false)
        ];
    }

    protected function filename() {
        return 'Locations_' . date('YmdHis');
    }
}
