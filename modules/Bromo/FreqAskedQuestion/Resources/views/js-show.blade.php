<script type="text/javascript">
    $(document).ready(function(){ 
       document.getElementById("edit-faq-btn").addEventListener("click", function(){
            var faq_id = $(this).attr('faq-id');
            location.href = "/faq/" + faq_id + "/edit";
       });
    })
</script>