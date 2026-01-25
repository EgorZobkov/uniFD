{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

        <h3> <strong>{{ translate("tr_1c3fea01a64e56bd70c233491dd537aa") }}</strong> </h3>

        <div class="my-tabs-items my-tabs-items-medium mt20">
            <a class="my-tabs-item {% if(!$_GET['tab'] || compareValues($_GET['tab'], 'my_reviews')){ echo 'active'; } %}" href="?tab=my_reviews" >{{ translate("tr_be785795f5671c67bb5115a4ee2b5069") }}</a>
            <a class="my-tabs-item {% if(compareValues($_GET['tab'], 'added')){ echo 'active'; } %}" href="?tab=added" >{{ translate("tr_8cdd004eb3181c7b872757b8018af33d") }}</a>
        </div>

        {% if($data->reviews): %}

        <div class="row row-cols-2 g-2 g-lg-3 mt25" >{{ $data->reviews }}</div>

        {{ $template->pagination->display() }}

        {% else: %}

          <div class="mt40 not-found-title-container" >
             <div class="not-found-title-container-image" >🧐</div>
             <p>{{ translate("tr_5781a644de7a7276ce1b079f9f27fafe") }}</p>           
          </div>

        {% endif; %}

  </div>

</div>

</div>

{% endblock %}