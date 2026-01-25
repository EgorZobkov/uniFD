public function defaultTplBody(){
    return trim('
    {% extends index.tpl %}

    {% block content %}

    <div class="container" >

        <h1 class="font-bold mt20 mb20">{{ $seo->h1 }}</h1>
             
        <p>{{ $seo->text }}</p>

        <p>Чтобы настроить заголовок и текст перейдите в раздел SEO и выберите данную страницу.</p>

        <p>To customize the title and text, go to the SEO section and select this page.</p>

        <p>🫶🏻✌🏻❤️</p>

    </div>

    {% endblock %}
    ');
}