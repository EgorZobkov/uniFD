{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

        <h3> <strong>{{ translate("tr_f139acad6b9e9ae951fc74f9df710e96") }}</strong> </h3>

        <div class="mt20" >
          
          <div class="mt30" >
            {% if($template->user->data->service_tariff->expiration_status): %}

              {% if($template->user->data->service_tariff->items->autorenewal): %}

                {% if($data->ads): %}

                <div class="row mt25" >{{ $data->ads; }}</div>

                {{ $template->pagination->display() }}

                {% else: %}

                  <div class="mt40 not-found-title-container" >
                     <div class="not-found-title-container-image" >🧐</div>
                     <p>{{ translate("tr_abe40b620b33b61056d38cfd4f6e2ff2") }}</p>           
                  </div>

                {% endif; %}

              {% else: %}

              <img src="{{ $template->storage->getAssetImage('7741796093758663.webp') }}" height="256" >

              <div class="row" >
                <div class="col-6" ><p class="mt15" >{{ translate("tr_16094f8c00bc5c4e8dd97afdc52d6adf") }}</p></div>
              </div>

              <a class="btn-custom button-color-scheme1" href="{{ outRoute('profile-tariffs') }}" >{{ translate("tr_fcdcc0277ce2f1765e53afb525273088") }}</a>
              {% endif; %}

            {% else: %}

              <img src="{{ $template->storage->getAssetImage('7741796093758663.webp') }}" height="256" >

              <div class="row" >
                <div class="col-6" ><p class="mt15" >{{ translate("tr_16094f8c00bc5c4e8dd97afdc52d6adf") }}</p></div>
              </div>

              <a class="btn-custom button-color-scheme1" href="{{ outRoute('profile-tariffs') }}" >{{ translate("tr_b28312ec69f7940ab6ae66fa556db296") }}</a>
            {% endif; %}
          </div>

        </div>


  </div>

</div>

</div>

{% endblock %}