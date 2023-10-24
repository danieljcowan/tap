<?php 
$footer_logo = get_field('footer_logo', 'option');
$contact_info = get_field('contact_info', 'option');
$copyright = get_field('copyright_info', 'option');
?>
	<footer>
	    <?php UI::tap_email_signup_HTML(); ?>

		<div class="<?php echo prefix()?>-footer">
			<div class="container">
				<div class="group group-flex <?= prefix()?>-footer-main">
					<div class="c c-4 c-sm-12">
						<?php if($footer_logo) { ?>
						<a href="<?=get_site_url()?>">
							<img class="<?php echo prefix()?>-footer-logo" src="<?php echo $footer_logo['url']; ?>" alt="<?php echo esc_attr($footer_logo['alt']); ?>">
						</a>
						<?php } ?>
						<div class="<?php echo prefix()?>-footer-contact">
							<?php echo $contact_info ?>
						</div>
					</div>
					<div class="c c-8 c-sm-12">
						<?php 
							wp_nav_menu( 
								array(
								    'theme_location' => 'footer-menu',
								    'container_class' => prefix() .'-footer-menu',
								)
							); ?>
					</div>
				</div>
				<div class="<?php echo prefix()?>-footer-copyright">
					<span><?php echo do_shortcode($copyright) ?></span>
				</div>
			</div>
		</div>
	</footer>

        <?php wp_footer(); ?>
        <script>console.log('Site URL: <?=get_site_url()?>');</script>
    </body>


</html>