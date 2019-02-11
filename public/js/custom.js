var App = function () {
    return {
        sellerDataTable() {
            $("#sellerDataTable").DataTable({
                responsive: !0, columnDefs: [{
                    targets: -1, title: "Actions", orderable: !1, render: function (a, t, e, n) {
                        return '<span class="dropdown">' +
                            '<a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">' +
                            '<i class="la la-ellipsis-h"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a class="dropdown-item" href="#"><i class="la la-edit"></i>Edit</a>' +
                            '<a class="dropdown-item" href="#"><i class="la la-check-circle"></i>Approve</a>' +
                            '<a class="dropdown-item" href="#"><i class="la la-times-circle"></i>Reject</a>' +
                            '</div></span>' +
                            '<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">' +
                            '<i class="la la-edit"></i></a>'
                    }
                }]
            })
        }
        
        // insert your custom js here
    }
}();