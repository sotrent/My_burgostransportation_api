$(".ui.dropdown").dropdown();
$('.ui.accordion').accordion();
/*
$('.menu.dropdown').popup({
    on         : 'click',
    inline     : true,
    // hoverable  : true,
    position   : 'bottom left',
    // delay: {
    //   show: 300,
    //   hide: 800
    // }
  });
*/
function tostadora(tipejo,cual="No Definido",moduloadmin=""){
 switch (tipejo) {
   case 1:
     toastr.success(cual,moduloadmin);
     break;
   case 2:
    toastr.info(cual,moduloadmin);
    break;
   case 3:
    toastr.warning(cual,moduloadmin);
    break;
   case 4:
    toastr.error(cual,moduloadmin);
    break;
 }
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-center",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "400",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
}
function cargaloader(cual){
  $("#"+cual).toggleClass('active');
}
$(".calendas").calentim({
        format: "YYYY-MM-DD",
        locale: 'es',
        //minDate: moment().subtract(0, "days").startOf("day"),
        //showOn: "left",
        //arrowOn: "center",
        autoAlign: true,
        calendarCount: 1,
        showFooter: false,
        showTimePickers: false,
        startEmpty: true,
        showHeader: false,
        singleDate: true,
        autoCloseOnSelect: true,
});
