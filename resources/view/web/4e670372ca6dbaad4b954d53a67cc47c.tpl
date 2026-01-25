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
                        <i class="ti ti-check"></i> {{ translate("tr_c1b5e0f3304d944a26d2130b796c3753") }}
                    </div>
                    <div>
                        <i class="ti ti-check"></i> {{ translate("tr_dad6f81abe0d432860d0304b4c129ec2") }}
                    </div>
                    <div>
                        <i class="ti ti-check"></i> {{ translate("tr_df94e3cf00bcac879830f7f5624d3fa6") }}
                    </div>
                </div>

            </div>

            <div class="col-lg-5 text-center" >
                <img src="{{ $template->storage->getAssetImage("5700121-promo-stat.webp") }}" height="350" >
            </div>

        </div>

        <h1 class="font-bold text-center mt100">{{ translate("tr_ea5a4d6f2873bc901045b0acc7277321") }}</h1>

        <section class="mt50">

        <div class="row" >
            
            <div class="col-lg-7" >
                
                <div class="promo-business-section-container-title" >
                    <h2>{{ translate("tr_838c33a96c1a3d15354de92dae7a0f08") }}</h2>
                    <p>{{ translate("tr_8076b18350b9af68e86b8df4d46d3307") }}</p>
                </div>

            </div>

            <div class="col-lg-5 text-center" >
                <img src="{{ $template->storage->getAssetImage("8399675111223322.png") }}" height="300" >
            </div>

        </div>            

        </section>

        <section class="mt50">

        <div class="row" >
            
            <div class="col-lg-7" >
                
                <div class="promo-business-section-container-title" >
                    <h2>{{ translate("tr_a62b9e5890d76fe02b0c809915136afd") }}</h2>
                    <p>{{ translate("tr_2c7e588d7cd70069a42d823fd2e0817c") }}</p>
                </div>

            </div>

            <div class="col-lg-5 text-center" >
                <img src="{{ $template->storage->getAssetImage("27614541074327343.webp") }}" height="300" >
            </div>

        </div>            

        </section>

        <section class="mt50" >

        <div class="row" >
            
            <div class="col-lg-7" >
                
                <div class="promo-business-section-container-title" >
                    <h2>{{ translate("tr_f139acad6b9e9ae951fc74f9df710e96") }}</h2>
                    <p>{{ translate("tr_16094f8c00bc5c4e8dd97afdc52d6adf") }}</p>
                </div>

            </div>

            <div class="col-lg-5 text-center" >
                <img src="{{ $template->storage->getAssetImage("7741796093758663.webp") }}" height="300" >
            </div>

        </div>            

        </section>

        <h1 class="font-bold text-center mt100">{{ translate("tr_36e5db13a1ce2fef17a0f20fa5667547") }}</h1>

        <section class="mt50">

        <form class="profile-tariffs-form" >

          <div class="profile-tariffs-list profile-tariffs-swiper mt50" >

            <div class="profile-tariffs-swiper-prev" > <span><i class="ti ti-chevron-left"></i></span> </div>
            <div class="profile-tariffs-swiper-next" > <span><i class="ti ti-chevron-right"></i></span> </div>

            <div class="swiper-wrapper" >
            {{ $template->component->service_tariffs->outTariffs() }}
            </div>

          </div>
          
          <input type="hidden" name="tariff_id" value="{{ $template->user->data->tariff_id }}" />
          <input type="hidden" name="target" value="service_tariff" />

          <div class="mt30" >
            <button class="initOptionsPaymentServiceTariff btn-custom-big button-color-scheme1 profile-tariffs-action-payment" >{{ translate("tr_ad5c2ce8c246a75449fc289b032c5ca8") }}</button>
          </div>

        </form>            

        </section>

    </div>

    {% endblock %}