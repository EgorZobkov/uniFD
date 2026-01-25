{% extends index.tpl %}

{% block content %}

<div class="container" >

  <div class="row" >

    <div class="col-md-12" >

      <div class="payment-status-container" >
        
        <h2>{{ translate("tr_127c82891ceccb541606679870f96512") }}</h2>
        <p>{{ translate("tr_be2883e683af46552caa5519fc657ff4") }}</p>

        {% if($order): %}
        <a class="btn-custom button-color-scheme2 mt15" href="{{ $order->data['return_url'] }}" >{{ translate("tr_5f8256eec9d799783ade21b422b9ded7") }}</a>
        {% endif; %}

      </div>

    </div>

  </div>

</div>

{% endblock %}