<?php 
	$category_link_cat3 = get_category_link( 3 ); 
	$category_link_cat4 = get_category_link( 4 );
	$category_link_cat5 = get_category_link( 5 ); 
	$category_link_cat6 = get_category_link( 6 ); 
	$category_link_cat7 = get_category_link( 7 ); 
	$category_link_cat8 = get_category_link( 8 ); 
	$category_link_cat9 = get_category_link( 9 ); 
?>


    <div class="row cat-menu-row" data-equalizer>
    	<div class="column small-12 medium-4">
        	<div class="cat-menu-item" data-equalizer-watch>
            	<a href="<?php echo $category_link_cat3; ?>">
                    <div class="cat-thumbnail">
                    	<img src="<?php if (function_exists('z_taxonomy_image_url')) echo z_taxonomy_image_url(3); ?>" alt="<?php echo get_cat_name(3); ?>">
                    </div>
                    <div class="cat-menu-title">
                    	<?php echo get_cat_name(3); ?>
                    </div>
                </a>
            </div>
        </div>
    	<div class="column small-12 medium-4">
        	<div class="cat-menu-item" data-equalizer-watch>
            	<a href="<?php echo $category_link_cat4; ?>">
                    <div class="cat-thumbnail">
                    	<img src="<?php if (function_exists('z_taxonomy_image_url')) echo z_taxonomy_image_url(4); ?>" alt="<?php echo get_cat_name(3); ?>">
                    </div>
                    <div class="cat-menu-title">
                    	<?php echo get_cat_name(4); ?>
                    </div>
                </a>
            </div>
        </div>
    	<div class="column small-12 medium-4">
        	<div class="cat-menu-item" data-equalizer-watch>
            	<a href="<?php echo $category_link_cat5; ?>">
                    <div class="cat-thumbnail">
                    	<img src="<?php if (function_exists('z_taxonomy_image_url')) echo z_taxonomy_image_url(5); ?>" alt="<?php echo get_cat_name(5); ?>">
                    </div>
                    <div class="cat-menu-title">
                    	<?php echo get_cat_name(5); ?>
                    </div>
                </a>
            </div>
        </div>
	</div>
    <div class="row cat-menu-row">
    	<div class="column small-12 medium-4">
        	<div class="cat-menu-item" data-equalizer-watch>
            	<a href="<?php echo $category_link_cat6; ?>">
                    <div class="cat-thumbnail">
                    	<img src="<?php if (function_exists('z_taxonomy_image_url')) echo z_taxonomy_image_url(6); ?>" alt="<?php echo get_cat_name(6); ?>">
                    </div>
                    <div class="cat-menu-title">
                    	<?php echo get_cat_name(6); ?>
                    </div>
                </a>
            </div>
        </div>
    	<div class="column small-12 medium-4">
        	<div class="cat-menu-item" data-equalizer-watch>
            	<a href="<?php echo $category_link_cat7; ?>">
                    <div class="cat-thumbnail">
                    	<img src="<?php if (function_exists('z_taxonomy_image_url')) echo z_taxonomy_image_url(7); ?>" alt="<?php echo get_cat_name(7); ?>">
                    </div>
                    <div class="cat-menu-title">
                    	<?php echo get_cat_name(7); ?>
                    </div>
                </a>
            </div>
        </div>   
    	<div class="column small-12 medium-4">
        	<div class="cat-menu-item" data-equalizer-watch>
            	<a href="<?php echo $category_link_cat8; ?>">
                    <div class="cat-thumbnail">
                    	<img src="<?php if (function_exists('z_taxonomy_image_url')) echo z_taxonomy_image_url(8); ?>" alt="<?php echo get_cat_name(8); ?>">
                    </div>
                    <div class="cat-menu-title">
                    	<?php echo get_cat_name(8); ?>
                    </div>
                </a>
            </div>
        </div>
	</div>
    <div class="row cat-menu-row">
    	<div class="column small-12 medium-4">
        	<div class="cat-menu-item">
            	<a href="<?php echo $category_link_cat9; ?>">
                    <div class="cat-thumbnail">
                    	<img src="<?php if (function_exists('z_taxonomy_image_url')) echo z_taxonomy_image_url(9); ?>" alt="<?php echo get_cat_name(9); ?>">
                    </div>
                    <div class="cat-menu-title">
                    	<?php echo get_cat_name(9); ?>
                    </div>
                </a>
            </div>
        </div>
    	<div class="column small-12 medium-4">
        	<div class="cat-menu-item">
            <a href="<?php bloginfo('url');?>/mortgage-term-glossary/">
            	<div class="cat-thumbnail">
                		<img src="<?php bloginfo('url');?>/wp-content/uploads/glossary-terms-link.jpg" alt="Glossary terms and definitions to help you understand more about the mortgage process and your options." />
                	</div>
       			</a>
        	</div>
        </div>
        <div class="column small-12 medium-4">&nbsp;
        </div>
         <div class="column small-12 medium-4">&nbsp;
        </div>       
    </div>