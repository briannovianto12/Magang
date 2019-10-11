<script id="edit" type="x-tmpl-mustache">
    <div class="t-item" data-id="{{ id }}" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <div>
            <div class="text-center">
                <br/>
                <h5>{{ data.name }}</h5>
                <h6>{{ data.id }}</h6>
            </div>
            <div style="padding-top: 25px">
                  <div class="media">
                  <img width="435" class="mr-3" src="{{ items }}" alt="...">
                  <div class="media-body">
                  <!-- <h5 class="mt-0">{{ data.name }}</h5>
                  <h6 class="mt-0">{{ data.id }}</h6> -->
                  
                  </div>
                  </div>
            </div>

            <div>
                <br/>
                <label>Produk Kategori Saat Ini :<br/> 
                    <strong>{{ current_category }}</strong>
                </label>
                <br/><br/>
            </div>

            <form id="form-edit-product">
                <div class="form-group">
                    <select class="form-control" id="category1" name="category1"></select>
                    <select class="form-control" id="category2" name="category2"></select>
                    <select class="form-control" id="category3" name="category3"></select>
                    <select class="form-control" id="category4" name="category4"></select>

                   <button data-product-id="{{ data.id }}" type="button" class="btn btn-primary btn-lg btn-block" id="btnUpdate">Update</button>
                </div>
            </form>
        </div>
    </div>
</script>

<script id="category" type="x-tmpl-mustache">    
    {{#categories}}
          <option value="{{ id }}">{{ name }}</option>
    {{/categories}}
</script>