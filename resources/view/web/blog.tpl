{% extends index.tpl %}

{% block head %}
<link rel="canonical" href="{{ $template->component->blog_categories->buildAliases((array)$data->category) }}"/>
{% endblock %}

{% block content %}

<div class="container mt20" >

    <nav aria-label="breadcrumb" class="mb15" >

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

        {{ $template->component->blog->outBreadcrumb(); }}

      </ol>

    </nav>

    <div class="row" >

      <div class="col-md-12" >

        <h1 class="font-bold" >{{ $seo->h1; }}</h1>

        <div class="blog-widget-categories-or-subcategories mt25" >
          
          {{ $template->component->blog_categories->outCategoriesOrSubCategories(); }}

        </div>

      </div>

    </div>

    <div class="row mt40" >
      <div class="col-md-12" >

          <div class="container-load-items" >
            {% component items/blog-skeleton.tpl %}
          </div>

          <input type="hidden" name="blog_category_id" value="{{ $data->category ? $data->category->id : '0'  }}" >

      </div>
    </div>

</div>

{% endblock %}