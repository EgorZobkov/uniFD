{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12">

    <div class="alert alert-primary">
      <p class="mb-0" >{{ translate("tr_cc2fb234772c7f5e6911334f83adf403") }} {{ $data->filepath }}</p>
    </div>

    <div class="card mt-3" >

      <div class="card-header d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row" >
        <h5 class="card-title mb-sm-0 me-2">{{ $data->filename }}</h5>
        <div class="action-btns">
          <a class="btn btn-label-primary me-2 waves-effect" href="javascript:history.back()" >
            <span class="align-middle"> {{ translate("tr_2b0b0225a86bb67048840d3da9b899bc") }}</span>
          </a>
          <button class="btn btn-primary waves-effect waves-light buttonSaveTemplate">{{ translate("tr_74ea58b6a801f0dce4e5d34dbca034dc") }}</button>
        </div>
      </div>

      <form class="formTemplates" method="post" >

        <div class="templates-code-view" >
          <textarea class="templates-page-code-view form-control" >{{ $data->content }}</textarea>
        </div>

        <input type="hidden" name="name" value="{{ $data->template_name }}" >
        <input type="hidden" name="section" value="js" >
      
      </form>
    </div>

  </div>

</div>