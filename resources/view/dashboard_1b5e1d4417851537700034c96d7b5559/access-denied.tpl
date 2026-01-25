{% extends index.tpl %}

{% block content %}

<div class="content-wrapper">
         
<div class="container-xxl flex-grow-1 container-p-y">

  {% component breadcrumbs.tpl %}

  {{ $template->ui->wrapperInfo('dashboard-access-is-closed'); }}

</div>

</div>
{% endblock %}