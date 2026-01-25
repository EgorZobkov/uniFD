public function outTotalReviews($total_reviews=0){
    global $app;
    return $total_reviews . ' ' . endingWord($total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72"));
}