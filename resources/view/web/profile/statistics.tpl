{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

        <h3> <strong>{{ translate("tr_a62b9e5890d76fe02b0c809915136afd") }}</strong> </h3>

        <div class="mt20" >
          
          <div class="mt30" >
            {% if($template->user->data->service_tariff->expiration_status): %}

              {% if($template->user->data->service_tariff->items->extra_statistics): %}

                <div class="btn-custom-mini button-color-scheme3 mb20 actionOpenStaticModal" data-modal-target="profileStatisticsChangeAd" >{{ translate("tr_a790cd5980b1308c07b902c18fa59584") }}</div>

                {{ $template->component->profile->outUserAdStatistics($_GET["item_id"], $template->user->data->id) }}

              {% else: %}

              <img src="{{ $template->storage->getAssetImage('27614541074327343.webp') }}" height="256" >

              <div class="row" >
                <div class="col-6" ><p class="mt15" >{{ translate("tr_2c7e588d7cd70069a42d823fd2e0817c") }}</p></div>
              </div>

              <a class="btn-custom button-color-scheme1" href="{{ outRoute('profile-tariffs') }}" >{{ translate("tr_30a544922e9bed51aeb1e0971ad7ddd6") }}</a>
              {% endif; %}
              
            {% else: %}

              <img src="{{ $template->storage->getAssetImage('27614541074327343.webp') }}" height="256" >

              <div class="row" >
                <div class="col-6" ><p class="mt15" >{{ translate("tr_2c7e588d7cd70069a42d823fd2e0817c") }}</p></div>
              </div>

              <a class="btn-custom button-color-scheme1" href="{{ outRoute('profile-tariffs') }}" >{{ translate("tr_b28312ec69f7940ab6ae66fa556db296") }}</a>
            {% endif; %}
          </div>

        </div>


  </div>

</div>

</div>

{{ $template->ui->tpl('modals/profile-statistics-change-date.tpl')->modal("profileStatisticsChangeDate", "small", $_GET) }}

{% endblock %}