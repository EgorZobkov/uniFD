{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

    <div class="profile-home-sections" >

      <section>

        {% if($template->settings->verification_users_status): %}

          {% if(!$template->user->data->verification_status): %}

          {% else: %}

          <div class="profile-home-sections-info-item">
          <h5> <strong>{{ translate("tr_8b172472598ea96545ea248dd2b60d0e") }}</strong> </h5>
          </div>

          {% endif %}

        {% endif %}



      </section>

      {% if($data->orders): %}
      <section>
      <h3> <strong>{{ translate("tr_0905527faec7de502c0e62ce318af892") }}</strong> </h3>
      <div class="row row-cols-2 g-2 g-lg-3 mt25" >{{ $data->orders }}</div>

      <a class="btn-custom-mini button-color-scheme2 mt10" href="{{ outRoute('profile-orders') }}" >{{ translate("tr_4afd2ca38e5bba8fb023f3bce3e22838") }}</a>
      </section>
      {% endif %}

      <section>
        {% if($data->ads): %}
          <h3> <strong>{{ translate("tr_ffc009f302516a8402667d060e48794b") }}</strong> </h3>

          <a class="btn-custom button-color-scheme1 mt10" href="{{ outRoute('ad-create') }}" >{{ translate("tr_6a597fed338ace644982313b3cfbead4") }}</a>

          <div class="row row-cols-2 g-2 g-lg-3 mt25" >{{ $data->ads; }}</div>

          <a class="btn-custom-mini button-color-scheme2 mt10" href="{{ outRoute('profile-ads') }}" >{{ translate("tr_d572de2b18482a4db2968a7fe6ca674f") }}</a>
        {% else: %}
          <h3> <strong>{{ translate("tr_698ee392dad3099a37dae5c98118fb2d") }}</strong> </h3>
          <a class="btn-custom button-color-scheme1 mt10" href="{{ outRoute('ad-create') }}" >{{ translate("tr_6a597fed338ace644982313b3cfbead4") }}</a>
        {% endif %}
      </section>

      {% if($data->favorites): %}
      <section>
      <h3> <strong>{{ translate("tr_2fc413929104c1a09ae0a66c48ce0902") }}</strong> </h3>
      <div class="row row-cols-2 g-2 g-lg-3 mt25" >{{ $data->favorites }}</div>
      </section>
      {% endif %}

      {% if($data->reviews): %}
      <section>
      <h3> <strong>{{ translate("tr_1c3fea01a64e56bd70c233491dd537aa") }}</strong> </h3>
      <div class="row row-cols-2 g-2 g-lg-3 mt25" >{{ $data->reviews }}</div>

      <a class="btn-custom-mini button-color-scheme2 mt10" href="{{ outRoute('profile-reviews') }}" >{{ translate("tr_4fbf45456be84d545b8a3052079e0173") }}</a>
      </section>
      {% endif %}

    </div>

  </div>

</div>

</div>

{% if($template->settings->registration_bonus_status): %}
{{ $template->ui->tpl('modals/profile-registration-bonus.tpl')->modal("profileRegistrationBonus", "small") }}
{% endif %}

{% endblock %}