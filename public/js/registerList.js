$(function() {
    $( "#datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        changeDay: true

    }).datepicker( "option", "dateFormat", 'yy.mm.dd')
        .datepicker("option", "dayNamesMin",  ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"] )
        .datepicker("option", "monthNamesShort",  ["Янв", "Февр", "Март", "Апр", "Май","Июнь","Июль","Авг","Сент","Окт","Нояб","Декаб"])
        .datepicker("option", "duration",  "slow")
        .datepicker("option", "yearRange",  "1916:2001")
        .datepicker("option", "maxDate",  new Date(2001, 1 - 2, 31));

    $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});


});



