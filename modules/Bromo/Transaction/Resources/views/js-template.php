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

<script id="editStatus" type="x-tmpl-mustache">
    <div class="t-item" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <div>
            <div class="text-center">
                <br/>
                <h4>Order No. {{ data.order_no }}</h4>
            </div>
            <form id="form-edit-product">
                <div class="form-group">
                    <label>
                        Notes:
                    </label>
                    <input id="changeNotes" class="form-control" type="text" placeholder="Notes">
                    <br/>
                   <button data-product-id="{{ data.id }}" type="button" class="btn btn-primary btn-lg btn-block" id="btnEditStatus">Edit Status</button>
                </div>
            </form>
        </div>
    </div>
</script>

<script id="internalNotes" type="x-tmpl-mustache">
    <div class="t-item" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <div>
            <div class="text-center">
                <br/>
                <h4>Order ID: {{ order_id }}</h4>
            </div>
            <br/>
            <div>
                <label>
                    Internal Notes:
                </label>
                {{#data}}
                    <input class="form-control" type="text" placeholder="{{internal_notes}}" readonly>
                    <br/>
                {{/data}}
            </div>
            <br/>
            <form id="form-internal-notes">
                <div class="form-group" method="POST">
                    <label>
                        Add Notes:
                    </label>
                    <input id="newInternalNotes" class="form-control" type="text" placeholder="Notes">
                    <br/>
                   <button data-order-id="{{ order_id }}" type="button" class="btn btn-primary btn-lg btn-block" id="btnAddInternalNotes">Add Notes</button>
                </div>
            </form>
        </div>
    </div>
</script>