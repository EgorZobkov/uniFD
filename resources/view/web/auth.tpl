{% extends index.tpl %}

{% block content %}

<div class="container mt15" >

<div class="row" >

  <div class="col-lg-12" >

   <div class="container-page-auth" >
      
      <div class="auth-block-tab-container" >
        {% component form-auth.tpl %}
      </div>

   </div>

  </div>

</div>

</div>

{% endblock %}