{% extends index.tpl %}

{% block content %}

<div class="container mt40 mb40" >

    <div class="row" >

      <div class="col-md-12" >

        <h1 class="font-bold" >{{ translate("tr_a1808993eb91e69573b41167cac0fee9") }}</h1>

      </div>

    </div>

    <div class="row" >

      <div class="col-md-7" >

        <form class="review-add-form" >

            <h4 class="font-bold mb30" >{{ translate("tr_7371bf6d57cc3386212661a06d2136b8") }}</h4>

            <div class="review-add-section" >
              <div class="row" >
                <div class="col-md-3" >
                    <h6> <strong>{{ translate("tr_f154d6cc8945d799f4b31ccc1e0019f5") }}</strong> </h6>
                </div>
                <div class="col-md-9" >
                  
                   <a href="{{ $template->component->profile->linkUserCard($data->alias) }}" class="font-bold" >{{ $data->short_name }}</a>

                </div>
              </div>
            </div>

            <div class="review-add-section" >
              <div class="row" >
                <div class="col-md-3" >
                    <h6> <strong>{{ translate("tr_a8017171f9cfb1e5367ef6d7ae6a8e9d") }}</strong> </h6>
                </div>
                <div class="col-md-9" >

                   {% if(!$data->item): %}
                   
                   {% if($data->user_items): %} 

                   <input type="text" class="form-control review-add-items-search" placeholder="{{ translate("tr_ff8ef34ca636fa06f0c6e3f3ceae279a") }}" >

                   <div class="review-add-items-container mt15" >

                      {% foreach ($data->user_items as $item): %}
                      <div class="review-add-item-container" data-id="{{ $item["id"] }}" >
                          <div class="review-add-item-container-box1" >
                             <div class="review-add-item-container-image" >
                                <img src="{{ $template->component->ads->getMedia($item["media"])->images->first }}" class="image-autofocus" >
                             </div>
                          </div>
                          <div class="review-add-item-container-box2" >
                             <span>{{ $item["title"] }}</span>
                             <span>{{ $template->component->ads->outPriceAndCurrency($item) }}</span>
                          </div>
                      </div>
                      {% endforeach %}

                   </div>

                   <input type="hidden" name="item_id" value="0" >

                   {% else: %}

                   <p>{{ translate("tr_abe40b620b33b61056d38cfd4f6e2ff2") }}</p>

                   {% endif %}

                   {% else: %}

                   <div class="review-add-items-container" >

                      <div class="review-add-item-container active" data-id="{{ $data->item->id }}" >
                          <div class="review-add-item-container-box1" >
                             <div class="review-add-item-container-image" >
                                <img src="{{ $data->item->media->images->first; }}" class="image-autofocus" >
                             </div>
                          </div>
                          <div class="review-add-item-container-box2" >
                             <span>{{ $data->item->title }}</span>
                             <span>{{ $template->component->ads->outPriceAndCurrency($data->item) }}</span>
                          </div>
                      </div>

                   </div>

                   <input type="hidden" name="item_id" value="{{ $data->item->id }}" >

                   {% endif %}

                </div>
              </div>
            </div>

            <div class="review-add-section" >
              <div class="row" >
                <div class="col-md-3" >
                    <h6> <strong>{{ translate("tr_45b3763c4a37a067bc796c6987ecc084") }}</strong> </h6>
                </div>
                <div class="col-md-9" >
                  
                   <div class="review-add-change-rating" >
                      <span data-rating="1" ><i class="ti ti-star-filled"></i></span>
                      <span data-rating="2" ><i class="ti ti-star-filled"></i></span>
                      <span data-rating="3" ><i class="ti ti-star-filled"></i></span>
                      <span data-rating="4" ><i class="ti ti-star-filled"></i></span>
                      <span data-rating="5" ><i class="ti ti-star-filled"></i></span>
                   </div>

                   <input type="hidden" name="rating" value="5" >

                </div>
              </div>
            </div>
          
            <div class="review-add-section" >
              <div class="row" >
                <div class="col-md-3" >
                    <h6> <strong>{{ translate("tr_4a3f5e52678242b15f4e65f85ff3345c") }}</strong> </h6>
                </div>
                <div class="col-md-9" >
                    
                    <textarea class="form-control-textarea" name="text" rows="6" placeholder="{{ translate("tr_41e102c828994c4a550429b9356b6938") }}" ></textarea>

                </div>
              </div>
            </div>

            <div class="review-add-section" >
              <div class="row" >
                <div class="col-md-3" >
                    <h6> <strong>{{ translate("tr_2acc8408875b8b1d472f949642ac98fb") }}</strong> </h6>
                </div>
                <div class="col-md-9" >
                    
                    <div class="btn-custom-mini button-color-scheme1 uniAttachFilesChange" data-accept="images" data-upload-route="review-upload-attach" data-parent-container="review-add-form" >{{ translate("tr_5eba283b81890978e67f4aa96dde1724") }}</div>

                    <div class="mb10" ><small>{{ translate("tr_b115d07f1a0d5627e04987e668cdc343") }}</small></div>

                    <div class="uni-attach-files-container" ></div>                    

                </div>
              </div>
            </div>

            {% if($data->order_id): %}
            <input type="hidden" name="order_id" value="{{ $data->order_id }}" >
            {% endif; %}

            <input type="hidden" name="user_id" value="{{ $data->id }}" >
            
            <div class="text-end" >
              <button class="actionAddReview btn-custom button-color-scheme3" >{{ translate("tr_2685ad7c44847a6006d2b2e1d35ac1a2") }}</button>
            </div>

        </form>

        <div class="review-add-success" >
          
          <h4 class="font-bold" >{{ translate("tr_3679d99fdb85fae194c92b745de3bd42") }}</h4>
          <p>{{ translate("tr_bfb5d06a10216433742c54483ad187c4") }}</p>

        </div>

      </div>

    </div>

</div>


{% endblock %}