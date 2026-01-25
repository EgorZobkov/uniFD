<div class="chat-dialogue-container" >

<div class="chat-dialogue-container-header" >

<div class="btn btn-label-primary waves-effect actionLoadCanvasChat" ><?php echo translate("tr_1789bfb652107358c8cb8902b4bc371f"); ?></div>

</div>

<div class="chat-dialogue-container-content" >
<div class="chat-dialogue-items-container chat-dialogue-messages-container"  data-token="<?php echo $data->token; ?>" >
<?php
	echo $app->component->chat->outMessagesChannel($app->component->chat->getDialogueDashboard($data->id,1), true);
?>
</div>
</div>

<div class="chat-dialogue-container-footer" >
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

	<input type="hidden" name="token" value="<?php echo $data->token; ?>" >

</form>
</div>

</div>