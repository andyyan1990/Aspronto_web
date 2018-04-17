/* global colorScheme, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

(function(api, $){
	api.controlConstructor['background'] = api.UploadControl.extend({ 
		ready: function() {
			api.UploadControl.prototype.ready.apply(this, arguments);

			if('background_image' === this.id){
				// Set up the new controls
				var control = this;
				control.container.on('click keydown', '.remove-button', function(){
					$('#customize-control-windflaw_option_background_size').hide();
				});
			}
		},
		select: function() {
			api.UploadControl.prototype.select.apply(this, arguments);
			$('#customize-control-windflaw_option_background_size').css('display', 'list-item');
		}
	});

	api.controlConstructor.radio = api.Control.extend({
		ready: function(){
			if('windflaw_option_background_size' === this.id){
				var bgImg = api.settings.settings.background_image, size = this.container;
				bgImg.value ? size.css('display', 'list-item') : size.hide();
			}
		}
	});
})(wp.customize, jQuery);
