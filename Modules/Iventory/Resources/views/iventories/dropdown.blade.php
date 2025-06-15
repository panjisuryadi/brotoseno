<div class="text-center">
<div class="dropdown show">
  <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Pilih Distribusi
  </a>

  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <a class="dropdown-item" href="{{route(''.$module_name.'.distribusi',[
                                 'id'=>encode_id($data->id),
                                 'distribusi'=>'toko']
                                 )}}">Toko</a>
    <a class="dropdown-item" href="{{route(''.$module_name.'.distribusi',[
                                 'id'=>encode_id($data->id),
                                 'distribusi'=>'sales']
                                 )}}">Sales</a>
       </div>
</div>


</div>


