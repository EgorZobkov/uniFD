<div class="chat-sidebar" >
  
  <div class="chat-sidebar-list" >

    <div class="btn-group width100p mb-1">
      <button type="button" class="btn btn-primary dropdown-toggle overflow-hidden d-sm-inline-flex d-block text-truncate waves-effect waves-light width100p" data-bs-toggle="dropdown" data-bs-display="static" aria-haspopup="true" aria-expanded="false">
       <?php echo translate("tr_fb3df31bf52df6c142a279ecdb6dd94c"); ?>
      </button>
      <ul class="dropdown-menu width100p">
        <li><button class="dropdown-item openModal" data-modal-id="chatRespondersModal" ><?php echo translate("tr_78e125d034ef547df04c7028517e5848"); ?></button></li>
        <li><button class="dropdown-item openModal" data-modal-id="chatChannelsModal" ><?php echo translate("tr_0c1119c13e4817a1a5ec5bedf23a20c8"); ?></button></li>
        <li><button class="dropdown-item openModal" data-modal-id="chatBlacklistModal" ><?php echo translate("tr_c0795423538f6f5674f82fcc778fed17"); ?></button></li>
        <li><button class="dropdown-item openModal" data-modal-id="chatAutoMessagesModal" ><?php echo translate("tr_038a7446d831c37f0fcfebdf4872eb08"); ?></button></li>
        <li><button class="dropdown-item openModal" data-modal-id="addResponderModal" ><?php echo translate("tr_8606433923deef22f8e78b1e5f245764"); ?></button></li>
        <li><button class="dropdown-item openModal" data-modal-id="addChannelModal" ><?php echo translate("tr_9022eafe2892aaa1b6f6c56457d4b3ed"); ?></button></li>
      </ul>
    </div>

    <div class="d-none d-lg-block" >

    <h5><?php echo translate("tr_0c1119c13e4817a1a5ec5bedf23a20c8"); ?></h5>

    <div class="chat-sidebar-list-channels" >

      {{ $template->component->chat->outChannelsDashboard($data->channel->id) }}

    </div>

    {% if($template->component->chat->getWaitingRespondersDashboard()): %}

    <h5><?php echo translate("tr_a028f0d5d7bf2625af93410a55af6882"); ?></h5>

    <div class="chat-sidebar-list-channels" >

      {{ $template->component->chat->outRespondersDashboard() }}

    </div>

    {% endif; %}
    
    </div>

  </div>

</div>