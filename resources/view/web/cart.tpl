{% extends index.tpl %}

{% block content %}

<div class="container mt40 mb40" >

    {% if($data->items): %}

    <h1 class="font-bold" >{{ $seo->h1 }}</h1>

    <div class="row mt20" >
      <div class="col-md-7 order-lg-1 order-2" >

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="cart-check-all" checked >
            <label class="form-check-label" for="cart-check-all">
              {{ translate("tr_4d09821e5f0ae6b496ac3211da10f88b") }}
            </label>
          </div>

          <form class="cart-form mt15" >

            <div class="order-buy-card-content" >

              {{ $template->component->cart->outCartItems($data) }}

            </div>

          </form>

      </div>
      <div class="col-md-3 order-lg-2 order-1 mb25" >
        
          <div class="order-buy-card-sidebar cart-sidebar-selected-items" >

              <h3>{{ translate("tr_c6ff3b2901b7ad603f6194c379ba36ea") }}</h3>

              <div class="order-buy-card-sidebar-list" >

                <div class="order-buy-card-sidebar-list-box" >
                  <div class="order-buy-card-sidebar-list-box-item1" >{{ translate("tr_ac7fc73e7bef8cceff85d626ded140c4") }}</div>
                  <div class="order-buy-card-sidebar-list-box-item2 cartLabelCountItems" > - </div>
                </div>

                <div class="order-buy-card-sidebar-list-box" >
                  <div class="order-buy-card-sidebar-list-box-item1" >{{ translate("tr_edcf39209f3f2bb6da1efd8258c12639") }}</div>
                  <div class="order-buy-card-sidebar-list-box-item2 cartLabelTotalAmount" > - </div>
                </div>

              </div>
            
              <button class="btn-custom button-color-scheme1 width100 mt20 actionCartGoCheckout" >{{ translate("tr_826ea712d2e1d2a94e3bb177ba7747a0") }}</button>

          </div>

          <div class="order-buy-card-sidebar cart-sidebar-not-selected-items" >

              {{ translate("tr_8b90b7bbb3bfcbe5367982b9f767a897") }}

          </div>

      </div>

    </div>

    {% else: %}

    <div class="row mt40" >
      <div class="col-md-7" >

          <h1 class="font-bold mt100" >{{ translate("tr_c5d122bb17e668cb0debb2df78bd64d2") }}</h1>

          <a class="btn-custom button-color-scheme1 mt15" href="{{ $template->component->catalog->currentAliases() }}">{{ translate("tr_eb557c3195702637b89955607c188486") }}</a>

      </div>
      <div class="col-md-3 d-none d-lg-block" >

          <img src="{{ $template->storage->getAssetImage("6672554874488510.webp") }}" height="350" >
        
      </div>

    </div>

    {% endif %}

</div>

{% endblock %}