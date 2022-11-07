

$(".calendas").calentim({
        format: "YYYY-MM-DD",
      //  locale: 'es',
      //  minDate: moment().subtract(0, "days").startOf("day"),
        showOn: "left",
        //arrowOn: "center",
        showFooter: false,
        showTimePickers: false,
        startEmpty: true,
        showHeader: false,
        singleDate: true,
        autoCloseOnSelect: true,
        /*disabledRanges: [
          {
            "start": moment("2019-09-22","YYYY-MM-DD"),
            "end": moment("2019-09-30", "YYYY-MM-DD")
          }
        ]*/

});
/*
var startDate, endDate, startInstance, endInstance;
var fillInputs = function () {
    if (startDate) startInstance.$elem.val(startDate.locale(startInstance.config.locale).format(startInstance.config.format));
    if (endDate) endInstance.$elem.val(endDate.locale(endInstance.config.locale).format(endInstance.config.format));
};
var beforeShow = function (instance) {
    if (startDate) {
        startInstance.config.startDate = startDate.clone();
        endInstance.config.startDate = startDate.clone();
    }
    if (endDate) {
        startInstance.config.endDate = endDate.clone();
        endInstance.config.endDate = endDate.clone();
    }
    fillInputs();
    instance.updateHeader();
    instance.reDrawCells();
    instance.updateTimePickerDisplay();
};
$("#datePickup").calentim({
    startEmpty: $("#datePickup").val() === "",
    startDate: $("#datePickup").val(),
    endDate: $("#dateDeliver").val(),
    enableKeyboard: false,
    format: "YYYY-MM-DD HH:mm",
    hourFormat: 24,
    minuteSteps: 15,
    showButtons: true,
    locale: 'es',
    minDate: moment().subtract(0, "days").startOf("day"),
    showFooter: false,
    oninit: function (instance) {
        startInstance = instance;
        if (!instance.config.startEmpty && instance.config.startDate) {
            instance.$elem.val(instance.config.startDate.locale(instance.config.locale).format(instance.config.format));
            startDate = instance.config.startDate.clone();
        }
    },
    onaftershow: beforeShow,
    ontimechange: function (instance, start, end) {
        if(start) startDate = start.clone();
        if(end) endDate = end.clone();
        fillInputs();
    },
    onfirstselect: function (instance, start) {
        startDate = start.clone();
        endDate = null;
        startInstance.globals.startSelected = false;
        startInstance.hideDropdown();
        endInstance.showDropdown();
        endInstance.setDisplayDate(start.clone());
        endInstance.config.minDate = startDate.clone();
        endInstance.config.startDate = startDate.clone();
        endInstance.config.endDate = null;
        endInstance.globals.startSelected = true;
        endInstance.globals.endSelected = false;
        endInstance.globals.firstValueSelected = true;
        if (endDate && startDate.isAfter(endDate)){
            endInstance.config.endDate = endDate.clone();
        }
        fillInputs();
        endInstance.updateHeader();
        endInstance.reDrawCells();
        endInstance.updateTimePickerDisplay();
    }
});
$("#dateDeliver").calentim({
    startEmpty: $("#dateDeliver").val() === "",
    startDate: $("#datePickup").val(),
    endDate: $("#dateDeliver").val(),
    format: "YYYY-MM-DD HH:mm",
    hourFormat: 24,
    minuteSteps: 15,
    showButtons: true,
    locale: 'es',
    minDate: moment().subtract(0, "days").startOf("day"),
    showFooter: false,
    oninit: function (instance) {
        endInstance = instance;
        if (!instance.config.startEmpty && instance.config.endDate) {
            instance.$elem.val(instance.config.endDate.locale(instance.config.locale).format(instance.config.format));
            endDate = instance.config.endDate.clone();
        }
    },
    onaftershow: beforeShow,
    ontimechange: function (instance, start, end) {
        if(start) startDate = start.clone();
        if(end) endDate = end.clone();
        fillInputs();
    },
    onafterselect: function (instance, start, end) {
        startDate = start.clone();
        endDate = end.clone();
        endInstance.hideDropdown();
        startInstance.config.endDate = endDate.clone();
        startInstance.globals.firstValueSelected = true;
        fillInputs();
        endInstance.globals.startSelected = true;
        endInstance.globals.endSelected = false;
    }
});
*/
