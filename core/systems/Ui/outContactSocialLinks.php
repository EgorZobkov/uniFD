function outContactSocialLinks(){
   global $app;

   $result = '';

   if($app->settings->contact_social_links){
      foreach ($app->settings->contact_social_links as $value) {
        if($value["link"] && $value["image"]){
          $result .= '
             <a class="contact-social-icon" href="'.$value["link"].'" target="_blank" >
               <img src="'.$value["image"].'" >
             </a>
          ';
        }
      }
   }

   return $result;

}