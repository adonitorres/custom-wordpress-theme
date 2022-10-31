<?php
/**
 * The user-facing side of our block
 * use block_field() to echo a setting
 * use block_value() to return a setting
 */
$number = block_value( 'number' );
$size = block_value( 'image-size' );
$category = block_value( 'category' );
$bg_color = block_value( 'bg_color' );
?>
<div style="background-color: <?php echo $bg_color; ?>" class="block-portfolio-pieces <?php block_field( 'className' ); ?> is-image-<?php echo $size ?>">
  <?php at_portfolio_pieces( $number, $size, $category ); ?>
</div>