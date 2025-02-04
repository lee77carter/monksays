<?php
/**
 * Simple Blog Card Template File
 *
 * @package WordPress
 * @subpackage Simple Blog Card
 * @since Simple Blog Card 2.00
 * @version 1.04
 */

?>

<style>
.simpleblogcard_img_block<?php echo esc_html( $hash ); ?> {
  float: <?php echo esc_attr( $img_pos ); ?>;
  padding: 10px;
}
.simpleblogcard_border<?php echo esc_html( $hash ); ?> {
  border-<?php echo esc_attr( $border_pos ); ?>: solid <?php echo esc_attr( $color_width ); ?>px <?php echo esc_attr( $color ); ?>;
  padding: 0.25em 0.25em;
  background: transparent;
}
.simpleblogcard_title<?php echo esc_html( $hash ); ?> {
  line-height: <?php echo esc_attr( $t_line_height ); ?>%;
  font-weight: bold;
  display: block;
}
.simpleblogcard_description<?php echo esc_html( $hash ); ?> {
  line-height: <?php echo esc_attr( $d_line_height ); ?>%;
  color: #333;
}
</style>
<div class="simpleblogcard_wrap">
	<?php if ( $target_blank ) : ?>
		<a style="text-decoration: none;" href=<?php echo esc_url( $url ); ?> target="_blank" rel="noopener">
	<?php else : ?>
		<a style="text-decoration: none;" href=<?php echo esc_url( $url ); ?>>
	<?php endif; ?>
	<?php if ( $img ) : ?>
		<figure class="simpleblogcard_img_block<?php echo esc_html( $hash ); ?>">
			<img style="border-radius: 5px; width: <?php echo esc_attr( $img_width ); ?>px; height: <?php echo esc_attr( $img_height ); ?>px;" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
		</figure>
	<?php endif; ?>
	<div class="simpleblogcard_inner">
		<div class="simpleblogcard_border<?php echo esc_html( $hash ); ?>">
			<?php echo esc_html( $host ); ?>
			<div class="simpleblogcard_title<?php echo esc_html( $hash ); ?>">
				<?php echo esc_html( $title ); ?>
			</div>
			<?php if ( $dessize > 0 ) : ?>
				<div class="simpleblogcard_description<?php echo esc_html( $hash ); ?>">
					<?php echo esc_html( $description ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div style="clear: both;"></div>
	</a>
</div>
