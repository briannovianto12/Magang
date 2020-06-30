<script id="rename-courier-shipping" type="x-tmpl-mustache">
    <div class="t-item" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <div>
            <div class="text-center">
                <br/>
                <h4>Nama Kurir: {{ data.name }}</h4>
                <h4>Nama Provider Key: {{ data.provider_key }}</h4>
            </div>
            <form id="form-update-ekspedisi">
                <div class="form-group">
                    <label>
                    </label>
                        <input id="newProviderKey" class="form-control" type="text" placeholder="New Provider Key" name="new_provider_key">
                    <br/>
                    <label>
                    </label>
                        <input id="newName" class="form-control" type="text" placeholder="New Courier Name" name="new_name">
                    <br/>
                   <button data-courier-id="{{ data.id }}" type="button" class="btn btn-primary btn-lg btn-block" id="btnUpdateCourier">Update Shipping Courier</button>
                </div>
            </form>
        </div>
    </div>
</script>

<script id="changePostalCode" type="x-tmpl-mustache">
    <div class="t-item" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <div>
            <div class="text-center">
                <br/>
                <h4>Province: {{ province_name }}</h4>
                <h4>City: {{ city_name }}</h4>
                <h4>District: {{ district_name }}</h4>
                {{#subdistrict_name}}
                    <h4>Subdistrict: {{ subdistrict_name }}</h4>
                {{/subdistrict_name}}
            </div>
            <form id="form-edit-product">
                <div class="form-group">
                    <label>
                        Postal Code:
                    </label>
                        {{#postal_code}}
                            <input id="inputPostalCode" class="form-control" type="text" placeholder="{{ postal_code }}">
                        {{/postal_code}}
                        {{^postal_code}}
                            <input id="inputPostalCode" class="form-control" type="text" placeholder="New Postal Code">
                        {{/postal_code}}
                    <br/>
                   <button class="btn btn-primary btn-lg btn-block" id="btnChangePostalCode">Change Postal Code</button>
                </div>
            </form>
        </div>
    </div>
</script>

<script id="enable-disable-courier" type="x-tmpl-mustache">
    <div class="t-item" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <div>
            <div class="text-center">
                <br/>
                {{#data.enabled}}
                <h4>Disable {{ data.name }}?</h4>
                {{/data.enabled}}
                {{^data.enabled}}
                <h4>Enable {{ data.name }}?</h4>
                {{/data.enabled}}
            </div>
        </div>
    </div>
</script>