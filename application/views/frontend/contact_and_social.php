<?php $user_details = $this->user_model->get_all_users($listing_details['user_id'])->row_array(); ?>
<div class="row mb-3">
	<div class="col-12">

		<!-- SECCIÓN DE INFORMACIÓN DEL PROPIETARIO (OWNER) -->
		<?php if(!empty($listing_details['owner_name']) || !empty($listing_details['owner_phone']) || !empty($listing_details['owner_email'])): ?>
		<div class="owner-info mb-3">
			<h6 class="mb-2"><?php echo get_phrase('owner_information'); ?></h6>
			
			<?php if(!empty($listing_details['owner_name'])): ?>
				<div class="owner-detail mb-2">
					<i class="icon-user mr-2"></i>
					<strong><?php echo get_phrase('owner_name'); ?>:</strong> 
					<span><?php echo $listing_details['owner_name']; ?></span>
				</div>
			<?php endif; ?>

			<?php if(!empty($listing_details['owner_phone'])): ?>
				<div class="owner-detail mb-2">
					<i class="icon-phone mr-2"></i>
					<strong><?php echo get_phrase('owner_phone'); ?>:</strong> 
					<a href="tel:<?php echo $listing_details['owner_phone']; ?>"><?php echo $listing_details['owner_phone']; ?></a>
				</div>
			<?php endif; ?>

			<?php if(!empty($listing_details['owner_email'])): ?>
				<div class="owner-detail mb-2">
					<i class="icon-email mr-2"></i>
					<strong><?php echo get_phrase('owner_email'); ?>:</strong> 
					<a href="mailto:<?php echo $listing_details['owner_email']; ?>"><?php echo $listing_details['owner_email']; ?></a>
				</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<!-- BOTONES DE CONTACTO EXISTENTES -->
		<?php if($listing_details['website'] != ""){ ?>
			<a href="<?php echo $listing_details['website']; ?>" target="blank" class="btn_1 full-width outline wishlist social-button" id = "btn-wishlist-social"><i class="icon-globe-6 mr-2"></i><?php echo get_phrase('website'); ?></a>
		<?php } ?>

		<?php if($listing_details['email'] != ""){ ?>
			<a href="mailto:<?php echo $listing_details['email']; ?>" target="" class="btn_1 full-width outline wishlist social-button" id = "btn-wishlist-social"><i class="icon-email mr-2"></i><?php echo get_phrase('email_us'); ?></a>
		<?php } ?>

		<?php if($listing_details['phone'] != ""){ ?>
			<a href="tel:<?php echo $listing_details['phone']; ?>" target="" class="btn_1 full-width outline wishlist social-button" id = "btn-wishlist-social"><i class="icon-phone mr-2"></i><?php echo get_phrase('call_now'); ?></a>
		<?php } ?>

		<!-- REDES SOCIALES EXISTENTES -->
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
