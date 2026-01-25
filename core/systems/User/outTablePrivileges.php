public function outTablePrivileges($user_id=0){
    global $app;

    $codePermissions = $this->codePermissions();

    ob_start();

    $userPrivileges = $user_id ? $this->getPrivileges($user_id) : [];
    $getPrivileges = $app->model->system_privileges->sort("id desc")->getAll();
    if($getPrivileges){
      foreach ($getPrivileges as $key => $privilege) {

        ?>
        <tr>
          <td class="text-nowrap fw-medium"><?php echo translateField($privilege['name']); ?></td>
          <td>
            <div class="d-flex">

              <?php
              foreach (explode(",", $privilege['permissions']) as $permission_key) {
                ?>

                <div class="form-check me-3 me-lg-5 container-all-checkbox">
                  <input class="form-check-input" type="checkbox" <?php if(isset($userPrivileges[$privilege['id']][$permission_key])){ echo 'checked=""'; } ?> name="privileges[<?php echo $privilege['id']; ?>][<?php echo $permission_key; ?>]" value="1" id="user_privilege_<?php echo $permission_key; ?>_<?php echo $privilege['id']; ?>" />
                  <label class="form-check-label" for="user_privilege_<?php echo $permission_key; ?>_<?php echo $privilege['id']; ?>"> <?php echo $codePermissions[$permission_key]["name"]; ?> </label>
                </div>

                <?php
              }
              ?>
              
            </div>
          </td>
        </tr>
        <?php
      }
    }

    return ob_get_clean();

}