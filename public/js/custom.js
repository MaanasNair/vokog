$(document).on('nifty.ready', function() {

	$('.editor').each(function(el){
		var editor = new Jodit(this, {
		  	"uploader": {
		    "insertImageAsBase64URI": true
		},
			"toolbarAdaptive": false
		});
	});

	// SELECT2 SINGLE
	// =================================================================
	// Require Select2
	// https://github.com/select2/select2
	// =================================================================
	$(".demo-select2").select2();

	// SELECT2 SINGLE
	// color select select2
	$('.color-var-select').select2({
        templateResult: colorCodeSelect,
        templateSelection: colorCodeSelect,
        escapeMarkup: function(m) { return m; }
    });
    function colorCodeSelect(state) {
        var colorCode = $(state.element).val();
        if (!colorCode) return state.text;
        return  "<span class='color-preview' style='background-color:"+colorCode+";'></span>" + state.text;
    }


	// SELECT2 Maximum Limit 4
	// =================================================================
	// Require Select2
	// https://github.com/select2/select2
	// =================================================================
	$(".demo-select2-max-4").select2({
        maximumSelectionLength: 4
    });

	$(".demo-select2-max-10").select2({
        maximumSelectionLength: 10
    });


	// SELECT2 PLACEHOLDER
	// =================================================================
	// Require Select2
	// https://github.com/select2/select2
	// =================================================================
	$(".demo-select2-placeholder").select2({
	    placeholder: "Select an option",
	    allowClear: true
	});



	// SELECT2 SELECT BOXES
	// =================================================================
	// Require Select2
	// https://github.com/select2/select2
	// =================================================================
	$(".demo-select2-multiple-selects").select2();

	// $('.demo-sw').each(function(){
	// 	new Switchery(this);
	// });
	//
	// $('.demo-dt-basic').on( 'length.dt', function ( e, settings, len ) {
	//
	// } );

	//$('.demo-dp-component .input-group.date').datepicker({autoclose:true, startDate: '-0d'});

    // BOOTSTRAP DATEPICKER WITH RANGE SELECTION
    // =================================================================
    // Require Bootstrap Datepicker
    // http://eternicode.github.io/bootstrap-datepicker/
    // =================================================================
    $('#demo-dp-range .input-daterange').datepicker({
        startDate: '-0d',
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true
	});

	// language flag select2
	$('.country-flag-select').select2({
        templateResult: countryCodeFlag,
        templateSelection: countryCodeFlag,
        escapeMarkup: function(m) { return m; }
    });
    function countryCodeFlag(state) {
        var flagName = $(state.element).data('flag');
        if (!flagName) return state.text;
        return "<img class='flag' src='" + flagName + "' height='14' />" +  state.text;
    }

});


function showAlert(type, message){
	$.niftyNoty({
		type: type,
		container: 'floating',
		html: message,
		closeBtn: true,
		floating: {
			position: 'top-right',
			animationIn: 'fadeIn',
			animationOut: 'fadeOut'
		},
		focus: true,
		timer: 3000
	});
}
