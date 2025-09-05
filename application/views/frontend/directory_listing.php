<div class="hero_in shop_detail" style="background: url(<?php echo base_url('uploads/listing_cover_photo/'.$listing_details['listing_cover']); ?>) center center no-repeat; background-size: cover;">
</div>
<!--/hero_in-->

<nav class="secondary_nav sticky_horizontal_2">
	<div class="container">
		<ul class="clearfix">
			<li><a href="#description" class="active"><?php echo get_phrase('description'); ?></a></li>
			<li><a href="#reviews"><?php echo get_phrase('reviews'); ?></a></li>
		</ul>
	</div>
</nav>

<div class="container margin_60_35">
	<div class="row">
		<div class="col-lg-12">
			<section id="description">
				<div class="detail_title_1">
					<div class="row">
						<div class="col-6">

						</div>
						<div class="col-6">

						</div>
					</div>
					<h1>
						<?php echo $listing_details['name']; ?>

						<?php $claiming_status = $this->db->get_where('claimed_listing', array('listing_id' => $listing_id))->row('status'); ?>
						<?php if($claiming_status == 1): ?>
							<span class="claimed_icon" data-toggle="tooltip" title="<?php echo get_phrase('this_listing_is_verified'); ?>">
								<img src="<?php echo base_url('assets/frontend/images/verified.png'); ?>" width="30" />
							</span>
						<?php endif; ?>
					</h1>
					<?php if ($listing_details['latitude'] != "" && $listing_details['longitude'] != ""): ?>
						<a class="address" href="http://maps.google.com/maps?q=<?php echo $listing_details['latitude']; ?>,<?php echo $listing_details['longitude']; ?>" target="_blank"><?php echo $listing_details['address']; ?></a>
					<?php endif; ?>
				</div>

				<div class="add_bottom_15">
					<?php
					$categories = json_decode($listing_details['categories']);
					for ($i = 0; $i < sizeof($categories); $i++):
						$this->db->where('id',$categories[$i]);
						$category = $this->db->get('category')->row_array();
						?>
						<span class="loc_open mr-2">
							<a href="<?php echo site_url('home/filter_listings?category='.$category['slug']); ?>"
								style="color: #32a067;">
								<?php echo $category['name'];?>
								>
							</a>
						</span>
						<?php
					endfor;
					?>
				</div>

				<h5><?php echo get_phrase('about'); ?></h5>
				<p>
					<?php echo nl2br($listing_details['description']); ?>
				</p>

				<!-- SHOP ADDON VIEW WILL BE HERE -->
				<?php if (get_addon_details('shop')): ?>
					<?php include 'shop.php'; ?>
				<?php endif; ?>
				<!-- Photo Gallery -->
				<?php if (count(json_decode($listing_details['photos'])) > 0): ?>
					<h5 class="add_bottom_15"><?php echo get_phrase('photo_gallery'); ?></h5>
					<div class="grid-gallery">
						<ul class="magnific-gallery">
							<?php foreach (json_decode($listing_details['photos']) as $key => $photo): ?>
								<?php if (file_exists('uploads/listing_images/'.$photo)): ?>
									<li>
										<figure>
											<img src="<?php echo base_url('uploads/listing_images/'.$photo); ?>" alt="">
											<figcaption>
												<div class="caption-content">
													<a href="<?php echo base_url('uploads/listing_images/'.$photo); ?>" title="" data-effect="mfp-zoom-in">
														<i class="pe-7s-plus"></i>

													</a>
												</div>
											</figcaption>
										</figure>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<hr>
				<?php include 'contact_and_social.php'; ?>

				<?php
// Lee y normaliza
$amenities = json_decode($listing_details['amenities'], true);
$amenities = is_array($amenities) ? array_filter($amenities) : [];
?>

<?php if (count($amenities) > 0): ?>
  <h5 class="add_bottom_15"><?php echo get_phrase('amenities'); ?></h5>
  <div class="row add_bottom_30">
    <?php foreach ($amenities as $amenity_id): ?>
      <?php
        // Si tu método get_amenity requiere el campo, usa dos llamadas como ya hace el proyecto:
        $icon = $this->frontend_model->get_amenity($amenity_id, 'icon')->row('icon');
        $nameObj = $this->frontend_model->get_amenity($amenity_id, 'name')->row();
        if (!$nameObj) continue; // por si hay IDs huérfanos
      ?>
      <div class="col-md-4">
        <ul>
          <li>
            <i class="<?php echo $icon; ?>"></i>
            <?php echo $nameObj->name; ?>
          </li>
        </ul>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

				<!-- /row -->

				<?php
				// Mostrar certificaciones si hay
				$certs = json_decode($listing_details['certifications'], true);
				if (is_array($certs) && count($certs) > 0): ?>
					<h5 class="add_bottom_15"><?php echo get_phrase('certifications'); ?></h5>
					<div class="row add_bottom_30">
						<?php foreach ($certs as $cert_id): ?>
							<div class="col-md-4">
								<ul>
									<li>
										<i class="<?php echo $this->frontend_model->get_certification($cert_id, 'icon')->row('icon'); ?>"></i>
										<?php echo $this->frontend_model->get_certification($cert_id, 'name')->row()->name; ?>
									</li>
								</ul>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>


				<!-- Opening and Closing Time -->
				<?php include 'opening_and_closing_time_schedule.php'; ?>

				<!-- Listing Type Wise Inner Page -->
				<?php if ($listing_details['listing_type'] == 'hotel'): ?>
					<hr>
					<?php include 'hotel_listing_inner_page.php'; ?>
				<?php elseif ($listing_details['listing_type'] == 'shop'):?>
					<hr>
					<?php include 'shop_listing_inner_page.php'; ?>
				<?php elseif ($listing_details['listing_type'] == 'restaurant'):?>
					<hr>
					<?php include 'restaurant_listing_inner_page.php'; ?>
				<?php elseif ($listing_details['listing_type'] == 'beauty'):?>
					<hr>
					<?php include 'beauty_listing_inner_page.php'; ?>
				<?php endif; ?>
				<!-- /row -->

				<!-- Video File Base On Package-->
				<?php include 'video_player.php'; ?>

				<hr>
				<h3><?= get_phrase('location'); ?></h3>
				<!-- <div id="categorySideMap" class="map-full map-layout single-listing-map" style="z-index: 50;"></div> -->
				<div id="map" class="map-full map-layout single-listing-map" style="z-index: 50;"></div>
				<!-- End Map -->
			</section>
			<!-- /section -->
			<!-- Section Of Review Starts -->
			
			<!-- /section -->

			
		</div>
		<!-- /col -->

		

	</div>
	<!-- /row -->
</div>
<!-- /container -->


<script type="text/javascript">
var isLoggedIn = '<?php echo $this->session->userdata('is_logged_in'); ?>';

// This function performs all the functionalities to add to wishlist
function addToWishList(listing_id) {
	if (isLoggedIn === '1') {
		$.ajax({
			type : 'POST',
			url : '<?php echo site_url('home/add_to_wishlist'); ?>',
			data : {listing_id : listing_id},
			success : function(response) {
				if (response == 'added') {
					$('#btn-wishlist').html('<i class="icon_heart"></i> <?php echo get_phrase('remove_from_wishlist'); ?>');
				}else {
					$('#btn-wishlist').html('<i class="icon_heart"></i> <?php echo get_phrase('add_to_wishlist'); ?>');
				}
			}
		});
	}else {
		loginAlert();
	}
}

// This function shows the Report listing form
function showClaimForm(){
	$('#claim_form').toggle();
	$('#report_form').hide();
}
// This function shows the Report listing form
function showReportForm() {
	$('#report_form').toggle();
	$('#claim_form').hide();
}

// This function return the number of different types of guests
function getTheGuestNumberForBooking(listing_type) {
	if (isLoggedIn === '1') {
		if (listing_type === "restaurant" || listing_type === "hotel") {
			$('#adult_guests_for_booking').val($('#adult_guests').val());
			$('#child_guests_for_booking').val($('#child_guests').val());
		}

		$('.contact-us-form').submit();
	}else {
		loginAlert();
	}

}
</script>

<!-- This map-category.php file has all the fucntions for showing the map, marker, map info and all the popup markups -->
<?php include 'assets/frontend/js/map/map-category.php'; ?>

<!-- This script is needed for providing the json file which has all the listing points and required information -->
<script>
createListingsMap({
	mapId: 'map',
	jsonFile: '<?php echo base_url('assets/frontend/single-listing-geojson/listing-id-'.$listing_id.'.json'); ?>'
});

//<!-- Facebook Pixel Code -->


//<!-- End Facebook Pixel Code -->
</script>
