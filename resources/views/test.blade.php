<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/emojify.js/1.1.0/css/basic/emojify.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/es5-shim/4.5.7/es5-shim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/es5-shim/4.5.7/es5-sham.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/json3/3.3.2/json3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.34.2/es6-shim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.34.2/es6-sham.min.js"></script>
<script src="https://wzrd.in/standalone/es7-shim@latest"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/emojify.js/1.1.0/js/emojify.min.js"></script>
{{--<script src="/plugins/Ranks-emojify/dist/js/emojify.min.js"></script>--}}

<script>
    $(document).ready(function () {
        emojify.setConfig({

            emojify_tag_type : 'div',           // Only run emojify.js on this element
            only_crawl_id    : null,            // Use to restrict where emojify.js applies
            img_dir          : '/img/emoji',  // Directory for emoji images
            ignored_tags     : {                // Ignore the following tags
                'SCRIPT'  : 1,
                'TEXTAREA': 1,
                'A'       : 1,
                'PRE'     : 1,
                'CODE'    : 1
            }
        });
        emojify.run();



        $('div.my_icon').find('img.emoji').on('click', function () {
            var src = $(this).attr('src');
            var alt = $(this).attr('alt');
            var title = $(this).attr('title');
            var input_val = $('#emo').html();


            $('#emo').html(input_val+'<img align="absmiddle" alt="'+alt+'" class="emoji" src="'+src+'" title="'+title+'"></img>');




        })



    });




</script>

<div contenteditable="true" style="outline: solid black 1px; width: 600px; min-height: 30px" id="emo"></div>


<img align="absmiddle" alt=":bowtie:" class="emoji" src="/img/emoji/bowtie.png" title=":bowtie:">


<p>
    :bowtie:
</p>




<div class="my_icon">
    <p>
        :bowtie:
        :smile:
        :laughing:
        :blush:
        :smiley:
        :running:
        :couple:
    </p>
</div>
