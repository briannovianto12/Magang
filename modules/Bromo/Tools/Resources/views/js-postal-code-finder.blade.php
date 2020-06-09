<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ nbs_asset('vendor/datatables/buttons.server-side.js') }}"></script>

<script type="text/javascript">
    var initColumns = [
            {'data': 'province_name', 'name': 'location_province.name', orderable: true, searchable: true},
            {'data': 'city_name', 'name': 'location_city.name', orderable: true, searchable: true},
            {'data': 'district_name', 'name': 'location_district.name', orderable: true, searchable: true},
            {'data': 'subdistrict_name', 'name': 'location_subdistrict.name', orderable: true, searchable: true},
            {'data': 'postal_code', 'name': 'location_subdistrict.postal_code', orderable: true, searchable: true},
        ];

        let orderColumnsForUpdated = [];

        var Data = {
            loadList: function () {
                Data.loadDataTable('table_postal_code_finder', "{{ route("postalCodeFinder.getByPostalCode") }}", initColumns, orderColumnsForUpdated);
            },
            loadDataTable: function (elem, route, getColumns, order = []) {
                if (!$.fn.dataTable.isDataTable("#" + elem)) {
                    $("#" + elem).DataTable({
                        serverSide: true,
                        processing: true,
                        ajax: route,
                        order: order,
                        scrollX: true,
                        searchable: true,
                        dom:
                            "<'row'<'col-sm-8 text-left dataTables_pager'li> <'col-sm-3 text-right'f> <'col-sm-1 text-right'B>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-12 dataTables_pager'p>>",
                        buttons: [
                            {'extend': 'reload', 'text': '<i class="la la-refresh"></i> <span>Reload</span>'}
                        ],
                        buttons: [
                            {'extend': 'reload', 'text': '<i class="la la-refresh"></i> <span>Reload</span>'}
                        ],
                        columns: getColumns
                    });
                }
            },
            init: function () {
                Data.loadList();
            }
        };
    
    $(document).ready(function () {
        Data.init();
    });
</script>