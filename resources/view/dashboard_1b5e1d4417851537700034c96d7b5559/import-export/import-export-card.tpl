
{% component breadcrumbs.tpl %}

{% if($data->status != 0): %}
<div class="nav-align-top mb-4">
  <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
    <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-import-card', [$data->id]) }}">{{ translate("tr_baa2025b9f3afaf0158bd40392043b31") }}</a></li>
    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-import-logs', [$data->id]) }}">{{ translate("tr_44c14175223df9bae3aff6309c061f4d") }}</a></li>
  </ul>
</div>
{% endif %}

<div class="row">

  {% if($data->table == "ads"): %}

  <div class="col-12 col-lg-3" >
    
    <div class="card">

      <div class="card-body">

        <form class="formParamsImport" >

          <label class="switch">
            <input type="checkbox" name="params[auto_renewal]" class="switch-input" value="1" {% if($data->params["auto_renewal"]): %} checked="" {% endif %} >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{ translate("tr_f139acad6b9e9ae951fc74f9df710e96") }}</span>
          </label>

          <label class="switch mt-3">
            <input type="checkbox" name="params[image_download]" class="switch-input import-card-container-checked-image-download" value="1" {% if($data->params["image_download"]): %} checked="" {% endif %} >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{ translate("tr_3113178731a98c5416fad0167e3aad12") }}</span>
          </label>  

          <div class="import-card-container-count-download-photo" {% if($data->params["image_download"]): %} style="display: block;" {% endif %} >

            <div class="text-light small fw-medium mb-2 mt-3">{{ translate("tr_cb8bfd4d5a1df2e7459f2fe740c8dcba") }}</div>

            <input type="text" class="form-control mb-2" name="params[image_count_download]" value="{{ $data->params["image_count_download"]?:5 }}" maxlength="2" >

          </div>

          <label class="switch mt-3">
            <input type="checkbox" name="params[only_photos]" class="switch-input" value="1" {% if($data->params["only_photos"]): %} checked="" {% endif %} >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{ translate("tr_5380055593718231df7305b6196b0952") }}</span>
          </label>

          <div class="text-light small fw-medium mb-2 mt-3">{{ translate("tr_6926e02be4135897ae84b36941554684") }}</div>    

          <label class="switch">
            <input type="checkbox" name="params[category_auto]" class="switch-input import-card-container-checked-category-auto" value="1" {% if($data->params["category_auto"]): %} checked="" {% endif %} >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{ translate("tr_ed94c430a0154fe7fad3d4b92b2322b0") }}</span>
          </label>

          <div class="import-card-container-selected-categories" {% if(!$data->params["category_auto"]): %} style="display: block;" {% endif %} >

            <div class="text-light small fw-medium mb-2 mt-3">{{ translate("tr_db3825af7f18cc7cf700984b9ca5bd4a") }}</div>

            <select name="params[category_id]" class="form-select selectpicker" title="{{ translate("tr_591cca300870eb571563ef4b8c8756ff") }}" >
               {{ $template->component->ads_categories->selectedIds($data->params["category_id"])->getRecursionOptions() }}
            </select>

          </div>      

          <div class="text-light small fw-medium mb-2 mt-3">{{ translate("tr_069c9cb17c0aca1e499f3a00fdeb9b3a") }}</div>    

          <label class="switch">
            <input type="checkbox" name="params[city_auto]" class="switch-input import-card-container-checked-cities-auto" value="1" {% if($data->params["city_auto"]): %} checked="" {% endif %} >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{ translate("tr_ed94c430a0154fe7fad3d4b92b2322b0") }}</span>
          </label>

          <div class="import-card-container-selected-cities" {% if(!$data->params["city_auto"]): %} style="display: block;" {% endif %} >

            <div class="text-light small fw-medium mb-2 mt-3">{{ translate("tr_7dfe7a8f465fe0769c414fc3f21278c6") }}</div>

            <div class="container-live-search-tags" >

              <div class="container-live-search" >
                <input type="text" class="form-control input-live-search input-live-search-cities" placeholder="{{ translate("tr_00d3ac3aab724303082b54fae62d7844") }}" value="{{ $data->city->name }}" >
                <div class="container-live-search-results" ></div>
                <input type="hidden" name="params[city_id]" value="{{ $data->params["city_id"]?:0 }}" class="input-live-search-city-id" >
              </div>

            </div>

          </div>

          <div class="text-light small fw-medium mb-2 mt-3">{{ translate("tr_b8c4e70da7bea88961184a1c1be9cb13") }}</div>    

          <label class="switch">
            <input type="checkbox" name="params[user_reg]" class="switch-input import-card-container-checked-user-auto" value="1" {% if($data->params["user_reg"]): %} checked="" {% endif %}  >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{ translate("tr_a0561cd8d41eefcf2a88d9e7a9921900") }}</span>
          </label>

          <div class="import-card-container-selected-users" {% if(!$data->params["user_reg"]): %} style="display: block;" {% endif %} >

            <div class="text-light small fw-medium mb-2 mt-3">{{ translate("tr_8765157c29f27cf555035c00c9711db7") }}</div>

            <div class="container-live-search" >
              <input type="text" class="form-control input-live-search input-live-search-users" placeholder="{{ translate("tr_ddfb56371beb6ffb9913fdd881c46ae0") }}"  value="{{ $data->user->name }}" >
              <input type="hidden" name="params[user_id]" value="{{ $data->params["user_id"]?:0 }}" class="input-live-search-user-id" >
              <div class="container-live-search-results" ></div>
            </div>

          </div>

        </form>

      </div>

    </div>

  </div>

  {% endif %}

  {% if($data->table == "users"): %}

  <div class="col-12 col-lg-3" >
    
  </div>

  {% endif %}

  {% if($data->table == "blog_posts"): %}

  <div class="col-12 col-lg-3" >
    
    <div class="card">

      <div class="card-body">

        <form class="formParamsImport" >

          <label class="switch">
            <input type="checkbox" name="params[image_download]" class="switch-input import-card-container-checked-image-download" value="1" {% if($data->params["image_download"]): %} checked="" {% endif %} >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{ translate("tr_3113178731a98c5416fad0167e3aad12") }}</span>
          </label>

          <div class="text-light small fw-medium mb-2 mt-3">{{ translate("tr_c95a1e2de00ee86634e177aecca00aed") }}</div>

          <select name="params[category_id]" class="form-select selectpicker" title="{{ translate("tr_591cca300870eb571563ef4b8c8756ff") }}" >
             <option value="0" selected >{{ translate("tr_9ebfe027b6ca4375b22599cd19ee2eb5") }}</option>
             {{ $template->component->blog_categories->selectedIds($data->params["category_id"])->getRecursionOptions() }}
          </select>

        </form>

      </div>

    </div>

  </div>

  {% endif %}

  <div class="col-12 col-lg-9" >
    
    <div class="card">

      <div class="card-body">

        {% if($data->status == 0): %}
        <div class="text-end" >
          <button class="btn btn-primary waves-effect waves-light buttonStartImport" >{{ translate("tr_ab06c60a274412be6ec56820fee139a3") }}</button>
        </div>
        {% else: %}

          {% if($data->status == 3 || $data->status == 4): %}
          <div class="text-end" >
            <button class="btn btn-primary waves-effect waves-light buttonSaveImport" >{{ translate("tr_74ea58b6a801f0dce4e5d34dbca034dc") }}</button>
          </div>
          {% endif %}

        {% endif %}

        <form class="formFieldsImport mt-4" >
          
          {% foreach($data->fields as $key1 => $value1): %}

            <div class="row mb-2" >
              <div class="col-12 col-md-3" >
                {{ $value1 }}
              </div>
              <div class="col-12 col-md-9" >
                <select name="params[fields][{{ $key1 }}]" class="form-select selectpicker" >
                   <option value="" >{{ translate("tr_591cca300870eb571563ef4b8c8756ff") }}</option>
                   {% foreach($data->document->header as $key2 => $value2): %}

                      <optgroup label="{{ $value2 }}">

                        {% if($data->params["fields"][$key1] == $key2 && $data->params["fields"]): %}
                        <option value="{{ $key2 }}" selected="" >{{ $data->document->values[$key2] }}</option>
                        {% else: %}
                        <option value="{{ $key2 }}" >{{ $data->document->values[$key2] }}</option>
                        {% endif %}
                      
                      </optgroup>

                   {% endforeach; %}
                </select>

                {% if($key1 == "category"): %}
                <div class="alert alert-primary mt-2" role="alert">
                  {{ translate("tr_52ed7bd1113648a15bfc27ef16a41eee") }}
                </div>
                {% endif %}

                {% if($key1 == "image"): %}
                <div class="alert alert-primary mt-2" role="alert">
                  {{ translate("tr_d4ee706dbac89737db0c20c787b5c56f") }}
                </div>
                {% endif %}

                {% if($key1 == "images"): %}
                <div class="alert alert-primary mt-2" role="alert">
                  {{ translate("tr_957dd4dcc60f58753b79ccf1949ce27a") }}
                </div>
                {% endif %}

                {% if($key1 == "filters"): %}
                <div class="alert alert-primary mt-2" role="alert">
                  {{ translate("tr_f0d09a71a66db7cd0ac1e400b6d015f0") }}
                </div>
                {% endif %}

              </div>                    
            </div>

          {% endforeach; %}

          <label class="form-label-error" data-name="fields" ></label>

          <input type="hidden" name="id" value="{{ $data->id }}" >

        </form>        

      </div>

    </div>

  </div>

</div>