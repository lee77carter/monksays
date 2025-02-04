<?php
/**
 * Simple Blog Card Template File
 *
 * @package WordPress
 * @subpackage Simple Blog Card
 * @since Simple Blog Card 2.00
 */

/**
 * Grid Card template for Simple Blog Card plugin.
 *
 * @version 1.1.2
 *
 * @since 1.0.2
 * @since 1.0.3 Tweaked CSS. Split common CSS into file.
 * @since 1.0.5 Tweaked CSS.
 * @since 1.1.0 Compliant with Simple Blog Card version 2.10. Supported image size.
 * @since 1.1.1 Fixed warning for no image. Tweaked CSS.
 * @since 1.1.2 Supported image size.
 */
?>
<?php $image_span = ( isset( $settings['imgsize'] ) && $settings['imgsize'] <= 100 ) ? 3 : 4; ?>
<style>
.simpleblogcard-template-gridcard-<?php echo esc_html( $hash ); ?> .card {
	border-<?php echo esc_attr( $border_pos ); ?>: solid <?php echo esc_attr( $color_width ); ?>px <?php echo esc_attr( $color ); ?>;
}
.simpleblogcard-template-gridcard-<?php echo esc_html( $hash ); ?> .card-image {
	grid-column: <?php echo ( 'left' === $img_pos ) ? '1 / span ' . (int) $image_span : (int) ( 12 - $image_span + 1 ) . ' / span ' . (int) $image_span; ?>;
	order: <?php echo ( 'left' === $img_pos ) ? '1' : '2'; ?>;
}
.simpleblogcard-template-gridcard-<?php echo esc_html( $hash ); ?> .card-content {
	grid-column: <?php echo $img ? ( 'left' === $img_pos ? (int) ( $image_span + 1 ) . ' / span ' . (int) ( 12 - $image_span ) : '1 / span ' . (int) ( 12 - $image_span ) ) : '1 / span 12'; ?>;
	order: <?php echo ( 'left' === $img_pos ) ? '2' : '1'; ?>;
}
.simpleblogcard-template-gridcard-<?php echo esc_html( $hash ); ?> .card-title {
	line-height: <?php echo (int) $t_line_height; ?>%;
}
.simpleblogcard-template-gridcard-<?php echo esc_html( $hash ); ?> .card-description {
	line-height: <?php echo (int) $d_line_height; ?>%;
}
</style>
<div class="simpleblogcard-template-gridcard simpleblogcard-template-gridcard-<?php echo esc_html( $hash ); ?>">
	<?php if ( $target_blank ) : ?>
		<a style="text-decoration: none;" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener">
	<?php else : ?>
		<a style="text-decoration: none;" href="<?php echo esc_url( $url ); ?>">
	<?php endif; ?>
		<div class="card">
			<?php if ( $img ) : ?>
				<figure class="card-image">
					<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" width="<?php echo (int) $img_width; ?>" height="<?php echo (int) $img_height; ?>"/>
				</figure>
			<?php endif; ?>
			<div class="card-content">
				<p class="card-host"><?php echo esc_html( $host ); ?></p>
				<p class="card-title"><?php echo esc_html( $title ); ?></p>
				<?php if ( $dessize > 0 ) : ?>
					<p class="card-description">
						<?php echo esc_html( $description ); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</a>
</div>
