
{% component breadcrumbs.tpl %}

<div class="card">

  <div class="card-body" >

    <div class="row g-4">

      <div class="col-md-3" >
         
        {% component chat/sidebar.tpl %}

      </div>

      <div class="col-md-9" >
        
        <div class="chat-content" >
          
          <div class="chat-dialogue-items-scroll" >
            <div class="chat-dialogue-items-container chat-content-dialogue-support chat-dialogue-messages-container {% if(!$data->dialogue): %} chat-dialogue-not-messages {% endif; %}" data-channel-id="{{ $data->channel->id }}" >

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

          <input type="hidden" name="channel_id" value="{{ $data->channel->id }}" >

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