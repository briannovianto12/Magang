!function(i){var e={};function t(o){if(e[o])return e[o].exports;var n=e[o]={i:o,l:!1,exports:{}};return i[o].call(n.exports,n,n.exports,t),n.l=!0,n.exports}t.m=i,t.c=e,t.d=function(i,e,o){t.o(i,e)||Object.defineProperty(i,e,{enumerable:!0,get:o})},t.r=function(i){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(i,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(i,"__esModule",{value:!0})},t.t=function(i,e){if(1&e&&(i=t(i)),8&e)return i;if(4&e&&"object"==typeof i&&i&&i.__esModule)return i;var o=Object.create(null);if(t.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:i}),2&e&&"string"!=typeof i)for(var n in i)t.d(o,n,function(e){return i[e]}.bind(null,n));return o},t.n=function(i){var e=i&&i.__esModule?function(){return i.default}:function(){return i};return t.d(e,"a",e),e},t.o=function(i,e){return Object.prototype.hasOwnProperty.call(i,e)},t.p="/",t(t.s=2)}({2:function(i,e,t){i.exports=t("oezg")},oezg:function(i,e){$(document).ready((function(){$("#origin-province").change((function(){var i=$(this).children("option:selected").val();$("#origin-city").find("option").remove(),$("#origin-district").find("option").remove(),$("#origin-subdistrict").find("option").remove(),$("#origin-postal-code").val(""),""!=i&&$.getJSON("/tools/postalCodeFinder/province/"+i,(function(i){$("#origin-city").prepend("<option value='' selected='selected'></option>"),$("#origin-district").prepend("<option value='' selected='selected'></option>"),$("#origin-subdistrict").prepend("<option value='' selected='selected'></option>"),i.cities.forEach((function(i){$("#origin-city").append(new Option(i.name,i.id))}))}))})),$("#origin-city").change((function(){var i=$(this).children("option:selected").val();""!=i&&($("#origin-district").find("option").remove(),$("#origin-subdistrict").find("option").remove(),$("#origin-postal-code").val(""),$.getJSON("/tools/postalCodeFinder/city/"+i,(function(i){$("#origin-district").prepend("<option value='' selected='selected'></option>"),$("#origin-subdistrict").prepend("<option value='' selected='selected'></option>"),i.districts.forEach((function(i){$("#origin-district").append(new Option(i.name,i.id))}))})))})),$("#origin-district").change((function(){var i=$(this).children("option:selected").val();$("#origin-subdistrict").find("option").remove(),$("#origin-postal-code").val(""),""!=i&&$.getJSON("/tools/postalCodeFinder/district/"+i,(function(i){$("#origin-subdistrict").prepend("<option value='' selected='selected'></option>"),i.subdistricts.forEach((function(i){$("#origin-subdistrict").append(new Option(i.name,i.id))}))}))})),$("#origin-subdistrict").change((function(){var i=$(this).children("option:selected").val();$("#origin-postal-code").val(""),""!=i&&$.getJSON("/tools/postalCodeFinder/subdistrict/"+i,(function(i){$("#origin-postal-code").val(i.postal_code)}))})),$("#destination-province").change((function(){var i=$(this).children("option:selected").val();$("#destination-city").find("option").remove(),$("#destination-district").find("option").remove(),$("#destination-subdistrict").find("option").remove(),$("#destination-postal-code").val(""),""!=i&&$.getJSON("/tools/postalCodeFinder/province/"+i,(function(i){$("#destination-city").prepend("<option value='' selected='selected'></option>"),$("#destination-district").prepend("<option value='' selected='selected'></option>"),$("#destination-subdistrict").prepend("<option value='' selected='selected'></option>"),i.cities.forEach((function(i){$("#destination-city").append(new Option(i.name,i.id))}))}))})),$("#destination-city").change((function(){var i=$(this).children("option:selected").val();$("#destination-district").find("option").remove(),$("#destination-subdistrict").find("option").remove(),$("#destination-postal-code").val(""),""!=i&&$.getJSON("/tools/postalCodeFinder/city/"+i,(function(i){$("#destination-district").prepend("<option value='' selected='selected'></option>"),$("#destination-subdistrict").prepend("<option value='' selected='selected'></option>"),i.districts.forEach((function(i){$("#destination-district").append(new Option(i.name,i.id))}))}))})),$("#destination-district").change((function(){var i=$(this).children("option:selected").val();$("#destination-subdistrict").find("option").remove(),$("#destination-postal-code").val(""),""!=i&&$.getJSON("/tools/postalCodeFinder/district/"+i,(function(i){$("#destination-subdistrict").prepend("<option value='' selected='selected'></option>"),i.subdistricts.forEach((function(i){$("#destination-subdistrict").append(new Option(i.name,i.id))}))}))})),$("#destination-subdistrict").change((function(){var i=$(this).children("option:selected").val();$("#destination-postal-code").val(""),""!=i&&$.getJSON("/tools/postalCodeFinder/subdistrict/"+i,(function(i){$("#destination-postal-code").val(i.postal_code)}))})),$("#package-weight").change((function(){var i=$("#package-value").val();$("#package-value").attr("value","IDR ".concat(i.toString()).concat(".00"))})),$("#btn-simulate").click((function(i){$("#shipper-list").hide(),$("#regular-shipper-list").empty(),$("#express-shipper-list").empty(),$("#trucking-shipper-list").empty(),i.preventDefault(),""==$("#package-weight").val()||""==$("#package-value").val()||""==$("#package-sizet").val()||""==$("#destination-postal-code").val()||""==$("#origin-postal-code").val()?alert("Please fill all the field!"):$.ajax({method:"GET",url:"/tools/shipping-simulation/simulate",contentType:"Appiclation/Json",dataType:"json",data:$("#simulation-form").serialize(),processData:!1,success:function(i){null!=i.shippers?(void 0!==i.shippers.regular_shippers?0!=i.shippers.regular_shippers[0].options.length&&(i.shippers.regular_shippers[0].options.forEach((function(i){var e=i.finalRate-i.platform_discount,t='<div class="row removeable"><div class="col-1"><img src="'+i.logo_url+'"></div><div class="col-3 ml-5"><h5>'+i.name+"</h5><h5> IDR "+e+" <strike> IDR "+i.finalRate+"</strike></h5></div></div>";$("#regular-shipper-list").append(t)})),$("#regular-shipper-list").show()):($("#regular-shipper-list-header").hide(),$("#regular-shipper-list").hide()),void 0!==i.shippers.express_shippers?0!=i.shippers.express_shippers[0].options.length&&(i.shippers.express_shippers[0].options.forEach((function(i){var e=i.finalRate-i.platform_discount,t='<div class="row removeable"><div class="col-1"><img src="'+i.logo_url+'"></div><div class="col-3 ml-5"><h5>'+i.name+"</h5><h5> IDR "+e+" <strike> IDR "+i.finalRate+"</strike></h5></div></div>";$("#express-shipper-list").append(t)})),$("#express-shipper-list").show()):($("#express-shipper-list-header").hide(),$("#express-shipper-list").hide()),void 0!==i.shippers.trucking_shippers?0!=i.shippers.trucking_shippers[0].options.length&&(i.shippers.trucking_shippers[0].options.forEach((function(i){var e=i.finalRate-i.platform_discount,t='<div class="row removeable"><div class="col-1"><img src="'+i.logo_url+'"></div><div class="col-3 ml-5"><h5>'+i.name+"</h5><h5> IDR "+e+" <strike> IDR "+i.finalRate+"</strike></h5></div></div>";$("#trucking-shipper-list").append(t)})),$("#trucking-shipper-list").show()):($("#trucking-shipper-list-header").hide(),$("#trucking-shipper-list").hide()),$("#shipper-list").show()):($("#shipper-list").hide(),$("#shipper-list-error").show())}})}))}))}});
