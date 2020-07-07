<script id="change-address" type="x-tmpl-mustache">
    <div class="t-item" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <form id="form-change-pickup-address" action="POST">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div id="form-group" >

                {{#shop_business_address_list}}    
                    {{#current_address}}                    
                            <input type="radio" name="address-line" value="{{id_str}}" checked>                                 
                                <b>Current Address</b>
                                <br/>    
                                <h5>{{id_str}}</h5>
                                <h5>{{building_name}}</h5>
                                <h5>{{address_line}}, {{ subdistrict }}, {{ district }}</h5>
                                <h5>{{ city }} - {{ province }}, {{ postal_code }}</h5>
                            </input>
                    {{/current_address}}

                    {{^current_address}}                    
                            <input type="radio" name="address-line" value="{{id_str}}" >
                                <h5>{{id_str}}</h5>
                                <h5>{{building_name}}</h5>
                                <h5>{{address_line}}, {{ subdistrict }}, {{ district }}</h5>
                                <h5>{{ city }} - {{ province }}, {{ postal_code }}</h5>
                            </input>
                    {{/current_address}}
                    <hr/>
                {{/shop_business_address_list}}
                
                <button type="button" class="btn btn-primary btn-lg btn-block" id="btnChangePickupAddress">Submit</button>
            
            </div>
        </form>
        
    </div>
</script>

<script id="change-commission" type="x-tmpl-mustache">
    <div class="t-item" style="text-align: left; font-size: 14px; font-color: #666 !important;">

        <form id="form-change-commission" action="POST">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div id="form-group">
                {{#shop.current_commission_null}}
                    <input type="radio" name="commission-type" value="" >
                        <b>None</b>
                    </input>
                    <hr/>
                {{/shop.current_commission_null}}
                {{#commission_group}}
                    {{#current_commission}}                    
                            <input type="radio" name="commission-type" value="{{id}}" checked>                                 
                                <b>{{name}} (Current Commission)</b>
                            </input>
                    {{/current_commission}}

                    {{^current_commission}}                    
                            <input type="radio" name="commission-type" value="{{id}}" >
                                <b>{{name}}</b>
                            </input>
                    {{/current_commission}}
                    <hr/>
                {{/commission_group}}
                
                <button type="button" class="btn btn-primary btn-lg btn-block" id="btnChangeCommission">Submit</button> 
            
            </div>
        </form>
        
    </div>
</script>

<script id="seller-courier-mapping" type="x-tmpl-mustache">
    <div class="t-item container" style="text-align: left; font-size: 14px; font-color: #666 !important;">
        <style>
            ul{
                columns: 4;
                -webkit-columns: 4;
                -moz-columns: 4;
            }
            li{
                height: 15px;
            }
        </style>
        <form id="form-seller-courier-mapping" action="POST">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div id="form-group" >
                <ul>
                {{#couriers}}
                    {{#checked}}
                        <li>    
                            <label for="courier">{{ name }}</label>
                            <input type="checkbox"  name="couriers" value="{{ id }}" checked>
                        </li>
                    {{/checked}}
                    
                    {{^checked}}
                        <li>    
                            <label for="courier">{{ name }}</label>
                            <input type="checkbox" name="couriers" value="{{ id }}">
                        </li>
                    {{/checked}}
                    <hr/>
                {{/couriers}}
                </ul>
                <button type="button" class="btn btn-primary btn-lg btn-block" id="btnSellerCourierMapping">Submit</button>
            
            </div>
        </form>
        
    </div>
</script>