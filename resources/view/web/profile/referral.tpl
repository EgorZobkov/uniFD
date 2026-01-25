{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

        <h3> <strong>{{ translate("tr_af290a256ca664b10c4fd61c9534c635") }}</strong> </h3>

        <div class="mt20 profile-wallet-info-balance" >
          <div class="row" >
            <div class="col-lg-3 col-12 col-md-6 col-sm-6" >
              
              <p>{{ translate("tr_e7148bd596f2016efca36c7bc1380926") }}</p>
              <h3>{{ $template->component->profile->totalAwardReferral($template->user->data->id) }}</h3>

            </div>
            <div class="col-lg-3 col-12 col-md-6 col-sm-6" >
              
              <p>{{ translate("tr_8d35fc1a3726a66254554311f6f30343") }}</p>
              <h3>{{ $template->component->profile->totalCountTransitionsReferral($template->user->data->id) }}</h3>

            </div>
          </div>

        </div>

        <div class="profile-referral-container mt20" >
          <h5>{{ translate("tr_a665a306521e0723ed1941c3069ad431") }}</h5>
          <a href="{{ getHost() . '/ref/' . $template->user->data->alias }}">{{ getHost() . '/ref/' . $template->user->data->alias }}</a>
          <p>{{ translate("tr_e13666db7233c018f1a5841903148a3f") }}</p>
        </div>

        <div class="my-tabs-items-small mt20">
            <a class="my-tabs-item {% if(!$_GET['tab']){ echo 'active'; } %}" href="{{ outRoute('profile-referral') }}" >{{ translate("tr_7e7e4571128430d719c7fc9b871b1d56") }}</a>
            <a class="my-tabs-item {% if(compareValues($_GET['tab'], 'rewards')){ echo 'active'; } %}" href="{{ requestBuildVars(['tab'=>'rewards']) }}" >{{ translate("tr_0e82d2545adc8e93cebc56ef6aab0a76") }}</a>
        </div>

        {% if($data->referrals): %}

          <div class="row row-cols-2 g-2 g-lg-3 mt25" >{{ $data->referrals; }}</div>

          {{ $template->pagination->display() }}

        {% else: %}

          <div class="mt40 not-found-title-container" >
             <div class="not-found-title-container-image" >🧐</div>
             <p>{{ translate("tr_d716fec18159de84dae4b5a94795ebac") }}</p>           
          </div>

        {% endif; %}

  </div>

</div>

</div>

{% endblock %}