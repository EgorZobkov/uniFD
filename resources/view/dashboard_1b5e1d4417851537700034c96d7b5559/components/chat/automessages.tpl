<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_038a7446d831c37f0fcfebdf4872eb08"); ?></h2>
</div>

<?php

$data = $app->model->chat_automessages->getAll();

if($data){

  ?>

    <form class="formChatAutoMessages" >
      
      <?php
      foreach ($data as $value) {
          ?>

          <div class="mb-3" >
            
            <h4> <strong><?php echo $app->component->chat->getActionCode($value["action"])->name; ?></strong> </h4>
            <textarea class="form-control" rows="4" name="actions[<?php echo $value["id"]; ?>]" ><?php echo translateField($value["text"]); ?></textarea>

          </div>

          <?php
      }
      ?>

      <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
        <button class="btn btn-primary actionSaveEditChatAutoMessages"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
      </div>      

    </form>

  <?php

}

?>
