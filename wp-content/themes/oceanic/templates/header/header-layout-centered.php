<?php global $woocommerce; ?>

<?php if( get_theme_mod( 'oceanic-show-header-top-bar', true ) ) : ?>
    
    <div class="site-top-bar border-bottom">
        
        <div class="site-container">
            
            <div class="site-top-bar-left">
				<div class="site-top-bar-left-text"><?php echo wp_kses_post( get_theme_mod( 'oceanic-header-info-text', '<em>CALL US:</em> 555-OCEANIC' ) ) ?></div>
            </div>
            <div class="site-top-bar-right">
                
                <?php
                if ( oceanic_is_woocommerce_activated() && get_theme_mod( 'oceanic-header-shop-links', true ) ) { ?>
                
		            <?php if ( is_user_logged_in() ) { ?>
		                <div class="site-header-right-link"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="my-account" title="<?php _e('My Account','oceanic'); ?>"><?php _e('My Account','oceanic'); ?></a></div>
		            <?php } else { ?>
		                <div class="site-header-right-link"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="my-account" title="<?php _e('Login','oceanic'); ?>"><?php _e('Sign In / Register','oceanic'); ?></a></div>
		            <?php } ?>
                    <div class="header-cart">
                        <a class="header-cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'oceanic'); ?>">
                            <span class="header-cart-amount">
                                <?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'oceanic'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?>
                            </span>
                            <span class="header-cart-checkout<?php echo ( $woocommerce->cart->cart_contents_count > 0 ) ? ' cart-has-items' : ''; ?>">
                                <span><?php _e('Checkout', 'oceanic'); ?></span> <i class="fa fa-shopping-cart"></i>
                            </span>
                        </a>
                    </div>
                    
                <?php
                }
                ?>
                
            </div>
            <div class="clearboth"></div>
            
        </div>
    </div>

<?php endif; ?>

<div class="site-container">
    
    <div class="site-header-branding">
        <?php if( get_header_image() ) : ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><img src="<?php esc_url( header_image() ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ) ?>" /></a>
        <?php else : ?>
        	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="site-title"><?php bloginfo( 'name' ); ?></a>
			<div class="site-description"><?php bloginfo( 'description' ); ?></div>
        <?php endif; ?>
    </div>
    
</div>

<nav id="site-navigation" class="main-navigation" role="navigation">
	<span class="header-menu-button"><i class="fa fa-bars"></i></span>
	<div id="main-menu" class="main-menu-container <?php echo get_theme_mod( 'oceanic-mobile-menu-color-scheme', 'oceanic-mobile-menu-dark-color-scheme' ); ?>">
		<div class="main-menu-close"><i class="fa fa-angle-right"></i><i class="fa fa-angle-left"></i></div>
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'main-navigation-inner' ) ); ?>
	</div>
</nav><!-- #site-navigation -->
