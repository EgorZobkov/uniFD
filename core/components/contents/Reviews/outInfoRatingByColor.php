public function outInfoRatingByColor($ad=[]){
    global $app;

    if(round($ad->total_rating, 1) >= 4.0){
        return '<div class="label-info-rating-by-color color-rating-green" ><span>'.sprintf("%.1f", $ad->total_rating).'</span> '.$ad->total_reviews.' '.endingWord($ad->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72")).'</div>';
    }
    
    if(round($ad->total_rating, 1) >= 3.0 && round($ad->total_rating, 1) < 4.0){
        return '<div class="label-info-rating-by-color color-rating-yellow" ><span>'.sprintf("%.1f", $ad->total_rating).'</span> '.$ad->total_reviews.' '.endingWord($ad->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72")).'</div>';
    }

    return '<div class="label-info-rating-by-color color-rating-gray" ><span>'.sprintf("%.1f", $ad->total_rating).'</span> '.$ad->total_reviews.' '.endingWord($ad->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72")).'</div>';

}