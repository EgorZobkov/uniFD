<?php

$notifications = $app->system->outWidgetNotifications();

?>

<div class="<?php echo $widget->size_cell; ?> mb-4 home-widget-item" data-id="<?php echo $data->id; ?>" >
  <div class="card mh-250" >
    <div class="card-body card-widget-gradient-bg2">

      <div class="card-widget-gradient-layer1" >

        <div class="card-title header-elements mb-0 pb-0">
          <div class="card-title-elements ms-auto">
            <span class="widget-sortable-handle" ><i class="tf-icons ti ti-arrows-maximize ti-sm text-white"></i></span>
            <div class="dropdown">
              <button class="btn p-0 text-white" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical ti-sm text-white"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end text-white" >
                <span class="dropdown-item cursor-pointer home-widget-item-remove" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_1705d7cb70e0c9d8820e1b03eca70f91"); ?></span>
              </div>
            </div>
          </div>
        </div>

        <div class="card-widget-slider-container swiper" >

          <div class="swiper-wrapper" >

            <?php
              if($notifications){
                 echo $notifications;
              }else{
                 ?>

                  <div class="card-widget-slider-item swiper-slide" >

                    <h1 class="text-white mb-0 mt-0"> <strong><?php echo translate("tr_cb66543d7971f2f922402594bd106487"); ?></strong> </h1>
                    <p class="text-white mb-0 mt-1" ><?php echo translate("tr_544ffc45f32381819dd014d6231405ae"); ?></p>

                  </div>                 

                 <?php
              }
            ?>

          </div>

        </div>

      </div>

      <div class="swiper-pagination"></div>

      <div class="home-widget-javascript-container" >
      <script type="text/javascript">

        const swiper = document.querySelector('.swiper');

        new Swiper(swiper, {
          slidesPerView: 'auto',
          pagination: {
            clickable: true,
            el: '.swiper-pagination'
          }
        });

      </script>
      </div>

    </div>
  </div>
</div>
