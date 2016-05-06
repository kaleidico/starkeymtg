<footer>
	<div class="container">
		<?php if(is_front_page()) { ?>
			<div class="row">
				<div class="col-xs-12">
					<h3 class="center more-bottom-margin">
						A fundamentally new<br>
						way to get a mortgage
					</h3>

					<p>Starkey Mortgage delivers a self-guided mortgage buying experience. We've modernized the process by taking it online, cutting the red tape and dropping the middleman--saving you time and money.</p>

					<p class="center more-bottom-margin"><a href="<?php bloginfo('siteurl'); ?>/pre-approval" class="btn btn-primary green-gradient btn-lg caps">Get Pre-Approved</a></p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-6 centered more-bottom-margin">
					<h4>The Traditional Process</h4>

					<img src="<?php bloginfo('siteurl'); ?>/wp-content/uploads/traditional-process.png" alt="The Traditional Process" width="427" height="188" class="aligncenter size-full wp-image-12911" />
				</div>
				<div class="col-xs-12 col-md-6 centered more-bottom-margin">
					<h4>The Starkey Mortgage Process</h4>

					<img src="<?php bloginfo('siteurl'); ?>/wp-content/uploads/the-lenderful-process.png" alt="The Lenderful Process" width="430" height="112" class="alignnone size-full wp-image-13004" />
				</div>
			</div>
		<?php }; ?>

			<div class="row">
				<div class="col-xs-12 center">
					<div class="footer-nav more-top-margin">
						<?php wp_nav_menu( array( 'theme_location' => 'Footer Navigation' ) ); ?>
					</div>
				</div>
			</div>
			<div class="row fp-footer-copyright center">
				<div class="col-xs-12">
					<p><a href="<?php bloginfo('siteurl'); ?>/disclosures-and-licenses/"><img src="<?php bloginfo('siteurl'); ?>/wp-content/uploads/equal-housing-white.png" alt="Equal Housing Opportunity" /></a></p>

					<p>&copy; <script>document.write(new Date().getFullYear())</script> Starkey Mortgage, All rights reserved.</p>
				</div>
			</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
