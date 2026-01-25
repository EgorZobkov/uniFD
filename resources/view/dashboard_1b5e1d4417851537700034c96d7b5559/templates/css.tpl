{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12 col-lg-3">

    <div class="nav-align-left">

        <ul class="nav nav-pills w-100" >
          {{ $template->component->templates->outSections(); }}        
        </ul>

    </div>

  </div>

  <div class="col-12 col-lg-9">

    <div class="card" >

        <div class="list-group list-group-flush">
            {{ $template->component->templates->getCss(); }}
        </div>

    </div>

  </div>

</div>