<script type="text/javascript">
    $(document).ready(function(){ 
        var input = $('input[name=input-tags]').tagify();
        var attachmentForm = $(".clone").html();

        $(".btn-add").click(function(){ 
            $(".clone").after(attachmentForm);
        });

        $("body").on("click",".btn-remove",function(){ 
            $(this).parents(".clone-child").remove();
        });

    });
</script>