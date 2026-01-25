{% extends index.tpl %}

{% block content %}

<div class="container mt20 mb40" >

    <div class="row" >

      <div class="col-md-9" >

        <h1 class="font-bold" >{{ $seo->h1 }}</h1>

      </div>

    </div>

    <div class="row mt20" >

      <div class="col-lg-9 col-12" >

        <div class="ad-card-item" >
          
          <div class="ad-card-item-image" > <img src="{{ $data->media->images->first; }}" class="image-autofocus" > </div>
          <div class="ad-card-item-title" > {{ $template->component->ads->outStatusByAd($data->status) }} {{ $data->title }} </div>

        </div>

        <div class="d-block d-lg-none" >
          <button class="btn-custom button-color-scheme3 actionOpenStaticModal" data-modal-target="adPaidServicesSearchUserItems" data-modal-params="{{ buildAttributeParams(["item_id"=>$data->id]) }}" >{{ translate("tr_a790cd5980b1308c07b902c18fa59584") }}</button>
        </div>

        <div class="ad-paid-services-list" >

          <form class="ad-paid-services-form" >

            {{ $template->component->ad_paid_services->outServices($data->id) }}

            <input type="hidden" name="id" value="{{ $data->id }}" />
            <input type="hidden" name="service_id" value="" />
            <input type="hidden" name="target" value="paid_ad_services" />

          </form>
          
        </div>

      </div>

      <div class="col-lg-3 col-12 d-none d-lg-block" >

        {{ $template->component->ad_paid_services->outItemsWaitingList($data->id, $template->user->data->id) }}

      </div>

    </div>

</div>


{% endblock %}