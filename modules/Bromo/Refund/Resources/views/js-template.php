<script id="edit-refund-status" type="x-tmpl-mustache">
    <div class="t-item" data-id="{{ id }}" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <div>
            <div class="text-center">
                <br/>
                <h5>Order No: {{ order_no }}</h5>
                <h5>Shop Name: {{ shop_name }}</h5>
                <h5>Buyer Name: {{ buyer_name }}</h5>
                <h5>Payment Amount: IDR {{ amount }}</h5>
            </div>

            <div>
                <br/>
                <strong>Input Refund Details:<br/> 
                </strong>
                <br/>
            </div>

            <form id="form-edit-product">
                <div class="form-group">
                    <input style="width: 100%" required data-toggle="datepicker" class="form-control-lg" id="refundDateInput" name="refundDateInput" type="text" readonly placeholder="Tanggal Refund" />
                </div>
                <div class="form-group">
                    <textarea style="width: 100%; height: 120px" class="form-control-lg" id="refundNotes" name="refundNotes" placeholder="Catatan Refund"></textarea>
                </div>
                   
                <button data-product-id="{{ id }}" type="button" class="btn btn-primary btn-lg btn-block" id="btnRefundOrder">Update Refund Status</button>
                </div>
            </form>
        </div>
    </div>
</script>
