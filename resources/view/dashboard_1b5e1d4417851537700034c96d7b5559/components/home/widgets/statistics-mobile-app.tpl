<?php

$data = $app->api->getStat();

?>
<div class="<?php echo $widget->size_cell; ?> mb-4 home-widget-item" data-id="<?php echo $data->id; ?>" >
  <div class="card h-100">
    <div class="card-body">

      <div class="card-title header-elements">
        <h5 class="m-0 me-2"><?php echo translateField($widget->name); ?></h5>
        <div class="card-title-elements ms-auto">
          <span class="widget-sortable-handle" ><i class="tf-icons ti ti-arrows-maximize ti-sm text-muted"></i></span>
          <div class="dropdown">
            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="ti ti-dots-vertical ti-sm text-muted"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" >
              <span class="dropdown-item cursor-pointer home-widget-item-remove" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_1705d7cb70e0c9d8820e1b03eca70f91"); ?></span>
            </div>
          </div>
        </div>
      </div>

      <div class="row gy-3 mt-3 mb-3">

            <div class="col-md-4 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-primary me-3 p-2">
                  <i class="ti ti-device-mobile-up ti-sm"></i>
                </div>
                <div class="card-info" >
                  <h5 class="mb-0"><?php echo $data->total_install; ?></h5>
                  <small><?php echo translate("tr_48013cdd5314bfd9aa5be12b8315b519"); ?></small>
                  
                </div>
              </div>
            </div>

            <div class="col-md-4 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-primary me-3 p-2">
                  <i class="ti ti-device-mobile-up ti-sm"></i>
                </div>
                <div class="card-info" >
                  <h5 class="mb-0"><?php echo $data->today_install; ?></h5>
                  <small><?php echo translate("tr_b525d150ad3379d5d89d3007a8f91252"); ?></small>
                  
                </div>
              </div>
            </div>

            <div class="col-md-4 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-primary me-3 p-2">
                  <i class="ti ti-wifi ti-sm"></i>
                </div>
                <div class="card-info" >
                  <h5 class="mb-0"><?php echo $data->active_sessions; ?></h5>
                  <small><?php echo translate("tr_07e91169ce477ab956d5ee2bb0a7bfc2"); ?></small>
                  
                </div>
              </div>
            </div>


            <div class="table-responsive">
              <table class="table card-table table-border-top-0 table-border-bottom-0">
                <tbody>

                  <?php if($data->active_sessions_list){

                    foreach ($data->active_sessions_list as $key => $value) {
                        ?>

                        <tr>
                          <td class="w-50 ps-0">
                            <div class="d-flex justify-content-start align-items-center">
                              <div class="me-2">
                                <?php if($value["device_platform"] == "Android"){ ?>
                                  <i class="icon-base ti ti-brand-android ti-sm icon-lg text-heading"></i>
                                <?php }elseif($value["device_platform"] == "iOS"){ ?>
                                  <i class="icon-base ti ti-brand-apple ti-sm icon-lg text-heading"></i>
                                <?php }else{ ?>
                                  <i class="icon-base ti ti-question-mark ti-sm icon-lg text-heading"></i>
                                <?php } ?>
                              </div>
                              <h6 class="mb-0 fw-normal"><?php echo $value["device_model"]; ?></h6>
                            </div>
                          </td>
                          <td class="text-end pe-0 text-nowrap">
                            <a class="mb-0" href="<?php echo $app->geo->linkToIpInfo($value["ip"]); ?>" target="_blank" ><?php echo $value["ip"]; ?></a>
                          </td>                          
                          <td class="text-end pe-0 text-nowrap">
                            <p class="mb-0 badge rounded-pill bg-label-success"><?php echo translate("tr_e10cee7357eeed289838def31bcca4f9"); ?></p>
                          </td>
                        </tr>

                        <?php
                    }

                    ?>

                  <?php } ?>

                </tbody>
              </table>
            </div>

            <div class="pt-1" >
              <a class="btn btn-label-primary waves-effect mt-3" href="<?php echo $app->router->getRoute("dashboard-mobile-app-stat"); ?>"><?php echo translate("tr_09b6a2cd538d40bf35120172499ac025"); ?></a>
            </div>

      </div>

    </div>
  </div>
</div>