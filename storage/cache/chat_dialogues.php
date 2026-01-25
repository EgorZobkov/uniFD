<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/chat" >Чат</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
    
  </div>

</div>



<div class="nav-align-top mb-4">
  <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
    <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="<?php echo $template->router->getRoute('dashboard-chat'); ?>"><?php echo translate("tr_378f419c63a1401d9be1d3cc87b432bc"); ?></a></li>
    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="<?php echo $template->router->getRoute('dashboard-chat-messages'); ?>"><?php echo translate("tr_8805c192ba830efc195acc12cdceacf0"); ?></a></li>
  </ul>
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

            <div class="chat-content-dialogues-support chat-dialogues-container" >
               <?php echo $data->dialogues; ?>
            </div>

        </div>

        <?php if($template->pagination->totalItems):; ?>
        <div class="mt-4 text-muted" ><?php echo translate("tr_6697cca28b154d276b9b1e9795ac7230"); ?> <strong><?php echo $template->pagination->totalItems; ?></strong>, <?php echo translate("tr_932b3194a5406d1e30c4f7d91d1c161f"); ?> <strong><?php echo $template->pagination->totalPages; ?></strong></div>
        <?php endif;; ?>

        <?php echo $template->pagination->display(); ?>

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