
    <link rel="stylesheet" href="css/docsupport/style.css">
    <link rel="stylesheet" href="css/docsupport/prism.css">
    <link rel="stylesheet" href="css/chosen.css">



                    <select data-placeholder="Выбирите магазин..." class="chosen-select" style="width:350px;" tabindex="2">
                        <option value=""></option>
                        <option value="United States">United States</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Aland Islands">Aland Islands</option>
                        <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
                    </select>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
    <script src="js/select/docsupport/chosen.jquery.js" type="text/javascript"></script>
    <script src="js/select/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Ой, ничего не найдено!'},
            '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    </script>


