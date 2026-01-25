{% extends index.tpl %}

{% block content %}

<div class="container mt40 mb40" >

    <div class="col-md-12" >
       <div class="mt30" >
           {{ $template->component->ads->outMediaGalleryInCard($data->item, ["height"=>"300px"]) }}
       </div>        
    </div>   

    <small>№{{ $data->order_id }}</small>
    <h1 class="font-bold" >{{ translate("tr_4d406f4dcd44a95252f06163a3cdcb5e") }} {{ $template->datetime->outDate($data->time_create) }}</h1>

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
                  <label> <strong>{{ translate("tr_96c68f4083b6f23961a53250941f6a1c") }}</strong> </label>
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
                  <label> <strong>{{ translate("tr_4af22f2d58c928ab7557d204d2459eb6") }}</strong> </label>
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

         <div class="order-card-section" >
           
            <div class="row" >
               <div class="col-md-3" >
                  <label> <strong>{{ translate("tr_9ee2770f56339d2fdc2357f2a2abacd9") }}</strong> </label>
               </div>
               <div class="col-md-9" >

                  <div>{{ translate("tr_f7419ccccc13a330eecb14a7d7b6d675") }} {{ $data->order->user_name }}</div>   
                  <div>{{ translate("tr_810fa9fb8a48cfad858a8d2742387770") }} {{ decrypt($data->order->user_phone) }}</div>   
                  <div>{{ translate("tr_6a1e265f92087bb6dd18194833fe946b") }} {{ decrypt($data->order->user_email) }}</div>

               </div>
            </div>

         </div>

         {% endif %}

         <div class="order-card-section" >
           
            <div class="row" >
               <div class="col-md-3" >
                  <label> <strong>{{ translate("tr_a8017171f9cfb1e5367ef6d7ae6a8e9d") }}</strong> </label>
               </div>
               <div class="col-md-9" >

                    <div class="order-card-section-items" >
                      <div class="order-card-section-items-image" >
                        <img src="{{ $data->item->media->images->first }}" class="image-autofocus" >
                      </div>
                      <div class="order-card-section-items-content" >
                        <div><a href="{{ $template->component->ads->buildAliasesAdCard($data->item) }}" >{{ $data->item->title }}</a></div>
                        <small>{{ $template->component->ads->outGeoAndAddressInAdCard($data->item) }}</small>
                      </div>
                    </div>                    

               </div>
            </div>

         </div>

         <div class="order-card-section" >
           
            <div class="row" >
               <div class="col-md-3" >
                  <label> <strong>{{ translate("tr_59dca952c1aa04c36bda1938ffca1856") }}</strong> </label>
               </div>
               <div class="col-md-9" >
                   
                     <div>{{ translate("tr_4349d50a7e0c914c88a510fbf86b3640") }} {{ $template->datetime->outDateTime($data->order->date_start) }} - {{ $template->datetime->outDateTime($data->order->date_end) }}</div>    
                     {% if($data->order->count_guests): %}  
                     <div>{{ translate("tr_1f43b67dab14730eb12ca7147dff5990") }} {{ $data->order->count_guests }}</div>
                     {% endif %}

               </div>
            </div>

         </div>

         {% if($data->order->additional_services): %}
         <div class="order-card-section" >
           
            <div class="row" >
               <div class="col-md-3" >
                  <label> <strong>{{ translate("tr_2f65331185abdf3f4a7ac9f810ebbcb2") }}</strong> </label>
               </div>
               <div class="col-md-9" >

                    {{ $template->component->ads->outBookingAdditionalServicesInCard($data) }}             

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

                  {{ $template->system->amount($data->order->amount) }}

                  {% if(!$data->item->booking->full_payment_status): %}

                  <div>{{ translate("tr_f1d0076b2267f5559b482d28106b33a1") }} {{ $template->system->amount($data->amount) }}</div>

                  {% if($data->item->booking->deposit_status): %}
                  <div>{{ translate("tr_c7bb13829f0c52a28e01bedd29bdfe0d") }} {{ $template->system->amount($data->item->booking->deposit_amount) }}</div>
                  {% endif; %}

                  <div>{{ translate("tr_9a6054b1258786529c4dd909ec032383") }} <strong>{{ $template->system->amount($data->order->amount-$data->amount) }}</strong> </div>

                  {% endif %}

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