<div class="chat-dialogues-container" >

<h3 class="mb15" > <strong><?php echo translate("tr_378f419c63a1401d9be1d3cc87b432bc"); ?></strong> </h3>

<div class="chat-dialogues-items" >

<?php

	if($data->dialogues || $data->channels){
		echo $app->component->chat->outChannels($data->channels);
		echo $app->component->chat->outDialogues($data->dialogues);
	}else{
		?>
		<div class="chat-dialogues-items-empty" >
			<h1>🤭</h1>
			<h4><?php echo translate("tr_968488faec375288c4e05f1f5b3e72e5"); ?></h4>
		</div>
		<?php
	}
?>

</div>

</div>
