<?php $user_details = $this->user_model->get_all_users($listing_details['user_id'])->row_array(); ?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Tarjeta de Contacto - MODIFICADO */
        .contact-card {
            background: transparent; /* Se vuelve transparente para mostrar el fondo de la página */
            border: none;
            padding: 25px 0; /* Quitamos padding lateral para que se alinee con el resto, mantenemos vertical */
        }

        .contact-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
            padding-bottom: 10px;
        }

        /* Items de información (Lista) */
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px; /* Un poco más de espacio */
            font-size: 14px;
            color: #555;
        }

        /* MODIFICADO: Iconos de información un poco más oscuros */
        .info-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e9ecef; /* <-- SE CAMBIÓ A UN GRIS UN POCO MÁS OSCURO para contraste */
            color: #666;
            border-radius: 50%;
            margin-right: 12px;
            font-size: 14px;
        }

        /* Contenedor de Iconos Sociales */
        .social-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0; /* Línea divisora sutil */
        }

        /* Botones Sociales (Se mantienen igual, se ven bien sobre cualquier fondo) */
        .social-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white !important;
            font-size: 18px;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
    </style>


<?php 
    // --- 1. PREPARACIÓN DE DATOS --- 
    
    // Formatear teléfono para WhatsApp
    $phone_clean = preg_replace('/\D/', '', $listing_details['owner_phone'] ?? '');
    if (!empty($phone_clean) && strpos($phone_clean, '57') !== 0) {
        $phone_clean = '57' . $phone_clean;
    }
    $whatsapp_url = !empty($phone_clean) ? "https://wa.me/" . $phone_clean : "";

    // Preparar URL de Google Maps
    $mapsUrl = "";
    if (!empty($listing_details['latitude']) && !empty($listing_details['longitude'])) {
        $lat = $listing_details['latitude'];
        $lng = $listing_details['longitude'];
        $mapsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode($lat . ',' . $lng);
    }

    // Decodificar redes sociales
    $social_links = json_decode($listing_details['social'], true);
    
    // Array de iconos y colores (Tu configuración original)
    $social_config = [
        'facebook' => ['icon' => 'fa-facebook-f', 'color' => '#1877F2'],
        'instagram' => ['icon' => 'fa-instagram', 'color' => 'linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888)'],
        'x' => ['icon' => 'fa-x-twitter', 'color' => '#000000'],
        'linkedin' => ['icon' => 'fa-linkedin-in', 'color' => '#0077B5'],
        'youtube' => ['icon' => 'fa-youtube', 'color' => '#FF0000'],
        'tiktok' => ['icon' => 'fa-tiktok', 'color' => '#010101'],
        'whatsapp' => ['icon' => 'fa-whatsapp', 'color' => '#25D366'],
        'telegram' => ['icon' => 'fa-telegram', 'color' => '#0088cc'],
        'messenger' => ['icon' => 'fa-facebook-messenger', 'color' => '#00B2FF'],
        'google_maps' => ['icon' => 'fa-location-dot', 'color' => '#EA4335'],
        'waze' => ['icon' => 'fa-location-arrow', 'color' => '#33CCFF'],
        'spotify' => ['icon' => 'fa-spotify', 'color' => '#1DB954'],
        'soundcloud' => ['icon' => 'fa-soundcloud', 'color' => '#FF5500'],
        'twitch' => ['icon' => 'fa-twitch', 'color' => '#9146FF'],
        'pinterest' => ['icon' => 'fa-pinterest', 'color' => '#E60023'],
        'behance' => ['icon' => 'fa-behance', 'color' => '#1769FF'],
        'dribbble' => ['icon' => 'fa-dribbble', 'color' => '#EA4C89'],
        'tripadvisor' => ['icon' => 'fa-tripadvisor', 'color' => '#34E0A1'],
        'trustpilot' => ['icon' => 'fa-star', 'color' => '#00B67A'],
        'github' => ['icon' => 'fa-github', 'color' => '#24292E'],
        'gitlab' => ['icon' => 'fa-gitlab', 'color' => '#FC6D26'],
        'stackoverflow' => ['icon' => 'fa-stack-overflow', 'color' => '#F48024'],
        'snapchat' => ['icon' => 'fa-snapchat-ghost', 'color' => '#FFFC00'],
        'reddit' => ['icon' => 'fa-reddit-alien', 'color' => '#FF4500'],
        'medium' => ['icon' => 'fa-medium', 'color' => '#12100E'],
        'vimeo' => ['icon' => 'fa-vimeo-v', 'color' => '#1AB7EA']    
    ];
?>

<div class="contact-card">
    <h5 class="contact-title">
        <?php echo get_phrase('contact_information'); ?>
    </h5>

    <div class="info-list">
        
        <?php if (!empty($listing_details['owner_name'])): ?>
        <div class="info-item">
            <div class="info-icon"><i class="fa-solid fa-user"></i></div>
            <div>
                <small class="text-muted d-block" style="line-height: 1;"><?php echo get_phrase('name'); ?></small>
                <strong><?php echo $listing_details['owner_name']; ?></strong>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($listing_details['owner_phone'])): ?>
        <div class="info-item">
            <div class="info-icon"><i class="fa-brands fa-whatsapp"></i></div>
            <div>
                <small class="text-muted d-block" style="line-height: 1;">WhatsApp</small>
                <a href="<?php echo $whatsapp_url; ?>" target="_blank" class="text-dark text-decoration-none">
                    <?php echo $listing_details['owner_phone']; ?>
                </a>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($listing_details['owner_email'])): ?>
        <div class="info-item">
            <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
            <div>
                <small class="text-muted d-block" style="line-height: 1;"><?php echo get_phrase('email'); ?></small>
                <a href="mailto:<?php echo $listing_details['owner_email']; ?>" class="text-dark text-decoration-none" style="word-break: break-all;">
                    <?php echo $listing_details['owner_email']; ?>
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="social-grid">
        
        <?php if (!empty($listing_details['phone'])): ?>
            <a href="tel:<?php echo $listing_details['phone']; ?>" class="social-btn" style="background-color: #444;" title="<?php echo get_phrase('call_now'); ?>">
                <i class="fa-solid fa-phone"></i>
            </a>
        <?php endif; ?>

        <?php if (!empty($whatsapp_url)): ?>
            <a href="<?php echo $whatsapp_url; ?>" target="_blank" class="social-btn" style="background-color: #25D366;" title="WhatsApp">
                <i class="fa-brands fa-whatsapp"></i>
            </a>
        <?php endif; ?>

        <?php if (!empty($mapsUrl)): ?>
            <a href="<?php echo $mapsUrl; ?>" target="_blank" class="social-btn" style="background-color: #EA4335;" title="Google Maps">
                <i class="fa-solid fa-location-dot"></i>
            </a>
        <?php endif; ?>

        <?php if (!empty($listing_details['website'])): ?>
            <a href="<?php echo $listing_details['website']; ?>" target="_blank" class="social-btn" style="background-color: #333;" title="Website">
                <i class="fa-solid fa-globe"></i>
            </a>
        <?php endif; ?>

        <?php if (!empty($social_links)): ?>
            <?php foreach ($social_links as $key => $url): ?>
                <?php if (!empty($url)): 
                    // Obtener config del icono, o default
                    $conf = isset($social_config[$key]) ? $social_config[$key] : ['icon' => 'fa-link', 'color' => '#777'];
                    $bgStyle = (strpos($conf['color'], 'linear') === 0) ? "background: {$conf['color']}" : "background-color: {$conf['color']}";
                ?>
                    <a href="<?php echo $url; ?>" target="_blank" class="social-btn" style="<?php echo $bgStyle; ?>" title="<?php echo ucfirst($key); ?>">
                        <i class="fa-brands <?php echo $conf['icon']; ?>"></i>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>