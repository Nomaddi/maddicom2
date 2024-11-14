<?php $user_details = $this->user_model->get_all_users($listing_details['user_id'])->row_array(); ?>
<div class="row mb-3">
	<div class="col-12">
		<h5 class="mb-3"><?php echo get_phrase('agent_details'); ?></h5>

		<div class="row mb-1">
			<div class="col-md-12">
				<a href="<?php echo site_url('home/user_profile'); ?>">
					<img src="<?php echo $this->user_model->get_user_thumbnail($user_details['id']); ?>" alt="" class="float-left mr-3" width="80">
				</a>
			
				<p class="m-0 pt-3"><a href="<?php echo site_url('home/user_profile/'.$user_details['id']); ?>" class=""><?= $user_details['name']; ?></a></p>
				<p>
					<small><?php echo get_phrase('total').' '.$this->user_model->get_listing_by_user_id($user_details['id'])->num_rows().' '.get_phrase('listings'); ?></small>
				</p>
			</div>
		</div>

		<?php if($listing_details['website'] != ""){ ?>
			<a href="<?php echo $listing_details['website']; ?>" target="blank" class="btn_1 full-width outline wishlist social-button" id = "btn-wishlist-social"><i class="icon-globe-6 mr-2"></i><?php echo get_phrase('website'); ?></a>
		<?php } ?>

		<?php if($listing_details['email'] != ""){ ?>
			<a href="mailto:<?php echo $listing_details['email']; ?>" target="" class="btn_1 full-width outline wishlist social-button" id = "btn-wishlist-social"><i class="icon-email mr-2"></i><?php echo get_phrase('email_us'); ?></a>
		<?php } ?>

		<?php if($listing_details['phone'] != ""){ ?>
			<a href="tel:<?php echo $listing_details['phone']; ?>" target="" class="btn_1 full-width outline wishlist social-button" id = "btn-wishlist-social"><i class="icon-phone mr-2"></i><?php echo get_phrase('call_now'); ?></a>
		<?php } ?>


		<?php $social = $listing_details['social']; ?>
		<?php $social = json_decode($social, true); ?>

		<?php if($social['facebook'] != ""){ ?>
			<a href="<?php echo $social['facebook']; ?>" target="blank" class="btn_1 full-width outline wishlist social-button" id = "btn-wishlist-social"><i class="icon-facebook-6 mr-2"></i><?php echo get_phrase('facebook'); ?></a>
		<?php } ?>

		<?php if($social['twitter'] != ""){ ?>
			<a href="<?php echo $social['twitter']; ?>" target="blank" class="btn_1 full-width outline wishlist social-button" id = "btn-wishlist-social"><i class="icon-twitter mr-2"></i><?php echo get_phrase('twitter'); ?></a>
		<?php } ?>

		<?php if($social['linkedin'] != ""){ ?>
			<a href="<?php echo $social['linkedin']; ?>" target="blank" class="btn_1 full-width outline wishlist social-button" id = "btn-wishlist-social"><i class="fab fa-linkedin mr-2"></i><?php echo get_phrase('linkedin'); ?></a>
		<?php } ?>
	</div>
</div>
<hr>