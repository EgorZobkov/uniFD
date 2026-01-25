
{% component breadcrumbs.tpl %}

<div class="card">

  <div class="card-body" >

    <div class="row g-4">

      <div class="col-md-3" >
         
        {% component chat/sidebar.tpl %}

      </div>

      <div class="col-md-9" >
        
        <div class="chat-content" >

          <div class="row" >
            
              <div class="col-9" >
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="{{ $template->storage->name($data->user->avatar)->get() }}" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="{{ $template->router->getRoute('dashboard-user-card', [$data->user->id]) }}" class="text-body text-truncate">{{ $data->user->name }}</a>
                  </div>
                </div>
              </div>

              <div class="col-3" >
                
                <div class="text-end" >
                    <div class="uni-dropdown">
                      <span class="uni-dropdown-name"> <div class="chat-dialogue-item-menu" ><i class="ti ti-dots"></i></div> </span>  
                      <div class="uni-dropdown-content uni-dropdown-content-align-right" >
                            <span class="uni-dropdown-content-item actionChatDeleteDialogue" data-id="{{ $data->dialogue_id }}" >{{ translate("tr_035e0bebc32263ca307af8514f5ea23e") }}</span>
                            {% if($template->component->profile->isBlacklist(0, $data->user->id, $data->channel_id)): %}
                            <span class="uni-dropdown-content-item actionChatAddUserToBlacklist" data-id="{{ $data->from_user_id }}" data-channel-id="{{ $data->channel_id }}" >{{ translate("tr_e3d48147853bb99996169256b5eb7cb9") }}</span>
                            {% else: %}
                            <span class="uni-dropdown-content-item actionChatAddUserToBlacklist" data-id="{{ $data->from_user_id }}" data-channel-id="{{ $data->channel_id }}" >{{ translate("tr_35903deefce1704c3623df8a08d9880f") }}</span>
                            {% endif %}
                      </div>               
                    </div>
                </div>

              </div>

          </div>

          <div class="chat-dialogue-items-scroll" >
            <div class="chat-dialogue-items-container chat-content-dialogue-support chat-dialogue-messages-container {% if(!$data->dialogue): %} chat-dialogue-not-messages {% endif; %}" data-token="{{ $data->token }}" >

              {% if($data->dialogue): %}

              {{ $data->dialogue }}

              {% else: %}

                <div class="chat-dialogues-items-empty" >
                  <div class="chat-dialogues-items-empty-icon" >🤭</div>
                  <h4>{{ translate("tr_0c40ace71e3e79f03d6ddfad326729a2") }}</h4>
                </div>              

              {% endif; %}

            </div>
          </div>

        </div>

        <form class="chat-dialogue-form" >

          <div class="chat-dialogue-footer" >
            <div class="chat-dialogue-footer-action-1" >
              <div class="chat-dialogue-footer-action-attach uniAttachFilesChange" data-accept="images" data-upload-route="dashboard-chat-upload-attach" data-parent-container="chat-dialogue-form" ><i class="ti ti-paperclip"></i></div>
            </div>
            <div class="chat-dialogue-footer-action-2" >
              <textarea class="chat-dialogue-footer-action-textarea" name="text" placeholder="{{ translate("tr_ac7a9c51a0e6e1f5bd5ddad4b23badae") }}" ></textarea>
            </div>
            <div class="chat-dialogue-footer-action-3" >
              <div class="chat-dialogue-footer-action-send" ><i class="ti ti-send"></i></div>
            </div>
          </div>
          <div class="uni-attach-files-container" ></div>

          <input type="hidden" name="token" value="{{ $data->token }}" >

        </form>

      </div>

    </div>

  </div>

</div>

{{ $template->ui->tpl('chat/add-channel.tpl')->modal("addChannel", "medium"); }}
{{ $template->ui->tpl('chat/add-responder.tpl')->modal("addResponder", "medium"); }}
{{ $template->ui->tpl('chat/responders.tpl')->modal("chatResponders", "big"); }}
{{ $template->ui->tpl('chat/channels.tpl')->modal("chatChannels", "big"); }}
{{ $template->ui->tpl('chat/blacklist.tpl')->modal("chatBlacklist", "medium"); }}
{{ $template->ui->tpl('chat/automessages.tpl')->modal("chatAutoMessages", "big"); }}