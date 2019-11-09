window._populateOrderItem = function(data) {
  
  // data.total_order_formatted = formatNumber(data.total_order)

  // Use mustache
  var template = $('#order-item').html();
  Mustache.parse(template);   // optional, speeds up future uses
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
    'data': 'shop_name', 
    'name': 'shop_name',
    
  }, 
  {
      'data': 'order_no', 
      'name': 'order_no',
      'searchable': true,
      
  }, 
  {
      'data': function(data, type, dataToSet){
          return data.buyer_name + '<br/><span class="text-danger">' + data.buyer_phone + '</span>';
      }, 
      'name': 'buyer_name',
  }, 
  {
      'data': 'total_order', 
      'name': 'total_order',
      'align': 'right',
      'render': $.fn.dataTable.render,
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
  dom:  
      "<'row'<'col-sm-6 text-left'l><'col-sm-12 text-right'B>>" +
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

window._performAcceptPickup = function( order_id ) {
  console.log(order_id)

  swalInfo('Mohon tunggu...', false)

  $.ajax({
    url: '/accept/' + order_id,
    method: 'PUT',
    data: {
      '_token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(data){
        if ( data.status == 'OK' ) {
          swalSuccess('Pesanan diterima', false, 2000)

          location.reload(true);

        } else {
          swalError('Oopps ada kesalahan sistem')
        }
    },
    error: function(error){
        console.log(error)
        swalError('Oopps ada kesalahan sistem')
    }
  })
}

window._performCancelPickup = function( order_id ) {
  console.log(order_id)

  swalInfo('Mohon tunggu...', false)

  $.ajax({
    url: '/cancel/' + order_id,
    method: 'PUT',
    data: {
      '_token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(data){
        if ( data.status == 'OK' ) {
          swalSuccess('Pickup dibatalkan', false, 2000)

          location.reload(true);

        } else {
          swalError('Oopps ada kesalahan sistem')
        }
    },
    error: function(error){
        console.log(error)
        swalError('Oopps ada kesalahan sistem')
    }
  })
}

window._performPickUpOrder = function( order_id ) {
  console.log(order_id)

  swalInfo('Mohon tunggu...', false)

  $.ajax({
    url: '/store-pickup/' + order_id,
    method: 'POST',
    data: new FormData(this),
    success: function(data){
        // if ( data.status == 'OK' ) {
        swalSuccess('Pesanan diterima', false, 2000)

        location.reload(true);

        // } else {
        //   swalError('Oopps ada kesalahan sistem')
        // }
    },
    error: function(error){
        console.log(error)
        swalError('Oopps ada kesalahan sistem')
    }
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

window.swalInfo = function ( message, showConfirmButton, timer ) {
  Swal.fire({
    position: 'top',
    type: 'info',
    text: message,
    showConfirmButton: (showConfirmButton==undefined) ? true : false,
    timer: (timer) ? timer : null,
  })
}

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

function swalError ( message, showConfirmButton, timer ) {
  Swal.fire({
    position: 'top',
    type: 'error',
    text: message,
    showConfirmButton: (showConfirmButton==undefined) ? true : false,
    timer: (timer) ? timer : null,
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

