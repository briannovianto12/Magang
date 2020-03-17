<script>
    $(document).ready(function () {
        $('#logistic_provider_city').select2({
            placeholder: "Choose Logistic Provider...",
            minimumInputLength: 2,
            ajax: {
                url: "search-logistic-provider",
                dataType: 'json',
                data: function (params) {
                
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('#logistic_provider_building').select2({
            placeholder: "Choose Logistic Provider...",
            minimumInputLength: 2,
            ajax: {
                url: "search-logistic-provider",
                dataType: 'json',
                data: function (params) {
                
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


        $('#city').select2({
            placeholder: "Choose City...",
            minimumInputLength: 2,
            ajax: {
                url: "search-city",
                dataType: 'json',
                data: function (params) {
                
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('#building').select2({
            placeholder: "Choose Building...",
            minimumInputLength: 2,
            ajax: {
                url: "search-building",
                dataType: 'json',
                data: function (params) {
                
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

    });
</script>