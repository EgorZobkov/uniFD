
{% component breadcrumbs.tpl %}

<div class="nav-align-top mb-4">
  <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-import-card', [$data->id]) }}">{{ translate("tr_baa2025b9f3afaf0158bd40392043b31") }}</a></li>
    <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-import-logs', [$data->id]) }}">{{ translate("tr_44c14175223df9bae3aff6309c061f4d") }}</a></li>
  </ul>
</div>

<div class="row">

  <div class="col-12 col-lg-12" >
    
    <div class="card">

      <div class="card-body">

      <textarea class="form-control" style="min-height: 700px" >{{ $data->logs }}</textarea>        

      </div>

    </div>

  </div>

</div>