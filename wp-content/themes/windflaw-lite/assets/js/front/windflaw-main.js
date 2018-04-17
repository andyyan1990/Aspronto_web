(function($){
	/**
	 * @description show scroll top btn if needed
	 */
	function windflaw_scrolltopBtn(){
		var $btn = $('.to-top'), scrollTop = $(window).scrollTop(), screenHeight = $(window).height();
		$btn.length ? ((scrollTop > screenHeight) ? $btn.addClass('show') : $btn.removeClass('show')) : '';
	}

	// Init site main menu
	function initMainNavigation(container){
		// Add dropdown toggle that displays child menu items.
		var dropdownToggle = $('<button />', {
			'class': 'dropdown-toggle',
			'aria-expanded': false
		}).append($('<span />', {
			'class': 'screen-reader-text',
			text: screenReaderText.expand
		}));

		container.find( '.menu-item-has-children > a' ).after(dropdownToggle);

		// Toggle buttons and submenu items with active children menu items.
		container.find('.current-menu-ancestor > button').addClass('toggled-on');
		container.find('.current-menu-ancestor > .sub-menu').addClass('toggled-on');

		// Add menu items with submenus to aria-haspopup="true".
		container.find('.menu-item-has-children').attr('aria-haspopup', 'true');

		container.find('.dropdown-toggle').click(function(e){
			var _this = $( this ), screenReaderSpan = _this.find( '.screen-reader-text' );
			e.preventDefault();
			_this.toggleClass( 'toggled-on' );
			_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );

			// jscs:disable
			_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			// jscs:enable
			screenReaderSpan.text( screenReaderSpan.text() === screenReaderText.expand ? screenReaderText.collapse : screenReaderText.expand );
		} );
	}
	initMainNavigation(jQuery('.main-navigation'));

	$(document).ready(function(){
		$('#main').fitVids();
		$('body').on('click', '.to-top', function(e){
			e.preventDefault();
			$('html, body').animate({scrollTop : 0}, 800);
			return false;
		})
		.on('click', '#site-navigation > ul > li > .level > .drop-btn', function() {
			if($('body').hasClass('nav-folded') && ($(this).parent().siblings('ul').length > 0)){
				var $nav = $(this).parents('#site-navigation').first(),
					$ul  = $(this).parent().siblings('ul');
				$nav.find('.drop-btn.expanded').not($(this)).removeClass('expanded');
				$(this).toggleClass('expanded');
				
				if($(this).parent().siblings('ul').css('display') == 'block'){
					$ul.add($ul.find('ul')).slideUp();
				}
				else{
					$nav.find('ul.sub-nav').not($ul).slideUp();
					$ul.slideDown();
				}
			}
		})
		.on('click', '#site-navigation ul.sub-nav > li > .level > .drop-btn', function() {
			if($('body').hasClass('nav-folded') && ($(this).parent().siblings('ul').length > 0)){
				$(this).toggleClass('expanded');
				
				if($(this).parent().siblings('ul').css('display') == 'block'){
					$(this).parent().siblings('ul').slideUp();
				}
				else{
					$(this).parent().parents('ul.has-sub').find('ul').slideUp();
					$(this).parent().siblings('ul').slideDown();
				}
			}
		})
		.on('click', '.site-header #menu-toggle', function(){ // When click the menu button:
			$(this).add($('#site-navigation')).toggleClass('toggled-on');
		})
		.on('focus blur', '#site-navigation a', function(e){
			$(this).parents('.menu-item').toggleClass('focus');
		});

		$(window).scroll(function(){
			windflaw_scrolltopBtn(); // Show or hide the "back to top" button.
		})
		.load(function(){
			$(window).trigger('scroll');
		})
		.resize(function(){
			$(window).trigger('scroll');

			if(window.innerWidth > 768){
				$('.site-header #menu-toggle').add($('#site-navigation')).removeClass('toggled-on');
			}
		});
	});
})(jQuery);