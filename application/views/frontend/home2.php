<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SPARKER - Premium directory and listings template by Ansonika.">
    <meta name="author" content="Ansonika">
    <title>SPARKER | Premium directory and listings template by Ansonika.</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
	<link href="css/vendors.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="css/custom.css" rel="stylesheet">

</head>

<body>	
	<div id="page">
	<main>
        <?php
		$hero_settings = json_decode(get_frontend_settings('hero_settings'), true);
		?>
        <section class="hero_single version_2 version_4" style=" url(<?php echo base_url('uploads/system/home_banner.jpg'); ?>) center center no-repeat; background-size: cover;">
	<div class="wrapper">
		<div class="container">
			<h3><?php echo get_frontend_settings('banner_title'); ?></h3>
			<p><?php echo get_frontend_settings('slogan'); ?></p>
			<form action="<?php echo site_url('home/filter_listings?'); ?>" method="get">
			   <input type="hidden" name="category" value="">
				<input type="hidden" name="amenity" value="">
				<input type="hidden" name="city" value="">
				<input type="hidden" name="price-range" value="0">
				<input type="hidden" name="status" value="">
				<input type="hidden" name="state" value="">
				<div class="row no-gutters custom-search-input-2">
					<div class="col-lg-4">
						<div class="form-group">
							<input class="form-control" type="text" name="search_string" placeholder="<?php echo get_phrase('what_are_you_looking_for'); ?>...">
							<i class="icon_search"></i>
						</div>
					</div>
					<div class="col-lg-3">
						
						<select class="wide" name="selected_city_id">
						
							<option value=""><?php echo get_phrase('Where'); ?></option>
							<?php
							$cities = $this->crud_model->get_cities()->result_array();
							foreach ($cities as $city):?>
								<option value="<?php echo $city['id']; ?>"><?php echo $city['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-lg-3">
						<select class="wide" name="selected_category_id">
							<option value=""><?php echo get_phrase('all_categories'); ?></option>
							<?php
							$categories = $this->crud_model->get_categories()->result_array();
							foreach ($categories as $category):?>
								<option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-lg-2">
						<input type="submit" value="<?= get_phrase('search'); ?>">
					</div>
				</div>
				<!-- /row -->
			</form>
				<ul class="counter">
					<li><strong><?php echo $this->db->count_all('city');?></strong> <?= get_phrase('Cities'); ?></li>
					<li><strong><?php echo $this->db->count_all('user');?></strong> <?= get_phrase('Users'); ?></li>
				</ul>
		</div>
	</div>
</section>
<!-- /container -->
		
<div class="bg_color_1">
			<div class="container margin_80_55">
				<div class="main_title_2">
					<span><em></em></span>
					<h2>Popular Categories</h2>
					<p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
				</div>
				<div class="row justify-content-center">
				<?php
				$this->db->order_by('name', 'asc');
				$categories = $this->db->get('category')->result_array();
				$count = count($categories);
				foreach ($categories as $key => $category):?>
					<?php if($key < 4 || $key < 5 && $count <= 5): ?>
					<div class="col-lg-3 col-md-6">				
						<a href="<?php echo site_url('home/search?search_string=&selected_city_id=&selected_category_id='.$category['id']); ?>" class="box_cat_home">
							<i class="icon_menu-circle_alt"></i>		
							<span class="mb-3 remake_ico <?php echo $category['icon_class']; ?>" ></span>
							<style> .remake_ico{font-size: 65px; color:#2A5082}</style>
							<h3><?php echo get_phrase($category['name']); ?></h3>
							
						</a>						
					</div>
					<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<!-- /hero_single -->	

		<div class="container-fluid margin_80_55">
			<div class="main_title_2">
				<span><em></em></span>
				<h2><?php echo get_phrase('popular_listings'); ?></h2>
				<p><?php echo get_phrase('the_popular_listings_are_progressively_below'); ?>.</p>
			</div>
			<div id="reccomended" class="owl-carousel owl-theme">
			<?php
				$this->db->order_by('name', 'asc');
				$this->db->limit(8);
				$listings = $this->db->get_where('listing', array('is_featured' => 1))->result_array();
				foreach ($listings as $key => $listing):?>
				<?php if($key < 8): ?>
				<div class="item">				
					<div class="strip grid">					
						<figure <?php if($listing['is_featured'] == 1) echo 'featured-body'; ?>>
							<!-- <a href="detail-restaurant.html" class=""></a> -->
							<a href="javascript::" class="wish_bt" onclick="addToWishList(this, '<?php echo $listing['id']; ?>')">
									<i class=" <?php echo is_wishlisted($listing['id']) ? 'fas fa-heart' : 'far fa-heart'; ?> "></i>
								</a>
							<a href="<?php echo get_listing_url($listing['id']); ?>"><img src="<?php echo base_url('uploads/listing_thumbnails/'.$listing['listing_thumbnail']); ?>" class="img-fluid" alt="" width="400" height="266"><div class="read_more"><span><?php echo get_phrase('read_more'); ?></span></div></a>
							<small><?php echo $listing['listing_type'] == "" ? ucfirst(get_phrase('general')) : ucfirst(get_phrase($listing['listing_type'])) ; ?></small>
						</figure>
						<div class="wrapper">
							<h3><a href="<?php echo get_listing_url($listing['id']); ?>"><?php echo get_phrase($listing['name']); ?></a></h3>
							<p><?php echo $listing['description']; ?></p>
							<?php if ($listing['latitude'] != "" && $listing['longitude'] != ""): ?>
											<a class="address" href="https://www.google.com/maps/dir//Assistance+%E2%80%93+H%C3%B4pitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x47e66e1de36f4147:0xb6615b4092e0351f!2sAssistance+Publique+-+H%C3%B4pitaux+de+Paris+(AP-HP)+-+Si%C3%A8ge!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361:">Get directions</a>
									<?php endif; ?>
						</div>
						<ul class="<?php if($listing['is_featured'] == 1) echo 'featured-footer'; ?>">
								<?php $opening_status = get_now_open($listing['id']); ?>
								<li><span class="<?php echo $opening_status == 'closed' ? 'loc_closed' : 'loc_open'; ?>"><?php echo get_phrase($opening_status); ?></span></li>
								<li>
									<div class="score">
										<span>
											<?php
					            if ($this->frontend_model->get_listing_wise_rating($listing['id']) > 0) {
					              $quality = $this->frontend_model->get_rating_wise_quality($listing['id']);
					              echo $quality['quality'];
					            }else {
												echo get_phrase('unreviewed');
											}
					            ?>
											<em>
												<?php echo count($this->frontend_model->get_listing_wise_review($listing['id'])).' '.get_phrase('reviews'); ?>
											</em>
										</span>
										<strong><?php echo $this->frontend_model->get_listing_wise_rating($listing['id']); ?></strong></div>
								</li>
							</ul>
					</div>					
				</div>
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<!-- /carousel -->
			<div class="container">
				<div class="btn_home_align"><a  class="btn_1 rounded" href="<?php echo site_url('home/listings'); ?>"><?php echo get_phrase('View_all'); ?></a></div>
			</div>
			<!-- /container -->
		</div>
		
		
		<div class="call_section">
	<div class="wrapper">
		<div class="container margin_80_55">
			<div class="main_title_2">
				<span><em></em></span>
				<h2><?php echo $hero_settings['title']; ?></h2>
				<p><?php echo $hero_settings['sub_title']; ?></p>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="box_how">
						<i class="<?php echo $hero_settings['icon_picker_one']; ?>"></i>
						<h3><?php echo $hero_settings['topic_one']; ?></h3>
						<p><?php echo $hero_settings['sub_topic_one']; ?></p>
						<span></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box_how">
						<i class="<?php echo $hero_settings['icon_picker_two']; ?>"></i>
						<h3><?php echo $hero_settings['topic_two']; ?></h3>
						<p><?php echo $hero_settings['sub_topic_two']; ?></p>
						<span></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box_how">
						<i class="<?php echo $hero_settings['icon_picker_three']; ?>"></i>
						<h3><?php echo $hero_settings['topic_three']; ?></h3>
						<p><?php echo $hero_settings['sub_topic_three']; ?></p>
					</div>
				</div>
			</div>
			<!-- /row -->
			<p class="text-center add_top_30 wow bounceIn" data-wow-delay="0.5s"><a id="sign_up" class="btn_1 rounded" href="<?php echo site_url('home/sign_up'); ?>"><?php echo get_phrase("register"); ?></a></p>
		</div>
		<canvas id="hero-canvas" width="1920" height="1080"></canvas>
	</div>
	<!-- /wrapper -->
</div>
		<!--/call_section-->
	</main>
	<!-- /main -->

	<!-- <footer class="plus_border">
		<div class="container margin_60_35">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-sm-6">
					<h3 data-bs-target="#collapse_ft_1">Quick Links</h3>
					<div class="collapse dont-collapse-sm" id="collapse_ft_1">
						<ul class="links">
							<li><a href="#0">About us</a></li>
							<li><a href="#0">Faq</a></li>
							<li><a href="#0">Help</a></li>
							<li><a href="#0">My account</a></li>
							<li><a href="#0">Create account</a></li>
							<li><a href="#0">Contacts</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<h3 data-bs-target="#collapse_ft_2">Categories</h3>
					<div class="collapse dont-collapse-sm" id="collapse_ft_2">
						<ul class="links">
							<li><a href="#0">Shops</a></li>
							<li><a href="#0">Hotels</a></li>
							<li><a href="#0">Restaurants</a></li>
							<li><a href="#0">Bars</a></li>
							<li><a href="#0">Events</a></li>
							<li><a href="#0">Fitness</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<h3 data-bs-target="#collapse_ft_3">Contacts</h3>
					<div class="collapse dont-collapse-sm" id="collapse_ft_3">
						<ul class="contacts">
							<li><i class="ti-home"></i>97845 Baker st. 567<br>Los Angeles - US</li>
							<li><i class="ti-headphone-alt"></i>+39 06 97240120</li>
							<li><i class="ti-email"></i><a href="#0">info@sparker.com</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<h3 data-bs-target="#collapse_ft_4">Keep in touch</h3>
					<div class="collapse dont-collapse-sm" id="collapse_ft_4">
						<div id="newsletter">
							<div id="message-newsletter"></div>
							<form method="post" action="assets/newsletter.php" name="newsletter_form" id="newsletter_form">
								<div class="form-group">
									<input type="email" name="email_newsletter" id="email_newsletter" class="form-control" placeholder="Your email">
									<input type="submit" value="Submit" id="submit-newsletter">
								</div>
							</form>
						</div>
						<div class="follow_us">
							<h5>Follow Us</h5>
							<ul>
								<li><a href="#0"><i class="ti-facebook"></i></a></li>
								<li><a href="#0"><i class="ti-twitter-alt"></i></a></li>
								<li><a href="#0"><i class="ti-google"></i></a></li>
								<li><a href="#0"><i class="ti-pinterest"></i></a></li>
								<li><a href="#0"><i class="ti-instagram"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
			<hr>
			<div class="row">
				<div class="col-lg-6">
					<ul id="footer-selector">
						<li>
							<div class="styled-select" id="lang-selector">
								<select>
									<option value="English" selected>English</option>
									<option value="French">French</option>
									<option value="Spanish">Spanish</option>
									<option value="Russian">Russian</option>
								</select>
							</div>
						</li>
						<li>
							<div class="styled-select" id="currency-selector">
								<select>
									<option value="US Dollars" selected>US Dollars</option>
									<option value="Euro">Euro</option>
								</select>
							</div>
						</li>
						<li><img src="img/cards_all.svg" alt=""></li>
					</ul>
				</div>
				<div class="col-lg-6">
					<ul id="additional_links">
						<li><a href="#0">Terms and conditions</a></li>
						<li><a href="#0">Privacy</a></li>
						<li><span>© 2021 Sparker</span></li>
					</ul>
				</div>
			</div>
		</div>
	</footer> -->
	<!--/footer-->
	</div>
	<!-- page -->
	
	<!-- Sign In Popup -->
	<div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">
		<div class="small-dialog-header">
			<h3>Sign In</h3>
		</div>
		<form>
			<div class="sign-in-wrapper">
				<a href="#0" class="social_bt facebook">Login with Facebook</a>
				<a href="#0" class="social_bt google">Login with Google</a>
				<div class="divider"><span>Or</span></div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" class="form-control" name="email" id="email">
					<i class="icon_mail_alt"></i>
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" class="form-control" name="password" id="password" value="">
					<i class="icon_lock_alt"></i>
				</div>
				<div class="clearfix add_bottom_15">
					<div class="checkboxes float-start">
						<label class="container_check">Remember me
						  <input type="checkbox">
						  <span class="checkmark"></span>
						</label>
					</div>
					<div class="float-end mt-1"><a id="forgot" href="javascript:void(0);">Forgot Password?</a></div>
				</div>
				<div class="text-center"><input type="submit" value="Log In" class="btn_1 full-width"></div>
				<div class="text-center">
					Don’t have an account? <a href="register.html">Sign up</a>
				</div>
				<div id="forgot_pw">
					<div class="form-group">
						<label>Please confirm login email below</label>
						<input type="email" class="form-control" name="email_forgot" id="email_forgot">
						<i class="icon_mail_alt"></i>
					</div>
					<p>You will receive an email containing a link allowing you to reset your password to a new preferred one.</p>
					<div class="text-center"><input type="submit" value="Reset Password" class="btn_1"></div>
				</div>
			</div>
		</form>
		<!--form -->
	</div>
	<!-- /Sign In Popup -->
	
	<div id="toTop"></div><!-- Back to top button -->
	<script>
		function addToWishList(elem, listing_id) {
		var isLoggedIn = '<?php echo $this->session->userdata('is_logged_in'); ?>';
		if (isLoggedIn === '1') {
			$.ajax({
				type : 'POST',
				url : '<?php echo site_url('home/add_to_wishlist'); ?>',
				data : {listing_id : listing_id},
				success : function(response) {
					if (response == 'added') {
						$(elem).html('<i class="fas fa-heart"></i>');
						toastr.success('<?php echo get_phrase('added_to_wishlist'); ?>');
					}else {
						$(elem).html('<i class="far fa-heart"></i>');
						toastr.success('<?php echo get_phrase('removed_from_the_wishlist'); ?>');
					}
				}
			});
		}else {
			loginAlert();
		}
	}
	</script>
	<!-- COMMON SCRIPTS -->
    <script src="js/common_scripts.js"></script>
	<script src="js/functions.js"></script>
	<script src="assets/validate.js"></script>

</body>
</html>