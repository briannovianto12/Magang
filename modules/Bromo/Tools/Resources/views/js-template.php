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