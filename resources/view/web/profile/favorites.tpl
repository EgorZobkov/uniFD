{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

        <h3> <strong>{{ translate("tr_2fc413929104c1a09ae0a66c48ce0902") }}</strong> </h3>

        <div class="my-tabs-items my-tabs-items-medium mt20">
            <a class="my-tabs-item {% if(!$_GET['tab'] || compareValues($_GET['tab'], 'ads')){ echo 'active'; } %}" href="?tab=ads" >{{ translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c") }}</a>
            <a class="my-tabs-item {% if(compareValues($_GET['tab'], 'searches')){ echo 'active'; } %}" href="?tab=searches" >{{ translate("tr_10b80a180d9f5ab5272132c27430a67e") }}</a>
            <a class="my-tabs-item {% if(compareValues($_GET['tab'], 'subscriptions')){ echo 'active'; } %}" href="?tab=subscriptions" >{{ translate("tr_4a2adbe0c408017611fe5cc95cbf1a8e") }}</a>
            <a class="my-tabs-item {% if(compareValues($_GET['tab'], 'viewed')){ echo 'active'; } %}" href="?tab=viewed" >{{ translate("tr_9b236849273d8b0743667e074f592454") }}</a>
        </div>

        {% if($data->favorites): %}

        <div class="row row-cols-2 g-2 g-lg-3 mt25" >{{ $data->favorites }}</div>

        {{ $template->pagination->display() }}

        {% else: %}

          <div class="mt40 not-found-title-container" >
             <div class="not-found-title-container-image" >🧐</div>
             <p>{{ translate("tr_d716fec18159de84dae4b5a94795ebac") }}</p>           
          </div>

        {% endif; %}

  </div>

</div>

</div>

{% endblock %}