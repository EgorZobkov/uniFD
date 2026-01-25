public function outStarsRating($rating=0){

    global $app;

    if(intval($rating)){
        if(intval($rating) == 1){
          return '
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star"></i></span>
                 <span><i class="ti ti-star"></i></span>
                 <span><i class="ti ti-star"></i></span>
                 <span><i class="ti ti-star"></i></span>
          ';
        }elseif(intval($rating) == 2){
          return '
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star"></i></span>
                 <span><i class="ti ti-star"></i></span>
                 <span><i class="ti ti-star"></i></span>
          ';
        }elseif(intval($rating) == 3){
          return '
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star"></i></span>
                 <span><i class="ti ti-star"></i></span>
          ';
        }elseif(intval($rating) == 4){
          return '
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star"></i></span>
          ';            
        }elseif(intval($rating) == 5){
           return '
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
           ';            
        }else{
           return '
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
           ';                
        }
    }else{
        return '
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
       ';
    }

}