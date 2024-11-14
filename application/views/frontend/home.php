<?php
$hero_settings = json_decode(get_frontend_settings('hero_settings'), true);
?>
<section class="hero_single version_2" style="background: #222 url(<?php echo base_url('uploads/system/home_banner.jpg'); ?>) center center no-repeat; background-size: cover;">
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
							<option value=""><?php echo get_phrase('all_cities'); ?></option>
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
		</div>
	</div>
</section>
<!-- /hero_single -->

<div class="main_categories">
	<div class="container">
		<ul class="clearfix">
			<?php
			$this->db->order_by('name', 'asc');
			$categories = $this->db->get('category')->result_array();
			$count = count($categories);
			foreach ($categories as $key => $category):?>
				<?php if($key < 4 || $key < 5 && $count <= 5): ?>
				<li>
					<a href="<?php echo site_url('home/search?search_string=&selected_city_id=&selected_category_id='.$category['id']); ?>">
						<i class="mb-3 <?php echo $category['icon_class']; ?>"></i>
						<h3><?php echo get_phrase($category['name']); ?></h3>
					</a>
				</li>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php if(count($categories) > 5): ?>
			<li>
				<a href="<?php echo site_url('home/category'); ?>">
					<h3><?php echo get_phrase('more'); ?></h3>
				</a>
			</li>
			<?php endif; ?>
		</ul>
	</div>
	<!-- /container -->
</div>
<!-- /main_categories -->

<div class="bg_color_1">
	<div class="container margin_80_55">

		<div class="main_title_3">
			<span></span>
			<h2><?php echo get_phrase('featured_listings'); ?></h2>
			<p><?php echo get_phrase('the_featured_listings_are_progressively_below'); ?>.</p>
			<a href="<?php echo site_url('home/listings'); ?>"><?php echo get_phrase('see_all'); ?></a>
		</div>
		<div class="row add_bottom_30">
			<?php
			$this->db->order_by('name', 'asc');
			$this->db->limit(8);
			$listings = $this->db->get_where('listing', array('is_featured' => 1))->result_array();
			foreach ($listings as $key => $listing):?>
				<?php if($key < 8): ?>
					<div class="col-lg-3 col-sm-6">
						<a href="<?php echo get_listing_url($listing['id']); ?>" class="grid_item small">
							<figure>
								<img src="<?php echo base_url('uploads/listing_thumbnails/'.$listing['listing_thumbnail']); ?>" class="img-fluid" alt="" width="400" height="266">
								<div class="info">
									<!-- <div class="cat_star"><i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i></div> -->
									<h3><?php echo get_phrase($listing['name']); ?></h3>
								</div>
							</figure>
						</a>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<!-- /row -->
		
		<div class="main_title_3">
			<span></span>
			<h2><?php echo get_phrase('popular_listings'); ?></h2>
			<p><?php echo get_phrase('the_popular_listings_are_progressively_below'); ?>.</p>
			<a href="<?php echo site_url('home/listings'); ?>"><?php echo get_phrase('see_all'); ?></a>
		</div>
		<div class="row add_bottom_30">
			<?php $listings = $this->frontend_model->get_top_ten_listings();
			foreach ($listings as $key => $listing): ?>
				<?php if($key < 8): ?>
					<div class="col-lg-3 col-sm-6">
						<a href="<?php echo get_listing_url($listing['id']); ?>" class="grid_item small">
							<figure>
								<img src="<?php echo base_url('uploads/listing_thumbnails/'.$listing['listing_thumbnail']); ?>" class="img-fluid" alt="" width="400" height="266">
								<div class="info">
									<!-- <div class="cat_star"><i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i></div> -->
									<h3><?php echo get_phrase($listing['name']); ?></h3>
								</div>
							</figure>
						</a>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<!-- /row -->
</div>
<!-- /bg_color_1 -->

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

<script>
	function home_categories(limitation){
		$('#home_category_loader').show();
		$.ajax({
			url: "<?php echo site_url('home/home_categories/'); ?>",
			success: function(response){
				$('#home_category_loader').hide();
				$('#home_category').html(response);

			}
		});
	}
</script>
