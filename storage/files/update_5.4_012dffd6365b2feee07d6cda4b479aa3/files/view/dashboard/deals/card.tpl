
{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12">

    <div class="card">

      <h4 class="card-header">{{ translate("tr_4f4f8f2300c28c487748885ae8d28945") }}</h4>

      <div class="card-body">

        <div class="row mb-3">
          <div class="col-md-2 col-12">
            <label class="form-label">{{ translate("tr_7203f7a4ff564cb876e8db54c903dbfc") }}</label>      
          </div>
          <div class="col-md-4 col-12">
            <span class="badge rounded-pill bg-label-{{ $template->component->transaction->getStatusDeal($data->status_processing)->label }}">{{ $template->component->transaction->getStatusDeal($data->status_processing)->name }}</span>      
          </div>
        </div>

        {% if($data->status_processing != "completed_order" && $data->status_processing != "cancel_order"): %}
        <div class="row mb-3">
          <div class="col-md-2 col-12">
            <label class="form-label">{{ translate("tr_829460b23fc752dbc614f5fb7563b4b0") }}</label>      
          </div>
          <div class="col-md-4 col-12">
            
            <form class="deal-card-dispute-form" >
            <div>
              <label>{{ translate("tr_9f0d385be737732c9bfa26317acf06f6") }}</label>
              <select class="selectpicker mt-1" name="dispute_solution_code" >
                <option value="" >{{ translate("tr_591cca300870eb571563ef4b8c8756ff") }}</option>
                {% foreach($template->component->transaction->codeSolutionsDisputeDeal() as $value): %}
                <option value="{{ $value['code'] }}" >{{ $value['name'] }}</option>
                {% endforeach %}
              </select>
              <label class="form-label-error" data-name="dispute_solution_code"></label>
            </div>

            <div class="mt-3" >
              <label>{{ translate("tr_8d7ae9e25c2fc07856a1406d06bfd3f4") }}</label>
              <textarea class="form-control mt-1" name="dispute_text" rows="3" ></textarea>
              <small>{{ translate("tr_61c4773460702765659407460d87a29c") }}</small>
            </div>

            <div class="text-end mt-3" >
                <button class="btn btn-primary waves-effect waves-light buttonSaveSolutionDisputeDeal" >{{ translate("tr_74ea58b6a801f0dce4e5d34dbca034dc") }}</button>
            </div>
            <input type="hidden" name="order_id" value="{{ $data->order_id }}" >
            </form>

          </div>
        </div>
        {% endif; %}

        <div class="row">
          <div class="col-md-2 col-12">
            <label class="form-label">{{ translate("tr_63fb7e1ff002d54e99ebf2f1a3df5172") }}</label>          
          </div>
          <div class="col-md-4 col-12">

              <div class="timeline-action">
                 {{ $template->component->transaction->outHistoryDeal($data->order_id) }}
              </div>            
   
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-2 col-12">
            <label class="form-label">{{ translate("tr_3dd4eba5c2fe9ed1f87eb045fd4cc6b3") }}</label>          
          </div>
          <div class="col-md-4 col-12">
            <a href="{{ $template->router->getRoute('dashboard-user-card', [$data->from_user->id]) }}">{{ $template->user->name($data->from_user) }}</a>       
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-2 col-12">
            <label class="form-label">{{ translate("tr_1d3ab78a9af6dabda066e3e9d4d004b0") }}</label>          
          </div>
          <div class="col-md-4 col-12">
            <a href="{{ $template->router->getRoute('dashboard-user-card', [$data->whom_user->id]) }}">{{ $template->user->name($data->whom_user) }}</a>         
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-2 col-12">
            <label class="form-label">{{ translate("tr_dfde1ffd136702faa5d88f9317918b49") }}</label>          
          </div>
          <div class="col-md-4 col-12">
            <div class="transaction-deal-card-items" >
              <div class="transaction-deal-card-items-image" >
                <img src="{{ $data->item->media->images->first }}" class="image-autofocus" >
              </div>
              <div class="transaction-deal-card-items-content" >
                <div><a href="{{ $template->component->ads->buildAliasesAdCard($data->item) }}" >{{ $data->item->title }}</a></div>
                <small>{{ $data->item->count }} {{ translate("tr_01340e1c32e59182483cfaae52f5206f") }} {{ $template->system->amount($data->item->amount) }}</small>
              </div>
            </div>          
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-2 col-12">
            <label class="form-label">{{ translate("tr_cf59ebf9edf7ebe3ece76645abb6de12") }}</label>          
          </div>
          <div class="col-md-4 col-12">
            {{ $template->system->amount($data->amount) }}
          </div>
        </div>

        {% if($data->delivery_amount): %}
        <div class="row mb-3">
          <div class="col-md-2 col-12">
            <label class="form-label">{{ translate("tr_b973ee86903271172c9b4f5529bc19bb") }}</label>          
          </div>
          <div class="col-md-4 col-12">
            {{ $template->system->amount($data->delivery_amount) }}
          </div>
        </div>
        {% endif %}

        <div class="row mb-3">
          <div class="col-md-2 col-12">
            <label class="form-label">{{ translate("tr_f8914a7651f75d84ae6726206d5a3e6e") }}</label>          
          </div>
          <div class="col-md-4 col-12">
             {{ $template->system->amount($template->component->transaction->calculationDealProfit($data->amount,$data->delivery_amount)) }}
          </div>
        </div>

      </div>

    </div>

  </div>

  <div class="col-12">

    <div class="card">

      <h4 class="card-header">{{ translate("tr_8323942df4e9b961854490fc2d90f46f") }}</h4>

      <div class="card-body">

        {% component deals/payments-list.tpl %}

      </div>

    </div>

  </div>

</div>