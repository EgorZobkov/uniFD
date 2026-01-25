
{% extends index.tpl %}

{% block content %}

<div class="container-xxl flex-grow-1 container-p-y">

  <div class="app-preload-body" data-params="{{ $template->view->getParamsPreload(); }}" >

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center py-3 mt-0 pt-0 pb-4 height62">
      <div class="d-flex flex-column justify-content-center">
        <div class="breadcrumbs-links-skeleton">{{ translate("tr_4922ea013f76c2d3622baf1f607812b6") }}</div>
      </div>
    </div>

    <div class="row g-4">

        <div class="col-lg-12 col-12">
            <div class="card skeleton" style="min-height: 400px;">
            </div>
        </div>

        <div class="col-lg-12 col-12">
            <div class="card skeleton" style="min-height: 600px;">
            </div>
        </div>

    </div>          

  </div>

</div>


{% endblock %}