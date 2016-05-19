<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>jQuery File Upload Example</title>
</head>
<body>
<input id="fileupload" type="file" name="files[]" data-url="test/server/php/" multiple>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/plugins/FileUploader/js/vendor/jquery.ui.widget.js"></script>
<script src="/plugins/FileUploader/js/jquery.iframe-transport.js"></script>
<script src="/plugins/FileUploader/js/jquery.fileupload.js"></script>

<div id="progress">
    <div class="bar" style="width: 0%;"></div>
</div>

<script>
    $(function () {
        $('#fileupload').fileupload({
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('<p/>').text(file.name).appendTo(document.body);
                });
            }
        });
    });




</script>
</body>
</html>
<style>
    .bar {
        height: 18px;
        background: green;
    }

</style>
