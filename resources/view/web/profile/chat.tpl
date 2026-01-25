{% extends index.tpl %}

{% block content %}

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    {% component profile/sidebar.tpl %}

  </div>

  <div class="col-md-9" >

      <div class="page-chat-container chat-container" >
        {{ $data->dialogues }}
      </div>

  </div>

</div>

</div>

{% endblock %}