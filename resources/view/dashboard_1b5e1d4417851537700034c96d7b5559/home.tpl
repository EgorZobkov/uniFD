
{% extends index.tpl %}

{% block content %}

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row widget-sortable-container" id="widget-sortable-container">
    
    {{ $template->system->outSystemHomeSkeletonWidgets() }}

  </div>
</div>

{% endblock %}