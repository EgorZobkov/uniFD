
{% component breadcrumbs.tpl %}

{% component users/sections.tpl %}

<div class="row">

<div class="col-xl-3 col-lg-3 col-md-3 col-12">
  
    <div class="d-flex align-items-start align-items-sm-center gap-6 mb-4">

      <div class="me-3" >
        <div class="avatar-size-1 inline-block" >
          <img class="rounded-circle image-autofocus" src="{{ $data->avatar_src }}" />
        </div>
      </div>

      <div class="button-wrapper">
        <h4 class="mb-1 mt-1">{{ $data->name }} {{ $data->surname }}</h4>
        <small>{{ $data->label_activity }}</small>

        <h5 class="mb-2 mt-2" ><strong>{{ $data->balance_by_currency }}</strong> <button class="btn btn-sm rounded-pill btn-icon btn-secondary waves-effect ms-2 waves-light" data-bs-target="#balanceEditModal" data-bs-toggle="modal" ><i class="ti ti-pencil"></i></button></h5>
        
      </div>

    </div>

    {% if($template->user->setUserId($data->id)->verificationAccess('control')->status): %}
      <div class="d-grid gap-2 mb-3" >

        <div class="btn-group">
          <button type="button" class="btn btn-primary dropdown-toggle overflow-hidden d-sm-inline-flex d-block text-truncate waves-effect waves-light width100p" data-bs-toggle="dropdown" data-bs-display="static" aria-haspopup="true" aria-expanded="false">
            {{ translate("tr_fb3df31bf52df6c142a279ecdb6dd94c") }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start width100p">
            <li><button class="dropdown-item loadEditUser" data-id="{{ $data->id }}" >{{ translate("tr_1706282c5244c8e988f76c5eb939b754") }}</button></li>
            <li><button class="dropdown-item authProfileUser" data-id="{{ $data->id }}" >{{ translate("tr_5df19588f4fb8e2b563c38212acc75d3") }}</button></li>
            {% if($data->id != $template->user->data->id): %}
            <li><button class="dropdown-item" data-bs-target="#userChatMessageModal" data-bs-toggle="modal" >{{ translate("tr_d257199de205608325f279ed7eff0785") }}</button></li>
            <li><button class="dropdown-item deleteUser" data-id="{{ $data->id }}" >{{ translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8") }}</button></li>
            {% endif; %}
          </ul>
        </div>

      </div>
    {% endif; %}

</div>

<div class="col-xl-9 col-lg-9 col-md-9 col-12">
  
  <div class="card mb-4">

    <h4 class="card-header">{{ translate("tr_34defb936a2ee53748ada5e0f321daf1") }}</h4>

    <div class="card-body">

      <div class="row" >
        <div class="col-lg-6 col-12 mb-3" >
          <label class="form-label label-bold">{{ translate("tr_7203f7a4ff564cb876e8db54c903dbfc") }}</label>
          <div>
            <span class="badge rounded-pill bg-label-{{ $data->status_label }}">{{ $data->status_name }}</span>
          </div>      

          {% if($data->reason_blocking): %}

          <div class="mb-2 mt-1">

            {% if($data->time_expiration_blocking): %}

              {{ translate("tr_1d05fd75df267dbcc432b2b7de4aa9f3") }} {{ $template->datetime->outDateTime($data->time_expiration_blocking) }}. {{ translate("tr_ce28b881ebd7df5f6f26f319aeb91a30") }} {{ $template->system->getReasonBlocking($data->reason_blocking_code)->text }}

            {% else: %}

              {{ translate("tr_ce28b881ebd7df5f6f26f319aeb91a30") }} {{ $template->system->getReasonBlocking($data->reason_blocking_code)->text }}

            {% endif %}

          </div>

          {% endif; %}

        </div>
        <div class="col-lg-6 col-12 mb-3" >
          <label class="form-label label-bold">{{ translate("tr_c7cadea1c393b4b40ed898d48f10c1b0") }}</label>
          <div>

            <div class="btn-group">
              <button class="btn btn-primary btn-sm dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              {% if($data->verification_status): %}
                {{ translate("tr_69132bec5be1a0571e264390fa310daa") }}
              {% else: %}
                {{ translate("tr_7470754707b1b6da2074c549ffe3691e") }}
              {% endif %}
              </button>
              <ul class="dropdown-menu" style="">
                <li><a class="dropdown-item actionUserChangeStatusVerification" href="#" data-id="{{ $data->id }}" data-status="1" >{{ translate("tr_e375ded5a165d2d2afa2c1dd12f8076f") }}</a></li>
                <li><a class="dropdown-item actionUserChangeStatusVerification" href="#" data-id="{{ $data->id }}" data-status="0" >{{ translate("tr_eb0d2fdc9ec16187d2770752d3a060cd") }}</a></li>
              </ul>
            </div>

          </div>          
        </div>
      </div>

      <div class="row" >
        <div class="col-lg-6 col-12 mb-3" >
          <label class="form-label label-bold">{{ translate("tr_d38d6d925c80a2267031f3f03d0a9070") }}</label>
          <div>{{ $data->name }}</div>          
        </div>
        <div class="col-lg-6 col-12 mb-3" >
          <label class="form-label label-bold">{{ translate("tr_a7b7df8362d60258a7208dde0a392643") }}</label>
          <div>{{ $data->surname ?: '-' }}</div>          
        </div>
      </div>

      <div class="row" >
        <div class="col-lg-6 col-12 mb-3" >
          <label class="form-label label-bold">{{ translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d") }}</label>
          <div>{{ $data->email ?: '-' }}</div>          
        </div>
        <div class="col-lg-6 col-12" >
          <label class="form-label label-bold">{{ translate("tr_2928e19c705428df3c9f1e6d4ea8042f") }}</label>
          <div>{{ $data->phone ?: '-' }}</div>          
        </div>
      </div>

    </div>

  </div>

  <div class="card mb-4">

    <h4 class="card-header">{{ translate("tr_bb76e5cb4e3a351b40252adcba1d62d2") }}</h4>

    <div class="card-body">

      {% if($data->service_tariff): %}

      <div class="row" >
        <div class="col-lg-6 col-12 mb-3" >
          <label class="form-label label-bold">{{ translate("tr_c1019eb5872cd3edd615a45bf988c46a") }}</label>
          <div>
            <span>{{ $data->service_tariff->data->name }}</span>
          </div>      
        </div>
        <div class="col-lg-6 col-12 mb-3" >
          <label class="form-label label-bold">{{ translate("tr_5192bdb7a058b0b2f9272d8696050d12") }}</label>
          <div>

            {% if($data->service_tariff->expiration_status): %}
              {{ $template->datetime->outDateTime($data->service_tariff->time_expiration) }}
            {% else: %}
            <span class="badge rounded-pill bg-label-danger">{{ translate("tr_17de549418a3c05ceb11239adee121a8") }}</span>
            {% endif %}

          </div>          
        </div>
      </div>

      <button class="btn btn-label-primary waves-effect waves-light mt-3 actionUserDeleteTariff" data-user-id="{{ $data->id }}" >{{ translate("tr_02bb111718d1ad7d36ef7100f83218f2") }}</button>

      {% else: %}

        <div class="wrapper-alert-no-data" >

          <div class="alert alert-primary d-flex align-items-center" role="alert">
            <span class="alert-icon text-primary me-2">
              <i class="ti ti-info-circle ti-xs"></i>
            </span>
            {{ translate("tr_adcf6aa3c258655bb21644bbb7a84036") }}
          </div>

        </div>

      {% endif %}

    </div>

  </div>

  <div class="card">

    <h4 class="card-header">{{ translate("tr_03352dc0e4eb3b221ae93ff088b5d206") }}</h4>

    <div class="card-body">

      <div class="row" >
        <div class="col-lg-6 col-12 mb-3" >
          <label class="form-label label-bold">{{ translate("tr_52855c0d3d8fa31b2e92c54be60d981e") }}</label>
          <div>{{ $template->datetime->outDate($data->time_create); }}</div>          
        </div>
        <div class="col-lg-6 col-12 mb-3" >
          <label class="form-label label-bold">{{ translate("tr_e0d5746f219655b72a81aa81a97361c7") }}</label>
          <div>{{ $template->datetime->outDate($data->time_last_activity); }}</div>          
        </div>
      </div>

      <div class="row" >
        <div class="col-lg-6 col-12" >
          <label class="form-label label-bold">{{ translate("tr_a12a3079e14ced46e69ba52b8a90b21a") }}</label>
          <div><a href="{{ $template->geo->linkToIpInfo($data->last_auth_data->ip); }}" target="_blank" >{{ $data->last_auth_data->ip ?: '-'; }}</a></div>          
        </div>
      </div>

    </div>

  </div>

  {% if($data->admin && ($template->user->data->role->chief || $data->id == $template->user->data->id)): %}
  <div class="card mt-4">

    <h4 class="card-header">{{ translate("tr_d2ed721d0c08f9f114598a084f24c784") }}</h4>

    <div class="card-body">

        <form class="userNotificationsForm" >

        <div class="row" >

        {% if($template->user->data->role->chief): %}
        <div class="col-12 mb-3">
          <label class="form-label label-bold" >{{ translate("tr_3e8cc7e5d096efe0b2fd75dad064b4db") }}</label>
          
          <div class="row" >
            <div class="col-6" >

                <select class="form-select selectpicker" name="notifications_list[]" multiple title="{{ translate("tr_591cca300870eb571563ef4b8c8756ff") }}" >
                    {{ $template->component->settings->getSystemNotifyList($data->id) }}
                </select>

            </div>
          </div> 

        </div>
        {% endif %}         

        {% if($data->id == $template->user->data->id): %}

        <div class="col-12 mb-3">
          <label class="form-label label-bold" >{{ translate("tr_b60bd4b1991e5ee1337ca6a6b8244a0a") }}</label>
          
          <div class="row" >
            <div class="col-6" >

                <select class="form-select selectpicker" name="notifications_method" >
                   <option value="email" {% if($data->notifications_method == "email"){ echo 'selected=""'; } %} >{{ translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d") }}</option> 
                   <option value="telegram" {% if($data->notifications_method == "telegram"){ echo 'selected=""'; } %} >{{ translate("tr_c915683f3ec888b8edcc7b06bd1428ec") }}</option> 
                </select>

            </div>
          </div> 

        </div>

        <div class="col-12" >
          <label class="form-label label-bold" >Telegram bot</label>
            {% if(!$data->messenger_token_id): %}
            <div>
            <a class="btn btn-primary" href="{{ outUserLinkTelegramBot($data->uniq_hash) }}" target="_blank" >{{ translate("tr_539327ce0420a5d3732b9f926abc1cb3") }}</a>  
            <div class="mt-2"> <small>{{ translate("tr_2cef0f08cd8777fcc23e8f09f0c439fa") }}</small> </div>  
            </div>
            {% else: %}
            <div> <small>{{ translate("tr_4da8762bc221c744cf34a55ceaf7a582") }}</small> </div> 
            {% endif %}     
        </div>

        {% endif %} 

        </div>

        <button class="btn btn-label-primary waves-effect waves-light mt-4 actionUserNotificationsSave" >{{ translate("tr_74ea58b6a801f0dce4e5d34dbca034dc") }}</button>

        <input type="hidden" name="id" value="{{ $data->id }}" >

        </form>

    </div>

  </div>
  {% endif %}

  {% if($data->id == $template->user->data->id && $data->role_id): %}

  <div class="card mt-4">

    <h4 class="card-header">{{ translate("tr_4d78efde5fff1c1644f0a2e4fe468919") }}</h4>

    <div class="card-body" >
      
      {% component users/access-key.tpl %}

    </div>

  </div>

  {% endif; %}

</div>

</div>

{{ $template->ui->tpl('users/balance-edit.tpl')->modal("balanceEdit", "small", $data); }}
{{ $template->ui->tpl('users/chat-message.tpl')->modal("userChatMessage", "medium", $data); }}