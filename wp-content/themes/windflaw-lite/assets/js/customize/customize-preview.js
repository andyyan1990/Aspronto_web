/**
 * Live-update changed settings in real time in the Customizer preview.
 */

( function( $ ) {
	var api = wp.customize;

	// Site title.
	api('blogname', function(value){
		value.bind( function(to){
			$('.logo.text-logo > a').text(to);
		} );
	} );

	// Site tagline.
	api('blogdescription', function( value ) {
		value.bind( function( to ) {
			$('p.site-description').text(to);
		});
	});

	api('windflaw_option_site_logo_width', function(value){
		value.bind(function(to){
			var $logo = $('#site-logo img');
			to = (to && (parseInt(to) > 0)) ? to : false;
			$logo.length ? (to ? $logo.css('width', to + 'px') : $logo.css('width', '')) : '';
		});
	});

	// Add custom-background-image body class when background image is added.
	api('background_image', function(value){
		value.bind( function(to){
			$('body').toggleClass( 'custom-background-image', '' !== to );
		});
	});
} )( jQuery );
