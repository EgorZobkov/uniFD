
{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12">

    <div class="card">

      <form class="formControlFilters" >

      <div class="card-header flex-column flex-md-row">
        <div class="text-end pt-3 pt-md-0">

          <div class="control-filters-container" >

          {% component control-filters-output.tpl %}

          <div class="control-filters-container-item" >
          <div class="btn-group">
              <select class="form-select selectpicker formControlDefaultFilters" name="filter[status]" >
                <option value="" >{{ translate("tr_ac1bbd60d1000d2fb97af5367b2e73d4") }}</option>
                {% foreach($template->component->shop->codeStatuses() as $value): %}
                <option value="{{ $value["code"]; }}" {% if(compareValues($_POST['filter']['status'], $value["code"])){ echo 'selected=""'; } %} >{{ $value["name"]; }}</option>
                {% endforeach %}
              </select>
          </div>
          </div>

          </div>

        </div>
      </div>

      </form>

      {% component shops/list.tpl %}

    </div>

    {% if($template->pagination->totalItems): %}
    <div class="mt-4 text-muted" >{{ translate("tr_6697cca28b154d276b9b1e9795ac7230") }} <strong>{{ $template->pagination->totalItems }}</strong>, {{ translate("tr_932b3194a5406d1e30c4f7d91d1c161f") }} <strong>{{ $template->pagination->totalPages }}</strong></div>
    {% endif; %}

    {{ $template->pagination->display() }}

  </div>
</div>
