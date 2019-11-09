<script type="text/javascript">
    $(document).ready(function(){ 
        document.getElementById("province").addEventListener("change", function(){
            var province = $(this).children("option:selected").val();
            document.getElementById("load-city-btn").addEventListener("click", function(){

            });
            document.getElementById("load-city-btn").click();
       });
    })
</script>