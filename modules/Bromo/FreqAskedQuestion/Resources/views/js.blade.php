<script type="text/javascript">
    $(document).ready(function(){ 
       document.getElementById("new-faq-btn").addEventListener("click", function(){
           location.href = "/faq/create";
       });
       document.getElementById("new-faq-cat-btn").addEventListener("click", function(){
           location.href = "/faq-category/create";
       });
       document.getElementById("faq-cat-list-btn").addEventListener("click", function(){
           location.href = "/faq-category/";
       });
    })
</script>