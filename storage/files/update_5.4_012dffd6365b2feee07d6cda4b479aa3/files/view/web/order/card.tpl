{% extends index.tpl %}

{% block content %}

<div class="container mt40 mb40" >

    <div class="col-md-12" >
       <div class="mt30" >
           {{ $template->component->ads->outMediaGalleryInCard($data->item, ["height"=>"300px"]) }}
       </div>        
    </div> 

    <small>№{{ $data->order_id }}</small>
    <h1 class="font-bold" >{{ translate("tr_4d406f4dcd44a95252f06163a3cdcb5e") }} {{ $template->datetime->outDate($data->time_create) }} {{ translate("tr_01340e1c32e59182483cfaae52f5206f") }} {{ $template->system->amount($data->amount) }}</h1>

    <div class="row mt40" >
      <div class="col-md-9" >

         <div class="order-card-section" >
           
            <div class="row" >
               <div class="col-md-3" >
                  <label> <strong>{{ translate("tr_7203f7a4ff564cb876e8db54c903dbfc") }}</strong> </label>
               </div>
               <div class="col-md-9" >

                  <div> <strong>{{ $template->component->transaction->getStatusDeal($data->status_processing)->name }}</strong> </div>

                  {{ $template->component->transaction->outActionsOrderDeal($data) }}

               </div>
            </div>

         </div>

         {% if($data->item->category->type_goods == "physical_goods"): %}

         <div class="order-card-section" >
           
            <div class="row" >
               <div class="col-md-3" >
                  <label> <strong>{{ translate("tr_b973ee86903271172c9b4f5529bc19bb") }}</strong> </label>
               </div>
               <div class="col-md-9" >

                  {% if($data->delivery_service_id): %}
                  <div> <strong>{{ $data->delivery_service->name }}</strong> </div>
                  {% else: %}
                  <div> <strong>{{ translate("tr_9f2cbe8833e00db205f337df75228893") }}</strong> </div>
                  {% endif %}

               </div>
            </div>

         </div>

         {% endif %}

         <div class="order-card-section" >
           
            <div class="row" >
               <div class="col-md-3" >
                  <label> <strong>{{ translate("tr_63fb7e1ff002d54e99ebf2f1a3df5172") }}</strong> </label>
               </div>
               <div class="col-md-9" >

                  <div class="timeline-action">
                     {{ $template->component->transaction->outHistoryDeal($data->order_id) }}
                  </div>
              
               </div>
            </div>

         </div>

         {% if($data->from_user_id == $template->user->data->id): %}

         <div class="order-card-section" >
           
            <div class="row" >
               <div class="col-md-3" >
                  <label> <strong>{{ translate("tr_3e3eba1f23da603d68cf7962434fc455") }}</strong> </label>
               </div>
               <div class="col-md-9" >

                  <div class="order-card-section-user" >
                    <div class="order-card-section-user-avatar" >
                      <img src="{{ $template->storage->name($data->whom_user->avatar)->host(true)->get() }}" class="image-autofocus" >
                    </div>
                    <div class="order-card-section-user-name" >
                      {{ $template->user->name($data->whom_user) }}
                    </div>
                  </div>

                  {% if($data->whom_user): %}
                  <button class="btn-custom-mini button-color-scheme1 actionOpenDialogueSendMessage mt15" data-params="{{ $template->component->chat->buildParams(['ad_id'=>$data->item->id, 'whom_user_id'=>$data->whom_user_id]) }}" >{{ translate("tr_014478b5b412ab74b6a95f968d4e413d") }}</button>
                  {% endif %}

               </div>
            </div>

         </div>

         {% endif %}

         {% if($data->whom_user_id == $template->user->data->id): %}

         <div class="order-card-section" >
           
            <div class="row" >
               <div class="col-md-3" >
                  <label> <strong>{{ translate("tr_91a72f953017cf1888e332146adacd83") }}</strong> </label>
               </div>
               <div class="col-md-9" >

                  <div class="order-card-section-user" >
                    <div class="order-card-section-user-avatar" >
                      <img src="{{ $template->storage->name($data->from_user->avatar)->host(true)->get() }}" class="image-autofocus" >
                    </div>
                    <div class="order-card-section-user-name" >
                      {{ $template->user->name($data->from_user) }}
                    </div>
                  </div>

                  {% if($data->from_user): %}
                  <button class="btn-custom-mini button-color-scheme1 actionOpenDialogueSendMessage mt15" data-params="{{ $template->component->chat->buildParams(['ad_id'=>$data->item->id, 'whom_user_id'=>$data->from_user_id]) }}" >{{ translate("tr_014478b5b412ab74b6a95f968d4e413d") }}</button>
                  {% endif %}                  

               </div>
            </div>

         </div>

         {% endif %}

         <div class="order-card-section" >
           
            <div class="row" >
               <div class="col-md-3" >
                  <label> <strong>{{ translate("tr_dfde1ffd136702faa5d88f9317918b49") }}</strong> </label>
               </div>
               <div class="col-md-9" >

                    <div class="order-card-section-items" >
                      <div class="order-card-section-items-image" >
                        <img src="{{ $data->item->media->images->first }}" class="image-autofocus" >
                      </div>
                      <div class="order-card-section-items-content" >
                        <div><a href="{{ $template->component->ads->buildAliasesAdCard($data->item) }}" >{{ $data->item->title }}</a></div>
                        <small>{{ $data->item->count }} {{ translate("tr_01340e1c32e59182483cfaae52f5206f") }} {{ $template->system->amount($data->item->amount) }}</small>
                      </div>
                    </div>                    

               </div>
            </div>

         </div>

         {% if($data->delivery_amount): %}
         <div class="order-card-section" >
           
            <div class="row" >
               <div class="col-md-3" >
                  <label> <strong>{{ translate("tr_b973ee86903271172c9b4f5529bc19bb") }}</strong> </label>
               </div>
               <div class="col-md-9" >

                  {{ $template->system->amount($data->delivery_amount) }}

               </div>
            </div>

         </div>
         {% endif; %}

         <div class="order-card-section" >
           
            <div class="row" >
               <div class="col-md-3" >
                  <label> <strong>{{ translate("tr_ae64471b74a2bd2e2f042844be5fbfe3") }}</strong> </label>
               </div>
               <div class="col-md-9" >

                  {{ $template->system->amount($data->amount) }}

               </div>
            </div>

         </div>

      </div>
    </div>

</div>

{{ $template->ui->tpl('modals/order-deal-confirm-execution-modal.tpl')->modal("execution", "small", $data) }}
{{ $template->ui->tpl('modals/order-deal-confirm-completed-modal.tpl')->modal("completed", "small", $data) }}
{{ $template->ui->tpl('modals/order-deal-dispute-modal.tpl')->modal("dispute", "small", $data) }}
{{ $template->ui->tpl('modals/order-deal-add-payment-score-modal.tpl')->modal("addPaymentScore", "small", $data) }}
{{ $template->ui->tpl('modals/order-deal-cancel-modal.tpl')->modal("cancelOrder", "small", $data) }}

{% endblock %}