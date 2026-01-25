
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
                <option value="0" {% if(compareValues($_POST['filter']['status'], 0)){ echo 'selected=""'; } %} >{{ translate("tr_13068c40c12a556c1ed7cd182ac6ab87") }}</option>
                <option value="1" {% if(compareValues($_POST['filter']['status'], 1)){ echo 'selected=""'; } %} >{{ translate("tr_59403859f500b33576858acd80863b81") }}</option>
              </select>
          </div>
          </div>

          </div>

        </div>
      </div>

      </form>

      {% component complaints/list.tpl %}

    </div>

    {% if($template->pagination->totalItems): %}
    <div class="mt-4 text-muted" >{{ translate("tr_6697cca28b154d276b9b1e9795ac7230") }} <strong>{{ $template->pagination->totalItems }}</strong>, {{ translate("tr_932b3194a5406d1e30c4f7d91d1c161f") }} <strong>{{ $template->pagination->totalPages }}</strong></div>
    {% endif; %}

    {{ $template->pagination->display() }}

  </div>
</div>
