public function outLabelsInCatalog($data=[]){
    global $app;

    if($data->service_urgently_status || $data->condition_new_status || $data->booking_status || $data->delivery_status){
    ?>

      <div class="container-item-labels" >
        
        <?php if($data->delivery_status == 1 && $data->user->delivery_status){ ?>
        <div class="container-item-labels-4" ><span><?php echo translate("tr_78b5fee18901ca2645ea512251b8375c"); ?></span></div>
        <?php } ?>

        <?php if($data->service_urgently_status){ ?>
        <div class="container-item-labels-2" ><span><?php echo translate("tr_c85cf9e96515efc35d01f5ead5495666"); ?></span></div>
        <?php } ?>

        <?php
        if($data->booking_status){
            if($data->category->booking_action == "booking"){
                ?>
                <div class="container-item-labels-1" ><span><?php echo translate("tr_18683b0d308a45672c6569209d040ebe"); ?></span></div>
                <?php
            }else{
                ?>
                <div class="container-item-labels-1" ><span><?php echo translate("tr_83e1d0278ef91f7851b947dc73e66491"); ?></span></div>
                <?php
            }
        }
        ?>

        <?php if($data->condition_new_status){ ?>
        <div class="container-item-labels-1" ><span><?php echo translate("tr_963d95509d21446ecc58963ffbc37251"); ?></span></div>
        <?php } ?>

      </div>

    <?php
    }

}