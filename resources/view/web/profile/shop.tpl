{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

        <h3> <strong>{{ translate("tr_838c33a96c1a3d15354de92dae7a0f08") }}</strong> </h3>

        <div class="mt20 profile-shop-container" >
          
          <img src="{{ $template->storage->getAssetImage('8399675111223322.png') }}" height="256" >

          <div class="row" >
            <div class="col-6" ><p class="mt15" >{{ translate("tr_8076b18350b9af68e86b8df4d46d3307") }}</p></div>
          </div>

          <div class="mt30" >
            {% if($template->user->data->service_tariff->expiration_status): %}
              {% if($template->user->data->service_tariff->items->shop): %}
              {% if($template->component->profile->checkVerificationPermissions($template->user->data->id, "open_shop")): %}
              <button class="btn-custom button-color-scheme1 actionOpenStaticModal" data-modal-target="openShop" >{{ translate("tr_af24710716a8659d1f810396ef1ca285") }}</button>
              {% else: %}
              <button class="btn-custom button-color-scheme1 actionOpenStaticModal" data-modal-target="verificationUser" >{{ translate("tr_af24710716a8659d1f810396ef1ca285") }}</button>
              {% endif %}
              {% else: %}
              <a class="btn-custom button-color-scheme1" href="{{ outRoute('profile-tariffs') }}" >{{ translate("tr_b96f55a0d63ebcb94e87db75d1db04b3") }}</a>
              {% endif %}
            {% else: %}
              <a class="btn-custom button-color-scheme1" href="{{ outRoute('profile-tariffs') }}" >{{ translate("tr_b28312ec69f7940ab6ae66fa556db296") }}</a>
            {% endif; %}
          </div>

        </div>


  </div>

</div>

</div>

{% endblock %}