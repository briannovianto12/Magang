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
                <strong>Input Refunded Date :<br/> 
                </strong>
                <br/>
            </div>

            <form id="form-edit-product">
                <div class="form-group">
                    <label for="refundDateInput" class="col-2 col-form-label"><strong>Date</strong></label>
                    <div class="col">
                        <input class="form-control" type="date" id="refundDateInput">
                    </div>
                    <label for="refundTimeInput" class="col-2 col-form-label"><strong>Time</strong></label>
                    <div class="col">
                        <input class="form-control" type="time" value="00:00:00" id="refundTimeInput">
                    </div>
                    <label for="refundNotes" class="col-2 col-form-label"><strong>Notes</strong></label>
                    <div class="col">
                        <input class="form-control" type="text" placeholder="Notes" id="refundNotes">
                    </div>
                   <button data-product-id="{{ id }}" type="button" class="btn btn-primary btn-lg btn-block" id="btnRefundOrder">Update Refund Status</button>
                </div>
            </form>
        </div>
    </div>
</script>
