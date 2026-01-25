<div class="chat-dialogue-container" >

<div class="chat-dialogue-container-header" >

<button class="btn-custom-mini button-color-scheme1 actionOpenDialogues mb25" ><i class="ti ti-chevron-left"></i> <?php echo translate("tr_1789bfb652107358c8cb8902b4bc371f"); ?></button>

<div class="row" >
	<div class="col-md-11 order-lg-1 order-2" >
		
		<div class="chat-dialogue-item-card" >
			<div class="chat-dialogue-item-card-image" >
				<img src="<?php echo $app->storage->name($data->channel->image)->path(null)->host(true)->get(); ?>" class="image-autofocus" />
			</div>
			<div class="chat-dialogue-item-card-content" >
				<div class="chat-dialogue-item-card-content-link-user-name" >
					<?php echo translateFieldReplace($data->channel, "name"); ?>
					<p><?php echo translateFieldReplace($data->channel, "text"); ?></p>		
				</div>
			</div>
		</div>

	</div>
	<div class="col-md-1 text-end order-lg-2 order-1" >

		<?php if($data->channel->type != "support"){ ?>
		<div class="uni-dropdown">
          <span class="uni-dropdown-name"> <div class="chat-dialogue-item-menu" ><i class="ti ti-dots"></i></div> </span>  
          <div class="uni-dropdown-content uni-dropdown-content-align-right" >
          		<?php if($app->component->chat->checkChannelDisableNotify($data->channel->id, $app->user->data->id)){ ?>
           			<span class="uni-dropdown-content-item actionChatChannelDisableNotify" data-id="<?php echo $data->channel->id; ?>" ><?php echo translate("tr_d31197c4fee0b3f97578d4fa41be8939"); ?></span>
           		<?php }else{ ?>
           			<span class="uni-dropdown-content-item actionChatChannelDisableNotify" data-id="<?php echo $data->channel->id; ?>" ><?php echo translate("tr_d155d300b3d5e139185b987e1962fd87"); ?></span>
           		<?php } ?>
          </div>               
        </div>
    	<?php } ?>

	</div>
</div>

</div>

<div class="chat-dialogue-container-content" >
<div class="chat-dialogue-items-container <?php if(!$data->messages){ ?>chat-dialogue-not-messages<?php } ?>" >

	<?php
		if($data->messages){
			echo $app->component->chat->outMessagesChannel($data);
		}else{
			?>
			<div class="chat-dialogues-items-empty" >
				<div class="chat-dialogues-items-empty-icon" >🤭</div>
				<h4><?php echo translate("tr_0c40ace71e3e79f03d6ddfad326729a2"); ?></h4>
			</div>
			<?php
		}
	?>

</div>
</div>

<div class="chat-dialogue-container-footer" >
<form class="chat-dialogue-form" >

	<?php if($data->channel->type != "closed"){ ?>

	<?php if(!$app->component->profile->isBlacklist(0, $app->user->data->id, $data->channel->id)){ ?>
	<div class="chat-dialogue-footer" >
		<div class="chat-dialogue-footer-action-1" >
			<div class="chat-dialogue-footer-action-attach uniAttachFilesChange" data-accept="images" data-upload-route="chat-upload-attach" data-parent-container="chat-container" ><i class="ti ti-paperclip"></i></div>
		</div>
		<div class="chat-dialogue-footer-action-2" >
			<textarea class="chat-dialogue-footer-action-textarea" name="text" placeholder="<?php echo translate("tr_ac7a9c51a0e6e1f5bd5ddad4b23badae"); ?>" ></textarea>
		</div>
		<div class="chat-dialogue-footer-action-3" >
			<div class="chat-dialogue-footer-action-send" ><i class="ti ti-send"></i></div>
		</div>
	</div>
	<div class="uni-attach-files-container" ></div>
	<?php }else{ ?>

		<div class="chat-dialogue-footer-blacklist" ><?php echo translate("tr_26203066157b9274815d796d9cec97d7"); ?></div>

	<?php } ?>

	<?php } ?>

	<input type="hidden" name="channel_id" value="<?php echo $data->channel->id; ?>" >

</form>
</div>

</div>