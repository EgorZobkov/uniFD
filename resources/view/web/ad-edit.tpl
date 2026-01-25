{% extends index.tpl %}

{% block content %}

<div class="container mt40" >

<h3 class="font-bold mb20" >{{ $data->title }}</h3>

<div class="ad-create-categories-container" style="display: none;" >
  
    <div class="row" >
      <div class="col-md-4" >

        <div class="ad-create-categories-container-items" ><button class="btn-custom button-color-scheme2 mb15 ad-create-categories-close" >{{ translate("tr_2b0b0225a86bb67048840d3da9b899bc") }}</button> {{ $template->component->ads_categories->outMainCategoriesInAdCreate() }}</div>

      </div>
    </div>

</div>

<div class="ad-create-options-container" style="display: block;" >

  <form class="form-ad-update" >

  <div class="ad-create-content-container" >
      {{ $template->component->ads->getContentAndOptions(["category_id"=>$data->category_id, "is_admin"=>$data->isAdmin],$data) }}
  </div>

  <input type="hidden" name="ad_id" value="{{ $data->id }}" >
  <input type="hidden" name="category_id" value="{{ $data->category_id }}" >
  <input type="hidden" name="geo_city_id" value="{{ $data->city_id }}" >
  <input type="hidden" name="geo_address_latitude" value="{{ $data->address_latitude }}" >
  <input type="hidden" name="geo_address_longitude" value="{{ $data->address_longitude }}" >
  <input type="hidden" name="geo_latitude" value="{{ $data->address_latitude ?: $data->geo_latitude }}" >
  <input type="hidden" name="geo_longitude" value="{{ $data->address_longitude ?: $data->geo_longitude }}" >

  <button class="btn-custom-big button-color-scheme3 adActionUpdate mt30 mb30" >{{ translate("tr_74ea58b6a801f0dce4e5d34dbca034dc") }}</button>

  </form>

</div>

</div>

{{ $template->component->geo->outMapChangeAddressInAdCreate() }}

{% endblock %}