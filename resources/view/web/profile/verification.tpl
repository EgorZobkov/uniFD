{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

        <h3> <strong>{{ translate("tr_c7cadea1c393b4b40ed898d48f10c1b0") }}</strong> </h3>

        {% if($template->user->data->verification_status): %}

          <div class="profile-verification-container mt30" >
            <h5>{{ translate("tr_1096e90e410c6b59c1f5691f389b23ec") }}</h5>
            <p>{{ translate("tr_5d6f57e86e6ffd8543c378afc03ea4f1") }}</p>
          </div>

        {% else: %}

        {% if(!$data->verification): %}

        <form class="profile-verification-form" >

        <div class="profile-verification-container mt30" >
          
           <h5> <strong>{{ translate("tr_75768c49c24662cc4465237b0731e1ce") }}</strong> </h5>

           <div class="profile-verification-contact-container" >
              <div>
                {% if($template->user->data->phone): %}
                <span> <i class="ti ti-check"></i> {{ translate("tr_9fdc3f131f7923e7bdd4ec60d465ae87") }} </span>
                {% else: %}
                <span> <i class="ti ti-exclamation-circle"></i> {{ translate("tr_9fdc3f131f7923e7bdd4ec60d465ae87") }} </span>
                <div><a class="btn-custom-mini button-color-scheme5 mt10" href="{{ outRoute('profile-settings') }}">{{ translate("tr_e2603bcce79e0b861ac1f1bd464de2b6") }}</a></div>
                {% endif %}
              </div>
              <div class="mt5" >
                {% if($template->user->data->email): %}
                <span> <i class="ti ti-check"></i> {{ translate("tr_92d65fa726a6a4b889597e2e0b1efa58") }} </span>
                {% else: %}
                <span> <i class="ti ti-exclamation-circle"></i> {{ translate("tr_92d65fa726a6a4b889597e2e0b1efa58") }} </span>
                <div><a class="btn-custom-mini button-color-scheme5 mt10" href="{{ outRoute('profile-settings') }}">{{ translate("tr_e2603bcce79e0b861ac1f1bd464de2b6") }}</a></div>
                {% endif %}
              </div>
           </div>

           <h5 class="mt30" > <strong>{{ translate("tr_5e523403f0c0d3386cbce4de7b8a0c0e") }}</strong> </h5>

           <div class="profile-verification-doc-container" >
                <span>{{ translate("tr_058afe4b7cd85060593f270b2f7756b2") }} <strong>{{ $data->uniq_code }}</strong></span>
                <div><span class="btn-custom-mini button-color-scheme1 mt10 uniAttachFilesChange" data-accept="images" data-upload-route="profile-verification-upload-attach" data-parent-container="profile-verification-doc-container" >{{ translate("tr_be82d1d8b51f81862b410f6a664cc4e0") }}</span></div>
                <div class="uni-attach-files-container"></div>
           </div>

           <div class="profile-verification-info-container" >
              <ul>
                <li>{{ translate("tr_8da311118221dc0c11aa027824e14ec4") }}</li>
                <li>{{ translate("tr_a24a9f16d9b4bb4cb6270e9650e32435") }}</li>
                <li>{{ translate("tr_d618390400991bcb66538958ba360a76") }}</li>
                <li>{{ translate("tr_6c4aa29526c6d86bc05f3a77cf022b03") }}</li>
              </ul>
           </div>           

        </div>

        <button class="btn-custom button-color-scheme5 mt50 actionSendUserVerification" >{{ translate("tr_9665e787c442763f065ee471f16ff7fd") }}</button>

        <div class="mt10" ><small>{{ translate("tr_1ba3555fb005ab797d3614258e8a3905") }} <br> {{ translate("tr_4a0f287f330eac79e8bb717ba1ac22a5") }}</small></div>

        </form>

        {% else: %}

          {% if($data->verification->status == "awaiting_verification"): %}
          <div class="profile-verification-container mt30" >
            <h5>{{ translate("tr_f3dad7e5739589b14472d0367362ffe4") }}</h5>
            <p>{{ translate("tr_0f4a88be7db0535c9a1d6c513f160834") }}</p>
          </div>
          {% endif %}

          {% if($data->verification->status == "verified"): %}
          <div class="profile-verification-container mt30" >
            <h5>{{ translate("tr_1096e90e410c6b59c1f5691f389b23ec") }}</h5>
            <p>{{ translate("tr_5d6f57e86e6ffd8543c378afc03ea4f1") }}</p>
          </div>
          {% endif %}

          {% if($data->verification->status == "rejected"): %}
          <div class="profile-verification-container mt30" >
            <h5>{{ translate("tr_0c89ae7c67cb259df5ee592bf815ed88") }}</h5>
            <p>{{ $data->verification->comment }}</p>
          </div>
          {% endif %}

        {% endif %}

        {% endif %}

  </div>

</div>

</div>

{% endblock %}