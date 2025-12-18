<?php 
// Limpiar barras escapadas del JSON y detectar tipo
$cover = str_replace('\/', '/', $listing_details['listing_cover']);
$is_cover_url = (strpos($cover, 'http://') === 0 || strpos($cover, 'https://') === 0);
$cover_background = $is_cover_url ? $cover : base_url('uploads/listing_cover_photo/'.$cover);
?>

<div class="hero_in shop_detail" style="background: url(<?php echo $cover_background; ?>) center center no-repeat;">
</div>
<!--/hero_in-->

<!-- <nav class="secondary_nav sticky_horizontal_2" style="background:#228e50 !important">
	<div class="container">
		<ul class="clearfix"> -->
			<!-- <li><a href="#description" class="active"><?php echo get_phrase('description'); ?></a></li> -->
			<!-- <li><a href="#reviews"><?php echo get_phrase('reviews'); ?></a></li> -->
		<!-- </ul>
	</div>
</nav> -->

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

						<?php if (!empty($listing_details['google_rating']) && $listing_details['google_rating'] > 0): ?>
							<span style="display: inline-block; margin-left: 10px; font-size: 0.6em; vertical-align: middle; color: #666;">
								<span style="color: #ffa500; font-size: 1.2em;">★</span>
								<strong style="color: #333;"><?php echo number_format($listing_details['google_rating'], 1); ?></strong>
								<?php if (!empty($listing_details['google_user_ratings_total']) && $listing_details['google_user_ratings_total'] > 0): ?>
									<span style="color: #999; font-size: 0.9em;">(<?php echo number_format($listing_details['google_user_ratings_total']); ?>)</span>
								<?php endif; ?>
							</span>
						<?php endif; ?>
					</h1>
					<?php if (!empty($listing_details['latitude']) && !empty($listing_details['longitude'])): 
						$lat = $listing_details['latitude'];
						$lng = $listing_details['longitude'];
						$url = 'https://www.google.com/maps/dir/?api=1'
							. '&destination=' . rawurlencode($lat . ',' . $lng)
							. '&dir_action=navigate'
							. '&travelmode=driving'; // walking | bicycling | transit
					?>
					<a class="address" href="<?= htmlspecialchars($url, ENT_QUOTES) ?>" target="_blank" rel="noopener">
						<?= htmlspecialchars($listing_details['address']) ?>
					</a>
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

				<h5><?php echo get_phrase('Description'); ?></h5>
				<p>
					<?php echo nl2br($listing_details['description']); ?>
				</p>

				<!-- SHOP ADDON VIEW WILL BE HERE -->
				<?php if (get_addon_details('shop')): ?>
					<?php include 'shop.php'; ?>
				<?php endif; ?>

				<style>	
					@media (min-width: 767px) {
					.grid-gallery ul li {
						margin: 0px !important;
						width: 23% !important;
					}
					}

					@media (max-width: 767px) {
					.grid-gallery ul li {
						margin: 0px !important;
						width: 48% !important;
						min-height: 48% !important;
					}
					}
					
					/* === Miniaturas === */
					.thumbs-container {
						max-height: 500px;
						overflow-y: auto; 
						padding-right: 5px;
					}

					/* Barra de scroll estilizada (Opcional, para que se vea moderna) */
					.thumbs-container::-webkit-scrollbar { width: 5px; }
					.thumbs-container::-webkit-scrollbar-thumb { background: #ccc; border-radius: 5px; }

					.thumb-item {
						position: relative;
						cursor: pointer;
						border: 2px solid transparent; /* Borde invisible por defecto */
						transition: all 0.3s;
						opacity: 0.6; /* Un poco transparente cuando no está activa */
						margin-bottom: 10px;
					}

					.thumb-item:hover, .thumb-item.active {
						border-color: #ffc107; /* Borde de selección */
						opacity: 1; /* Totalmente visible al seleccionar */
					}

					.thumb-img {
						width: 100%;
						height: 80px;
						object-fit: cover;
						border-radius: 4px;
						display: block;
					}

					/* === Imagen Principal === */
					.main-image-wrapper {
						width: 100%;
						height: 500px; /* Altura fija para mantener la estructura */
						background-color: #f8f9fa; /* Fondo gris suave por si la imagen tarda en cargar */
						border-radius: 8px;
						overflow: hidden;
						box-shadow: 0 4px 12px rgba(0,0,0,0.1); /* Sombra suave para darle profundidad */
					}

					.main-img {
						width: 100%;
						height: 100%;
						object-fit: cover; /* Esto recorta la imagen para llenar el espacio. Si prefieres que se vea la imagen completa sin recortar (aunque queden espacios blancos), cambia 'cover' por 'contain' */
						display: block;
					}

					.video-icon-overlay {
						position: absolute;
						top: 50%;
						left: 50%;
						transform: translate(-50%, -50%);
						color: white;
						font-size: 24px;
						text-shadow: 0 2px 5px rgba(0,0,0,0.8);
						pointer-events: none; /* Para que el clic pase al div padre */
						z-index: 2;
					}
					/* Contenedor principal para Videos (oculto por defecto) */
					#mainVideoContainer {
						width: 100%;
						height: 100%; /* Para llenar los 500px o 300px definidos antes */
						display: none; /* Se muestra solo si es video */
						background: #000;
					}

					/* Asegurar que Plyr llene el espacio */
					.plyr {
						height: 100%;
						width: 100%;
					}

					/* === ESTILOS RESPONSIVOS PARA MÓVIL === */
					@media (max-width: 767.98px) {
						
						/* Contenedor de miniaturas en horizontal */
						.thumbs-container {
							display: flex;       /* Pone los elementos en fila */
							flex-direction: row; /* Dirección horizontal */
							overflow-x: auto;    /* Permite scroll lateral */
							overflow-y: hidden;  /* Quita scroll vertical */
							white-space: nowrap; /* Evita que salten de línea */
							width: 100%;
							max-height: auto;    /* Quitamos la restricción de altura */
							padding-bottom: 10px; /* Espacio para el dedo al hacer scroll */
							margin-top: 10px;
						}

						/* Ajuste de cada miniatura en móvil */
						.thumb-item {
							flex: 0 0 auto;  /* No permite que se estiren ni encojan */
							width: 80px;     /* Ancho fijo cuadrado */
							margin-right: 10px; /* Espacio entre fotos */
							margin-bottom: 0;   /* Quitamos margen inferior */
						}

						/* Reducir altura de la imagen principal en móvil */
						/* 500px es mucho para un celular, mejor 300px o 350px */
						.main-image-wrapper {
							height: 300px; 
						}
					}
					
					</style>

				<!-- NEW GALLERY -->

				<!-- <?php 
				// --- Lógica de preparación de datos (Igual que antes) ---
				$photos_data = [];
				$raw_photos = json_decode($listing_details['photos']);

				if (is_array($raw_photos) && count($raw_photos) > 0) {
					foreach ($raw_photos as $photo) {
						$is_full_url = (strpos($photo, 'http://') === 0 || strpos($photo, 'https://') === 0);
						if ($is_full_url) {
							$url = $photo;
						} else {
							if (file_exists('uploads/listing_images/'.$photo)) {
								$url = base_url('uploads/listing_images/'.$photo);
							} else {
								continue; 
							}
						}
						$photos_data[] = $url;
					}
				}

				$main_photo = count($photos_data) > 0 ? $photos_data[0] : base_url('assets/img/placeholder.jpg');
				?> -->

				<?php 
				// --- 1. PREPARACIÓN DE DATOS ---

				$gallery_items = [];

				// A. Procesar IMÁGENES
				$raw_photos = json_decode($listing_details['photos']);
				if (is_array($raw_photos)) {
					foreach ($raw_photos as $photo) {
						// Tu validación de URL existente...
						$url = (strpos($photo, 'http') === 0) ? $photo : base_url('uploads/listing_images/'.$photo);
						if (!file_exists('uploads/listing_images/'.$photo) && strpos($photo, 'http') !== 0) continue;

						$gallery_items[] = [
							'type'   => 'image',
							'src'    => $url,
							'thumb'  => $url // La misma imagen sirve de miniatura
						];
					}
				}

				// B. Procesar VIDEOS (Solo si tiene permisos)
				if (has_package_feature('ability_to_add_video', $listing_details['user_id']) == 1) {
					$raw_videos = !empty($listing_details['videos']) ? json_decode($listing_details['videos'], true) : [];
					
					// Compatibilidad videos antiguos
					if (empty($raw_videos) && !empty($listing_details['video_url'])) {
						$raw_videos[] = ['provider' => $listing_details['video_provider'], 'url' => $listing_details['video_url']];
					}

					foreach ($raw_videos as $video) {
						$thumb = base_url('assets/img/video-placeholder.jpg'); // Miniatura por defecto
						
						// Intentar obtener miniatura real (especialmente para YouTube)
						if ($video['provider'] == 'youtube') {
							// Extraer ID de Youtube para obtener la miniatura
							preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video['url'], $match);
							if (isset($match[1])) {
								$thumb = "https://img.youtube.com/vi/{$match[1]}/hqdefault.jpg";
							}
						}
						// Para Vimeo es más complejo obtener thumbnail sin API, usamos placeholder o icono.

						$gallery_items[] = [
							'type'     => 'video',
							'provider' => $video['provider'],
							'src'      => $video['url'], // URL del video
							'thumb'    => $thumb
						];
					}
				}

				// Elemento inicial
				$first_item = !empty($gallery_items) ? $gallery_items[0] : null;
				?>

				<link rel="stylesheet" href="<?php echo base_url('assets/global/plyr/plyr.css'); ?>">

				<div class="row mt-4">
    
				<div class="col-md-2 order-2 order-md-1">
					<div class="thumbs-container">
						<?php if (!empty($gallery_items)): ?>
							<?php foreach ($gallery_items as $index => $item): ?>
								
								<div class="thumb-item <?php echo ($index === 0) ? 'active' : ''; ?>" 
									onclick="changeMedia(this, '<?php echo $item['type']; ?>', '<?php echo $item['src']; ?>', '<?php echo $item['provider'] ?? ''; ?>')">
									
									<img src="<?php echo $item['thumb']; ?>" class="thumb-img" alt="Media">
									
									<?php if ($item['type'] === 'video'): ?>
										<div class="video-icon-overlay">
											<i class="fa-solid fa-play-circle"></i>
										</div>
									<?php endif; ?>
									
								</div>

							<?php endforeach; ?>
						<?php else: ?>
							<p class="text-muted text-center">Sin contenido</p>
						<?php endif; ?>
					</div>
				</div>

				<div class="col-md-6 order-1 order-md-2 mb-3 mb-md-0">
					<div class="main-image-wrapper">
						
						<img id="mainImageDisplay" 
							src="<?php echo ($first_item && $first_item['type'] == 'image') ? $first_item['src'] : ''; ?>" 
							class="main-img" 
							style="display: <?php echo ($first_item && $first_item['type'] == 'image') ? 'block' : 'none'; ?>;">

						<div id="mainVideoContainer" 
							style="display: <?php echo ($first_item && $first_item['type'] == 'video') ? 'block' : 'none'; ?>;">
							</div>

					</div>
				</div>

				<div class="col-md-4 order-3 order-md-3">
					<div class="box_detail">
						<!-- <h3>Información</h3> -->
						<?php include 'contact_and_social.php'; ?>

						<?php
						// IDs de certificaciones guardados en el listing (JSON)
						$cert_ids = json_decode($listing_details['certifications'] ?? '[]', true);

						if (is_array($cert_ids) && !empty($cert_ids)): ?>
						<h5 class="add_bottom_15"><?= get_phrase('certifications'); ?></h5>
						<div class="row add_bottom_30">
							<?php foreach ($cert_ids as $cert_id):
							// Trae la fila completa de la certificación
							$cert = $this->frontend_model->get_certification($cert_id)->row_array();
							if (!$cert) continue;

							// ¿Hay imagen física subida?
							$has_image = !empty($cert['image']) && file_exists(FCPATH.'uploads/certifications/'.$cert['image']);
							?>
							<div class="col-md-4">
								<ul class="mb-2">
								<li>
									<?php if ($has_image): ?>
									<img
										src="<?= base_url('uploads/certifications/'.$cert['image']); ?>"
										alt="<?= html_escape($cert['name']); ?>"
										style="height:60px;width:auto;vertical-align:middle;margin-right:6px;">
									<?php elseif (!empty($cert['icon'])): ?>
									<i class="<?= html_escape($cert['icon']); ?>" style="margin-right:6px;"></i>
									<?php endif; ?>
									<!-- <?= html_escape($cert['name']); ?> -->
								</li>
								</ul>
							</div>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					</div>
				</div>

			</div>
			<hr>
				

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
				<!-- <?php include 'video_player.php'; ?> -->

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

<!-- <script>
function changeImage(element, src) {
    // Cambia la fuente de la imagen grande
    document.getElementById('mainImageDisplay').src = src;

    // Gestiona la clase 'active' en las miniaturas
    document.querySelectorAll('.thumb-item').forEach(thumb => thumb.classList.remove('active'));
    element.classList.add('active');
}
</script> -->

<script src="<?php echo base_url('assets/global/plyr/plyr.js'); ?>"></script>

<script>
// Variable global para guardar la instancia del reproductor
let playerInstance = null;

document.addEventListener('DOMContentLoaded', () => {
    // Si el primer elemento al cargar es un video, inicializarlo
    <?php if ($first_item && $first_item['type'] == 'video'): ?>
        loadVideo('<?php echo $first_item['src']; ?>', '<?php echo $first_item['provider']; ?>');
    <?php endif; ?>
});

function changeMedia(element, type, src, provider) {
    // 1. Manejo de clases visuales en miniaturas
    document.querySelectorAll('.thumb-item').forEach(thumb => thumb.classList.remove('active'));
    element.classList.add('active');

    const imgContainer = document.getElementById('mainImageDisplay');
    const vidContainer = document.getElementById('mainVideoContainer');

    if (type === 'image') {
        // --- MODO IMAGEN ---
        
        // Detener video si existe
        if (playerInstance) {
            playerInstance.destroy(); // Destruye Plyr para parar audio/video
            playerInstance = null;
            vidContainer.innerHTML = ''; // Limpiar HTML
        }

        // Mostrar imagen, ocultar video
        vidContainer.style.display = 'none';
        imgContainer.style.display = 'block';
        imgContainer.src = src;

    } else if (type === 'video') {
        // --- MODO VIDEO ---
        
        // Ocultar imagen, mostrar video
        imgContainer.style.display = 'none';
        vidContainer.style.display = 'block';

        // Cargar el video
        loadVideo(src, provider);
    }
}

function loadVideo(url, provider) {
    const vidContainer = document.getElementById('mainVideoContainer');
    
    // Limpiar reproductor anterior si existe
    if (playerInstance) {
        playerInstance.destroy();
        playerInstance = null;
    }

    let html = '';

    // Construir HTML según proveedor
    if (provider === 'youtube') {
        // Extraer ID simple para YouTube
        let videoId = url.split('v=')[1];
        if (!videoId && url.indexOf('youtu.be') > -1) {
             videoId = url.split('/').pop();
        }
        const ampersandPosition = videoId ? videoId.indexOf('&') : -1;
        if (ampersandPosition !== -1) {
            videoId = videoId.substring(0, ampersandPosition);
        }

        html = `<div class="plyr__video-embed" id="player">
                    <iframe src="https://www.youtube.com/embed/${videoId}?origin=<?php echo base_url(); ?>&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                </div>`;
    } 
    else if (provider === 'vimeo') {
        // Necesitamos el ID de vimeo. Usualmente viene en la URL com vimeo.com/123456
        let videoId = url.split('/').pop();
        // Si tienes una función PHP para el ID, úsala en el loop, si no, intentamos extraerla así.
        
        html = `<div class="plyr__video-embed" id="player">
                    <iframe src="https://player.vimeo.com/video/${videoId}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay"></iframe>
                </div>`;
    } 
    else {
        // HTML5 Video
        html = `<video id="player" playsinline controls>
                    <source src="${url}" type="video/mp4" />
                </video>`;
    }

    vidContainer.innerHTML = html;

    // Inicializar Plyr
    playerInstance = new Plyr('#player');
}
</script>
