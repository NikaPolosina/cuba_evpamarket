$(function(){
    $('#fileupload').fileupload({
        url                : fileUrl,
        previewMaxWidth    : 300,
        previewMaxHeight   : 300,
        filesContainer     : $('.files'),
        uploadTemplateId   : null,
        downloadTemplateId : null,
        uploadTemplate     : null,
        downloadTemplate   : null,
        autoUpload         : true

    })
        .on('fileuploadprocessalways', function(e, data){
        })
        .on('fileuploadadd', function(e, data){
        })
        .on('fileuploadsubmit', function(e, data){
            data.formData = {path : nededPath};})
        .on('fileuploaddone', function(e, data){

            var url = $('.files').find('.delete').attr('data-url');

            if(url && url.length > 0){
                $.ajax({
                    type:"DELETE",
                    url: url,
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }

                });
            }

            var row   = $('<tr class="template-upload">' +
            '<td>' +
            '<div>' +
            '<button class="btn btn-danger delete" data-type="DELETE" data-url="'+data.result.files[0]["deleteUrl"]+'&path='+nededPath+'"> Удалить </button>' +
            '</div>' +
            '<span class="preview"></span>' +
            '</td>' +
            '<div class="error"></div>' +
            '</td>' +
            '</tr>');
            row.find('.preview').append(data.files[0].preview);
            $('.files').html(row);
        })
        .on('fileuploaddestroy', function (e, data) {
            if(confirm('Вы уверены чт хотите удалить картинку ? Если Вы это сделаете, то она навсегда удалится с вашего альбома.')){
                $(data.context.context).parents('tr').eq(0).remove();

            }else{
                return false;
            }
        })
        .on('fileuploadfail', function(e, data){});
});