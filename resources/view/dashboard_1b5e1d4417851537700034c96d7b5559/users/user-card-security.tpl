
{% component breadcrumbs.tpl %}

{% component users/sections.tpl %}

<div class="row">

<div class="col-12">
  
  <div class="card card-action mb-4">

    <div class="card-header">
      <h5 class="card-action-title mb-0">{{ translate("tr_82871e6364e5e1be295153076afd26b9") }}</h5>

      {% if($template->user->setUserId($data->id)->verificationAccess('control')->status): %}
      <div class="card-action-element">
        <div class="dropdown">
          <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ti ti-dots-vertical text-muted"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" >
            <li><span class="dropdown-item clearAuthUser" data-id="{{ $data->id }}" >{{ translate("tr_7074366a7567f200d45f7f99e7da037d") }}</span></li>
          </ul>
        </div>
      </div>
      {% endif; %}

    </div>

    {% component users/auth.tpl %}

  </div>

  <div class="card mb-4">

    <h5 class="card-header">{{ translate("tr_5c9659c0d9e1dea8a091c52af26e8740") }}</h5>

    {% component users/sessions.tpl %}

  </div>

</div>

</div>