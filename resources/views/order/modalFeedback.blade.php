<div class="modal fade" id="feed_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Редактор отзыва</h4>
            </div>
            <div class="modal-body">
                <input class="input_id_modal_feed" value="" type="hidden"/>
                <textarea  id="modal_body" name=""  cols="30" rows="10"></textarea>

            </div>
            <div class="modal-footer" style="text-align: right;">
                <button type="button"  class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                <button type="button"  id="feed-change" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<script src="/plugins/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea",theme: "modern",width: 850 ,height: 300,
        language: 'ru',
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor " +
            "responsivefilemanager" +
            " code"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        image_advtab: true ,

        external_filemanager_path:"/plugins/responsive_filemanager/filemanager/",
        filemanager_title:"Responsive Filemanager" ,
        external_plugins: { "filemanager" : "/plugins/responsive_filemanager/filemanager/plugin.min.js"}
    });
</script>