
{% component breadcrumbs.tpl %}

  <div class="row g-4">

      <div class="col-12" >
        
        <div class="card" >

          <div class="card-body" >

            <form class="blog-post-content-form" >

              <div class="text-end mb-2" >
                <button class="btn btn-primary waves-effect waves-light buttonSaveBlogPostContent" data-id="{{ $data->id }}" >{{ translate("tr_74ea58b6a801f0dce4e5d34dbca034dc") }}</button>
                <a class="btn btn-label-primary waves-effect waves-light" href="{{ $template->component->blog->buildAliasesPostCard($data) }}" target="_blank" > <i class="ti ti-share-3"></i> </a>
              </div>

              <div class="blog-post-content-container" id="blog-post-content-container" >

                {{ $template->component->blog->outContentDashboard($data->content) }}

              </div>
              
              <div class="blog-post-content-change-items-container" >

                <div class="blog-post-content-change-items" >
                  <span class="btn rounded-pill btn-icon btn-primary waves-effect waves-light actionChangeItemContentBlog" ><i class="ti ti-plus"></i></span>
                  <div class="blog-post-content-list-items" >
                    <span class="actionAddItemContentBlog" data-type="image" >{{ translate("tr_346e125feb343c46c0b833c320bea4cf") }}</span>
                    <span class="actionAddItemContentBlog" data-type="link_video" >{{ translate("tr_6cb973ce673f5293344836f9791fc149") }}</span>
                    <span class="actionAddItemContentBlog" data-type="text" >{{ translate("tr_e256835c8eac179597eb134d12a9fdd0") }}</span>
                    <span class="actionAddItemContentBlog" data-type="code" >{{ translate("tr_104f86b866d498d3977644b356422b02") }}</span>
                    <span class="actionAddItemContentBlog" data-type="separator" >{{ translate("tr_90a76516841efa7bad336a9d72311de9") }}</span>
                  </div>
                </div>

              </div>

              <input type="hidden" name="id" value="{{ $data->id }}" >

            </form>

          </div>

        </div>

      </div>

  </div>