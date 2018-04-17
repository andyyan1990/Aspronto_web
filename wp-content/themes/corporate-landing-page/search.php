<?php 
get_header();
$colmain = (is_active_sidebar( 'sidebar-1' )) ? 'col-md-8 col-lg-8' : 'col-md-12 col-lg-12';
?>
<div id="content" class="site-content blog-two">
    <div class="container">
        <div class="row">
            <div class="<?php echo esc_attr($colmain);?>">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main blog-main">
                        <?php if(have_posts()):
                        while(have_posts()): the_post();
                        get_template_part( 'template-parts/content', 'search' ); 
                        endwhile;
                        else:
                        get_template_part('template-parts/content' , 'none' );        
                        endif;?>
                        
                    </main>
                    <?php corporate_landing_page_pagination(); ?>
                </div>
            </div>
            <?php 
                get_sidebar(); 
            ?>
        </div>
    </div>
</div>
<?php get_footer();?>
