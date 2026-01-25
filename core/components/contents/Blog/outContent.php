public function outContent($data=[]){
    global $app;

    if($data->content){

        foreach (_json_decode(translateFieldReplace($data, "content")) as $key => $nested) {
            foreach ($nested as $type => $value) { 
                
                if($type == "image"){

                    ?>
                    <section class="blog-content-image" >
                        <div>
                            <img src="<?php echo $app->storage->name($value)->host(true)->get(); ?>" alt="<?php echo translateFieldReplace($data, "title"); ?>" >
                        </div>
                    </section>
                    <?php

                }elseif($type == "link_video"){

                    $video = $app->video->parseLinkSource($value);

                    if($video){
                        ?>
                        <section class="blog-content-iframe" >
                            <div>
                             <iframe
                                src="<?php echo $video->link; ?>"
                                allowfullscreen
                                allowtransparency
                              ></iframe> 
                            </div>                       
                        </section>
                        <?php
                    }else{
                        ?>
                        <section class="blog-content-iframe" >
                            <div>
                            <video class="blog-post-plyr-video" playsinline controls >
                             <iframe
                                src="<?php echo $value; ?>"
                                allowfullscreen
                                allowtransparency
                              ></iframe>
                            </video>  
                            </div>                      
                        </section>
                        <?php                            
                    }
                    
                }elseif($type == "text"){

                    ?>
                    <section class="blog-content-text" >
                    <p><?php echo outTextWithLinks(urldecode($value), false); ?></p>
                    </section>
                    <?php
                    
                }elseif($type == "code"){
                    
                    ?>
                    <section class="blog-content-code-text" >
                    <?php echo $value; ?>
                    </section>
                    <?php

                }elseif($type == "separator"){
                    
                    ?>
                    <section class="blog-content-separator" >
                    <hr>
                    </section>
                    <?php

                }

            }
        }

    }

}