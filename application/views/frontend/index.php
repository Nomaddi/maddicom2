<!DOCTYPE html>
<html lang="en">

	<head>

	    <!-- Meta tags and seo configuration -->
	    <?php include 'site_meta.php';?>

	    <!-- Top css library files -->
	    <?php include 'includes_top.php';?>

		<?php 
		if($page_name=='directory_listing') 
		{
			include 'user_meta_pixel.php';
		}
		else
		{
            include 'admin_meta_pixel.php';
		}
		?>

		<style>

		.whatsapp-float-btn {
			position: fixed;
			width: 60px;
			height: 60px;
			bottom: 25px;
			left: 25px;
			background-color: #25d366;
			color: #FFF !important;
			border-radius: 50px;
			text-align: center;
			font-size: 32px;
			box-shadow: 2px 2px 10px rgba(0,0,0,0.3);
			z-index: 9999;
			display: flex;
			align-items: center;
			justify-content: center;
			transition: all 0.3s ease;
			text-decoration: none !important;
		}

		.whatsapp-float-btn:hover {
			background-color: #128c7e;
			color: #FFF !important;
			transform: scale(1.1);
			box-shadow: 2px 2px 15px rgba(0,0,0,0.4);
		}

		/* Ajuste de posición para dispositivos móviles */
		@media (max-width: 768px) {
			.whatsapp-float-btn {
				width: 50px;
				height: 50px;
				font-size: 26px;
				bottom: 20px;
				right: 20px;
			}
		}
		</style>
	</head>
	<?php $season = get_current_season(); ?>
	<body class="season-<?php echo $season; ?>">
		<div id="page">

			<!-- Header -->
			<?php
			if ($page_name == 'home' || $page_name == '404')
				include 'header_home.php';
			else if ($page_name == 'listings' || $page_name == 'listing/create')
				include 'header_listing.php';
			else if ($page_name == 'directory_listing')
				include 'header_home.php';
			else
				include 'header.php';
			?>

			<!-- Main page -->
			<main>
				<?php include $page_name . '.php'; ?>
			</main>

			<!-- Site footer -->
			<?php
				if(!($page_name == 'listings' && $this->session->userdata('listings_view') == 'list_view')):
					include 'footer.php';
				endif;
			?>
		</div>

		<!-- Signin popup -->
		<?php include 'signin_popup.php';?>

		<!-- Back to top button -->
		<div id="toTop"></div>

		<!-- Bottom js library files -->
		<?php include 'includes_bottom.php';?>
		
		<!--modal-->
		<?php include 'modal.php'; ?>
		<?php
			if(get_frontend_settings('cookie_status') == 1):
				include 'eu-cookie.php';
			endif;
		?>
		<?php
			if(get_addon_details('fb_messenger') != 0){
				if(isset($listing_details['id'])):
					if(check_facebook_page_data($listing_details['id']) && $page_name == 'directory_listing'){
						include 'fb_messenger.php';
					}
				endif;
			}
		?>
	
		<!-- Botón Flotante de WhatsApp -->
		<a href="https://wa.me/573118113276?text=Hola,%20Chigüira,%20me%20gustaría%20obtener%20más%20información" 
		class="whatsapp-float-btn" 
		target="_blank" 
		rel="noopener noreferrer"
		title="Habla con Chigüira.">
			<i class="fab fa-whatsapp"></i>
		</a>
	</body>
</html>
