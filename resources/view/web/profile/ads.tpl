{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

        <h3> <strong>{{ translate("tr_ffc009f302516a8402667d060e48794b") }}</strong> </h3>

        <div class="my-tabs-items-small mt20">
            <a class="my-tabs-item {% if(!$_GET['status']){ echo 'active'; } %}" href="{{ outRoute('profile-ads') }}" >{{ translate("tr_1cc7e7972b8c9daa5e9c8e94483acc7d") }} <span>{{ $template->component->profile->outCountAdsUserByStatus() }}</span> </a>
            <a class="my-tabs-item {% if(compareValues($_GET['status'], 'active')){ echo 'active'; } %}" href="{{ requestBuildVars(['status'=>'active']) }}" >{{ translate("tr_c83f7ab515c5cf6bed69213f55f917c7") }} <span>{{ $template->component->profile->outCountAdsUserByStatus('active') }}</span> </a>
            <a class="my-tabs-item {% if(compareValues($_GET['status'], 'sold')){ echo 'active'; } %}" href="{{ requestBuildVars(['status'=>'sold']) }}" >{{ translate("tr_af43d5369e953088e86102931ef6be20") }} <span>{{ $template->component->profile->outCountAdsUserByStatus('sold') }}</span> </a>
            <a class="my-tabs-item {% if(compareValues($_GET['status'], 'moderation')){ echo 'active'; } %}" href="{{ requestBuildVars(['status'=>'moderation']) }}" >{{ translate("tr_d9d74d385363cf3fdf9c1e62b484acca") }} <span>{{ $template->component->profile->outCountAdsUserByStatus('moderation') }}</span> </a>
            <a class="my-tabs-item {% if(compareValues($_GET['status'], 'waiting_payment')){ echo 'active'; } %}" href="{{ requestBuildVars(['status'=>'waiting_payment']) }}" >{{ translate("tr_c3778e4b26fed47232f25379c67c0010") }} <span>{{ $template->component->profile->outCountAdsUserByStatus('waiting_payment') }}</span> </a>
            <a class="my-tabs-item {% if(compareValues($_GET['status'], 'archive')){ echo 'active'; } %}" href="{{ requestBuildVars(['status'=>'archive']) }}" >{{ translate("tr_9e1ad28d8e86e5df9b53cb1f360e7114") }} <span>{{ $template->component->profile->outCountAdsUserByStatus('archive') }}</span> </a>
        </div>

        <a class="btn-custom button-color-scheme2 mt20" href="{{ outRoute('ad-create') }}" >{{ translate("tr_6a597fed338ace644982313b3cfbead4") }}</a>

        {% if($data->ads): %}

          <div class="row row-cols-2 g-2 g-lg-3 mt25" >{{ $data->ads; }}</div>

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