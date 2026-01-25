{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

        <h3> <strong>{{ translate("tr_0905527faec7de502c0e62ce318af892") }}</strong> </h3>

        <div class="my-tabs-items my-tabs-items-medium mt20">
            <a class="my-tabs-item {% if(!$_GET['tab'] || compareValues($_GET['tab'], 'buy')){ echo 'active'; } %}" href="?tab=buy" >{{ translate("tr_82329f6f0fb076026c94fde71d8c2136") }}</a>
            <a class="my-tabs-item {% if(compareValues($_GET['tab'], 'sell')){ echo 'active'; } %}" href="?tab=sell" >{{ translate("tr_e8d5f643de71af2e7d7aceae72e859a9") }}</a>
        </div>

        {% if($data->orders): %}

        <div class="row row-cols-2 g-2 g-lg-3 mt25" >{{ $data->orders; }}</div>

        {{ $template->pagination->display() }}

        {% else: %}

          <div class="mt40 not-found-title-container" >
             <div class="not-found-title-container-image" >🧐</div>
             <p>{{ translate("tr_efb9a0cf37e542160d0fcd33f5cc9f5c") }}</p>           
          </div>

        {% endif; %}

  </div>

</div>

</div>

{% endblock %}