{% extends index.tpl %}

{% block content %}
    
    <div class="search-map-sidebar-control-mobile" >
        
        <div class="row" >
            <div class="col-lg-8" >
                {% if($_GET["c_id"]): %}
                <div class="mb5" ><strong>{{ $template->component->ads_categories->chainCategory($_GET["c_id"])->chain_build }}</strong></div>
                {% endif %}
                <span class="actionSaveSearch catalog-container-links-inline-item">👉 {{ translate("tr_0f724ec88b1fc82527e8097190f4fa5c") }}</span>
            </div>
            <div class="col-lg-4 text-end" >
                 <div class="btn-custom-mini button-color-scheme1 actionMapShowFilters" >{{ translate("tr_f7ac6fc5c5a477063add9c6d0701985d") }} {% if($_GET["filter"]): %}<span class="badge badge-dot bg-danger ml5 badge-dot"></span>{% endif %} </div>
            </div>
        </div>

    </div>

    <div class="search-map-sidebar" >
        
        <div class="search-map-sidebar-control" >
            <div class="row" >
                <div class="col-lg-8" >
                    {% if($_GET["c_id"]): %}
                    <div class="mb5" ><strong>{{ $template->component->ads_categories->chainCategory($_GET["c_id"])->chain_build }}</strong></div>
                    {% endif %}
                    <span class="actionSaveSearch catalog-container-links-inline-item">👉 {{ translate("tr_0f724ec88b1fc82527e8097190f4fa5c") }}</span>
                </div>
                <div class="col-lg-4 text-end" >
                     <div class="btn-custom-mini button-color-scheme1 actionMapShowFilters" >{{ translate("tr_f7ac6fc5c5a477063add9c6d0701985d") }} {% if($_GET["filter"]): %}<span class="badge badge-dot bg-danger ml5 badge-dot"></span>{% endif %} </div>
                </div>
            </div>
        </div>

        <div class="search-map-sidebar-container" >
          <div class="row" >
            {% component items/map-skeleton.tpl %}
          </div>
        </div>

    </div>

    <div class="search-map-sidebar-card" >
    </div>

    <div class="search-map-sidebar-filters" >

        <div class="search-map-sidebar-filters-control text-end" >
            <div class="btn-custom-mini button-color-scheme2 actionMapCloseFilters" >{{ translate("tr_dd9463bd5d0c650b468fc5d6cfa1073c") }}</div>
        </div>

        <form class="live-filters search-map-sidebar-filters-container" >

          <div class="params-form-item params-form-item-categories" >
              <label class="params-form-item-label" >{{ translate("tr_c95a1e2de00ee86634e177aecca00aed") }}</label>
              <div class="params-form-item-subcategories" >
                {{ $template->component->ads_categories->outReverseCategories($_GET["c_id"]) }}
              </div>
          </div>

          {{ $template->component->catalog->buildParamsForm($_GET, $_GET["c_id"], false); }}

          <div class="search-map-sidebar-filters-buttons" >
            
            <button class="btn-custom button-color-scheme1 width100 actionApplyLiveFilters" >{{ translate("tr_130bbbc068f7a58df5d47f6587ff4b43") }}</button>

            {% if($_GET["filter"]): %}
            <button class="btn-custom button-color-scheme4 width100 mt5 actionClearLiveFilters">{{ translate("tr_02d901c131a1b8c2d1dd669e1f6c88a5") }}</button>
            {% endif %}

          </div>

        </form>

    </div>

    <div class="search-map-container initMap" id="initMap" ></div>

    {{ $template->component->geo->outMapSearchItems() }}

    {{ $template->ui->tpl('modals/contact-modal.tpl')->modal("contact", "small") }}

{% endblock %}