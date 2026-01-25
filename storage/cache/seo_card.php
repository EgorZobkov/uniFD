<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/seo" >Seo</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
        <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="dashboard-seo" data-page-icon="ti-template" data-page-name="Seo" >
                  <span class="ti ti-heart-plus"></span>
              </button>
    </div>
    
  </div>

</div>



<?php echo $template->component->translate->outLanguagesSections($data->lang_iso,$template->router->getRoute('dashboard-seo-card', [$data->id])); ?>

<div class="row g-4">

  <div class="col-12 col-lg-3">

    <div class="nav-align-left">

        <ul class="nav nav-pills w-100">

          <?php echo $template->component->seo->outSections($data->id);; ?>
          
        </ul>

    </div>

  </div>

  <div class="col-12 col-lg-9">

    <div class="card" >
      
      <div class="card-body" >

        <form class="formSeo" >

    <div class="mb-3">
      <label class="form-label mb-2" >Макросы</label>

       <div class="seo-container-makros-list" >
         <span class="badge rounded-pill bg-primary copyToClipboard" title="Название домена" >{domain}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Ссылка на сайт" >{domain_link}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Название проекта" >{project_name}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Заголовок проекта" >{project_title}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Контактный email" >{contact_email}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Контактный номер телефона" >{contact_phone}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Название организации" >{contact_organization_name}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Адрес организации" >{contact_organization_address}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Название текущего города пользователя" >{current_geo_name}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Название текущего города пользователя со склонением" >{current_geo_name_declension}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Текст текущего города пользователя" >{current_geo_text}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Название текущей категории пользователя" >{current_category_name}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Meta title текущей категории пользователя" >{current_category_title}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="H1 заголовок текущей категории пользователя" >{current_category_h1}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Короткое описание текущей категории пользователя" >{current_category_desc}</span><span class="badge rounded-pill bg-primary copyToClipboard" title="Описание текущей категории пользователя" >{current_category_text}</span>       </div>

    </div>

    
    <div class="mb-3">
      <label class="form-label mb-2" >Условие</label>
      
      <select class="form-select selectpicker seo-catalog-change-condition-category" >
         <option value="category" >Если выбрана категория</option>
         <option value="not_category" >Если не выбрана категория</option>
      </select>

    </div>

    <div class="seo-catalog-condition-category-container-1" >

        <div class="mb-3">
          <label class="form-label mb-2" >Заголовок страницы</label>
          <input type="text" name="content[ru][category][meta_title]" class="form-control" value="{current_category_name} " />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >Краткое описание</label>
          <textarea class="form-control" name="content[ru][category][meta_desc]" ></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H1</label>
          <input type="text" name="content[ru][category][h1]" class="form-control" value="{current_category_name}" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H2</label>
          <input type="text" name="content[ru][category][h2]" class="form-control" value="" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H3</label>
          <input type="text" name="content[ru][category][h3]" class="form-control" value="" />
        </div>

        <div>
          <label class="form-label mb-2" >Текст</label>
          <textarea class="form-control" name="content[ru][category][text]" rows="6" ></textarea>
        </div>
      
    </div>

    <div class="seo-catalog-condition-category-container-2" >
      
        <div class="mb-3">
          <label class="form-label mb-2" >Заголовок страницы</label>
          <input type="text" name="content[ru][not_category][meta_title]" class="form-control" value="Объявления - {project_name}" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >Краткое описание</label>
          <textarea class="form-control" name="content[ru][not_category][meta_desc]" ></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H1</label>
          <input type="text" name="content[ru][not_category][h1]" class="form-control" value="Объявления - {project_name}" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H2</label>
          <input type="text" name="content[ru][not_category][h2]" class="form-control" value="" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H3</label>
          <input type="text" name="content[ru][not_category][h3]" class="form-control" value="" />
        </div>

        <div>
          <label class="form-label mb-2" >Текст</label>
          <textarea class="form-control" name="content[ru][not_category][text]" rows="6" ></textarea>
        </div>

    </div>

    
    <input type="hidden" name="id" value="2" >
    <input type="hidden" name="lang_iso" value="ru" >

</form>        

<div class="mt-4 d-grid gap-2 col-lg-4 mx-auto">
  <button class="btn btn-primary actionSeoSaveEdit">Сохранить</button>
</div>

      </div>

    </div>

  </div>

</div>