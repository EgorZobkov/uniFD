{% extends index.tpl %}

{% block head %}
<meta property="og:title" content="{{ $seo->meta_title }}">
<meta property="og:url" content="{{ $template->component->profile->linkUserCard($data->user->alias) }}">
<meta property="og:image" content="{{ $template->storage->name($data->user->avatar)->host(true)->get() }}">
{% endblock %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/user-card-sidebar.tpl %}

  </div>

  <div class="col-md-9" >

    <h3> <strong>{{ translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c") }}</strong> </h3>

    {% if($data->ads): %}

    <div class="row row-cols-2 g-2 g-lg-3 mt25" >{{ $data->ads }}</div>

    <a class="btn-custom-mini button-color-scheme1 mt10" href="{{ outRoute('user-card-ads', [$data->user->alias]) }}" >{{ translate("tr_d572de2b18482a4db2968a7fe6ca674f") }}</a>

    {% else: %}

      <div class="mt40 not-found-title-container" >
         <div class="not-found-title-container-image" >🧐</div>
         <p>{{ translate("tr_abe40b620b33b61056d38cfd4f6e2ff2") }}</p>           
      </div>

    {% endif; %}

    <h3 class="mt30" > <strong>{{ translate("tr_1c3fea01a64e56bd70c233491dd537aa") }}</strong> </h3>

    {% if($data->reviews): %}

    <div class="row row-cols-2 g-2 g-lg-3 mt25" >{{ $data->reviews }}</div>

    {% else: %}

      <div class="mt40 not-found-title-container" >
         <div class="not-found-title-container-image" >🧐</div>
         <p>{{ translate("tr_5781a644de7a7276ce1b079f9f27fafe") }}</p>           
      </div>

    {% endif; %}


  </div>

</div>

</div>

{% endblock %}