<script src="<?= \Uri::base() ?>assets/vendors/js/vendors.min.js"></script>
<script src="<?= \Uri::base() ?>assets/vendors/js/ui/jquery.sticky.js"></script>
<!--<script src="--><?php //= \Uri::base() ?><!--assets/vendors/js/charts/apexcharts.min.js"></script>-->
<script src="<?= \Uri::base() ?>assets/vendors/js/extensions/toastr.min.js"></script>
<script src="<?= \Uri::base() ?>assets/js/core/app-menu.js"></script>
<script src="<?= \Uri::base() ?>assets/js/core/app.js"></script>
<script src="<?= \Uri::base() ?>assets/js/core/scripts.js"></script>
<script src="<?= \Uri::base() ?>assets/js/scripts/customizer.js"></script>
<script src="<?= \Uri::base() ?>assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--<script src="--><?php //= \Uri::base() ?><!--assets/js/scripts/pages/dashboard-ecommerce.js"></script>-->

<script>
(function() {
	// Cấu hình mặc định cho toastr
	if (typeof toastr !== 'undefined') {
		toastr.options = {
			closeButton: true,
			progressBar: true,
			newestOnTop: true,
			timeOut: 4000,
			positionClass: 'toast-top-right'
		};
		<?php if (\Session::get_flash('success')): ?>
		toastr.success('<?= addslashes(\Session::get_flash('success')); ?>', 'Success');
		<?php endif; ?>
		<?php if (\Session::get_flash('error')): ?>
		toastr.error('<?= addslashes(\Session::get_flash('error')); ?>', 'Error');
		<?php endif; ?>
		<?php if (\Session::get_flash('warning')): ?>
		toastr.warning('<?= addslashes(\Session::get_flash('warning')); ?>', 'Warning');
		<?php endif; ?>
		<?php if (\Session::get_flash('info')): ?>
		toastr.info('<?= addslashes(\Session::get_flash('info')); ?>', 'Info');
		<?php endif; ?>
	}
})();
</script>

<script>
// Delay initialization to ensure all scripts are loaded
setTimeout(function() {
	if (window.jQuery) {
		console.log('Select2 available:', typeof jQuery().select2);
		console.log('Found icon pickers:', jQuery('.js-select2-icon').length);
		
		if (jQuery().select2) {
			// Initialize icon picker Select2
			jQuery('.js-select2-icon').each(function(){
				var $el = jQuery(this);
				if ($el.data('select2')) {
					console.log('Select2 already initialized for:', $el.attr('id'));
					return;
				}
				
				console.log('Initializing Select2 for:', $el.attr('id'));
				$el.select2({
					width: '100%',
					placeholder: $el.data('placeholder') || 'Chọn icon',
					templateResult: function (state) {
						if (!state.id) { return state.text; }
						var img = state.element && state.element.getAttribute('data-img');
						if (img) {
							return jQuery('<span><img src="'+img+'" style="width:18px;height:18px;object-fit:contain;margin-right:6px;" /> '+ state.text +'</span>');
						}
						return state.text;
					},
					templateSelection: function (state) {
						if (!state.id) { return state.text; }
						var img = state.element && state.element.getAttribute('data-img');
						if (img) {
							return jQuery('<span><img src="'+img+'" style="width:18px;height:18px;object-fit:contain;margin-right:6px;" /> '+ state.text +'</span>');
						}
						return state.text;
					}
				});
			});
			
			// Initialize multi-select Select2
			jQuery('.js-select2-multi').each(function(){
				var $el = jQuery(this);
				if ($el.data('select2')) {
					console.log('Select2 multi already initialized for:', $el.attr('id'));
					return;
				}
				
				console.log('Initializing Select2 multi for:', $el.attr('id'));
				$el.select2({
					width: '100%',
					placeholder: $el.data('placeholder') || 'Chọn...',
					allowClear: true,
					closeOnSelect: false
				});
			});
		} else {
			console.error('Select2 not available');
		}
	} else {
		console.error('jQuery not available');
	}
}, 100);
</script>

<script src="<?= \Uri::base() ?>assets/js/admin-swal.js"></script>


