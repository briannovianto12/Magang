<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ nbs_asset('js/jquery.number.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    $(function () {    
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('payout.list') !!}",
            columns: [
                {
                    'data': 'action',
                    'name': 'action',
                    'white-space': 'nowrap',
                    'searchable': true,
                    'orderable': false,
                    'exportable': false,
                    'printable': false,
                    'footer': 'Action'
                },
                {data: 'internal_no', name: 'internal_no', searcheble: true, orderable: false},
                {data: 'created_for_user_id', name: 'created_for_user_id', orderable: false, searchable: true},
                {
                    'data' : 'amount', 
                    'name' : 'amount', 
                },
                {data: 'reason', name: 'reason', searchable: false},
                {data: 'additional_notes', name: 'additional_notes', searchable: false},
                {data: 'status', name: 'status', searchable: true},
                {data: 'created_by', name: 'created_by', searchable: true},
                {
                    data: 'created_at', 
                    name: 'created_at', 
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'expired_at', 
                    name: 'expired_at', 
                    searchable: true,
                    orderable: true
                },
            ],
            columnDefs: [
                {
                    targets: 2,
                    className: 'dt-right'
                },
            ],
            "processing": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            pageLength: 25,
            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            "createdRow": function ( row, data, index ) {
                var color = 'blue';
                if (data.status == "COMPLETED") {
                    color = 'green';
                } 
                if (data.status == 'FAILED') {
                    color = 'red';
                }
                if (data.status == 'EXPIRED') {
                    color = 'grey';
                }
                if (data.status == 'VOIDED') {
                    color = 'grey';
                }

                $(row).find('td:eq(6)').css('color', color);
            }

        });
    });

    function _send(route) {
        swal({
            title: "Are you sure?",
            type: "question",
            showCancelButton: true,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: route,
                    method: 'POST',
                    dataType : "json",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(data) {
                        if ( data.status == 'OK' ) {
                            Swal.fire({
                              position: 'top',
                              type: 'success',
                              text: data.message,
                            }).then(function(){ 
                              $('.data-table').DataTable().ajax.reload();
                              }
                            );  
                        } else if ( data.status == 'Failed' ) {
                            Swal.fire({
                              position: 'top',
                              type: 'error',
                              text: data.message,
                            })
                        } else {
                            Swal.fire({
                              position: 'top',
                              type: 'error',
                              text: 'Else!',
                            })
                        }
                    },
                    error: function(error){
                        Swal.fire({
                            position: 'top',
                            type: 'error',
                            text: 'Error!',
                        })
                    }
                })
            }
        });
    }

    $(document).ready(function () {
        function formatNumber(num) {
          return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        }

        function arrayRemove(arr, value) {
            return arr.filter(function(ele){
                return ele != value;
            });
        }

        $('.number').number(true,0, ',', '.');

        $('#created_for').select2({
            placeholder: "Choose user...",
            minimumInputLength: 2,
            ajax: {
                url: "search-user",
                dataType: 'json',
                data: function (params) {
                
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    });

    var maxLength = 148;
    var maxLengthTitle = 40;
    
    $('textarea').keyup(function() {
        var length = $(this).val().length;
        var length = maxLength-length;
        $('#chars').text(length);
    });

    $(".alert").fadeTo(3000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
    });




</script>
