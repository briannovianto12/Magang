/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Resources/assets/js/logistic.js":
/*!*****************************************!*\
  !*** ./Resources/assets/js/logistic.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

window._populateOrderItem = function (data) {
  // data.total_order_formatted = formatNumber(data.total_order)
  // Use mustache
  var template = $('#order-item').html();
  Mustache.parse(template); // optional, speeds up future uses

  var rendered = Mustache.render(template, data);
  return rendered;
};

window.def_dt_settings = {
  language: window._standardDataTableLang,
  "columnDefs": [{
    className: "text-right font-weight-bold",
    "targets": [4]
  }, {
    className: "font-weight-bold",
    "targets": [2, 3]
  }],
  serverSide: true,
  processing: true,
  ajax: "",
  order: [[5, 'desc']],
  scrollX: true,
  dom: "<'row'<'col-sm-6 text-left'l><'col-sm-6 text-right'B>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
  buttons: [{
    'extend': 'reload',
    'text': '<i class="la la-refresh"></i> <span>Segarkan</span>'
  }],
  columns: [{
    'data': 'action',
    'name': 'action',
    'width': '80px',
    'searchable': false,
    'orderable': false,
    'exportable': false,
    'printable': false,
    'footer': 'Action'
  }, {
    'data': 'DT_RowIndex',
    'name': 'DT_RowIndex',
    'orderable': false,
    'searchable': false,
    'width': '80px',
    "visible": false
  }, {
    'data': 'shop_name',
    'name': 'shop_name'
  }, {
    'data': 'order_no',
    'name': 'order_no',
    'searchable': true
  }, {
    'data': function data(_data, type, dataToSet) {
      return _data.buyer_name + '<br/><span class="text-danger">' + _data.buyer_phone + '</span>';
    },
    'name': 'buyer_name'
  }, {
    'data': 'total_order',
    'name': 'total_order',
    'align': 'right',
    'render': $.fn.dataTable.render
  }, {
    'data': 'updated_at',
    'name': 'updated_at',
    'width': '150px'
  }, {
    'data': 'reject_notes',
    'name': 'reject_notes'
  }, {
    'data': 'notes',
    'name': 'notes'
  }]
};
window.def_dt_mobile_settings = {
  language: window._standardDataTableLang,
  "columnDefs": [{
    className: "bigger-text",
    targets: [0]
  }],
  serverSide: true,
  processing: true,
  ajax: "",
  order: [],
  scrollX: true,
  dom: "<'row'<'col-sm-6 text-left'l><'col-sm-12 text-right'B>>" + "<'row'<'col-sm-12'tr>>",
  buttons: [{
    'extend': 'reload',
    'text': '<i class="la la-refresh"></i> <span>Segarkan</span>',
    'className': 'btn-block'
  }],
  columns: [{
    'data': function data(_data2, type, dataToSet) {
      return _populateOrderItem(_data2);
      ;
    }
  }]
};

window._performAcceptPickup = function (order_id) {
  console.log(order_id);
  swalInfo('Mohon tunggu...', false);
  $.ajax({
    url: '/accept/' + order_id,
    method: 'PUT',
    data: {
      '_token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      if (data.status == 'OK') {
        swalSuccess('Pesanan diterima', false, 2000);
        location.reload(true);
      } else {
        swalError('Oopps ada kesalahan sistem');
      }
    },
    error: function error(_error) {
      console.log(_error);
      swalError('Oopps ada kesalahan sistem');
    }
  });
};

window._performCancelPickup = function (order_id) {
  console.log(order_id);
  swalInfo('Mohon tunggu...', false);
  $.ajax({
    url: '/cancel/' + order_id,
    method: 'PUT',
    data: {
      '_token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      if (data.status == 'OK') {
        swalSuccess('Pickup dibatalkan', false, 2000);
        location.reload(true);
      } else {
        swalError('Oopps ada kesalahan sistem');
      }
    },
    error: function error(_error2) {
      console.log(_error2);
      swalError('Oopps ada kesalahan sistem');
    }
  });
};

window._performPickUpOrder = function (order_id) {
  console.log(order_id);
  swalInfo('Mohon tunggu...', false);
  $.ajax({
    url: '/store-pickup/' + order_id,
    method: 'POST',
    data: new FormData(this),
    success: function success(data) {
      // if ( data.status == 'OK' ) {
      swalSuccess('Pesanan diterima', false, 2000);
      location.reload(true); // } else {
      //   swalError('Oopps ada kesalahan sistem')
      // }
    },
    error: function error(_error3) {
      console.log(_error3);
      swalError('Oopps ada kesalahan sistem');
    }
  });
};

window.swalQuestion = function (title, text, type, input, inputOptions) {
  if (input == undefined) {
    return Swal.fire({
      position: 'top',
      title: title,
      text: text,
      type: type == null ? 'question' : type,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak'
    });
  }

  return Swal.fire({
    position: 'top',
    title: title,
    text: text,
    type: type == null ? 'question' : type,
    input: input,
    inputOptions: inputOptions,
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya',
    cancelButtonText: 'Tidak'
  });
};

window.swalInfo = function (message, showConfirmButton, timer) {
  Swal.fire({
    position: 'top',
    type: 'info',
    text: message,
    showConfirmButton: showConfirmButton == undefined ? true : false,
    timer: timer ? timer : null
  });
};

window.swalConfirmOrder = function (html) {
  return Swal.fire({
    position: 'top',
    // grow: 'fullscreen',
    title: '<strong>Konfirmasi Terima Order</strong>',
    type: '',
    html: html,
    showCloseButton: true,
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: '<i class="fa fa-thumbs-up"></i> Terima',
    confirmButtonAriaLabel: 'Terima',
    cancelButtonText: '<i class="fa fa-thumbs-down"></i> Tolak',
    cancelButtonAriaLabel: 'Tolak'
  });
};

function swalError(message, showConfirmButton, timer) {
  Swal.fire({
    position: 'top',
    type: 'error',
    text: message,
    showConfirmButton: showConfirmButton == undefined ? true : false,
    timer: timer ? timer : null
  });
}

window.swalSuccess = function (message, showConfirmButton, timer) {
  Swal.fire({
    position: 'top',
    type: 'success',
    text: message,
    showConfirmButton: showConfirmButton == undefined ? true : false,
    timer: timer ? timer : null
  });
};

/***/ }),

/***/ "./Resources/assets/sass/app.scss":
/*!****************************************!*\
  !*** ./Resources/assets/sass/app.scss ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!********************************************************************************!*\
  !*** multi ./Resources/assets/js/logistic.js ./Resources/assets/sass/app.scss ***!
  \********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/aliirawan/Projects/Grosera/bromo-platform-dashboard/modules/Bromo/Logistic/Resources/assets/js/logistic.js */"./Resources/assets/js/logistic.js");
module.exports = __webpack_require__(/*! /Users/aliirawan/Projects/Grosera/bromo-platform-dashboard/modules/Bromo/Logistic/Resources/assets/sass/app.scss */"./Resources/assets/sass/app.scss");


/***/ })

/******/ });