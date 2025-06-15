@extends('layouts.app')

@section('title', 'Edit Role')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@push('page_css')
    <style>
        .custom-control-label {
            cursor: pointer;
        }
    </style>
@endpush



@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @include('utils.alerts')
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('patch')

                    <div class="card">
                        <div class="card-body">


                        <div class="flex justify-between gap-3">
                            <div class="form-group w-2/3">
                                <label for="name">Role Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name" required value="{{ $role->name }}">
                            </div>
                            <div class="form-group w-1/3">
                                <label for="name"></label>
                                <button type="submit" class="mt-2 w-full btn btn-primary">Update Role <i class="bi bi-check"></i>
                                </button>
                            </div>
                        </div>

                              <div class="px-4 flex relative py-2">
                                    <div class="absolute inset-1 flex items-center">
                                        <div class="w-full border-b border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-left">
                                <div class="tracking-widest bg-white pl-0 pr-1 custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="select-all">
                                    <label class="font-semibold custom-control-label text-sm uppercase text-dark" for="select-all">Give All Permissions</label>
                                </div>

                                    </div>
                                </div>




 <div class="flex flex-row grid grid-cols-2 gap-1 mb-2">
<div class="card h-100 border-0 shadow">
    <div class="card-header">
        Dashboard
    </div>
    <div class="card-body">

<div class="flex flex-row grid grid-cols-2 gap-1">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input"
            id="show_total_stats" name="permissions[]"
            value="show_total_stats" {{ $role->hasPermissionTo('show_total_stats') ? 'checked' : '' }}>
            <label class="custom-control-label" for="show_total_stats">Total Stats</label>
        </div>
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input"
        id="show_notifications" name="permissions[]"
        value="show_notifications" {{ $role->hasPermissionTo('show_notifications') ? 'checked' : '' }}>
        <label class="custom-control-label" for="show_notifications">Notifications</label>
       </div>

        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input"
            id="show_month_overview" name="permissions[]"
            value="show_month_overview" {{ $role->hasPermissionTo('show_month_overview') ? 'checked' : '' }}>
            <label class="custom-control-label" for="show_month_overview">Month Overview</label>
        </div>

    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input"
        id="show_weekly_sales_purchases" name="permissions[]"
        value="show_weekly_sales_purchases" {{ $role->hasPermissionTo('show_weekly_sales_purchases') ? 'checked' : '' }}>
        <label class="custom-control-label" for="show_weekly_sales_purchases">Weekly Sales & Purchases</label>
    </div>

    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input"
        id="show_monthly_cashflow" name="permissions[]"
        value="show_monthly_cashflow" {{ $role->hasPermissionTo('show_monthly_cashflow') ? 'checked' : '' }}>
        <label class="custom-control-label" for="show_monthly_cashflow">Monthly Cashflow</label>
    </div>

        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input"
            id="show_logs_dashboard" name="permissions[]"
            value="show_logs_dashboard" {{ $role->hasPermissionTo('show_logs_dashboard') ? 'checked' : '' }}>
            <label class="custom-control-label" for="show_logs_dashboard">show logs dashboard</label>
        </div>
     
        

       </div>
    </div>





</div>





<div class="card h-100 border-0 shadow">
    <div class="card-header">
        Users Management
    </div>
    <div class="card-body">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_user_management" name="permissions[]"
                value="access_user_management" {{ $role->hasPermissionTo('access_user_management') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_user_management">Access Menu Users</label>
            </div>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_own_profile" name="permissions[]"
                value="edit_own_profile" {{ $role->hasPermissionTo('edit_own_profile') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_own_profile">Own Profile</label>
            </div>


    </div>
 
</div>



 </div>


{{-- batas --}}

 <div class="flex flex-row grid grid-cols-1 gap-1 mb-2">

<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Akses Roles | Pages per Roles
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_gudang" name="permissions[]"
                value="access_gudang" {{ $role->hasPermissionTo('access_gudang') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_gudang">
                  {{ label_Case('access_gudang') }}
               </label>
            </div>
            
                <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="dashboard_gudang" name="permissions[]"
                value="dashboard_gudang" {{ $role->hasPermissionTo('dashboard_gudang') ? 'checked' : '' }}>
                <label class="custom-control-label" for="dashboard_gudang">
                  {{ label_Case('dashboard_gudang') }}
               </label>
            </div>
            
        <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_admin_sales" name="permissions[]"
                value="access_admin_sales" {{ $role->hasPermissionTo('access_admin_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_admin_sales">
                  {{ label_Case('access_admin_sales') }}
               </label>
            </div>
            
   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="dashboard_admin_sales" name="permissions[]"
                value="dashboard_admin_sales" {{ $role->hasPermissionTo('dashboard_admin_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="dashboard_admin_sales">
                  {{ label_Case('dashboard_admin_sales') }}
               </label>
            </div>


   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_kepala_toko" name="permissions[]"
                value="access_kepala_toko" {{ $role->hasPermissionTo('access_kepala_toko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_kepala_toko">
                  {{ label_Case('access_kepala_toko') }}
               </label>
            </div>

 <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="dashboard_kepala_toko" name="permissions[]"
                value="dashboard_kepala_toko" {{ $role->hasPermissionTo('dashboard_kepala_toko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="dashboard_kepala_toko">
                  {{ label_Case('dashboard_kepala_toko') }}
               </label>
            </div>



   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_kasir" name="permissions[]"
                value="access_kasir" {{ $role->hasPermissionTo('access_kasir') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_kasir">
                  {{ label_Case('access_kasir') }}
               </label>
            </div>

     <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="dashboard_sales" name="permissions[]"
                value="dashboard_sales" {{ $role->hasPermissionTo('dashboard_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="dashboard_sales">
                  {{ label_Case('dashboard_sales') }}
               </label>
            </div>

           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_sales" name="permissions[]"
                value="access_sales" {{ $role->hasPermissionTo('access_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_sales">
                  {{ label_Case('access_sales') }}
               </label>
            </div>
      <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input"
            id="dashboard_distribusi" name="permissions[]"
            value="dashboard_distribusi" {{ $role->hasPermissionTo('dashboard_distribusi') ? 'checked' : '' }}>
            <label class="custom-control-label" for="dashboard_distribusi">
           Dashboard Distribusi </label>
        </div>

      <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input"
            id="access_page_distribusi" name="permissions[]"
            value="access_page_distribusi" {{ $role->hasPermissionTo('access_page_distribusi') ? 'checked' : '' }}>
            <label class="custom-control-label" for="access_page_distribusi">
           Akses Page Distribusi </label>
        </div>

             
          <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="dashboard_pos" name="permissions[]"
                value="dashboard_pos" {{ $role->hasPermissionTo('dashboard_pos') ? 'checked' : '' }}>
                <label class="custom-control-label" for="dashboard_pos">
                  {{ label_Case('dashboard_pos') }}
               </label>
            </div>
          
            
        </div>
    </div>
</div>




 </div>
 <div class="flex flex-row grid grid-cols-2 gap-1 mb-2">





<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
      Akses Menu
    </div>
    <div class="card-body">


<div class="flex flex-row grid grid-cols-2 gap-1">
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input"
        id="access_masterdata" name="permissions[]"
        value="access_masterdata" {{ $role->hasPermissionTo('access_masterdata') ? 'checked' : '' }}>
        <label class="custom-control-label" for="access_masterdata">{{ Label_case('masterdata') }}</label>
    </div>
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input"
        id="access_menu_reports" name="permissions[]"
        value="access_menu_reports" {{ $role->hasPermissionTo('access_menu_reports') ? 'checked' : '' }}>
        <label class="custom-control-label" for="access_menu_reports">{{ Label_case('reports') }}</label>
    </div>


    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input"
        id="access_stoks" name="permissions[]"
        value="access_stoks" {{ $role->hasPermissionTo('access_stoks') ? 'checked' : '' }}>
        <label class="custom-control-label" for="access_stoks">{{ Label_case('access_stoks') }}</label>
    </div>

       <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input"
        id="access_menu_pengeluaran" name="permissions[]"
        value="access_menu_pengeluaran" {{ $role->hasPermissionTo('access_menu_pengeluaran') ? 'checked' : '' }}>
        <label class="custom-control-label" for="access_menu_pengeluaran">{{ Label_case('pengeluaran') }}</label>
    </div> 

       <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input"
        id="access_menu_penjualan" name="permissions[]"
        value="access_menu_penjualan" {{ $role->hasPermissionTo('access_menu_penjualan') ? 'checked' : '' }}>
        <label class="custom-control-label" for="access_menu_penjualan">{{ Label_case('penjualan') }}</label>
    </div>
    
       <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input"
        id="access_menu_stok" name="permissions[]"
        value="access_menu_stok" {{ $role->hasPermissionTo('access_menu_stok') ? 'checked' : '' }}>
        <label class="custom-control-label" for="access_menu_stok">{{ Label_case('stok') }}</label>
    </div>


       <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input"
        id="access_menu_toko" name="permissions[]"
        value="access_menu_toko" {{ $role->hasPermissionTo('access_menu_toko') ? 'checked' : '' }}>
        <label class="custom-control-label" for="access_menu_toko">
        {{ Label_case('toko') }}</label>
    </div>
    
    
</div>

</div>
</div>






<div class="card h-100 border-0 shadow">
<div class="card-header font-semibold">
   Distribusi
</div>
    <div class="card-body">
 <div class="flex flex-row grid grid-cols-2 gap-1 mb-2">   


<div class="custom-control custom-switch">

    <input type="checkbox" class="custom-control-input"
    id="access_distribusi" name="permissions[]"
    value="access_distribusi" {{ $role->hasPermissionTo('access_distribusi') ? 'checked' : '' }}>
    <label class="custom-control-label" for="access_distribusi"> Access Distribusi</label>
</div>

<div class="custom-control custom-switch">

    <input type="checkbox" class="custom-control-input"
    id="create_distribusi" name="permissions[]"
    value="create_distribusi" {{ $role->hasPermissionTo('create_distribusi') ? 'checked' : '' }}>
    <label class="custom-control-label" for="create_distribusi">Create Distribusi</label>
</div>



<div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input"
    id="show_distribusi" name="permissions[]"
    value="show_distribusi" {{ $role->hasPermissionTo('show_distribusi') ? 'checked' : '' }}>
    <label class="custom-control-label" for="show_distribusi">Show Distribusi</label>
</div>


<div class="custom-control custom-switch">

    <input type="checkbox" class="custom-control-input"
    id="edit_distribusi" name="permissions[]"
    value="edit_distribusi" {{ $role->hasPermissionTo('edit_distribusi') ? 'checked' : '' }}>
    <label class="custom-control-label" for="edit_distribusi">Edit Distribusi</label>
</div>


<div class="custom-control custom-switch">

    <input type="checkbox" class="custom-control-input"
    id="delete_distribusi" name="permissions[]"
    value="delete_distribusi" {{ $role->hasPermissionTo('delete_distribusi') ? 'checked' : '' }}>
    <label class="custom-control-label" for="delete_distribusi">Delete Distribusi</label>
</div>


<div class="custom-control custom-switch">

    <input type="checkbox" class="custom-control-input"
    id="approve_distribusi" name="permissions[]"
    value="approve_distribusi" {{ $role->hasPermissionTo('approve_distribusi') ? 'checked' : '' }}>
    <label class="custom-control-label" for="approve_distribusi">Approve Distribusi</label>
</div>



<div class="custom-control custom-switch">

    <input type="checkbox" class="custom-control-input"
    id="reject_distribusi" name="permissions[]"
    value="reject_distribusi" {{ $role->hasPermissionTo('reject_distribusi') ? 'checked' : '' }}>
    <label class="custom-control-label" for="reject_distribusi">Reject Distribusi</label>
</div>


</div>




    </div>
</div>


<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
        Buys back Sales 
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1 mb-2">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_buybacksales" name="permissions[]"
                value="access_buybacksales" {{ $role->hasPermissionTo('access_buybacksales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_buybacksales">Akses Buys Back Sales</label>
            </div>


          <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_buybacksales" name="permissions[]"
                value="create_buybacksales" {{ $role->hasPermissionTo('create_buybacksales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_buybacksales">Buat Buys Back Sales</label>
            </div>

         <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_buybacksales" name="permissions[]"
                value="edit_buybacksales" {{ $role->hasPermissionTo('edit_buybacksales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_buybacksales">
                Edit Buys Back Sales</label>
            </div>

 <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_buybacksales" name="permissions[]"
                value="delete_buybacksales" {{ $role->hasPermissionTo('delete_buybacksales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_buybacksales">
                Hapus Buys Back Sales</label>
            </div>


           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="approve_buybacksales" name="permissions[]"
                value="approve_buybacksales" {{ $role->hasPermissionTo('approve_buybacksales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="approve_buybacksales">
                Approve Buys Back Sales</label>
            </div>



           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="reject_buybacksales" name="permissions[]"
                value="reject_buybacksales" {{ $role->hasPermissionTo('reject_buybacksales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="reject_buybacksales">
                Reject Buys Back Sales</label>
            </div>

     <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="print_buybacksales" name="permissions[]"
                value="print_buybacksales" {{ $role->hasPermissionTo('print_buybacksales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="print_buybacksales">
                Print Buys Back Sales</label>
            </div>


         </div>
    </div>
</div>





<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
      Buys Back Toko
    </div>
    <div class="card-body">


<div class="flex flex-row grid grid-cols-2 gap-1">
        <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_buybacktoko" name="permissions[]"
                value="access_buybacktoko" {{ $role->hasPermissionTo('access_buybacktoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_buybacktoko">Akses Buys Back Toko</label>
            </div>


          <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_buybacktoko" name="permissions[]"
                value="create_buybacktoko" {{ $role->hasPermissionTo('create_buybacktoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_buybacktoko">Buat Buys Back Toko</label>
            </div>

         <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_buybacktoko" name="permissions[]"
                value="edit_buybacktoko" {{ $role->hasPermissionTo('edit_buybacktoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_buybacktoko">
                Edit Buys Back Toko</label>
            </div>   

             <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_buybacktoko" name="permissions[]"
                value="show_buybacktoko" {{ $role->hasPermissionTo('show_buybacktoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_buybacktoko">
                Show Buys Back Toko</label>
            </div>

 <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_buybacktoko" name="permissions[]"
                value="delete_buybacktoko" {{ $role->hasPermissionTo('delete_buybacktoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_buybacktoko">
                Hapus Buys Back Toko</label>
            </div>


           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="approve_buybacktoko" name="permissions[]"
                value="approve_buybacktoko" {{ $role->hasPermissionTo('approve_buybacktoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="approve_buybacktoko">
                Approve Buys Back Toko</label>
            </div>



           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="reject_buybacktoko" name="permissions[]"
                value="reject_buybacktoko" {{ $role->hasPermissionTo('reject_buybacktoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="reject_buybacktoko">
                Reject Buys Back Toko</label>
            </div>

     <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="print_buybacktoko" name="permissions[]"
                value="print_buybacktoko" {{ $role->hasPermissionTo('print_buybacktoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="print_buybacktoko">
                Print Buys Back Toko</label>
            </div>

     <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_buysback_nota" name="permissions[]"
                value="create_buysback_nota" {{ $role->hasPermissionTo('create_buysback_nota') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_buysback_nota">
                Buat Buys Back Nota</label>
            </div>
  <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_buysback_nota" name="permissions[]"
                value="access_buysback_nota" {{ $role->hasPermissionTo('access_buysback_nota') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_buysback_nota">
                Akses Buys Back Nota</label>
            </div>

    
    
</div>

</div>
</div>


<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Sales Office
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_sales_office" name="permissions[]"
                value="access_sales_office" {{ $role->hasPermissionTo('access_sales_office') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_sales_office">{{ label_Case('access_sales_office') }}</label>
            </div>

           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_sales_office" name="permissions[]"
                value="create_sales_office" {{ $role->hasPermissionTo('create_sales_office') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_sales_office">{{ label_Case('create_sales_office') }}</label>
            </div>

  <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_sales_office" name="permissions[]"
                value="show_sales_office" {{ $role->hasPermissionTo('show_sales_office') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_sales_office">{{ label_Case('show_sales_office') }}</label>
            </div>

  <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_sales_office" name="permissions[]"
                value="edit_sales_office" {{ $role->hasPermissionTo('edit_sales_office') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_sales_office">{{ label_Case('edit_sales_office') }}</label>
            </div>


  <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_sales_office" name="permissions[]"
                value="delete_sales_office" {{ $role->hasPermissionTo('delete_sales_office') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_sales_office">{{ label_Case('delete_sales_office') }}</label>
            </div>

           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="print_sales_office" name="permissions[]"
                value="print_sales_office" {{ $role->hasPermissionTo('print_sales_office') ? 'checked' : '' }}>
                <label class="custom-control-label" for="print_sales_office">{{ label_Case('print_sales_office') }}</label>
            </div>

  <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="reject_sales_office" name="permissions[]"
                value="reject_sales_office" {{ $role->hasPermissionTo('reject_sales_office') ? 'checked' : '' }}>
                <label class="custom-control-label" for="reject_sales_office">{{ label_Case('reject_sales_office') }}</label>
            </div>


           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="approve_sales_office" name="permissions[]"
                value="approve_sales_office" {{ $role->hasPermissionTo('approve_sales_office') ? 'checked' : '' }}>
                <label class="custom-control-label" for="approve_sales_office">{{ label_Case('approve_sales_office') }}</label>
            </div>


           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="dashboard_sales_office" name="permissions[]"
                value="dashboard_sales_office" {{ $role->hasPermissionTo('dashboard_sales_office') ? 'checked' : '' }}>
                <label class="custom-control-label" for="dashboard_sales_office">{{ label_Case('dashboard_sales_office') }}</label>
            </div>


           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_datasales" name="permissions[]"
                value="access_datasales" {{ $role->hasPermissionTo('access_datasales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_datasales">{{ label_Case('access_data_sales') }}</label>
            </div>





            
        </div>
    </div>
</div>






<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Sales Payment
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">

        <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_sales_payment" name="permissions[]"
                value="access_sales_payment" {{ $role->hasPermissionTo('access_sales_payment') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_sales_payment">
                {{ label_Case('access_sales_payment') }}
              </label>
            </div>
   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="dashboard_payment" name="permissions[]"
                value="dashboard_payment" {{ $role->hasPermissionTo('dashboard_payment') ? 'checked' : '' }}>
                <label class="custom-control-label" for="dashboard_payment">
                {{ label_Case('dashboard_payment') }}
              </label>
            </div>

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_sales_payment" name="permissions[]"
                value="create_sales_payment" {{ $role->hasPermissionTo('create_sales_payment') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_sales_payment">
                {{ label_Case('create_sales_payment') }}
              </label>
            </div>

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="print_sales_payment" name="permissions[]"
                value="print_sales_payment" {{ $role->hasPermissionTo('print_sales_payment') ? 'checked' : '' }}>
                <label class="custom-control-label" for="print_sales_payment">
                {{ label_Case('print_sales_payment') }}
              </label>
            </div>



            
        </div>
    </div>
</div>



<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Suppliers
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_suppliers" name="permissions[]"
                value="access_suppliers" {{ $role->hasPermissionTo('access_suppliers') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_suppliers">
                  {{ label_Case('access_suppliers') }}
               </label>
            </div>

           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_suppliers" name="permissions[]"
                value="create_suppliers" {{ $role->hasPermissionTo('create_suppliers') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_suppliers">
                  {{ label_Case('create_suppliers') }}
               </label>
            </div>

    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_suppliers" name="permissions[]"
                value="show_suppliers" {{ $role->hasPermissionTo('show_suppliers') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_suppliers">
                  {{ label_Case('show_suppliers') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_suppliers" name="permissions[]"
                value="delete_suppliers" {{ $role->hasPermissionTo('delete_suppliers') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_suppliers">
                  {{ label_Case('delete_suppliers') }}
               </label>
            </div>




            
        </div>
    </div>
</div>






<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
     Toko
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_storeemployees" name="permissions[]"
                value="access_storeemployees" {{ $role->hasPermissionTo('access_storeemployees') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_storeemployees">
                  {{ label_Case('access_pegawai_toko') }}
               </label>
            </div>

    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_storeemployees" name="permissions[]"
                value="create_storeemployees" {{ $role->hasPermissionTo('create_storeemployees') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_storeemployees">
                  {{ label_Case('create_pegawai_toko') }}
               </label>
            </div>

 <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_storeemployees" name="permissions[]"
                value="edit_storeemployees" {{ $role->hasPermissionTo('edit_storeemployees') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_storeemployees">
                  {{ label_Case('edit_pegawai_toko') }}
               </label>
            </div>


        <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_storeemployees" name="permissions[]"
                value="delete_storeemployees" {{ $role->hasPermissionTo('delete_storeemployees') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_storeemployees">
                  {{ label_Case('delete_pegawai_toko') }}
               </label>
            </div>


    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_penentuanharga" name="permissions[]"
                value="access_penentuanharga" {{ $role->hasPermissionTo('access_penentuanharga') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_penentuanharga">
                  {{ label_Case('penentuan_harga') }}
               </label>
            </div>



            
        </div>
    </div>
</div>


<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Penerimaan Barang Luar
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_buys_back_luar" name="permissions[]"
                value="access_buys_back_luar" {{ $role->hasPermissionTo('access_buys_back_luar') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_buys_back_luar">
                  {{ label_Case('access_buys_back_luar') }}
               </label>
            </div> 



             <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_penerimaanbarangluars" name="permissions[]"
                value="access_penerimaanbarangluars" {{ $role->hasPermissionTo('access_penerimaanbarangluars') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_penerimaanbarangluars">
                  {{ label_Case('access') }}
               </label>
            </div> 




            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_penerimaanbarangluars" name="permissions[]"
                value="create_penerimaanbarangluars" {{ $role->hasPermissionTo('create_penerimaanbarangluars') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_penerimaanbarangluars">
                  {{ label_Case('create') }}
               </label>
            </div>
               <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_penerimaanbarangluars" name="permissions[]"
                value="edit_penerimaanbarangluars" {{ $role->hasPermissionTo('edit_penerimaanbarangluars') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_penerimaanbarangluars">
                  {{ label_Case('edit') }}
               </label>
            </div>



                <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_penerimaanbarangluars" name="permissions[]"
                value="delete_penerimaanbarangluars" {{ $role->hasPermissionTo('delete_penerimaanbarangluars') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_penerimaanbarangluars">
                  {{ label_Case('delete') }}
               </label>
            </div>

     <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_insentif" name="permissions[]"
                value="access_insentif" {{ $role->hasPermissionTo('access_insentif') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_insentif">
                  {{ label_Case('access_insentif') }}
               </label>
            </div>


            
        </div>
    </div>
</div>


<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Penerimaan Barang Luar Sales
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-1 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_penerimaanbarangluarsales" name="permissions[]"
                value="access_penerimaanbarangluarsales" {{ $role->hasPermissionTo('access_penerimaanbarangluarsales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_penerimaanbarangluarsales">
                  {{ label_Case('access_penerimaanbarang_luar_sales') }}
               </label>
            </div>
                <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_penerimaanbarangluarsales" name="permissions[]"
                value="create_penerimaanbarangluarsales" {{ $role->hasPermissionTo('create_penerimaanbarangluarsales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_penerimaanbarangluarsales">
                  {{ label_Case('create') }}
               </label>
            </div>
                  <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_penerimaanbarangluarsales" name="permissions[]"
                value="edit_penerimaanbarangluarsales" {{ $role->hasPermissionTo('edit_penerimaanbarangluarsales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_penerimaanbarangluarsales">
                  {{ label_Case('edit') }}
               </label>
            </div>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_penerimaanbarangluarsales" name="permissions[]"
                value="delete_penerimaanbarangluarsales" {{ $role->hasPermissionTo('delete_penerimaanbarangluarsales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_penerimaanbarangluarsales">{{ label_Case('delete') }}
               </label>
            </div>


            
        </div>
    </div>
</div>


<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Distribusi Sales
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_distribusisales" name="permissions[]"
                value="access_distribusisales" {{ $role->hasPermissionTo('access_distribusisales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_distribusisales">
                  {{ label_Case('access_distribusi_sales') }}
               </label>
            </div>

   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_distribusisales" name="permissions[]"
                value="create_distribusisales" {{ $role->hasPermissionTo('create_distribusisales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_distribusisales">
                  {{ label_Case('create_distribusi_sales') }}
               </label>
            </div>


   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_distribusisales" name="permissions[]"
                value="edit_distribusisales" {{ $role->hasPermissionTo('edit_distribusisales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_distribusisales">
                  {{ label_Case('edit_distribusi_sales') }}
               </label>
            </div>

   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_distribusisales" name="permissions[]"
                value="delete_distribusisales" {{ $role->hasPermissionTo('delete_distribusisales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_distribusisales">
                  {{ label_Case('delete_distribusi_sales') }}
               </label>
            </div>




            
        </div>
    </div>
</div>

<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Penjualan Sales
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_penjualansales" name="permissions[]"
                value="access_penjualansales" {{ $role->hasPermissionTo('access_penjualansales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_penjualansales">
                  {{ label_Case('access_penjualan_sales') }}
               </label>
            </div>

     
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_penjualansales" name="permissions[]"
                value="create_penjualansales" {{ $role->hasPermissionTo('create_penjualansales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_penjualansales">
                  {{ label_Case('create_penjualan_sales') }}
               </label>
            </div>

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_penjualansales" name="permissions[]"
                value="show_penjualansales" {{ $role->hasPermissionTo('show_penjualansales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_penjualansales">
                  {{ label_Case('show_penjualansales') }}
               </label>
            </div>

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_penjualansales" name="permissions[]"
                value="edit_penjualansales" {{ $role->hasPermissionTo('edit_penjualansales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_penjualansales">
                  {{ label_Case('edit_penjualan_sales') }}
               </label>
            </div>


  <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_penjualansales" name="permissions[]"
                value="delete_penjualansales" {{ $role->hasPermissionTo('delete_penjualansales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_penjualansales">
                  {{ label_Case('delete_penjualan_sales') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_bayar_penjualan_sales" name="permissions[]"
                value="access_bayar_penjualan_sales" {{ $role->hasPermissionTo('access_bayar_penjualan_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_bayar_penjualan_sales">
                  {{ label_Case('bayar_penjualan_sales') }}
               </label>
            </div>


            
        </div>
    </div>
</div>


<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Penerimaan barang DP
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_penerimaanbarangdps" name="permissions[]"
                value="access_penerimaanbarangdps" {{ $role->hasPermissionTo('access_penerimaanbarangdps') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_penerimaanbarangdps">
                  {{ label_Case('access') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_penerimaanbarangdps" name="permissions[]"
                value="create_penerimaanbarangdps" {{ $role->hasPermissionTo('create_penerimaanbarangdps') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_penerimaanbarangdps">
                  {{ label_Case('create') }}
               </label>
            </div>
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_penerimaanbarangdps" name="permissions[]"
                value="edit_penerimaanbarangdps" {{ $role->hasPermissionTo('edit_penerimaanbarangdps') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_penerimaanbarangdps">
                  {{ label_Case('edit') }}
               </label>
            </div>    

             <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_penerimaanbarangdps" name="permissions[]"
                value="delete_penerimaanbarangdps" {{ $role->hasPermissionTo('delete_penerimaanbarangdps') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_penerimaanbarangdps">
                  {{ label_Case('delete') }}
               </label>
            </div>

     <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_bayar_penerimaanbarangdps" name="permissions[]"
                value="access_bayar_penerimaanbarangdps" {{ $role->hasPermissionTo('access_bayar_penerimaanbarangdps') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_bayar_penerimaanbarangdps">
                  {{ label_Case('Bayar') }}
               </label>
            </div>



            
        </div>
    </div>
</div>


<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Produksi
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_produksis" name="permissions[]"
                value="access_produksis" {{ $role->hasPermissionTo('access_produksis') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_produksis">
                  {{ label_Case('access_produksi') }}
               </label>
            </div>

    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_produksis" name="permissions[]"
                value="create_produksis" {{ $role->hasPermissionTo('create_produksis') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_produksis">
                  {{ label_Case('create_produksi') }}
               </label>
            </div>


    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_produksis" name="permissions[]"
                value="edit_produksis" {{ $role->hasPermissionTo('edit_produksis') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_produksis">
                  {{ label_Case('edit_produksi') }}
               </label>
            </div>


           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_produksis" name="permissions[]"
                value="delete_produksis" {{ $role->hasPermissionTo('delete_produksis') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_produksis">
                  {{ label_Case('delete_produksi') }}
               </label>
            </div>




            
        </div>
    </div>
</div>

<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Retur Sale
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_retursale" name="permissions[]"
                value="access_retursale" {{ $role->hasPermissionTo('access_retursale') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_retursale">
                  {{ label_Case('access_retur_sale') }}
               </label>
            </div>
       
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_retursale" name="permissions[]"
                value="create_retursale" {{ $role->hasPermissionTo('create_retursale') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_retursale">
                  {{ label_Case('create_retur_sale') }}
               </label>
            </div>


   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_retursale" name="permissions[]"
                value="edit_retursale" {{ $role->hasPermissionTo('edit_retursale') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_retursale">
                  {{ label_Case('edit_retur_sale') }}
               </label>
            </div>


   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_retursale" name="permissions[]"
                value="delete_retursale" {{ $role->hasPermissionTo('delete_retursale') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_retursale">
                  {{ label_Case('delete_retur_sale') }}
               </label>
            </div>




            
        </div>
    </div>
</div>



<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Product Transfer
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_product_transfer" name="permissions[]"
                value="access_product_transfer" {{ $role->hasPermissionTo('access_product_transfer') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_product_transfer">
                  {{ label_Case('access_product_transfer') }}
               </label>
            </div>

      <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_product_transfer" name="permissions[]"
                value="create_product_transfer" {{ $role->hasPermissionTo('create_product_transfer') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_product_transfer">
                  {{ label_Case('create_product_transfer') }}
               </label>
            </div>

   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_product_transfer" name="permissions[]"
                value="show_product_transfer" {{ $role->hasPermissionTo('show_product_transfer') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_product_transfer">
                  {{ label_Case('show_product_transfer') }}
               </label>
            </div>
  <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_product_transfer" name="permissions[]"
                value="edit_product_transfer" {{ $role->hasPermissionTo('edit_product_transfer') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_product_transfer">
                  {{ label_Case('edit_product_transfer') }}
               </label>
            </div>
 <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_product_transfer" name="permissions[]"
                value="delete_product_transfer" {{ $role->hasPermissionTo('delete_product_transfer') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_product_transfer">
                  {{ label_Case('delete_product_transfer') }}
               </label>
            </div>




            
        </div>
    </div>
</div>



<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Customer sales
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_customersales" name="permissions[]"
                value="access_customersales" {{ $role->hasPermissionTo('access_customersales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_customersales">
                  {{ label_Case('access_customer_sales') }}
               </label>
            </div>    

             <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_customersales" name="permissions[]"
                value="create_customersales" {{ $role->hasPermissionTo('create_customersales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_customersales">
                  {{ label_Case('create_customer_sales') }}
               </label>
            </div>
      <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_customersales" name="permissions[]"
                value="edit_customersales" {{ $role->hasPermissionTo('edit_customersales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_customersales">
                  {{ label_Case('edit_customer_sales') }}
               </label>
            </div>

  <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_customersales" name="permissions[]"
                value="delete_customersales" {{ $role->hasPermissionTo('delete_customersales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_customersales">
                  {{ label_Case('delete_customer_sales') }}
               </label>
            </div>



            
        </div>
    </div>
</div>



{{-- ######## --}}

<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Laporan Sales
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_hutang_sales" name="permissions[]"
                value="access_hutang_sales" {{ $role->hasPermissionTo('access_hutang_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_hutang_sales">
                  {{ label_Case('access_hutang_sales') }}
               </label>
            </div>

          <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="print_hutang_sales" name="permissions[]"
                value="print_hutang_sales" {{ $role->hasPermissionTo('print_hutang_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="print_hutang_sales">
                  {{ label_Case('print_hutang_sales') }}
               </label>
            </div>

          <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_hutang_sales" name="permissions[]"
                value="show_hutang_sales" {{ $role->hasPermissionTo('show_hutang_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_hutang_sales">
                  {{ label_Case('show_hutang_sales') }}
               </label>
            </div>

         <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_piutang_sales" name="permissions[]"
                value="access_piutang_sales" {{ $role->hasPermissionTo('access_piutang_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_piutang_sales">
                  {{ label_Case('access_piutang_sales') }}
               </label>
            </div>
       
         <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_piutang_sales" name="permissions[]"
                value="show_piutang_sales" {{ $role->hasPermissionTo('show_piutang_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_piutang_sales">
                  {{ label_Case('show_piutang_sales') }}
               </label>
            </div>



            
        </div>
    </div>
</div>

{{-- ######## --}}




{{-- ######## --}}
<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Data Sales
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
       

      <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_sales" name="permissions[]"
                value="create_sales" {{ $role->hasPermissionTo('create_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_sales">
                  {{ label_Case('create_sales') }}
               </label>
            </div>

          <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_sales" name="permissions[]"
                value="show_sales" {{ $role->hasPermissionTo('show_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_sales">
                  {{ label_Case('show_sales') }}
               </label>
            </div>

          <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_sales" name="permissions[]"
                value="edit_sales" {{ $role->hasPermissionTo('edit_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_sales">
                  {{ label_Case('edit_sales') }}
               </label>
            </div>


          <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_sales" name="permissions[]"
                value="delete_sales" {{ $role->hasPermissionTo('delete_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_sales">
                  {{ label_Case('delete_sales') }}
               </label>
            </div>

           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="print_sales" name="permissions[]"
                value="print_sales" {{ $role->hasPermissionTo('print_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="print_sales">
                  {{ label_Case('print_sales') }}
               </label>
            </div>


           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_stock_sales" name="permissions[]"
                value="show_stock_sales" {{ $role->hasPermissionTo('show_stock_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_stock_sales">
                  {{ label_Case('show_stock_sales') }}
               </label>
            </div>



            
        </div>
    </div>
</div>
{{-- ######## --}}




















<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Stock
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="dashboard_stock" name="permissions[]"
                value="dashboard_stock" {{ $role->hasPermissionTo('dashboard_stock') ? 'checked' : '' }}>
                <label class="custom-control-label" for="dashboard_stock">
                  {{ label_Case('dashboard_stock') }}
               </label>
            </div>

       
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_stock" name="permissions[]"
                value="access_stock" {{ $role->hasPermissionTo('access_stock') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_stock">
                  {{ label_Case('access_stock') }}
               </label>
            </div>

           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_stock" name="permissions[]"
                value="create_stock" {{ $role->hasPermissionTo('create_stock') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_stock">
                  {{ label_Case('create_stock') }}
               </label>
            </div>


           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_stock" name="permissions[]"
                value="show_stock" {{ $role->hasPermissionTo('show_stock') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_stock">
                  {{ label_Case('show_stock') }}
               </label>
            </div>

   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_stock" name="permissions[]"
                value="edit_stock" {{ $role->hasPermissionTo('edit_stock') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_stock">
                  {{ label_Case('edit_stock') }}
               </label>
            </div>

   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_stock" name="permissions[]"
                value="delete_stock" {{ $role->hasPermissionTo('delete_stock') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_stock">
                  {{ label_Case('delete_stock') }}
               </label>
            </div>


   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="print_stock" name="permissions[]"
                value="print_stock" {{ $role->hasPermissionTo('print_stock') ? 'checked' : '' }}>
                <label class="custom-control-label" for="print_stock">
                  {{ label_Case('print_stock') }}
               </label>
            </div>



   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="reject_stock" name="permissions[]"
                value="reject_stock" {{ $role->hasPermissionTo('reject_stock') ? 'checked' : '' }}>
                <label class="custom-control-label" for="reject_stock">
                  {{ label_Case('reject_stock') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="approve_stock" name="permissions[]"
                value="approve_stock" {{ $role->hasPermissionTo('approve_stock') ? 'checked' : '' }}>
                <label class="custom-control-label" for="approve_stock">
                  {{ label_Case('approve_stock') }}
               </label>
            </div>




            
        </div>
    </div>
</div>



<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Prosses
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_proses_olah" name="permissions[]"
                value="show_proses_olah" {{ $role->hasPermissionTo('show_proses_olah') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_proses_olah">
                  {{ label_Case('show_proses_olah') }}
               </label>
            </div>


           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_proses_prod_berlian" name="permissions[]"
                value="show_proses_prod_berlian" {{ $role->hasPermissionTo('show_proses_prod_berlian') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_proses_prod_berlian">
                  {{ label_Case('show_proses_produksi_berlian') }}
               </label>
            </div>


           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_proses_reparasi" name="permissions[]"
                value="show_proses_reparasi" {{ $role->hasPermissionTo('show_proses_reparasi') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_proses_reparasi">
                  {{ label_Case('show_proses_reparasi') }}
               </label>
            </div>

           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_proses_rongsok" name="permissions[]"
                value="show_proses_rongsok" {{ $role->hasPermissionTo('show_proses_rongsok') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_proses_rongsok">
                  {{ label_Case('show_proses_rongsok') }}
               </label>
            </div>

   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_proses_cuci" name="permissions[]"
                value="show_proses_cuci" {{ $role->hasPermissionTo('show_proses_cuci') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_proses_cuci">
                  {{ label_Case('show_proses_cuci') }}
               </label>
            </div>





            
        </div>
    </div>
</div>


<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Kelola Stok
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
       
           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_kelola_stok" name="permissions[]"
                value="access_kelola_stok" {{ $role->hasPermissionTo('access_kelola_stok') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_kelola_stok">
                  {{ label_Case('access_kelola_stok') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_stock_opname" name="permissions[]"
                value="show_stock_opname" {{ $role->hasPermissionTo('show_stock_opname') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_stock_opname">
                  {{ label_Case('show_stock_opname') }}
               </label>
            </div>

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_stock_in_out" name="permissions[]"
                value="show_stock_in_out" {{ $role->hasPermissionTo('show_stock_in_out') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_stock_in_out">
                  {{ label_Case('show_stock_in_out') }}
               </label>
            </div>

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_stock_pending_office" name="permissions[]"
                value="show_stock_pending_office" {{ $role->hasPermissionTo('show_stock_pending_office') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_stock_pending_office">
                  {{ label_Case('show_stock_pending_office') }}
               </label>
            </div>


           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_stock_lantakan" name="permissions[]"
                value="show_stock_lantakan" {{ $role->hasPermissionTo('show_stock_lantakan') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_stock_lantakan">
                  {{ label_Case('show_stock_lantakan') }}
               </label>
            </div>

           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_stock_gudang" name="permissions[]"
                value="show_stock_gudang" {{ $role->hasPermissionTo('show_stock_gudang') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_stock_gudang">
                  {{ label_Case('show_stock_gudang') }}
               </label>
            </div>

            




            
        </div>
    </div>
</div>





<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Stok Cabang
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_stok_cabang" name="permissions[]"
                value="access_stok_cabang" {{ $role->hasPermissionTo('access_stok_cabang') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_stok_cabang">
                  {{ label_Case('access_stok_cabang') }}
               </label>
            </div>

            
         <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_stock_ready_cabang" name="permissions[]"
                value="show_stock_ready_cabang" {{ $role->hasPermissionTo('show_stock_ready_cabang') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_stock_ready_cabang">
                  {{ label_Case('show_stock_ready_cabang') }}
               </label>
            </div>


          <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_stok_pending" name="permissions[]"
                value="access_stok_pending" {{ $role->hasPermissionTo('access_stok_pending') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_stok_pending">
                  {{ label_Case('access_stok_pending') }}
               </label>
            </div>


          <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_stok_dp" name="permissions[]"
                value="access_stok_dp" {{ $role->hasPermissionTo('access_stok_dp') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_stok_dp">
                  {{ label_Case('access_stok_dp') }}
               </label>
            </div>


          <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_stok_pending_office" name="permissions[]"
                value="access_stok_pending_office" {{ $role->hasPermissionTo('access_stok_pending_office') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_stok_pending_office">
                  {{ label_Case('access_stok_pending_office') }}
               </label>
            </div>



            
        </div>
    </div>
</div>















<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Customer
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_customers" name="permissions[]"
                value="access_customers" {{ $role->hasPermissionTo('access_customers') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_customers">
                  {{ label_Case('access_customers') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_customers" name="permissions[]"
                value="create_customers" {{ $role->hasPermissionTo('create_customers') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_customers">
                  {{ label_Case('create_customers') }}
               </label>
            </div>
   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_customers" name="permissions[]"
                value="show_customers" {{ $role->hasPermissionTo('show_customers') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_customers">
                  {{ label_Case('show_customers') }}
               </label>
            </div>

   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_customers" name="permissions[]"
                value="edit_customers" {{ $role->hasPermissionTo('edit_customers') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_customers">
                  {{ label_Case('edit_customers') }}
               </label>
            </div>

  <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_customers" name="permissions[]"
                value="delete_customers" {{ $role->hasPermissionTo('delete_customers') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_customers">
                  {{ label_Case('delete_customers') }}
               </label>
            </div>




            
        </div>
    </div>
</div>



<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       P O S
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
  

    
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_pos" name="permissions[]"
                value="access_pos" {{ $role->hasPermissionTo('access_pos') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_pos">
                  {{ label_Case('access_pos') }}
               </label>
            </div>


    
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_pos" name="permissions[]"
                value="create_pos" {{ $role->hasPermissionTo('create_pos') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_pos">
                  {{ label_Case('create_pos') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_pos" name="permissions[]"
                value="show_pos" {{ $role->hasPermissionTo('show_pos') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_pos">
                  {{ label_Case('show_pos') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_pos" name="permissions[]"
                value="edit_pos" {{ $role->hasPermissionTo('edit_pos') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_pos">
                  {{ label_Case('edit_pos') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="print_pos" name="permissions[]"
                value="print_pos" {{ $role->hasPermissionTo('print_pos') ? 'checked' : '' }}>
                <label class="custom-control-label" for="print_pos">
                  {{ label_Case('print_pos') }}
               </label>
            </div>




            
        </div>
    </div>
</div>




<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Settings
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_settings" name="permissions[]"
                value="access_settings" {{ $role->hasPermissionTo('access_settings') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_settings">
                  {{ label_Case('access_settings') }}
               </label>
            </div>
            
        </div>
    </div>
</div>



<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Distribusi Toko
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_distribusitoko" name="permissions[]"
                value="access_distribusitoko" {{ $role->hasPermissionTo('access_distribusitoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_distribusitoko">
                  {{ label_Case('access_distribusi_toko') }}
               </label>
            </div>

     <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_distribusitoko" name="permissions[]"
                value="create_distribusitoko" {{ $role->hasPermissionTo('create_distribusitoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_distribusitoko">
                  {{ label_Case('create_distribusi_toko') }}
               </label>
            </div>
   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_distribusitoko" name="permissions[]"
                value="show_distribusitoko" {{ $role->hasPermissionTo('show_distribusitoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_distribusitoko">
                  {{ label_Case('show_distribusi_toko') }}
               </label>
            </div>

   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_distribusitoko" name="permissions[]"
                value="edit_distribusitoko" {{ $role->hasPermissionTo('edit_distribusitoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_distribusitoko">
                  {{ label_Case('edit_distribusi_toko') }}
               </label>
            </div>

  <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="print_distribusitoko" name="permissions[]"
                value="print_distribusitoko" {{ $role->hasPermissionTo('print_distribusitoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="print_distribusitoko">
                  {{ label_Case('print_distribusi_toko') }}
               </label>
            </div>
 <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="reject_distribusitoko" name="permissions[]"
                value="reject_distribusitoko" {{ $role->hasPermissionTo('reject_distribusitoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="reject_distribusitoko">
                  {{ label_Case('reject_distribusi_toko') }}
               </label>
            </div>
 <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="approve_distribusitoko" name="permissions[]"
                value="approve_distribusitoko" {{ $role->hasPermissionTo('approve_distribusitoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="approve_distribusitoko">
                  {{ label_Case('approve_distribusitoko') }}
               </label>
            </div>


   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_distribusitoko" name="permissions[]"
                value="delete_distribusitoko" {{ $role->hasPermissionTo('delete_distribusitoko') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_distribusitoko">
                  {{ label_Case('delete_distribusi_toko') }}
               </label>
            </div>



            
        </div>
    </div>
</div>








<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Products
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_products" name="permissions[]"
                value="access_products" {{ $role->hasPermissionTo('access_products') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_products">
                  {{ label_Case('access_products') }}
               </label>
            </div>
    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_products" name="permissions[]"
                value="create_products" {{ $role->hasPermissionTo('create_products') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_products">
                  {{ label_Case('create_products') }}
               </label>
            </div>

        <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_products" name="permissions[]"
                value="show_products" {{ $role->hasPermissionTo('show_products') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_products">
                  {{ label_Case('show_products') }}
               </label>
            </div>

    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_products" name="permissions[]"
                value="edit_products" {{ $role->hasPermissionTo('edit_products') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_products">
                  {{ label_Case('edit_products') }}
               </label>
            </div>


    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_products" name="permissions[]"
                value="edit_products" {{ $role->hasPermissionTo('edit_products') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_products">
                  {{ label_Case('edit_products') }}
               </label>
            </div>


    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_products" name="permissions[]"
                value="delete_products" {{ $role->hasPermissionTo('delete_products') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_products">
                  {{ label_Case('delete_products') }}
               </label>
            </div>


    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_tracking_products" name="permissions[]"
                value="show_tracking_products" {{ $role->hasPermissionTo('show_tracking_products') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_tracking_products">
                  {{ label_Case('show_tracking_products') }}
               </label>
            </div>

    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_approve_product" name="permissions[]"
                value="access_approve_product" {{ $role->hasPermissionTo('access_approve_product') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_approve_product">
                  {{ label_Case('access_approve_product') }}
               </label>
            </div>

            
        </div>
    </div>
</div>





<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Penerimaan Berlian
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-1 gap-1">

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_penerimaan_qc_berlian" name="permissions[]"
                value="access_penerimaan_qc_berlian" {{ $role->hasPermissionTo('access_penerimaan_qc_berlian') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_penerimaan_qc_berlian">
                  {{ label_Case('access_penerimaan_qc_berlian') }}
               </label>
            </div>

           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_hutang_pembelian_berlian" name="permissions[]"
                value="access_hutang_pembelian_berlian" {{ $role->hasPermissionTo('access_hutang_pembelian_berlian') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_hutang_pembelian_berlian">
                  {{ label_Case('access_hutang_pembelian_berlian') }}
               </label>
            </div>


            
        </div>
    </div>
</div>


<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Pengeluaran (Expenses)
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">

            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_expenses" name="permissions[]"
                value="access_expenses" {{ $role->hasPermissionTo('access_expenses') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_expenses">
                  {{ label_Case('access_expenses') }}
               </label>
            </div>


      
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_expenses" name="permissions[]"
                value="create_expenses" {{ $role->hasPermissionTo('create_expenses') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_expenses">
                  {{ label_Case('create_expenses') }}
               </label>
            </div>

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_expenses" name="permissions[]"
                value="edit_expenses" {{ $role->hasPermissionTo('edit_expenses') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_expenses">
                  {{ label_Case('edit_expenses') }}
               </label>
            </div>


    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_expenses" name="permissions[]"
                value="delete_expenses" {{ $role->hasPermissionTo('delete_expenses') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_expenses">
                  {{ label_Case('delete_expenses') }}
               </label>
            </div>


    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_expense_categories" name="permissions[]"
                value="access_expense_categories" {{ $role->hasPermissionTo('access_expense_categories') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_expense_categories">
                  {{ label_Case('access_expense_categories') }}
               </label>
            </div>






            
        </div>
    </div>
</div>




<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Products Transfer
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_product_transfer" name="permissions[]"
                value="access_product_transfer" {{ $role->hasPermissionTo('access_product_transfer') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_product_transfer">
                  {{ label_Case('access_product_transfer') }}
               </label>
            </div>

            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_tracking_products" name="permissions[]"
                value="show_tracking_products" {{ $role->hasPermissionTo('show_tracking_products') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_tracking_products">
                  {{ label_Case('show_tracking_products') }}
               </label>
            </div>


   
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_product_transfer" name="permissions[]"
                value="create_product_transfer" {{ $role->hasPermissionTo('create_product_transfer') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_product_transfer">
                  {{ label_Case('create_product_transfer') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_product_transfer" name="permissions[]"
                value="show_product_transfer" {{ $role->hasPermissionTo('show_product_transfer') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_product_transfer">
                  {{ label_Case('show_product_transfer') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_product_transfer" name="permissions[]"
                value="edit_product_transfer" {{ $role->hasPermissionTo('edit_product_transfer') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_product_transfer">
                  {{ label_Case('edit_product_transfer') }}
               </label>
            </div>

           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_product_transfer" name="permissions[]"
                value="delete_product_transfer" {{ $role->hasPermissionTo('delete_product_transfer') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_product_transfer">
                  {{ label_Case('delete_product_transfer') }}
               </label>
            </div>




            
        </div>
    </div>
</div>





<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Penerimaan Barang (Goodsreceipts)
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_goodsreceipts" name="permissions[]"
                value="access_goodsreceipts" {{ $role->hasPermissionTo('access_goodsreceipts') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_goodsreceipts">
                  {{ label_Case('access_goodsreceipts') }}
               </label>
            </div>

   
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_goodsreceipts" name="permissions[]"
                value="create_goodsreceipts" {{ $role->hasPermissionTo('create_goodsreceipts') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_goodsreceipts">
                  {{ label_Case('create_goodsreceipts') }}
               </label>
            </div>


    <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="show_goodsreceipts" name="permissions[]"
                value="show_goodsreceipts" {{ $role->hasPermissionTo('show_goodsreceipts') ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_goodsreceipts">
                  {{ label_Case('show_goodsreceipts') }}
               </label>
            </div>


           <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_goodsreceipts" name="permissions[]"
                value="edit_goodsreceipts" {{ $role->hasPermissionTo('edit_goodsreceipts') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_goodsreceipts">
                  {{ label_Case('edit_goodsreceipts') }}
               </label>
            </div>


   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_goodsreceipts" name="permissions[]"
                value="delete_goodsreceipts" {{ $role->hasPermissionTo('delete_goodsreceipts') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_goodsreceipts">
                  {{ label_Case('delete_goodsreceipts') }}
               </label>
            </div>


   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="print_goodsreceipts" name="permissions[]"
                value="print_goodsreceipts" {{ $role->hasPermissionTo('print_goodsreceipts') ? 'checked' : '' }}>
                <label class="custom-control-label" for="print_goodsreceipts">
                  {{ label_Case('print_goodsreceipts') }}
               </label>
            </div>


  <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="reject_goodsreceipts" name="permissions[]"
                value="reject_goodsreceipts" {{ $role->hasPermissionTo('reject_goodsreceipts') ? 'checked' : '' }}>
                <label class="custom-control-label" for="reject_goodsreceipts">
                  {{ label_Case('reject_goodsreceipts') }}
               </label>
            </div>

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="approve_goodsreceipts" name="permissions[]"
                value="approve_goodsreceipts" {{ $role->hasPermissionTo('approve_goodsreceipts') ? 'checked' : '' }}>
                <label class="custom-control-label" for="approve_goodsreceipts">
                  {{ label_Case('approve_goodsreceipts') }}
               </label>
            </div>


      <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="dashboard_goodsreceipts" name="permissions[]"
                value="dashboard_goodsreceipts" {{ $role->hasPermissionTo('dashboard_goodsreceipts') ? 'checked' : '' }}>
                <label class="custom-control-label" for="dashboard_goodsreceipts">
                  {{ label_Case('dashboard_goodsreceipts') }}
               </label>
            </div>




            
        </div>
    </div>
</div>






<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Adjustments
    </div>
    <div class="card-body">
        <div class="flex flex-row grid grid-cols-2 gap-1">
            
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_adjustments" name="permissions[]"
                value="access_adjustments" {{ $role->hasPermissionTo('access_adjustments') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_adjustments">
                  {{ label_Case('access_adjustments') }}
               </label>
            </div>

      
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="create_adjustments" name="permissions[]"
                value="create_adjustments" {{ $role->hasPermissionTo('create_adjustments') ? 'checked' : '' }}>
                <label class="custom-control-label" for="create_adjustments">
                  {{ label_Case('create_adjustments') }}
               </label>
            </div>

   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="edit_adjustments" name="permissions[]"
                value="edit_adjustments" {{ $role->hasPermissionTo('edit_adjustments') ? 'checked' : '' }}>
                <label class="custom-control-label" for="edit_adjustments">
                  {{ label_Case('edit_adjustments') }}
               </label>
            </div>

   <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="delete_adjustments" name="permissions[]"
                value="delete_adjustments" {{ $role->hasPermissionTo('delete_adjustments') ? 'checked' : '' }}>
                <label class="custom-control-label" for="delete_adjustments">
                  {{ label_Case('delete_adjustments') }}
               </label>
            </div>



            
        </div>
    </div>
</div>







</div>
{{-- batas --}}



<div class="flex flex-row grid grid-cols-1 gap-1 mb-2">


<div class="card h-100 border-0 shadow">
    <div class="card-header font-semibold">
       Reports
    </div>
    <div class="card-body">
       
<div class="flex flex-row grid grid-cols-2 gap-1 mb-2">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_reports" name="permissions[]"
                value="access_reports" {{ $role->hasPermissionTo('access_reports') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_reports">
                  {{ label_Case('access_reports') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_laporan_laba_rugi" name="permissions[]"
                value="access_laporan_laba_rugi" {{ $role->hasPermissionTo('access_laporan_laba_rugi') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_laporan_laba_rugi">
                  {{ label_Case('access_laporan_laba_rugi') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_laporan_pembayaran" name="permissions[]"
                value="access_laporan_pembayaran" {{ $role->hasPermissionTo('access_laporan_pembayaran') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_laporan_pembayaran">
                  {{ label_Case('access_laporan_pembayaran') }}
               </label>
            </div>

      <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_laporan_piutang" name="permissions[]"
                value="access_laporan_piutang" {{ $role->hasPermissionTo('access_laporan_piutang') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_laporan_piutang">
                  {{ label_Case('access_laporan_piutang') }}
               </label>
            </div>


        <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_laporan_hutang" name="permissions[]"
                value="access_laporan_hutang" {{ $role->hasPermissionTo('access_laporan_hutang') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_laporan_hutang">
                  {{ label_Case('access_laporan_hutang') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_laporan_penjualan" name="permissions[]"
                value="access_laporan_penjualan" {{ $role->hasPermissionTo('access_laporan_penjualan') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_laporan_penjualan">
                  {{ label_Case('access_laporan_penjualan') }}
               </label>
            </div>


            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_laporan_pembelian" name="permissions[]"
                value="access_laporan_pembelian" {{ $role->hasPermissionTo('access_laporan_pembelian') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_laporan_pembelian">
                  {{ label_Case('access_laporan_pembelian') }}
               </label>
            </div>

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_laporan_retur_sales" name="permissions[]"
                value="access_laporan_retur_sales" {{ $role->hasPermissionTo('access_laporan_retur_sales') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_laporan_retur_sales">
                  {{ label_Case('access_laporan_retur_sales') }}
               </label>
            </div>

     <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input"
                id="access_laporan_retur_pembelian" name="permissions[]"
                value="access_laporan_retur_pembelian" {{ $role->hasPermissionTo('access_laporan_retur_pembelian') ? 'checked' : '' }}>
                <label class="custom-control-label" for="access_laporan_retur_pembelian">
                  {{ label_Case('access_laporan_retur_pembelian') }}
               </label>
            </div>

</div>


    </div>
</div>

</div>












                            <div class="row">
                                <!-- Dashboard Permissions -->

                                        
                                <!-- Expenses Permission -->
                   
                      

                         
                           

                                <!-- Sale Returns Permission -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="card h-100 border-0 shadow">
                                        <div class="card-header">
                                            Sale Returns
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="access_sale_returns" name="permissions[]"
                                                               value="access_sale_returns" {{ $role->hasPermissionTo('access_sale_returns') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="access_sale_returns">Access</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="create_sale_returns" name="permissions[]"
                                                               value="create_sale_returns" {{ $role->hasPermissionTo('create_sale_returns') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="create_sale_returns">Create</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="show_sale_returns" name="permissions[]"
                                                               value="show_sale_returns" {{ $role->hasPermissionTo('show_sale_returns') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="show_sale_returns">View</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="edit_sale_returns" name="permissions[]"
                                                               value="edit_sale_returns" {{ $role->hasPermissionTo('edit_sale_returns') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="edit_sale_returns">Edit</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="delete_sale_returns" name="permissions[]"
                                                               value="delete_sale_returns" {{ $role->hasPermissionTo('delete_sale_returns') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="delete_sale_returns">Delete</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="access_sale_return_payments" name="permissions[]"
                                                               value="access_sale_return_payments" {{ $role->hasPermissionTo('access_sale_return_payments') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="access_sale_return_payments">Payments</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Purchases Permission -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="card h-100 border-0 shadow">
                                        <div class="card-header">
                                            Purchases
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="access_purchases" name="permissions[]"
                                                               value="access_purchases" {{ $role->hasPermissionTo('access_purchases') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="access_purchases">Access</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="create_purchases" name="permissions[]"
                                                               value="create_purchases" {{ $role->hasPermissionTo('create_purchases') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="create_purchases">Create</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="show_purchases" name="permissions[]"
                                                               value="show_purchases" {{ $role->hasPermissionTo('show_purchases') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="show_purchases">View</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="edit_purchases" name="permissions[]"
                                                               value="edit_purchases" {{ $role->hasPermissionTo('edit_purchases') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="edit_purchases">Edit</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="delete_purchases" name="permissions[]"
                                                               value="delete_purchases" {{ $role->hasPermissionTo('delete_purchases') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="delete_purchases">Delete</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="access_purchase_payments" name="permissions[]"
                                                               value="access_purchase_payments" {{ $role->hasPermissionTo('access_purchase_payments') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="access_purchase_payments">Payments</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Purchases Returns Permission -->
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="card h-100 border-0 shadow">
                                        <div class="card-header">
                                            Purchase Returns
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="access_purchase_returns" name="permissions[]"
                                                               value="access_purchase_returns" {{ $role->hasPermissionTo('access_purchase_returns') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="access_purchase_returns">Access</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="create_purchase_returns" name="permissions[]"
                                                               value="create_purchase_returns" {{ $role->hasPermissionTo('create_purchase_returns') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="create_purchase_returns">Create</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="show_purchase_returns" name="permissions[]"
                                                               value="show_purchase_returns" {{ $role->hasPermissionTo('show_purchase_returns') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="show_purchase_returns">View</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="edit_purchase_returns" name="permissions[]"
                                                               value="edit_purchase_returns" {{ $role->hasPermissionTo('edit_purchase_returns') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="edit_purchase_returns">Edit</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="delete_purchase_returns" name="permissions[]"
                                                               value="delete_purchase_returns" {{ $role->hasPermissionTo('delete_purchase_returns') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="delete_purchase_returns">Delete</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="access_purchase_return_payments" name="permissions[]"
                                                               value="access_purchase_return_payments" {{ $role->hasPermissionTo('access_purchase_return_payments') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="access_purchase_return_payments">Payments</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Reports -->
                                               


                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('#select-all').click(function() {
                var checked = this.checked;
                $('input[type="checkbox"]').each(function() {
                    this.checked = checked;
                });
            })
        });
    </script>
@endpush
