



<link rel="stylesheet" href="/css/emojionearea.min.css" />
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">


<div class="row">
    <div class="col-sm-9">
        <div class="input_classic">
            <div class="span6 ya">
                <div class="di">
                    <div class="my_avatar avatar_css" style="float: left">
                        <img src="/img/users/3/avatar.png" alt="avatar">
                    </div>
                    <div class=" avatar_css my_avatar" style="float:right; width: 20%">
                        <img src="/img/users/3/avatar.png" alt="avatar">
                    </div>

                </div>
                <textarea style="border: 0!important; width: 80%" id="emojionearea1" placeholder="Введите Ваше сообщение..."></textarea>

                <div class="sometin">
                    <button class="flat_button fl_r">Отправить</button>
                </div>
            </div>
        </div>
    </div>


</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script src="/js/emojionearea.min.js"></script>

<script>

    $(document).ready(function() {
        $("#emojionearea1").emojioneArea({
            pickerPosition: "left",
            tonesStyle: "bullet"
        });
        $("#emojionearea2").emojioneArea({
            pickerPosition: "bottom",
            tonesStyle: "radio"
        });
        $("#emojionearea3").emojioneArea({
            pickerPosition: "left",
            filtersPosition: "bottom",
            tonesStyle: "square"
        });
        $("#emojionearea4").emojioneArea({
            pickerPosition: "bottom",
            filtersPosition: "bottom",
            tonesStyle: "checkbox"
        });
        $("#emojionearea5").emojioneArea({
            pickerPosition: "top",
            filtersPosition: "bottom",
            tones: false,
            autocomplete: false,
            inline: true,
            hidePickerOnBlur: false
        });
    });
</script>



<style>
    * {
        font-family: Arial, Helvetica, san-serif;
    }
    .row:after, .row:before {
        content: " ";
        display: table;
        clear: both;
    }
    .span6 {
        float: left;
        width: 40%;
        padding: 1% 1% 0% 1%;
    }
    .emojionearea-editor:not(.inline) {
        min-height: 3em!important;
    }
    /*--------------------*/
    .sometin{
        padding: 15px 5px 5px 5px;
        min-height: 35px;
        border-top: 1px #d7d8db solid;
    }
    .flat_button{
        padding: 7px 16px 8px;
        margin: 0;
        font-size: 12.5px;
        display: inline-block;
        zoom: 1;
        cursor: pointer;
        white-space: nowrap;
        outline: none;
        font-family: -apple-system,BlinkMacSystemFont,Roboto,Open Sans,Helvetica Neue,sans-serif;
        vertical-align: top;
        line-height: 15px;
        text-align: center;
        text-decoration: none;
        background: none;
        background-color: #5e81a8;
        color: #fff;
        border: 0;
        border-radius: 2px;
        box-sizing: border-box;
    }
    .fl_r {
        float: right;
    }
    .ya{
        border-radius: 0 0 2px 2px;
        box-shadow: 0 1px 0 0 #d7d8db, 0 0 0 1px #e3e4e8;
    }
    .my_avatar{
        width: 20%;

    }
    .avatar_css{
        height: 46px!important;
        width: 46px!important;
        border-radius: 50%!important;
        overflow: hidden;
    }
    .avatar_css>img{
        max-width: 100%;
        height: auto;
        display: block;
    }

    .emojionearea{
        float: right;
        width: 80%;
    }
    .sometin{
        width: 80%;
        float: right;
    }
</style>

