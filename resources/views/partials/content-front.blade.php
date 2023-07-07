<?php if (function_exists('user_submitted_posts')) user_submitted_posts(); ?>

@php 

//Create WordPress Query with 'orderby' set to 'rand' (Random)
$the_query = new WP_Query( array ( 'orderby' => 'rand', 'posts_per_page' => '1' ) );
// output the random post
while ( $the_query->have_posts() ) : $the_query->the_post();
    echo '<li>';
    the_title();
    echo '</li>';
endwhile;

// Reset Post Data
wp_reset_postdata();

@endphp
