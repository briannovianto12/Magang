@extends('theme::layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ nbs_asset('css/kendo/kendo.common.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ nbs_asset('css/kendo/kendo.default.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ nbs_asset('css/kendo/kendo.default.mobile.min.css')}}" />

    <style>
        .k-button.k-spreadsheet-sheets-bar-add{
            display:none
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('js/kendo/jquery.min.js') }}"></script>
    <script src="{{ nbs_asset('js/kendo/jszip.min.js') }}"></script>
    <script src="{{ nbs_asset('js/kendo/kendo.all.min.js') }}"></script>

    <script>
    $(function() {

        var spreadsheet = $("#spreadsheet").kendoSpreadsheet({
            change: onChange, // event dari kendo
            columns: 8,
            rows: 100,
            toolbar: false,
            sheets: [{
                name: "Logistik Traditional",
                frozenColumns: 2,
                rows: [
                    {
                        height: 25,
                        cells: [
                            {
                                value : "order_no", textAlign : "center", enable: false , fontSize: 14, textAlign: "center", color: "black", bold: true, background : "rgb(192,192,192)"
                            },
                            {
                                value : "airwaybill", textAlign : "center", enable: false , fontSize: 14, textAlign: "center", color: "black", bold: true, background : "rgb(192,192,192)"
                            },
                            {
                                value : "shop_name", textAlign : "center", enable: false , fontSize: 14, textAlign: "center", color: "black", bold: true, background : "rgb(192,192,192)"
                            },
                            {
                                value : "system_price", textAlign : "center", enable: false , fontSize: 14, textAlign: "center", color: "black", bold: true, background : "rgb(192,192,192)"
                            },
                            {
                                value : "system_weight (KG)", textAlign : "center", enable: false , fontSize: 14, textAlign: "center", color: "black", bold: true, background : "rgb(192,192,192)"
                            },
                            {
                                value : "discount_platform", textAlign : "center", enable: false , fontSize: 14, textAlign: "center", color: "black", bold: true, background : "rgb(192,192,192)"
                            },
                            {
                                value : "real_price", textAlign : "center", enable: false , fontSize: 14, textAlign: "center", color: "black", bold: true, background : "rgb(192,192,192)"
                            },
                            {
                                value : "real_weight (KG)", textAlign : "center", enable: false , fontSize: 14, textAlign: "center", color: "black", bold: true, background : "rgb(192,192,192)"
                            },
                            {
                                value : "message", textAlign : "center", enable: false , fontSize: 14, textAlign: "center", color: "black", bold: true, background : "rgb(192,192,192)"
                            },

                        ]
                    }
                ],
                columns: [
                    { width: 200 },
                    { width: 200 },
                    { width: 200 },
                    { width: 200 },
                    { width: 200 },
                    { width: 200 },
                    { width: 200 },
                    { width: 200 },
                    { width: 500 }
                ]
            }]
        }).data("kendoSpreadsheet");

        function onChange(e)
        {
            let values = e.range.values()
            var sheet = spreadsheet.activeSheet();
            var message = "";
            var counter = e.range._ref.topLeft.row;

            if(values != undefined && e.range._ref.topLeft.col === 0)
            {
                if(!values[0][0] && sheet.activeCell().topLeft.row)
                {
                    sheet.range(sheet.activeCell().topLeft.row,2).input('');
                    sheet.range(sheet.activeCell().topLeft.row,3).input('');
                    sheet.range(sheet.activeCell().topLeft.row,4).input('');
                    sheet.range(sheet.activeCell().topLeft.row,5).input('');
                    sheet.range(sheet.activeCell().topLeft.row,6).input('');
                    sheet.range(sheet.activeCell().topLeft.row,7).input('');
                    sheet.range(sheet.activeCell().topLeft.row,8).input('');
                }


                $.post( "/logistic-spreadsheet",
                {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'input': values,
                })
                .done(function(data){
                    var json = JSON.parse(data);

                    if(json.status == 'success')
                    {

                        for(index = 0 ; index <= json.data.length; index++)
                        {
                            if (json.data[index]!= undefined){
                                sheet.range(counter,2).input(json.data[index].shop_name);
                                sheet.range(counter,3).input(json.data[index].system_price);
                                sheet.range(counter,4).input(json.data[index].system_weight);
                                sheet.range(counter,5).input(json.data[index].platform_discount);
                                sheet.range(counter,8).input(json.data[index].message).bold(true);
                                counter += 1;
                            }
                        }
                    }
                    else
                    {
                        swal.fire({
                            position: 'top',
                            type: 'danger',
                            text: 'Data Not Found',
                        }).then(function(){
                            location.reload();
                        });
                    }
                });
            }
        }

        var sheet = spreadsheet.activeSheet();

        sheet.range("C2:F100").enable(false).color("black").background("#D3D3D3");
        sheet.range("I2:I100").enable(false).color("black").background("#D3D3D3");

        sheet.range('A2:A100').validation({
            datatype: "number",
            from: "LEN(A2) >= 19",
            allowNulls: true,
            type: "reject",
            comparerType : "custom",
            titleTemplate: "Order Validation Error",
            messageTemplate: " Order No Lengh Must 19 Characters "
        });

        sheet.range('B2:B100').validation({
            datatype: "number",
            from: "LEN(B2) >= 5",
            allowNulls: true,
            type: "reject",
            comparerType : "custom",
            titleTemplate: "Order Validation Error",
            messageTemplate: " Airwaybill Lengh Must 5 Characters "
        });

        sheet.range('G2:G100').validation({
            datatype: "number",
            from: "0",
            allowNulls: true,
            type: "reject",
            comparerType : "greaterThan",
            titleTemplate: "Order Validation Error",
            messageTemplate: " Real Price Must be greater than {0} "
        });

        sheet.range('H2:H100').validation({
            datatype: "number",
            from: "0",
            allowNulls: true,
            type: "reject",
            comparerType : "greaterThan",
            titleTemplate: "Order Validation Error",
            messageTemplate: " Real Weight Must be greater than {0} "
        });

        //===================================================================================================================
        //== Get Value  =====================================================================================================
        //===================================================================================================================

        $("#submit").click(function(){
            var data = [];
            var sheet = spreadsheet.activeSheet();
            console.log('test');

            // get order_no push into json object
            var rangeA = sheet.range('A2:A100');
            rangeA.forEachCell(function(row, column, cellProperties){
                if(cellProperties.value != undefined)
                {
                    data.push({
                        order_no: cellProperties.value,
                    });
                }
            });

            // get airwaybill push into json object
            var rangeB = sheet.range('B2:B100');
            rangeB.forEachCell(function(row,column, cellProperties){
                if(cellProperties.value != undefined)
                {
                    data[row-1].airwaybill = cellProperties.value
                }
            });

            //get correction_price push into json object
            var rangeF = sheet.range('G2:G100');
            rangeF.forEachCell(function(row,column, cellProperties){
                if(cellProperties.value != undefined)
                {
                    data[row-1].real_price = cellProperties.value
                }
            });

            // get correction_weight push into json object
            var rangeG = sheet.range('H2:H100');
            rangeG.forEachCell(function(row,column, cellProperties){
                if(cellProperties.value != undefined)
                {
                    data[row-1].real_weight = cellProperties.value
                }
            });

            // get correction_weight push into json object
            var rangeG = sheet.range('I2:I100');
            rangeG.forEachCell(function(row,column, cellProperties){
                if(cellProperties.value != undefined)
                {
                    data[row-1].message = cellProperties.value
                }
            });

            for(index = 0; index < data.length; index++)
            {

                if(data[index].airwaybill == undefined || data[index].airwaybill == null)
                {
                    alert("Please check airwaybill");
                    break;
                }

                if(data[index].real_price == undefined || data[index].real_price == null)
                {
                    alert("Please check real price")
                    break;
                }

                if(data[index].real_weight == undefined || data[index].real_weight == null)
                {
                    alert("Please check real weight")
                    break;
                }

                if(data[index].message != undefined && data[index].message != "")
                {
                    alert("Please check again the Order_No, we found Order_No already shipped ");
                    break;
                }

                if(index != 0)
                {
                    var valueArr = data.map(function(item){return item.order_no});
                    var isDuplicate = valueArr.some(function(item,idx){
                        return valueArr.indexOf(item) != idx
                    });
                    if(isDuplicate === true){
                        alert("Please check again Order No , We Found Duplicate");
                        break;
                    }
                }

            }


            $.ajax({
                url:"/logistic-spreadsheet/submit",
                method:"POST",
                dataType:"json",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    data:data
                },
                success:function(data){
                    if(data.status == 'success')
                    {
                        swal.fire({
                            position: 'top',
                            type: 'success',
                            text: data.message,
                        }).then(function(){
                            location.reload();
                        });

                    }
                }
            });

        });
    });
    </script>

@endsection


@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => $title . ': Spreadsheet'])
        @slot('body')
            @can('view_logistic_spreadsheet')
            <div class="m-portlet__body">
                <div class="row">
                    <div class="mb-4" >
                        <button class="btn btn-primary" id="submit">Submit</button>
                    </div>
                </div>
                <div class="row">
                    <div id="spreadsheet" style="width: 100%"></div>
                </div>
            </div>
            @endcan
        @endslot
    @endcomponent

@endsection
