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
                                <h5>{{building_name}}</h5>
                                <h5>{{address_line}}, {{ subdistrict }}, {{ district }}</h5>
                                <h5>{{ city }} - {{ province }}, {{ postal_code }}</h5>
                            </input>
                    {{/current_address}}

                    {{^current_address}}                    
                            <input type="radio" name="address-line" value="{{id_str}}" >
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