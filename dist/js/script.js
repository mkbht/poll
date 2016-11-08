$(document).ready(function() {
	/* input focus */
    $('.input-group').on('focus', '.form-control', function () {
    	$(this).closest('.input-group, .form-group').addClass('focus');
    	})
    .on('blur', '.form-control', function () {
    		     $(this).closest('.input-group, .form-group').removeClass('focus');
    		   });

    $(':radio').radiocheck();
    $(':checkbox').radiocheck();
    $('[data-toggle="tooltip"]').tooltip();
    if ($('[data-toggle="switch"]').length) {
      $('[data-toggle="switch"]').bootstrapSwitch();
    }

    $("select").select2({dropdownCssClass: 'dropdown-inverse'});
});