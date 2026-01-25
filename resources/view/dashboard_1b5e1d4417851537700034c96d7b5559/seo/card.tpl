
{% component breadcrumbs.tpl %}

{{ $template->component->translate->outLanguagesSections($data->lang_iso,$template->router->getRoute('dashboard-seo-card', [$data->id])) }}

<div class="row g-4">

  <div class="col-12 col-lg-3">

    <div class="nav-align-left">

        <ul class="nav nav-pills w-100">

          {{ $template->component->seo->outSections($data->id); }}
          
        </ul>

    </div>

  </div>

  <div class="col-12 col-lg-9">

    <div class="card" >
      
      <div class="card-body" >

        {% component seo/content.tpl %}

      </div>

    </div>

  </div>

</div>