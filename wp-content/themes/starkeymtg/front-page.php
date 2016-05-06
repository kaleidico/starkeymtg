<?php get_header(); ?>


<!-- BEGIN FRONT PAGE HERO SECTION -->
<div class="fp-hero more-top-padding">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-6 center">
				<div class="fp-welcome-content">
					<h1 class="no-top-margin no-bottom-margin">Starkey</h1>

					<div class="fp-welcome-line-1">Where People<br>Come First</div>

					<div class="row">
						<div class="col-xs-12 col-sm-6 more-bottom-margin">
							<a href="<?php bloginfo('siteurl'); ?>/purchase/" class="btn btn-primary btn-large fp-hero-btn blue-gradient btn-block">
								<span class="fp-hero-btn-icon fa fa-home"></span><br>
								<span class="fp-hero-btn-text">Purchase</span>
							</a>
						</div>
						<div class="col-xs-12 col-sm-6 more-bottom-margin">
							<a href="<?php bloginfo('siteurl'); ?>/refinance/" class="btn btn-primary btn-large fp-hero-btn red-gradient btn-block">
								<span class="fp-hero-btn-icon fa fa-usd"></span><br>
								<span class="fp-hero-btn-text">Refinance</span>
							</a>
						</div>
					</div>
					<div class="row">
					      <div class="col-xs-12 col-sm-6 more-bottom-margin">
							<a href="<?php bloginfo('siteurl'); ?>/pre-approval/" class="btn btn-primary btn-large fp-hero-btn blue-gradient red-gradient-desktop btn-block">
							      <span class="fp-hero-btn-icon fa fa-check-square"></span><br>
							      <span class="fp-hero-btn-text">Free Pre-Approval</span>
							</a>
					      </div>
						<div class="col-xs-12 col-sm-6 more-bottom-margin">
							<a href="<?php bloginfo('siteurl'); ?>/mortgage-calculators/" class="btn btn-primary btn-large fp-hero-btn red-gradient blue-gradient-desktop btn-block">
								<span class="fp-hero-btn-icon fa fa-calculator"></span><br>
								<span class="fp-hero-btn-text">Calculators</span>
							</a>
					      </div>
					  </div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6"></div>
		</div>
	</div>
</div>
<!-- END FRONT PAGE HERO SECTION -->
<!-- BEGIN FRONT PAGE CHAT SECTION -->
<div class="fp-chat">
	<div class="container">
		<div class="row">
    			<div class="col-xs-12 xs-align-center col-md-2">
        			<div class="sales-img"><img src="<?php echo get_template_directory_uri(); ?>/img/sales.png" alt="Chat"></div>
        		</div>
        		<div class="col-xs-12 col-md-8 xs-align-center">
	        		<div class="fp-chat-content">
	            			Would an online chat be more convenient?
	            		</div>
        		</div>
        		<div class="col-xs-12 col-md-2">
        			<div class="aaa-chat-button-container">
                			<a href="javascript:$zopim.livechat.window.show()" class="pretty-chat-btn btn btn-primary white-border hover-white-txt">
                    				<div class="chat-button-icon fa fa-comment"></div>
                    				<div class="chat-button-content">Chat<br>Now</div>
                			</a>
            		</div>
		</div>
        </div>
    </div>
</div>
<!-- END FRONT PAGE CHAT SECTION -->

<!-- BEGIN TRENDING MORTGAGE SLIDER -->
<div class="fp-trending-section">
	<div class="container">
		<div class="row more-bottom-margin">
			<div class="col-xs-12">
				<h2 class="center">Popular Mortgage Programs</h2>

				The way to your perfect mortgage starts with understanding. The more you know, the better decisions you will make. Take a look through today’s most popular programs.

				<b>Questions? Just ask. <a href="javascript:$zopim.livechat.window.show()">Your Starkey Mortgage expert</a> is standing by.</b>
			</div>
		</div>
	</div>
</div>
<!-- END TRENDING MORTGAGE SLIDER -->

<!-- BEGIN MORTGAGE PRODUCTS TABLE -->
<div class="fp-mortgage-products-table">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php echo do_shortcode('[ldf_products]'); ?>

					<p><em>These programs are based on the following assumptions: A purchase price of $250,000 and a downpayment of 20% with a credit rating of 760.</em></p>
			</div>
		</div>
</div>
<!-- END MORTGAGE PRODUCTS TABLE -->

<!-- BEGIN CHAT/CALL/ONLINE APPLICATION -->
<div class="fp-cta more-top-margin">
	<div class="container">
		<?php echo do_shortcode('[content_block id=12840]'); ?>
	</div>
</div>
<!-- END CHAT/CALL/ONLINE APPLICATION -->

<div class="fp-capture more-bottom-margin">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<img src="<?php echo get_template_directory_uri(); ?>/img/starkey-capture.jpg" alt="Screenshot of Starkey Website">
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
