{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12">

    <div class="alert alert-primary">
      <p class="mb-0" >{{ translate("tr_cc2fb234772c7f5e6911334f83adf403") }} {{ $data->filepath }}</p>
      {% if($data->link): %}
      <p class="mt-1 mb-0" >{{ translate("tr_fb44bd6886f29a9a4c41530709674b99") }} <a href="{{ $data->link }}" target="_blank" >{{ $data->link }}</a></p>
      <p class="mt-1 mb-0" >{{ translate("tr_2131d768c3763875eb59b17f84aa0843") }} {{ $template->component->templates->outTplPageAlias($data->alias) }}</p>
      {% endif; %}
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

        <input type="hidden" name="id" value="{{ $data->id }}" >
        <input type="hidden" name="section" value="page" >
      
      </form>
    </div>

  </div>

</div>