	<div class="row">


<?php 




?>

<?php 
//echo "image count=".$image_count;
//echo "<br/>";
//print_r($array_updated_details_final);
//echo "<br/>";
//echo "<br/>";
//print_r($array_deepresults_final);
//echo "testing...";
	?>

		<?php 


		//if($api_details3 !== '') { 

		if($image_count>0) { 

			?>
			<div class="column small-12 large-6 z-img-container">
				<img src="<?php echo $api_details3[0]; ?>" class="z-img">
			</div>
		




			<div class="column small-12 large-6">
		<?php 
	} 



		else { ?>
			<div class="column small-12 full-map-container">
		<?php }; ?>
			<?php if($array_deepresults_final['latitude'] && $array_deepresults_final['longitude'] !== '') { ?>
				<div class="z-map-container google-maps">	
					<iframe class="z-map" src="https://www.google.com/maps/embed/v1/view?key=AIzaSyAnhflsrwrV8JxF1TjUvNs9tzTUZYJtdQg&center=<?php echo $array_deepresults_final['latitude']; ?>,<?php echo $array_deepresults_final['longitude']; ?>&zoom=18&maptype=satellite" width="1024" height="100px" frameborder="0" style="border:0;" allowfullscreen>
					</iframe>
				</div>
			<?php }; ?>	
		</div>
	</div>
	<div class="row">
		<div class="column small-12 large-7">
			<div class="z-home-address">
				<div class="zha-1"><?php echo $array_deepresults_final['request_address']; ?></div>
				<div class="zha-2"><?php echo $array_deepresults_final['request_citystatezip']; ?></div>
			</div>
			
			<div class="z-rooms-size more-bottom-margin">
				<?php if (is_null($array_deepresults_final['bedrooms'])) {

				//<?php if ($array_deepresults_final['bedrooms'] !== '') {
					echo "--";
				} else { 
					echo $array_deepresults_final['bedrooms']; 
				}; ?> beds &middot; 
				
				<?php if ($array_deepresults_final['bathrooms'] == '') {
					echo "--";
				} else { 
					echo $array_deepresults_final['bathrooms']; 
				}; ?> baths &middot; 
				
				<?php if ($array_deepresults_final['finishedSqFt'] == '') {
					echo "--";
				} else { 
					echo $array_deepresults_final['finishedSqFt']; 
				}; ?> sqft
			</div>
			
			<div class="z-description more-bottom-margin">
				<?php if ($array_updated_details_final['homeDescription'] !== '') {
					echo $array_updated_details_final['homeDescription']; 
				} else { }; ?>
			</div>
			
			<div class="z-facts">
				<h2 class="z-label">Home Facts</h2>
			
				<ul class="z-list">
					<?php 
					if (!is_null($array_deepresults_final['yearBuilt'])) {
					//if ($array_deepresults_final['yearBuilt'] !== '') { 
					
					?> <li> Built in <?php echo $array_deepresults_final['yearBuilt']; ?></li><?php }; ?>
					
					<?php if ($array_deepresults_final['useCode'] !== '') { 
					?> <li> <?php echo $array_deepresults_final['useCode']; ?></li><?php }; ?>
					
					<?php if ($array_deepresults_final['lotSizeSqFt'] !== '') { 
					?> <li> Lot Size: <?php echo $array_deepresults_final['lotSizeSqFt']; ?> sqft. </li><?php }; ?>
					
					<?php 

					if (!is_null($array_deepresults_final['totalRooms'])) {
					//if ($array_deepresults_final['totalRooms'] !== '') { 
					?> 

					<li> <?php echo $array_deepresults_final['totalRooms']; ?> total rooms </li>

					<?php 
					}
					 ?>
					
					<?php if ($array_deepresults_final['taxAssessmentYear'] !== '') { 
					?> <li> Tax Assessment Year: <?php echo $array_deepresults_final['taxAssessmentYear']; ?></li><?php }; ?>
					
					<?php if ($array_deepresults_final['taxAssessment'] !== '') { 
					?> <li> Tax Assessment: $<?php echo $array_deepresults_final['taxAssessment']; ?>0</li><?php }; ?>

					<?php 
					if (!is_null($array_updated_details_final['heatingSources'])) {
					//if ($array_updated_details_final['heatingSources'] !== '') { 
					?> <li> <?php echo $array_updated_details_final['heatingSources']; ?> Heating</li><?php }; ?>

					<?php 
					if (!is_null($array_updated_details_final['heatingSystem'])) {
					//if ($array_updated_details_final['heatingSystem'] !== '') { 
					?> <li> <?php echo $array_updated_details_final['heatingSystem']; ?> System</li><?php }; ?>
					
					<?php 
					if (!is_null($array_updated_details_final['coolingSystem'])) {
						//if ($array_updated_details_final['coolingSystem'] !== '') { 
					?> <li> <?php echo $array_updated_details_final['coolingSystem']; ?> Cooling</li><?php }; ?>
					
					<?php 
					if (!is_null($array_updated_details_final['appliances'])) {
					//if ($array_updated_details_final['appliances'] !== '') { 
					?> <li> <?php echo $array_updated_details_final['appliances']; ?></li><?php } else { }; ?>

					<?php 
					if (!is_null($array_updated_details_final['architecture'])) {
					//if ($array_updated_details_final['architecture'] !== '') { 
					?> <li> <?php echo $array_updated_details_final['architecture']; ?></li><?php }; ?>						
				</ul>
				<div class="clearfix"></div>
				
				<div class="z-last-sold">
					Last sold on 
					<?php 


					//if ($array_deepresults_final['lastSoldDate'] !== '') {
					if (!is_null($array_deepresults_final['lastSoldDate'])) {

						echo $array_deepresults_final['lastSoldDate']; 
					} else { 
						echo "an unknown date";
					};
					?> for 
					<?php 

					//if ($array_deepresults_final['lastSoldPrice'] !== '') { 
					if (!is_null($array_deepresults_final['lastSoldPrice'])) {

						echo "$" . $array_deepresults_final['lastSoldPrice']; 
					} else { 
						echo "an unknown price";
					}; ?>
				</div>				


				
				


				<?php if ($array_updated_details_final['architecture'] !== '') { ?> 					
					<h2 class="z-label">Schools</h2>
				
					<ul class="z-list">
						<li>
							<?php 
						if (is_null($array_updated_details_final['schoolDistrict'])) {
						echo "No data available.";	
						}

						else {

							echo $array_updated_details_final['schoolDistrict']." School District"; 
						}
						

						?>

					</li>
					</ul>
					<div class="clearfix"></div>
				<?php }; ?>
				
				
				<?php 
				if ($array_deepresults_final['graphsanddata'] !== '') { 
					?>
					<h2 class="z-label">Home Value Data</h2>
				
					<?php 
					//echo $array_deepresults_final['graphsanddata']; 
					?>
					<a href="<?php echo $array_deepresults_final['graphsanddata']; ?>" target="_blank">View Home Value Data Results on Zillow.com</a>
					<?php

			}
			?>
				
				<?php if ($array_deepresults_final['comparables'] !== '') { 
					?>
					<h2 class="z-label">Home Comparables</h2>

<?php 
					//echo $array_deepresults_final['comparables']; 
					?>
					<a href="<?php echo $array_deepresults_final['comparables']; ?>" target="_blank">View Home Comparables Results on Zillow.com</a>
					<?php

				
					 ?>
				<?php 
				}
				 ?>
			</div>
			<br/>

			
			<div class="z-photos">
				<?php 
				
				//if($api_details3 !== '') { 
				if($image_count>0) { 
					?>
					<ul class="small-block-grid-2">
						<?php 
						foreach ($api_details3 as $value3) { 
							?>
							<li><img src="<?php echo $value3; ?>"></li>
						<?php 
					} 
					?>
					</ul>
				<?php }; ?>
			</div>
		</div>
		<div class="column small-12 large-5">
			<h2 class="z-mortgage-options">Mortgage Options</h2>
			
			<?php echo do_shortcode('[ldf_products entries_string="'.$implode_entries.'"  ]'); ?>
		</div>
	


	</div>

	<?php
	//$implode_entries=implode("|",$form_input1);



//echo do_shortcode('[ldf_products_quote_table entries_string="'.$implode_entries.'"  ]');

?>


