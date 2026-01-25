<div class="col-12" >
  <div class="table-container-item-list" >

    <div class="row" >
      
      <div class="col-lg-3 col-md-3 col-sm-3 col-12" >
          <?php echo $app->user->name($user); ?>
      </div>

      <div class="col-lg-5 col-md-5 col-sm-5 col-12" >
        <strong><?php echo $app->component->profile->getActionCode($value->action_code)->name ?></strong>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-4 col-12" >
        <small><?php echo $app->datetime->outDateTime($value->time_create); ?></small>
      </div>

    </div>

  </div>
</div>