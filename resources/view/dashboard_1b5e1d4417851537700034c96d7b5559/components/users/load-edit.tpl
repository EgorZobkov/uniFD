<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_1167e787a81a5549bc895f4c61dcba4b"); ?></h2>
</div>

<form class="formEditUser" >

  <div class="row g-3" >

  <?php if($app->user->data->id != $data->id){ ?>
  <div class="col-12">
      
      <label class="form-label label-bold" ><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></label>
      <select class="form-select select-status-user selectpicker" name="status" >
        <?php echo $app->component->users->outAllStatusesOptions($data->status); ?>
      </select>

  </div>
  <div class="container-change-reason-blocking" <?php if($data->status == 2){ echo 'style="display: block;"'; } ?> >
    <div class="col-12">
      <label class="form-label label-bold" ><?php echo translate("tr_85b385928b60d0bbb6c9ac74f5c6ac56"); ?><span class="form-label-importantly" >*</span></label>
      <select class="form-select select-change-reason-blocking selectpicker" name="reason_blocking_code" >

          <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
          <?php
          foreach ($app->system->getAllReasonsBlocking() as $value){
            if(compareValues($data->reason_blocking_code, $value["code"])){
              ?>
              <option value="<?php echo $value["code"]; ?>" selected="" ><?php echo $value["name"]; ?></option>
              <?php
            }else{
              ?>
              <option value="<?php echo $value["code"]; ?>" ><?php echo $value["name"]; ?></option>
              <?php
            }
          }
          ?>
          <option value="other" ><?php echo translate("tr_15291f4233174b813811b7489b48c712"); ?></option>

      </select>
      <label class="form-label-error" data-name="reason_blocking_code" ></label>
    </div>
    <div class="col-12 mt-3">
      <label class="form-label label-bold" ><?php echo translate("tr_ed49a0edfed3c17ccac8905b3242b673"); ?></label>
      
      <select class="form-select selectpicker" name="time_blocking" >

          <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
          <option value="forever" ><?php echo translate("tr_b2eda1939786d3a007ed81f9ac650b9f"); ?></option>
          <option value="1" ><?php echo translate("tr_b56e1c416ceda0816a0f2242c5aa1528"); ?></option>
          <option value="2" ><?php echo translate("tr_dee6518a9ce26c73b1e9cfa9c5001ff4"); ?></option>
          <option value="3" ><?php echo translate("tr_53321abe1e8d9146ff5412b8599e9220"); ?></option>
          <option value="6" ><?php echo translate("tr_6bb5398c677c4482b4bfe96c5640db2b"); ?></option>
          <option value="12" ><?php echo translate("tr_2053630d5a4d483dde84b1e56d8ee183"); ?></option>
          <option value="24" ><?php echo translate("tr_cf9000d173bd118b08eb01e92b351e87"); ?></option>
          <option value="168" ><?php echo translate("tr_7ae3b8d7a17bcceae3c6c345fea0f5b6"); ?></option>
          <option value="336" ><?php echo translate("tr_8562f1a21a279ce635c983dc2610a833"); ?></option>
          <option value="720" ><?php echo translate("tr_2d54fa570eb4c0b652fb3f24f68226ae"); ?></option>

      </select>
      <label class="form-label-error" data-name="time_blocking" ></label>

    </div>
    <div class="container-comment-reason-blocking mt-3" >
      <div class="col-12">
        <label class="form-label label-bold" ><?php echo translate("tr_d8ef4d305370a3d4416ce85a4d8791d8"); ?><span class="form-label-importantly" >*</span></label>
        
        <textarea class="form-control" name="reason_blocking_comment" ></textarea>
        <label class="form-label-error" data-name="reason_blocking_comment" ></label>
        
      </div>
    </div>
  </div>
  <div class="col-12">
    <label class="form-label label-bold" ><?php echo translate("tr_5d621b760a9bc521f627c5fb49bb5c45"); ?></label>
    <select class="form-select select-role-user selectpicker" name="role_id" >
      <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
      <?php echo $app->component->users->outAllRolesOptions($data->role_id); ?>
    </select>
    <label class="form-label-error" data-name="role_id" ></label>
  </div>
  <?php } ?>
  <div class="col-12">
    <label class="form-label label-bold" ><?php echo translate("tr_db65551f5f17de36a67766ab127f925d"); ?> </label>
    <?php echo $app->ui->managerFiles(["filename"=>$data->avatar, "type"=>"images", "path"=>"user-avatar"]); ?>
    <label class="form-label-error" data-name="avatar" ></label>
  </div>
  <div class="col-6">
    <label class="form-label label-bold" ><?php echo translate("tr_d38d6d925c80a2267031f3f03d0a9070"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" value="<?php echo $data->name; ?>" />
    <label class="form-label-error" data-name="name" ></label>
  </div>
  <div class="col-6">
    <label class="form-label label-bold" ><?php echo translate("tr_a7b7df8362d60258a7208dde0a392643"); ?></label>
    <input type="text" name="surname" class="form-control" value="<?php echo $data->surname; ?>" />
  </div>
  <div class="col-6">
    <label class="form-label label-bold" ><?php echo translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d"); ?></label>
    <input type="text" name="email" class="form-control" value="<?php echo $data->email; ?>" />
    <label class="form-label-error" data-name="email" ></label>
  </div>
  <div class="col-6">
    <label class="form-label label-bold" ><?php echo translate("tr_2928e19c705428df3c9f1e6d4ea8042f"); ?></label>
    <input type="text" name="phone" class="form-control" value="<?php echo $data->phone; ?>" />
    <label class="form-label-error" data-name="phone" ></label>
  </div>
  <div class="col-6">
    <label class="form-label label-bold" ><?php echo translate("tr_5ebe553e01799a927b1d045924bbd4fd"); ?><span class="form-label-importantly" >*</span></label>

    <div class="input-group input-group-merge">
      <input type="text" class="form-control input-generate-password" name="password" >
      <span class="input-group-text cursor-pointer action-generate-password" ><i class="ti ti-key"></i></span>
    </div>
    <label class="form-label-error" data-name="password" ></label>

  </div>

  <div class="container-privileges-user" <?php if($app->user->data->id != $data->id && !$app->user->getRole($data->role_id)->chief && $data->role_id){ echo 'style="display: block;"'; } ?> >
    <div class="col-12">

      <div class="table-responsive">
        <table class="table table-flush-spacing">
          <tbody>
            <tr>
              <td class="text-nowrap fw-medium">
               <?php echo translate("tr_68edc00df5b0afac454087e586d885f3"); ?>
              </td>
              <td>
                <div class="form-check">
                  <input class="form-check-input select-all-checkbox" type="checkbox" id="edit-admin-select-all-checkbox" />
                  <label class="form-check-label" for="edit-admin-select-all-checkbox"> <?php echo translate("tr_4d09821e5f0ae6b496ac3211da10f88b"); ?> </label>
                </div>
              </td>
            </tr>

            <?php echo $app->user->outTablePrivileges($data->id); ?>

          </tbody>
        </table>
        <label class="form-label-error" data-name="privileges" ></label>
      </div>

    </div>
  </div>

  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >

  </div>

  <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
  <button class="btn btn-primary buttonSaveEditUser"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
  </div>

</form>
