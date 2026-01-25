public function outShareSocialLinks($id=0){
    global $app;

    $ad = $this->getAd($id);

    $link = urlencode($this->buildAliasesAdCard($ad));

    ?>

    <div class="share-social-list-link" >
        <a href="https://vk.com/share.php?url=<?php echo $link; ?>" target="_blank" > <img src="<?php echo $app->storage->name("social/vk.png")->path('images')->get(); ?>"> <?php echo translate("tr_d235f33b916d3985aefdd3c5589b57b8"); ?></a>
        <a href="https://connect.ok.ru/offer?url=<?php echo $link; ?>" target="_blank" > <img src="<?php echo $app->storage->name("social/ok.png")->path('images')->get(); ?>"> <?php echo translate("tr_ef3f299a1b962975c0981fdec324c86c"); ?></a>   
        <a href="https://t.me/share/url?url=<?php echo $link; ?>" target="_blank" > <img src="<?php echo $app->storage->name("social/tg.png")->path('images')->get(); ?>"> <?php echo translate("tr_c915683f3ec888b8edcc7b06bd1428ec"); ?></a>
        <a href="whatsapp://send?text=<?php echo $link; ?>" target="_blank" > <img src="<?php echo $app->storage->name("social/wa.png")->path('images')->get(); ?>"> <?php echo translate("tr_8b777ebcc5034ce0fe96dd154bcb370e"); ?></a>
        <a href="#" class="copyToClipboard" data-link="<?php echo urldecode($link); ?>" ><?php echo translate("tr_0c15689762ce47e7e3aceac28dbe8d17"); ?></a>
    </div>

    <?php

}