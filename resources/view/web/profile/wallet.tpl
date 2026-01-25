{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

        <h3> <strong>{{ translate("tr_419a0c4f19223bbef8fd1cbf92bf0cd0") }}</strong> </h3>

        <div class="mt20 profile-wallet-info-balance" >
          <p>{{ translate("tr_95dcad972e98961cdb8a49897d2fc550") }}</p>
          <h3>{{ $template->user->data->balance_by_currency }}</h3>
        </div>

        <div class="my-tabs-items my-tabs-items-medium mt20">
            <div class="my-tabs-item active" data-id="1" >{{ translate("tr_356d93adeaa7dfc2f6df1ffe8f04c79d") }}</div>
            <div class="my-tabs-item" data-id="2" >{{ translate("tr_60474cc5f82d9aa40595415691312c2c") }}</div>
        </div>

        <div class="my-tabs-content-container" >
          <div class="my-tabs-content my-tabs-content-1" >
            
            <form class="profile-wallet-payment-form" >

              <p class="mt30" > {{ translate("tr_917a902a8d941c7311d4ea87dd3626b2") }} </p>

              <div class="row" >
                <div class="col-md-3" >
                  <input type="number" class="form-control" name="amount" step="0.01" min="{{ $template->setting->profile_wallet_min_amount_replenishment }}" max="{{ $template->setting->profile_wallet_max_amount_replenishment }}" placeholder="{{ $template->system->getDefaultCurrency()->symbol }}" >
                </div>
              </div>

              <p class="mt30" > {{ translate("tr_4dbf0c67eed6243d0535352743ed3b46") }} </p>

              <div>
                <div class="row" >
                  <div class="col-md-6" >
                    {{ $template->component->transaction->outActivePaymentsInWallet() }}
                  </div>
                </div>
              </div>

              <button class="btn-custom button-color-scheme1 mt30 profile-wallet-payment-action-replenishment">{{ translate("tr_7199188f4dfaf0bfbe033af01906ddc6") }}</button>

            </form>

          </div>
          <div class="my-tabs-content my-tabs-content-2" >

            {% if($data->history): %}

              {{ $data->history }}

            {% else: %}

              <div class="mt40 not-found-title-container" >
                 <div class="not-found-title-container-image" >🧐</div>
                 <p>{{ translate("tr_3a54e7d21900776b9b9637249f11231f") }}</p>           
              </div>

            {% endif; %}

          </div>
        </div>

  </div>

</div>

</div>

{% endblock %}