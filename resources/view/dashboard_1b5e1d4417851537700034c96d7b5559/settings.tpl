
{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12 col-lg-3">
    <div class="d-flex justify-content-between flex-column mb-3 mb-md-0">
      <ul class="nav nav-align-left nav-pills flex-column">
        
        {{ $template->component->settings->outSections(); }}

      </ul>
    </div>
  </div>

  <div class="col-12 col-lg-9 pt-4 pt-lg-0">
    <form class="formSettings" method="post" >

        {{ $template->component->settings->outSectionContent(); }}
    
    </form>
  </div>

</div>