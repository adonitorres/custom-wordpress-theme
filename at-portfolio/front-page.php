<?php get_header( 'home' ); ?>

    <main class="content">

      <?php //the loop
      if( have_posts() ){
        while( have_posts() ){
          the_post();
          the_content(); //full content
        } //end while
      }else{
        echo 'Sorry, No Posts.';
      } //end the loop ?>

    </main>
    <!-- end .content -->

<?php get_footer(); ?>