{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

        <h3> <strong>{{ translate("tr_a49106cadab8ae1ff6a37e7ccea9c665") }}</strong> </h3>

        <p>{{ translate("tr_73fea1848966c71c4dd0954923d11026") }}</p>

        <form class="profile-tariffs-form" >

          <div class="profile-tariffs-list profile-tariffs-swiper mt50" >

            <div class="profile-tariffs-swiper-prev" > <span><i class="ti ti-chevron-left"></i></span> </div>
            <div class="profile-tariffs-swiper-next" > <span><i class="ti ti-chevron-right"></i></span> </div>

            <div class="swiper-wrapper" >
            {{ $template->component->service_tariffs->outTariffs() }}
            </div>

          </div>
          
          <input type="hidden" name="tariff_id" value="{{ $template->user->data->tariff_id }}" />
          <input type="hidden" name="target" value="service_tariff" />

          <div class="mt30" >
            <button class="initOptionsPaymentServiceTariff btn-custom-big button-color-scheme1 profile-tariffs-action-payment" >{{ translate("tr_ad5c2ce8c246a75449fc289b032c5ca8") }}</button>
          </div>

        </form>

  </div>

</div>

</div>

{% endblock %}