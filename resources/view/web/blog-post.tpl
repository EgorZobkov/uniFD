{% extends index.tpl %}

{% block head %}
<meta property="og:title" content="{{ $seo->h1; }}">
<meta property="og:description" content="{{ $seo->meta_desc; }}">
<meta property="og:image" content="{{ $template->storage->name($data->image)->get() }}">
{% endblock %}

{% block content %}

<div class="container mt20 mb40" >

    <div class="breadcrumb-container" >
      <nav aria-label="breadcrumb">

        <ol class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">

          <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
            <a itemprop="item" href="{{ outLink(); }}">
            <span itemprop="name">{{ translate("tr_047f5653b183292396e67f14c8750b73") }}</span></a>
            <meta itemprop="position" content="1">
          </li>

          <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
            <a itemprop="item" href="{{ outRoute('blog') }}">
            <span itemprop="name">{{ translate("tr_103a554114af7c598a4f835ac463722e") }}</span></a>
            <meta itemprop="position" content="2">
          </li>

          {{ $template->component->blog->outBreadcrumbInPost($data->category_id) }}

        </ol>

      </nav>
    </div>

    <div class="text-center" >
      <h1 class="font-bold" >{{ $seo->h1; }}</h1>

      <div class="ad-card-info-line" >
        <span>{{ $template->datetime->outLastTime($data->time_create); }}</span>
        <span><i class="ti ti-eye"></i> {{ $template->component->blog->getViews($data->id); }} ({{ $template->component->blog->getViewsToday($data->id); }} {{ translate("tr_a9705117762f35c4940a622bc9940a01") }})</span>
      </div>
    </div>

    <div class="row mt50" >

      <div class="col-lg-8 col-12" >

        <div class="blog-post-card-content" >

          {{ $template->component->blog->outContent($data) }}

        </div>
        
      </div>

      <div class="col-lg-4 col-12" >

        <div class="blog-post-card-sidebar" >

          <div class="row row-cols-2 g-2 g-lg-3" >
            {{ $template->component->blog->outCardPosts($data->id,4) }}
          </div>

        </div>        

      </div>

    </div>

</div>

{% endblock %}