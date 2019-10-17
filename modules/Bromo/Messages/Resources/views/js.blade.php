<script type="text/javascript">

    $(document).ready(function () {

        document.getElementById("filter-search-btn").addEventListener("click", filter_search);

        function filter_search(){
            var val = $('#search-box').val();
            alert(val);
            window.location.href = 'messages/search/';
        } 
    })

</script>