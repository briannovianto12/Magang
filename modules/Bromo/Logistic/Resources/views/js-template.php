<script id="order-item" type="x-tmpl-mustache">
    <div class="t-item" data-id="{{ id }}" style="text-align: left">
        
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="content" onclick="location.href='logistic-info/{{id}}';" style="cursor: pointer;">
                        {{#waiting_pickup}}
                            <span class="badge badge-danger" style="display:block; padding: 10px 10px; text-align: left;"> Order #{{ order_no }} - Menunggu Dijemput </span>
                        {{/waiting_pickup}}
                        {{#in_process}}
                            <span class="badge badge-warning" style="display:block; padding: 10px 10px; text-align: left;"> Order #{{ order_no }} - Proses Ke Ekspedisi </span>
                        {{/in_process}}
                        {{#picked_up}}
                            <span class="badge badge-success" style="display:block; padding: 10px 10px; text-align: left;"> Order #{{ order_no }} - Sudah Dijemput </span>
                        {{/picked_up}}
                        
                        <div class="media">
                            <img width="100" class="mr-3" src="{{ gcs_path }}{{ logo }}" alt="..." style="padding:10px">
                            <div class="media-body">
                                <h5><b> {{ shop_name }}</h5></b>
                                <span>Pembeli:<b style="color: Blue"> {{ buyer_name }}</span></b><br/>
                                <span>Ekspedisi:<b style="color: Blue"> {{ courier_name }}</span></b><br/>
                                <span>Barang Siap Kirim:<b> {{ expected_date }}</span></b><br/>
                                {{#penjemput}}
                                    <span>Penjemput:<b"> {{ penjemput }}</span></b>
                                {{/penjemput}}
                                {{^penjemput}}
                                    <span>Penjemput:<b"> -</span></b>
                                {{/penjemput}}
                            </div>
                        </div>
                    </div>
                </div>
                <div id="swal-target-{{ id }}"></div>
            </div>
        </div>

        <div class='form-group'>
            
        </div>
    </div>
</script>