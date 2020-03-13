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

<script id="changeOrderSuccess" type="x-tmpl-mustache">
    <div class="t-item" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <div>
            <div class="text-center">
                <br/>
                <h4>Order No. {{ order_no }}</h4>
            </div>
            <form id="form-edit-product">
                <div class="form-group">
                    <label>
                        Re-enter Order No:
                    </label>
                    <input id="orderNo" class="form-control" type="text" placeholder="Order No.">
                    <br/>
                    <label>
                        Notes:
                    </label>
                    <input id="changeNotes" class="form-control" type="text" placeholder="Notes">
                    <br/>
                   <button data-product-id="{{ data.id }}" type="button" class="btn btn-primary btn-lg btn-block" id="btnChangeOrderSuccess">Change Status to "Success"</button>
                </div>
            </form>
        </div>
    </div>
</script>

<script id="changePickedUp" type="x-tmpl-mustache">
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
                   <button data-product-id="{{ data.id }}" type="button" class="btn btn-primary btn-lg btn-block" id="btnChangePickedUp">Change To Pickup</button>
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
                <h4>Order No: {{ order_no }}</h4>
            </div>
            <br/>
            <div class="d-flex justify-content-center">
                <table id="internal-notes-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Internal Notes</th>
                            <th>Inputted By</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <br/>
            <div>
            </div>
            <div class="row">`
                <div class="col-6 offset-3">
                    <form id="form-internal-notes">
                        <div class="form-group" method="POST">
                            <label>
                                <b>Add Notes:</b>
                            </label>
                            <input id="newInternalNotes" class="form-control" type="text" placeholder="Notes">
                            <br/>
                        <button data-order-id="{{ order_id }}" type="button" class="btn btn-primary btn-lg btn-block" id="btnAddInternalNotes">Add Notes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</script>

<script id="rejectOrder" type="x-tmpl-mustache">
    <div class="t-item" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <div>
            <div class="text-center">
                <br/>
                <h4>Order No. {{ data.order_no }}</h4>
            </div>
            <form id="form-edit-product" action="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label>
                        Reject Notes:
                    </label>
                    <input id="rejectNotes" class="form-control" type="text" placeholder="Notes">
                    <br/>
                   <button data-order-id="{{ data.id }}" type="button" class="btn btn-danger btn-lg btn-block" id="btnRejectOrder">Reject Order</button>
                </div>
            </form>
        </div>
    </div>
</script>

<script id="pickup" type="x-tmpl-mustache">
    <div class="t-item" data-id="{{ id }}" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <div>
            <div class="text-center">
                <h5>Atur waktu untuk pengambilan oleh kurir</h5>
                <br>
                <h5><b>Estimasi pengambilan sampai H+1</b></h5>
                <h5><b>(Senin-Sabtu)</b></h5>
                <br/><br/> 
            </div>
            <form>
                <div class="form-group">
                    <input style="width: 100%" required data-toggle="datepicker" class="form-control-lg" id="pickup_date" name="pickup_date" type="text" readonly placeholder="Tanggal Pickup" />
                </div>
                <div class="form-group">
                    <textarea style="width: 100%; height: 120px" class="form-control-lg" id="pickup_instruction" name="pickup_instruction" placeholder="Catatan untuk Pickup (Opsional)"></textarea>
                </div>
                <div class="form-group">
                    <label>Berat (kg) - dibulatkan ke atas kg terdekat</label>
                    <input readonly value="{{ shipping_weight }}" style="width: 100%" class="form-control-lg" id="weight" name="weight" type="text" placeholder="Berat (kg)" />
                </div>

                <h4>Keterangan Ukuran Paket</h4>
                <ul class="size_list">
                    <li>Kecil (1-3 kg)</li>
                    <li>Sedang (4-8 kg)</li>
                    <li>Besar (9+ kg)</li>
                </ul>
                 
                <button data-order-id="{{ id }}" type="button" class="btn btn-primary btn-lg btn-block" id="btnKirim">Kirim</button>
            </form>
        </div>
    </div>
</script>

<script id="update-awb" type="x-tmpl-mustache">
    <div class="t-item" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <div>
            <div class="text-center">
                <br/>
                <h4>Order No. {{ order_no }}</h4>
            </div>
            <form id="form-update-awb">
                <div class="form-group">
                    <label>
                    </label>
                    <input id="newAwb" class="form-control" type="text" placeholder="New Airwaybill" name="new_airwaybill">
                    <br/>
                   <button data-order-id="{{ data.id }}" type="button" class="btn btn-primary btn-lg btn-block" id="btnUpdateAwb">Update Airwaybill</button>
                </div>
            </form>
        </div>
    </div>
</script>