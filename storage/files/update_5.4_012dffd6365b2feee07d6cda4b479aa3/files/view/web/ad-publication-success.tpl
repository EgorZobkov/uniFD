{% extends index.tpl %}

{% block content %}

<div class="container mt40 mb40" >

    <div class="row" >

      <div class="col-md-9" >

        <h1 class="font-bold" >{{ $seo->h1 }}</h1>

        <p>{{ translate("tr_9f74eca72305defc8be73484d4758d56") }}</p>

      </div>

    </div>

    <a class="btn-custom-big button-color-scheme2" href="{{ $template->component->ads->buildAliasesAdCard($data) }}" >{{ translate("tr_eaea8b2f7cf64b9c25af6d604645419b") }}</a>

    <div class="row mt20" >

      <div class="col-md-9" >

        <div class="ad-card-item" >
          
          <div class="ad-card-item-image" > <img src="{{ $data->media->images->first; }}" class="image-autofocus" > </div>
          <div class="ad-card-item-title" > {{ $template->component->ads->outStatusByAd($data->status) }} {{ $data->title }} </div>

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

    </div>

</div>


{% endblock %}