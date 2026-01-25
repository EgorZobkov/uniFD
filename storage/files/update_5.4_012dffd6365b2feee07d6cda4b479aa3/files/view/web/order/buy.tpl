{% extends index.tpl %}

{% block content %}

<div class="container mt20 mb40" >

    <h1 class="font-bold" >{{ translate("tr_f50d065821e1d997a32ec402f29cf6ea") }}</h1>

    <div class="row mt20" >
      <div class="col-lg-6 col-12 order-lg-1 order-2" >

          <div class="order-buy-card-content" >

            <div class="ad-card-item" >
              
              <div class="ad-card-item-image" > <img src="{{ $data->ad->media->images->first; }}" class="image-autofocus" > </div>
              <div class="ad-card-item-content" >
                <div class="ad-card-item-content-title" > <a href="{{ $template->component->ads->buildAliasesAdCard($data->ad) }}">{{ $data->ad->title }}</a> </div>
                <div class="ad-card-item-content-prices" >{{ $template->component->ads->outPrices($data->ad) }}</div>
              </div>
              
            </div>            

          </div>

          {% if($data->ad->category->type_goods == "physical_goods"): %}
          <h4 class="font-bold mt40" >{{ translate("tr_e1c460cccae48238e3f198c18f8c6e00") }}</h4>

          <div class="order-buy-card-delivery" >
            
            <div class="order-buy-card-delivery-item actionBuyChangeDelivery active" data-id="0" >
                <span> <strong>{{ translate("tr_5d14f6aabcfceaf70a9afe00b38103e9") }}</strong> </span>
                <span>{{ translate("tr_6d96fd666927fc73d925d2113fa8053d") }}</span>
            </div>

            {{ $template->component->delivery->outDeliveryListInOrder($data->ad) }}

          </div>

          <div class="order-buy-card-info" >
            <ul>
              <li>{{ translate("tr_fcb0272c847cee0581a0c339869a5c8b") }}</li>
              <li>{{ translate("tr_c73a81c30d41ccea4bc89c2ddd910f16") }}</li>
              <li>{{ translate("tr_4f87b8406bae1cc2ceadfab07676a12e") }}</li>
            </ul>
          </div>

          <div class="order-buy-delivery-point" >
            
            <h4 class="font-bold mt40">{{ translate("tr_756fec706d7df0fe9bdc33ea1ce80dda") }}</h4>

            <div class="order-buy-delivery-point-data" >
            </div>

            <input type="hidden" name="delivery_point_id" value="0" >

          </div>

          <div class="order-buy-delivery-recipient" >
            
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

          </div>

          {% endif; %}

          {% if($data->ad->category->type_goods == "electronic_goods"): %}

          <div class="order-buy-card-info" >
            <ul>
              <li>{{ translate("tr_6ce42989e48acb25228c9e1021b69981") }}</li>
              <li>{{ translate("tr_38194c10aab1e48eaa75abc448cef8c3") }}</li>
              <li>{{ translate("tr_4f87b8406bae1cc2ceadfab07676a12e") }}</li>
            </ul>
          </div>
          
          {% endif; %}

      </div>
      <div class="col-lg-3 col-12 order-lg-2 order-1 mb25" >
        
          <div class="order-buy-card-sidebar" >

              <h3>{{ translate("tr_c6ff3b2901b7ad603f6194c379ba36ea") }}</h3>

              <div class="order-buy-card-sidebar-list" >

                <div class="order-buy-card-sidebar-list-box" >
                  <div class="order-buy-card-sidebar-list-box-item1" >{{ translate("tr_cb8bfd4d5a1df2e7459f2fe740c8dcba") }}</div>
                  <div class="order-buy-card-sidebar-list-box-item2" > <strong>1</strong> </div>
                </div>

                <div class="order-buy-card-delivery-list-box" >
                  <div class="order-buy-card-sidebar-list-box" >
                    <div class="order-buy-card-sidebar-list-box-item1" >{{ translate("tr_b973ee86903271172c9b4f5529bc19bb") }}</div>
                    <div class="order-buy-card-sidebar-list-box-item2" > <strong class="order-buy-card-delivery-total-amount" >-</strong> </div>
                  </div>
                </div>

                <div class="order-buy-card-sidebar-list-box" >
                  <div class="order-buy-card-sidebar-list-box-item1" >{{ translate("tr_edcf39209f3f2bb6da1efd8258c12639") }}</div>
                  <div class="order-buy-card-sidebar-list-box-item2" > <strong class="order-buy-card-total-amount"  data-total-amount="{{ $data->ad->price }}" >{{ $template->system->amount($data->ad->price, $data->ad->currency_code) }}</strong> </div>
                </div>

              </div>
            
              <button class="btn-custom button-color-scheme1 width100 mt20 initPaymentItemSecureDeal" data-id="{{ $data->ad->id }}" >{{ translate("tr_e1f7d614ec62e7651cd1c77c6f3a8afb") }}</button>

              <div class="order-buy-card-sidebar-info" >
                {{ translate("tr_978c4604c3e80e5a8889f58d3d209aa0") }}
              </div>

          </div>

      </div>

    </div>

</div>

{{ $template->ui->tpl('modals/order-delivery-recipient.tpl')->modal("orderDeliveryRecipient", "small") }}

{% endblock %}