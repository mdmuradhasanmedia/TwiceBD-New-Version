<?php get_header(); ?>
<?php 
                if (have_posts()) : while (have_posts()) : the_post();

                    get_template_part('post', 'page');
                endwhile;
                               else :
                    get_template_part('post', 'noresults');
                endif; 
            ?>
    
<?php get_footer(); ?>