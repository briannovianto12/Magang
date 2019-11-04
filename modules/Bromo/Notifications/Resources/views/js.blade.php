<script src="http://code.jquery.com/jquery-1.5.js"></script>
<script>
    var maxLength = 148;
    var maxLengthTitle = 40;
    
    $('textarea').keyup(function() {
      var length = $(this).val().length;
      var length = maxLength-length;
      $('#chars').text(length);
    });

    $("#message-title").keyup(function() {
      var length = $(this).val().length;
      var length = maxLengthTitle-length;
      $('#title-chars').text(length);
    });

    $("#topic").change(function () {
    if($(this).val() == "0") $(this).addClass("empty");
    else $(this).removeClass("empty")
    });
    
    $("#topic").change();

</script>