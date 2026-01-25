{% extends index.tpl %}

{% block content %}

<div class="container mt40 mb40" >

    <a class="btn-custom-mini button-color-scheme2" href="{{ outRoute('cart') }}" ><i class="ti ti-chevron-left"></i> {{ translate("tr_2b0b0225a86bb67048840d3da9b899bc") }}</a>

    <h1 class="font-bold mt10" >{{ $seo->h1 }}</h1>

    <div class="row mt20" >
      <div class="col-md-7" >

          <div class="order-buy-card-content" >

            {{ $template->component->cart->outCheckoutItems($data) }}

          </div>

          {% if($template->settings->integration_delivery_services_active): %}
          <h4 class="font-bold mt40">{{ translate("tr_e3956f167dd00ecf8648f41119bd5a3e") }}</h4>

          {% if($template->user->data->delivery_data): %}
          <div class="order-buy-delivery-recipient-data" >
            <div>
            {{ $template->user->data->delivery_data->name }} {{ $template->user->data->delivery_data->patronymic }} {{ $template->user->data->delivery_data->surname }}
            <br>
            {{ decrypt($template->user->data->delivery_data->phone) }}
            <br>
            {{ decrypt($template->user->data->delivery_data->email) }}
            </div>
          </div>
          <span class="btn-custom-mini button-color-scheme3 openModal mt20" data-modal-id="orderDeliveryRecipientModal" >{{ translate("tr_47e2436e5560837160a70c64466ea22b") }}</span>
          {% else: %}
          <div class="order-buy-delivery-recipient-data" >
          </div>
          <span class="btn-custom-mini button-color-scheme3 openModal mt20" data-modal-id="orderDeliveryRecipientModal" >{{ translate("tr_5eba283b81890978e67f4aa96dde1724") }}</span>
          {% endif %}
          {% endif %}

      </div>
      <div class="col-md-3" >
        
          <div class="order-buy-card-sidebar cart-sidebar-selected-items" >

              <h3>{{ translate("tr_c6ff3b2901b7ad603f6194c379ba36ea") }}</h3>

              <div class="order-buy-card-sidebar-list" >

                <div class="order-buy-card-sidebar-list-box" >
                  <div class="order-buy-card-sidebar-list-box-item1" >{{ translate("tr_ac7fc73e7bef8cceff85d626ded140c4") }}</div>
                  <div class="order-buy-card-sidebar-list-box-item2 cartLabelCountItems" > {{ $data->total_count }} </div>
                </div>

                <div class="order-buy-card-delivery-list-box" >
                  <div class="order-buy-card-sidebar-list-box" >
                    <div class="order-buy-card-sidebar-list-box-item1" >{{ translate("tr_b973ee86903271172c9b4f5529bc19bb") }}</div>
                    <div class="order-buy-card-sidebar-list-box-item2" > <strong class="order-buy-card-delivery-total-amount" >-</strong> </div>
                  </div>
                </div>

                <div class="order-buy-card-sidebar-list-box" >
                  <div class="order-buy-card-sidebar-list-box-item1" >{{ translate("tr_edcf39209f3f2bb6da1efd8258c12639") }}</div>
                  <div class="order-buy-card-sidebar-list-box-item2 cartLabelTotalAmount" data-total-amount="{{ $data->total_amount }}" > {{ $template->system->amount($data->total_amount) }} </div>
                </div>

              </div>
            
              <button class="btn-custom button-color-scheme1 width100 mt20 actionCartToPayment" data-session="{{ $data->session_id }}" >{{ translate("tr_e1f7d614ec62e7651cd1c77c6f3a8afb") }}</button>

              <div class="order-buy-card-sidebar-info" >
                {{ translate("tr_978c4604c3e80e5a8889f58d3d209aa0") }}
              </div>

          </div>

          <div class="order-buy-card-sidebar cart-sidebar-not-selected-items" >

              {{ translate("tr_8b90b7bbb3bfcbe5367982b9f767a897") }}

          </div>

      </div>

    </div>

</div>

{{ $template->ui->tpl('modals/order-delivery-recipient.tpl')->modal("orderDeliveryRecipient", "small") }}

{% endblock %}