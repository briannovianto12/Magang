!function(a){var e={};function t(o){if(e[o])return e[o].exports;var n=e[o]={i:o,l:!1,exports:{}};return a[o].call(n.exports,n,n.exports,t),n.l=!0,n.exports}t.m=a,t.c=e,t.d=function(a,e,o){t.o(a,e)||Object.defineProperty(a,e,{configurable:!1,enumerable:!0,get:o})},t.n=function(a){var e=a&&a.__esModule?function(){return a.default}:function(){return a};return t.d(e,"a",e),e},t.o=function(a,e){return Object.prototype.hasOwnProperty.call(a,e)},t.p="/",t(t.s=0)}({0:function(a,e,t){t("INRN"),a.exports=t("1pLS")},"1pLS":function(a,e){},INRN:function(a,e){$(document).ready(function(){function a(){$("#table-regular-shop tbody").empty();var a=$("#shop-searchbar").val();$("#table-regular-shop").DataTable().destroy(),$("#table-regular-shop").DataTable({searching:!1,info:!1,processing:!0,ajax:"/popular-shop/search/"+a,columns:[{data:"shop_name",name:"shop_name"},{data:"action",name:"action"}],dom:'<"top"l>rt<"bottom"p><"clear">',ordering:!1,pagingType:"simple_numbers"}),$("#table-popular-shop").DataTable().draw(),$("#list-regular-shop").show()}function e(){$("#table-popular-shop").DataTable().destroy(),$("#table-popular-shop").DataTable({searching:!1,info:!1,processing:!0,ajax:"/popular-shop/get-list/",columns:[{data:"shop_name",name:"shop_name"},{data:"action",name:"action"}],dom:'<"top"l>rt<"bottom"p><"clear">',ordering:!1,pagingType:"simple_numbers"}),$("#table-popular-shop").DataTable().draw()}$("#shop-searchbar").val(""),$("#shop-search-form").submit(function(a){a.preventDefault()}),$("#btn-search-shop").click(function(){""==$("#shop-searchbar").val()?alert("Searchbar is empty!"):a()}),$("#shop-searchbar").keyup(function(a){a.preventDefault(),13===a.keyCode&&$("#btn-search-shop").click()}),e(),$(document).on("click",".btn-add-to-popular-list",function(t){var o=$(this).attr("data-id");console.log(o),t.preventDefault(),$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$.ajax({method:"POST",url:"/popular-shop/add",data:{shop_id:o},success:function(t){""!=$("#shop-searchbar").val()&&a(),e()}})}),$(document).on("click",".btn-remove-from-popular-list",function(t){var o=$(this).attr("data-id");confirm("Are you sure ?")&&(t.preventDefault(),$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$.ajax({method:"DELETE",url:"/popular-shop/"+o,success:function(t){""!=$("#shop-searchbar").val()&&a(),e()}}))}),$(document).on("click","#btn-update-index",function(a){a.preventDefault(),$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$.ajax({method:"POST",url:"/popular-shop/update-index",success:function(){alert("Index Updated!")}})})})}});