<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/chat" >Чат</a><span class="text-muted" > / </span>Новости и акции    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
    
  </div>

</div>



<div class="card">

  <div class="card-body" >

    <div class="row g-4">

      <div class="col-md-3" >
         
        <div class="chat-sidebar" >
  
  <div class="chat-sidebar-list" >

    <div class="btn-group width100p mb-1">
      <button type="button" class="btn btn-primary dropdown-toggle overflow-hidden d-sm-inline-flex d-block text-truncate waves-effect waves-light width100p" data-bs-toggle="dropdown" data-bs-display="static" aria-haspopup="true" aria-expanded="false">
       Действия      </button>
      <ul class="dropdown-menu width100p">
        <li><button class="dropdown-item openModal" data-modal-id="chatRespondersModal" >Рассылки</button></li>
        <li><button class="dropdown-item openModal" data-modal-id="chatChannelsModal" >Каналы</button></li>
        <li><button class="dropdown-item openModal" data-modal-id="chatBlacklistModal" >Черный список</button></li>
        <li><button class="dropdown-item openModal" data-modal-id="chatAutoMessagesModal" >Автосообщения</button></li>
        <li><button class="dropdown-item openModal" data-modal-id="addResponderModal" >Создать рассылку</button></li>
        <li><button class="dropdown-item openModal" data-modal-id="addChannelModal" >Создать канал</button></li>
      </ul>
    </div>

    <div class="d-none d-lg-block" >

    <h5>Каналы</h5>

    <div class="chat-sidebar-list-channels" >

      <?php echo $template->component->chat->outChannelsDashboard($data->channel->id); ?>

    </div>

    <?php if($template->component->chat->getWaitingRespondersDashboard()):; ?>

    <h5>Ожидают рассылки</h5>

    <div class="chat-sidebar-list-channels" >

      <?php echo $template->component->chat->outRespondersDashboard(); ?>

    </div>

    <?php endif;; ?>
    
    </div>

  </div>

</div>

      </div>

      <div class="col-md-9" >
        
        <div class="chat-content" >
          
          <div class="chat-dialogue-items-scroll" >
            <div class="chat-dialogue-items-container chat-content-dialogue-support chat-dialogue-messages-container <?php if(!$data->dialogue):; ?> chat-dialogue-not-messages <?php endif;; ?>" data-channel-id="<?php echo $data->channel->id; ?>" >

              <?php if($data->dialogue):; ?>

              <?php echo $data->dialogue; ?>

              <?php else:; ?>

                <div class="chat-dialogues-items-empty" >
                  <div class="chat-dialogues-items-empty-icon" >🤭</div>
                  <h4><?php echo translate("tr_0c40ace71e3e79f03d6ddfad326729a2"); ?></h4>
                </div>              

              <?php endif;; ?>

            </div>
          </div>

        </div>

        <form class="chat-dialogue-form" >

          <div class="chat-dialogue-footer" >
            <div class="chat-dialogue-footer-action-1" >
              <div class="chat-dialogue-footer-action-attach uniAttachFilesChange" data-accept="images" data-upload-route="dashboard-chat-upload-attach" data-parent-container="chat-dialogue-form" ><i class="ti ti-paperclip"></i></div>
            </div>
            <div class="chat-dialogue-footer-action-2" >
              <textarea class="chat-dialogue-footer-action-textarea" name="text" placeholder="<?php echo translate("tr_ac7a9c51a0e6e1f5bd5ddad4b23badae"); ?>" ></textarea>
            </div>
            <div class="chat-dialogue-footer-action-3" >
              <div class="chat-dialogue-footer-action-send" ><i class="ti ti-send"></i></div>
            </div>
          </div>
          <div class="uni-attach-files-container" ></div>

          <input type="hidden" name="channel_id" value="<?php echo $data->channel->id; ?>" >

        </form>

      </div>

    </div>

  </div>

</div>

<?php echo $template->ui->tpl('chat/add-channel.tpl')->modal("addChannel", "medium");; ?>
<?php echo $template->ui->tpl('chat/add-responder.tpl')->modal("addResponder", "medium");; ?>
<?php echo $template->ui->tpl('chat/responders.tpl')->modal("chatResponders", "big");; ?>
<?php echo $template->ui->tpl('chat/channels.tpl')->modal("chatChannels", "big");; ?>
<?php echo $template->ui->tpl('chat/blacklist.tpl')->modal("chatBlacklist", "medium");; ?>
<?php echo $template->ui->tpl('chat/automessages.tpl')->modal("chatAutoMessages", "big");; ?>