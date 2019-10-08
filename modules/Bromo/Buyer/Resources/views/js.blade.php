<script type="text/javascript">
    document.getElementById("cpy-btn").addEventListener("click", copy_address);

    function copy_address() {
        var copyText = document.getElementById("business-address");
        var textArea = document.createElement("textarea");
        textArea.value = copyText.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        alert('Text Copied!');
    }
</script>