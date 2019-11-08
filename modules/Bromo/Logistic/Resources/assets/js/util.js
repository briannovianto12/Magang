window.formatNumber = function(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
  }
  
  window._populateOrderItem = function(data) {
  
    data.total_order_formatted = formatNumber(data.total_order)
  
    // Use mustache
    var template = $('#order-item').html();
    Mustache.parse(template);   // optional, speeds up future uses
    var rendered = Mustache.render(template, data);
    return rendered;
  }
  
  window._populateOrderDetails = function(data, options) {
    var html = '';
    
    if(data.order.quotation_snapshot!=null){
       data.order.quotation_total_gross = formatNumber(data.order.quotation_snapshot.net_detail.total_gross)
       data.order.quotation_total_discount = formatNumber(data.order.quotation_snapshot.net_detail.total_discount)
       data.order.quotation_total_order = formatNumber(data.order.quotation_snapshot.net_detail.total_order)
    }
  
    if(data.order.notes == null) {
      data.order.notes = '-'
    } 
    
    if(options == undefined)
    // options = { header: true, buyer: true, shipping: true, destination: true, invoice: false, label: false };
    options = { header: true, buyer: true, shipping: true, destination: true, invoice: false, label: false, notes: true};
  
    options.header = options.header || true;
    options.buyer = options.buyer || true;
    options.destination = options.destination || true;
    options.shipping = options.shipping || true;
  
    data.order.payment_details.total_order_formatted = formatNumber(data.order.payment_details.total_order)
  
    // Use mustache
    var template = $('#order-details').html();
    Mustache.parse(template);   // optional, speeds up future uses
  
    data.options = options
    var rendered = Mustache.render(template, data);
    return rendered;
  }
  
  
  window.def_dt_settings = {
    language: window._standardDataTableLang,
    "columnDefs": [
        { 
             className: "text-right font-weight-bold", 
             "targets": [ 4 ] 
        },
        {
            className: "font-weight-bold", 
             "targets": [ 2, 3 ]
        },
    ],
    serverSide: true,
    processing: true,
    ajax: "",
    order: [
        [5, 'desc']
    ],
    scrollX: true,
    dom: "<'row'<'col-sm-6 text-left'l><'col-sm-6 text-right'B>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
    buttons: [
        {'extend': 'reload', 'text': '<i class="la la-refresh"></i> <span>Segarkan</span>'}
    ],
    columns: [
    {
        'data': 'action',
        'name': 'action',
        'width': '80px',
        'searchable': false,
        'orderable': false,
        'exportable': false,
        'printable': false,
        'footer': 'Action'
    },
    {
        'data': 'DT_RowIndex',
        'name': 'DT_RowIndex',
        'orderable': false,
        'searchable': false,
        'width': '80px',
        "visible": false,
    }, {
        'data': 'order_no', 
        'name': 'order_no',
        
    }, {
        'data': function(data, type, dataToSet){
            return data.buyer_name + '<br/><span class="text-danger">' + data.buyer_phone + '</span>';
        }, 
        'name': 'buyer_name',
    }, {
        'data': 'total_order', 
        'name': 'total_order',
        'align': 'right',
        'render': $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' ),
    }, {
        'data': 'updated_at', 
        'name': 'updated_at',
        'width': '150px',
    }, {
      'data': 'reject_notes', 
      'name': 'reject_notes',
    }, {
      'data': 'notes', 
      'name': 'notes',
    }]
  };
  
  window.def_dt_mobile_settings = {
    language: window._standardDataTableLang,
    "columnDefs": [
        { 
             className: "bigger-text",
             targets: [0],
        },
    ],
    serverSide: true,
    processing: true,
    ajax: "",
    order: [
        
    ],
    scrollX: true,
    dom: "<'row'<'col-sm-6 text-left'l><'col-sm-6 text-right'B>>" +
        "<'row'<'col-sm-12'tr>>",
    buttons: [
        { 'extend': 'reload', 
          'text': '<i class="la la-refresh"></i> <span>Segarkan</span>',
          'className': 'btn-block',
        }
    ],
    columns: [
    {
        'data': function(data, type, dataToSet) {
            return _populateOrderItem(data);;
        }
    }]
  }
  // Swal Instance Helper
  window.swalConfirmOrder = function( html ) {
    return Swal.fire({
      position: 'top',
      // grow: 'fullscreen',
      title: '<strong>Konfirmasi Terima Order</strong>',
      type: '',
      html: html,
      showCloseButton: true,
      showCancelButton: true,
      focusConfirm: false,
      confirmButtonText:
          '<i class="fa fa-thumbs-up"></i> Terima',
      confirmButtonAriaLabel: 'Terima',
      cancelButtonText:
          '<i class="fa fa-thumbs-down"></i> Tolak',
      cancelButtonAriaLabel: 'Tolak'    
    })
  }
  window.swalSuccess = function ( message, showConfirmButton, timer ) {
    Swal.fire({
      position: 'top',
      type: 'success',
      text: message,
      showConfirmButton: (showConfirmButton==undefined) ? true : false,
      timer: (timer) ? timer : null,
    })
  }
  window.swalInfo = function ( message, showConfirmButton, timer ) {
    Swal.fire({
      position: 'top',
      type: 'info',
      text: message,
      showConfirmButton: (showConfirmButton==undefined) ? true : false,
      timer: (timer) ? timer : null,
    })
  }
  function swalError ( message, showConfirmButton, timer ) {
    Swal.fire({
      position: 'top',
      type: 'error',
      text: message,
      showConfirmButton: (showConfirmButton==undefined) ? true : false,
      timer: (timer) ? timer : null,
    })
  }
  window.swalQuestion = function ( title, text, type, input, inputOptions) {
    if (input == undefined) {
      return Swal.fire({
        position: 'top',
        title: title,
        text: text,
        type: (type==null) ? 'question': type,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
      })
    }
    return Swal.fire({
      position: 'top',
      title: title,
      text: text,
      type: (type==null) ? 'question': type,
      input: input,
      inputOptions: inputOptions,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak'
    })
  }
  
  // Perform AJAX Request to Reject Order
  window._performRejectOrder = function( order_id, reasonValue, callback ) {
    
    swalInfo('Mohon tunggu...', false)
  
    $.ajax({
      url: '/order/' + order_id + '/reject-order',
      method: 'PUT',
      dataType : "json",
      data: {
          '_token': $('meta[name="csrf-token"]').attr('content'),
          "reason" : reasonValue,
      },
      success: function(data){
          // Terima
          swalSuccess('Pesanan ditolak', false, 2000)
  
          if(callback) callback()
      },
      error: function(error){
          console.log(error)
          swalError('Oopps ada kesalahan sistem')
      }
    })
  }
  // Perform AJAX Request to Accept Order
  window._performAcceptOrder = function( order_id, callback ) {
  
    swalInfo('Mohon tunggu...', false)
  
    $.ajax({
      url: '/order/' + order_id + '/accept-order',
      method: 'PUT',
      dataType : "json",
      data: {
          '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data){
          // Terima
          swalSuccess('Pesanan diterima', false, 2000)
         
          if(callback) callback()
      },
      error: function(error){
          console.log(error)
          swalError('Oopps ada kesalahan sistem')
      }
    })
  }
  // Show Order Information for Confirm Order
  window._showInfoConfirmOrder = function( target, order_id, callback ) {
    $(target).attr('disabled', true)
    $.ajax({
        method: 'get',
        url: '/order-info/' + order_id,
        success: function(data){
            $(target).attr('disabled', false)
            var html = _populateOrderDetails(data)
            
            
            $('#modalConfirm .modal-dialog .modal-content .modal-body').html(html) 
            
            $('#modalConfirm').modal('show')
  
            $('#modalConfirm #btnTerima').click(function(){
              var order_id = $(this).parent().parent().next().find('#order_id').val()
              var btnClose = $(this).parent().parent().find('.btn-close')
              swalQuestion('Terima Pesanan', "Apakah anda yakin ?")
              .then((result) => {
                  if (result.value) {
                      
                    _performAcceptOrder ( order_id, callback)
                    btnClose.click()
                  }
              })
            });
            $('#modalConfirm #btnTolak').click(function(){
              var order_id = $(this).parent().parent().next().find('#order_id').val()
              var btnClose = $(this).parent().parent().find('.btn-close')
              swalQuestion('Tolak Pesanan', "Apakah anda yakin ?", "warning", 'select', window._standardReason)
              .then((result) => {
                  if (result.value) {
                      _performRejectOrder ( order_id, result.value, callback)
                      btnClose.click()
                  }
              })
            })
        },
        error: function(error){
            console.log(error)
            $(target).attr('disabled', false)
            swalError('Oopps ada kesalahan sistem')
        }
    })
  }
  
  window._showInfoOrderGeneral = function( order_id, invoice = false, label = false, ship = false ) {
    $.ajax({
      method: 'get',
      url: '/order-info/' + order_id,
      success: function(data){
  
          var html = _populateOrderDetails(data, { "invoice": invoice, "label": label, "ship": ship })
  
          Swal.fire({                              
              // grow: 'fullscreen',
              title: '<strong>Info Order</strong>',
              type: '',
              html: html,
              showCloseButton: true,
              showCancelButton: false,
              showConfirmButton: false,
              focusConfirm: false
          }).then((result) => {
              return
          })
      },
      error: function(error){
          console.log(error)
          swalError('Oopps ada kesalahan sistem')
      }
    })
  }
  
  window._callCourier = function(e, order_id, shipping_weight ){
    var html = '';
  
    $.get('/pickup-info')
    .done(function(data){
  
      //Backend return gram, convert into kgs
      data.shipping_weight = Math.ceil(0.001 * shipping_weight);
      data.id = order_id;
  
      // Use mustache
      var template = $('#pickup').html();
      Mustache.parse(template);   // optional, speeds up future uses
      
      html = Mustache.render(template, data);
  
      var today = new Date();
      var tomorrow = new Date();
      var hour = today.getHours();
      var validatePickupDate = new Date();
      if( hour < 12 ) {
        validatePickupDate = today;
      } else {
        tomorrow.setDate(today.getDate() + 1);
        validatePickupDate = tomorrow;
      }
    
      Swal.fire({                              
        // grow: 'fullscreen',
        title: '<strong>Panggil Kurir</strong>',
        type: '',
        html: html,
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        focusConfirm: false,
        customClass: 'swal2-overflow',
        onOpen: function(){
          $("[data-toggle='datepicker']").datepicker({
            todayHighlight: 1,
            daysOfWeekDisabled: [0],
            format: 'dd-mm-yyyy',
            orientation: "bottom left",
            startDate: validatePickupDate,
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
          }).on('show', function () {
              $(document).on('scroll', function () {
                  $("[data-toggle='datepicker']").datepicker('place')
              });
          })
          $('#btnKirim').click(function(){
              
              var data = {
                pickup_date: $('#pickup_date').val(),
                pickup_instruction: $('#pickup_instruction').val(),
                weight: $('#weight').val()
              }
  
              if( data.pickup_date == "") {
                alert("Pilih tanggal Pickup")
                $('#pickup_date').focus()
                return
              }
  
              var local_order_id = $(this).attr('data-order-id')
  
              $("#btnKirim").attr("disabled", true);
              $("#btnKirim").html("Harap tunggu");
              $.ajax({
                method: 'POST',
                url: '/pickup/' + local_order_id,
                dataType : "json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'pickup_date': data.pickup_date,
                    'pickup_instruction': data.pickup_instruction,
                    'dimension_weight': data.weight
                },
                success: function(data){
                    
                    if ( data.status == 'OK' && data.airwaybill != '' ) {
                      // swalSuccess('Data berhasil dikirim ke kurir. Mohon tunggu kurir untuk Pickup', false, 2000)
                      Swal.fire({
                        type: 'success',
                        html:
                          '<h4>' + 'pastikan cantumkan nomor ini di paket anda' + '</h4> \n' +
                          '<h3 style="color:green">' + data.airwaybill + '</h3>' +
                          '<h5>' + 'Data berhasil dikirim ke kurir. Mohon tunggu kurir untuk Pickup' + '</h5>' ,
                        showCloseButton: true,
                        showCancelButton: false,
                        focusConfirm: false,
                        confirmButtonAriaLabel: 'OK',
                      })
  
                      // Success
                      $('#order_process_mobile').DataTable().ajax.reload(function(){
                        $('#btnKirim').removeAttr("disabled");
                        $("#btnKirim").html("Kirim");
                        
                      })
                    } else if(data.status == 'OK' && data.airwaybill == '') {
                      Swal.fire({
                        type: 'success',
                        title: 'Data berhasil dikirim ke kurir.',
                        text: 'Mohon tunggu kurir untuk Pickup'
                      })
  
                      // Success
                      $('#order_process_mobile').DataTable().ajax.reload(function(){
                        $('#btnKirim').removeAttr("disabled");
                        $("#btnKirim").html("Kirim");
                        
                      })
                    } else {
                      $('#btnKirim').removeAttr("disabled");
                      $("#btnKirim").html("Kirim");
                      swalError(data.error)
                    }
                },
                error: function(error){
                    console.log(error)
                    $('#btnKirim').removeAttr("disabled");
                    
                    swalError('Oopps ada kesalahan sistem')
                }
  
              });
  
          })
        }
      }).then((result) => {
          
          return
      })
    })
    .fail(function(e) {
      console.log(e)
      alert( "Oops terjadi kesalahan pada sistem" );
    }); 
  }