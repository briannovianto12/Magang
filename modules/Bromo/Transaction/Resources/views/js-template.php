<script id="edit" type="x-tmpl-mustache">
    <div class="t-item" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <div>
            <div class="text-center">
                <br/>
                <h4>Order ID: {{ ids.order_id }}</h4>
                <h4>Shipping Manifest ID: {{ ids.shipping_manifest_id }}</h4>
            </div>
            <div>
            <br/>
                <label>
                    Current Weight:
                </label>
                <input id="curr-weight" class="form-control" type="text" placeholder="{{curr_detail.curr_weight}} Kg" readonly>
                <br/>
                <label>
                    Current Cost:
                </label>
                <input id="curr-cost" class="form-control" type="text" placeholder="IDR {{curr_detail.curr_cost}}" readonly>
                <br/>
                <label>
                    New Weight :
                </label>
                <input id="new-weight" class="form-control" type="number" min="1" placeholder="0">
                <br/>
                <label>
                    New Cost :
                </label>
                <input id="new-cost" class="form-control" type="text" placeholder="IDR 0.00" readonly>
                <br/><br/>
            </div>
            <form id="form-edit-product">
                <div class="form-group">

                   <button data-product-id="{{ data.id }}" type="button" class="btn btn-primary btn-lg btn-block" id="btnUpdate">Update</button>
                </div>
            </form>
        </div>
    </div>
</script>