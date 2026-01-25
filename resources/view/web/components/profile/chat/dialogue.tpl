<div class="chat-dialogue-container" >

<div class="chat-dialogue-container-header" >

<button class="btn-custom-mini button-color-scheme1 actionOpenDialogues mb25" ><i class="ti ti-chevron-left"></i> <?php echo translate("tr_1789bfb652107358c8cb8902b4bc371f"); ?></button>

<div class="row" >
	<div class="col-md-11 order-lg-1 order-2" >
		
		<?php if($data->ad){ ?>
		<div class="chat-dialogue-item-card" >
			<div class="chat-dialogue-item-card-image" >
				<img src="<?php echo $data->ad->media->images->first; ?>" title="<?php echo $data->ad->title; ?>" class="image-autofocus" />
			</div>
			<div class="chat-dialogue-item-card-content" >
				<a class="chat-dialogue-item-card-content-link-ad" href="<?php echo $app->component->ads->buildAliasesAdCard($data->ad); ?>" target="_blank" ><?php echo $data->ad->title; ?></a>
				<a class="chat-dialogue-item-card-content-link-user" href="<?php echo $app->component->profile->linkUserCard($data->user->alias); ?>" target="_blank" ><?php echo $data->user->name; ?> <?php echo $data->user->surname; ?> <span class="chat-dialogue-item-card-content-status-online-label" ><?php echo $app->user->labelActivity($data->user->time_last_activity); ?></span></a>
			</div>
		</div>
		<?php }else{ ?>
		<div class="chat-dialogue-item-card" >
			<div class="chat-dialogue-item-card-image" >
				<img src="<?php echo $app->storage->name($data->user->avatar)->path(null)->host(true)->get(); ?>" class="image-autofocus" />
			</div>
			<div class="chat-dialogue-item-card-content" >
				<a class="chat-dialogue-item-card-content-link-user-name" href="<?php echo $app->component->profile->linkUserCard($data->user->alias); ?>" target="_blank" ><?php echo $data->user->name; ?> <?php echo $data->user->surname; ?></a>
				<div class="chat-dialogue-item-card-content-status-online" ><?php echo $app->user->labelActivity($data->user->time_last_activity); ?></div>
			</div>
		</div>
		<?php } ?>

	</div>
	<div class="col-md-1 text-end order-lg-2 order-1" >

		<div class="uni-dropdown">
          <span class="uni-dropdown-name"> <div class="chat-dialogue-item-menu" ><i class="ti ti-dots"></i></div> </span>  
          <div class="uni-dropdown-content uni-dropdown-content-align-right" >
           <?php if($app->component->profile->isBlacklist($app->user->data->id, $data->user->id)){ ?>
           	  	<span class="uni-dropdown-content-item actionAddUserToBlacklist" data-id="<?php echo $data->user->id; ?>" ><?php echo translate("tr_e3d48147853bb99996169256b5eb7cb9"); ?></span>
       	   <?php }else{ ?>
       	   		<span class="uni-dropdown-content-item actionAddUserToBlacklist" data-id="<?php echo $data->user->id; ?>" ><?php echo translate("tr_35903deefce1704c3623df8a08d9880f"); ?></span>
       	   <?php } ?>
           <span class="uni-dropdown-content-item actionChatDeleteDialogue" data-id="<?php echo $data->dialogue->id; ?>" ><?php echo translate("tr_76d883219c572c983be4356c1979cf78"); ?></span>
           <?php if($data->ad){ ?>
           	<span class="uni-dropdown-content-item actionChatRequestReview" data-id="<?php echo $data->dialogue->id; ?>" ><?php echo translate("tr_b4bc9d9949f4294be66eed2f21a187e4"); ?></span>
           <?php } ?>
          </div>               
        </div>

	</div>
</div>
</div>

<div class="chat-dialogue-container-content" >
<div class="chat-dialogue-items-container <?php if(!$data->messages){ ?>chat-dialogue-not-messages<?php } ?>" >

	<?php
		if($data->messages){
			echo $app->component->chat->outMessages($data);
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

	<?php if(!$app->component->profile->isBlacklistСross($app->user->data->id, $data->user->id)){ ?>
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

	<input type="hidden" name="token" value="<?php echo $data->token; ?>" >

</form>
</div>

</div>