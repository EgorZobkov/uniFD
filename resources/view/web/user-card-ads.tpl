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

        <a class="btn-custom-mini button-color-scheme2 mb10" href="{{ $template->component->profile->linkUserCard($data->user->alias) }}" ><i class="ti ti-chevron-left"></i> {{ translate("tr_2b0b0225a86bb67048840d3da9b899bc") }}</a>

        <h3> <strong>{{ translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c") }}</strong> </h3>

        <div class="my-tabs-items-small mt20">
            <a class="my-tabs-item {% if(compareValues($_GET['status'], 'active') || !$_GET['status']){ echo 'active'; } %}" href="{{ requestBuildVars(['status'=>'active']) }}" >{{ translate("tr_c83f7ab515c5cf6bed69213f55f917c7") }} <span>{{ $template->component->profile->outCountAdsUserByStatus('active',$data->user->id) }}</span> </a>
            <a class="my-tabs-item {% if(compareValues($_GET['status'], 'sold')){ echo 'active'; } %}" href="{{ requestBuildVars(['status'=>'sold']) }}" >{{ translate("tr_af43d5369e953088e86102931ef6be20") }} <span>{{ $template->component->profile->outCountAdsUserByStatus('sold',$data->user->id) }}</span> </a>
        </div>

        {% if($data->ads): %}

          <div class="row mt25" >{{ $data->ads; }}</div>

          {{ $template->pagination->display() }}

        {% else: %}

          <div class="mt40 not-found-title-container" >
             <div class="not-found-title-container-image" >🧐</div>
             <p>{{ translate("tr_c3b91a7a70cf6227c8277790bd2e5efc") }}</p>           
          </div>

        {% endif; %}

  </div>

</div>

</div>

{% endblock %}