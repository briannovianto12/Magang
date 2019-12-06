<script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function () {
        $(".product-id-cpy-btn").click(function(){
            var copyText = $(this).attr("data-id");
            var textArea = document.createElement("textarea");
            textArea.value = copyText;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("Copy");
            textArea.remove();
            alert('Text Copied!');
        });

        @isset($data)
        if ("{{ route('report.show', $data->id) }}" === "{{ url()->current() }}") {
            var switchEl = $('#status');

            switchEl.on('change', function () {
                $('#modal').modal('show');
            });

            $('#cancel').on('click', function () {
                if ("{{ $data->status }}" == "{{ \Bromo\Product\Models\ProductStatus::PUBLISH }}") {
                    switchEl.prop('checked', true);
                } else {
                    switchEl.prop('checked', false);
                }

                $('#modal').modal('hide');
            });
        }
        @endisset
        
    });
</script>