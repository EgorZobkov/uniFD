{% extends index.tpl %}

    {% block content %}

    <div class="container" >

        <div class="row mt50" >
            
            <div class="col-lg-7" >
                
                <div class="promo-business-header-container-title" >
                    <h1 class="font-bold">{{ $seo->h1 }}</h1>
                    <h3>{{ $seo->h3 }}</h3>
                </div>

                <div class="promo-business-header-container-list" >
                    <div>
                        <i class="ti ti-check"></i> {{ translate("tr_f0bd0d6690c7b2f248da5b3d200a8b15") }}
                    </div>
                    <div>
                        <i class="ti ti-check"></i> {{ translate("tr_1500778e85780ef95129e8e0f1a48907") }}
                    </div>
                    <div>
                        <i class="ti ti-check"></i> {{ translate("tr_3677ee79e51454e8da26eb578c6c4e5c") }}
                    </div>
                </div>

            </div>

            <div class="col-lg-5 text-center" >
                <img src="{{ $template->storage->getAssetImage("9693091-promo-secure.webp") }}" height="350" >
            </div>

        </div>

        <h1 class="font-bold text-center mt100">{{ translate("tr_aecbc683d9b6bd5f03aaad30baeabc60") }}</h1>

        <section class="mt50">

        <div class="row" >
            
            <div class="col-lg-7" >
                
                <div class="promo-business-section-container-title" >
                    <h2>{{ translate("tr_3c27df9663315d0ef2b73d71ff529cea") }}</h2>
                    <p>{{ translate("tr_c0c96408d1911c5c3b258bae6f23be72") }}</p>
                    <a class="btn-custom button-color-scheme1 mt15" href="{{ $template->component->catalog->currentAliases() }}">{{ translate("tr_eb557c3195702637b89955607c188486") }}</a>
                </div>

            </div>

            <div class="col-lg-5 text-center" >
                <img src="{{ $template->storage->getAssetImage("9693091-promo-goods-1.webp") }}" height="200" >
            </div>

        </div>            

        </section>

        <section class="mt50">

        <div class="row" >
            
            <div class="col-lg-7" >
                
                <div class="promo-business-section-container-title" >
                    <h2>{{ translate("tr_a1ab06d4236be75417e5eefdf70ce3a1") }}</h2>
                    <p>{{ translate("tr_75a6413bfa0aa732c66d5f512f930bc9") }}</p>
                </div>

            </div>

            <div class="col-lg-5 text-center" >
                <img src="{{ $template->storage->getAssetImage("9693091-promo-delivery-1.png") }}" height="150" >
            </div>

        </div>            

        </section>

        <section class="mt50" >

        <div class="row" >
            
            <div class="col-lg-7" >
                
                <div class="promo-business-section-container-title" >
                    <h2>{{ translate("tr_4a3f5e52678242b15f4e65f85ff3345c") }}</h2>
                    <p>{{ translate("tr_dbabea657dae6c7bf576aeb75514c5dd") }}</p>
                </div>

            </div>

            <div class="col-lg-5 text-center" >
                <img src="{{ $template->storage->getAssetImage("9693091-promo-review-1.png") }}" height="150" >
            </div>

        </div>            

        </section>

        <h1 class="font-bold text-center mt100">{{ translate("tr_b95c712202117d075a449c08de50bb6f") }}</h1>

        <section class="mt20 text-center">

             <a href="{{ outRoute('ad-create') }}" class="btn-custom button-color-scheme3" > {{ translate("tr_6a597fed338ace644982313b3cfbead4") }} </a>       

        </section>

    </div>

    {% endblock %}