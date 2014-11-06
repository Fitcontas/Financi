$(document).ready(function() {
	setTimeout(function () {
		apply_datepicker();
	}, 100);
});

function apply_datepicker()
{

    $('.input-group.contrato-date, .input-datapicker').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: true,
        endDate: new Date()
    });
    
    $(".input-group.date, .input-datapicker").datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: true
    });

    
}

function isInt(n) {
    return typeof n === 'number' && n % 1 == 0;
}