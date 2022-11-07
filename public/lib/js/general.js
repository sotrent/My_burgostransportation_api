var actuante=[];
var incrementador=0;
var lastModalSelected="";
$(".ui.dropdown").dropdown();

function openlilmenu(){
  $(".lilmenu").slideDown();
  $("#hanLilmenuop").hide();
  $("#hanLilmenucl").show();
}
function hidelilmenu(){
  $(".lilmenu").slideUp();
  $("#hanLilmenuop").show();
  $("#hanLilmenucl").hide();
}
function noTxtmenu(){
  $(".noTextMenu").hide();
  $("#lilmenu").addClass('notxtmenu');
  $("#sitextbuton").show();
  $("#notextbuton").hide();
  //document.getElementById('lilmenu').style.width = "53px";
}
function siTxtmenu(){
  $(".noTextMenu").show(25);
  $("#lilmenu").removeClass('notxtmenu');
  $("#sitextbuton").hide();
  $("#notextbuton").show();
}

function showGenNew(){
  $(".ui.generalNew.modal").modal('show');
  lastModalSelected="generalNew";
}
function showGenView(){
  $(".ui.generalView.modal").modal('show');
  lastModalSelected="generalView";
}
function showGenEdit(){
  $(".ui.generalEdit.modal").modal('show');
  lastModalSelected="generalEdit";
}

function hideGenNew(){
  $(".ui.generalNew.modal").modal('hide');
}
function hideGenView(){
  $(".ui.generalView.modal").modal('hide');
}
function hideGenEdit(){
  $(".ui.generalEdit.modal").modal('hide');
}


function tostadora(tipejo,cual){
  switch (tipejo) {
    case 1:
      toastr.success(cual,"");
      break;
    case 2:
     toastr.info(cual,"");
     break;
    case 3:
     toastr.warning(cual,"");
     break;
    case 4:
     toastr.error(cual,"");
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
