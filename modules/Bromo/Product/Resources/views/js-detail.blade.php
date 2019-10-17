<script type="text/javascript">
    $(document).ready(function(){ 
        var original = $('input[name=default-tags]').tagify();
        var input = $('input[name=input-tags]').tagify();

        document.getElementById("input-form").style.display = "none";
        document.getElementById("edit-tags-btn").addEventListener("click", show_form);

        function show_form(){
            if(document.getElementById("input-form").style.display == "block")
                document.getElementById("input-form").style.display = "none";
            else if(document.getElementById("input-form").style.display = "none")
                document.getElementById("input-form").style.display = "block";
        }

    })
</script>