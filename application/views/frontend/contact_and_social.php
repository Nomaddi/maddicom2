<?php $user_details = $this->user_model->get_all_users($listing_details['user_id'])->row_array(); ?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    /* ==== ESTILOS DE LOS ICONOS CIRCULARES ==== */
    .social-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        color: white;
        font-size: 22px;
        margin-right: 10px;
        transition: transform 0.3s ease, opacity 0.3s ease;
        text-decoration: none;
    }

    .social-circle:hover {
        transform: scale(1.1);
        opacity: 0.9;
    }

    .whatsapp-circle {
        background-color: #25D366;
    }

    .phone-circle {
        background-color: #34b7f1;
    }

    .location-circle {
        background-color: #ea4335;
    }

    /* Rojo estilo Google Maps */
    /* sitio */
    .site-circle {
        background-color: #1877F2;
    }
</style>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">
        <h5 class="mb-3 text-primary">
            <i class="fa-solid fa-address-card me-2"></i> <?php echo get_phrase('contact_information'); ?>
        </h5>

        <div class="d-flex flex-column gap-2">
            <?php if (!empty($listing_details['owner_name'])): ?>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-user me-2 text-secondary"></i>
                    <strong class="me-1">∙<?php echo get_phrase('name'); ?>: </strong>
                    <span><?php echo $listing_details['owner_name']; ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($listing_details['owner_phone'])): ?>
                <?php
                $phone = preg_replace('/\D/', '', $listing_details['owner_phone']);
                if (strpos($phone, '57') !== 0) {
                    $phone = '57' . $phone;
                }
                ?>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-brands fa-whatsapp me-2 text-success"></i>
                    <strong class="me-1">∙WhatsApp: </strong>
                    <a href="https://wa.me/<?php echo $phone; ?>" target="_blank" class="text-success text-decoration-none">
                        <?php echo $listing_details['owner_phone']; ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php if (!empty($listing_details['owner_email'])): ?>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-envelope me-2 text-danger"></i> <strong class="me-1">∙
                        <?php echo get_phrase('email'); ?>: </strong>
                    <a href="mailto:<?php echo $listing_details['owner_email']; ?>" class="text-decoration-none">
                        <?php echo $listing_details['owner_email']; ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <hr>

        <!-- 🔵 ICONOS CIRCULARES DE CONTACTO -->
        <div class="social-wrapper text-center mt-3">

            <!-- Botones principales (sitio, teléfono, mapa, etc.) -->
            <div class="social-icons mb-3">
                <?php if ($listing_details['website'] != ""): ?>
                    <a href="<?php echo $listing_details['website']; ?>" target="_blank" class="social-circle site-circle"
                        title="<?php echo get_phrase('website'); ?>">
                        <i class="fa-solid fa-globe"></i>
                    </a>
                <?php endif; ?>

                <?php if (!empty($listing_details['owner_phone'])): ?>
                    <a href="https://wa.me/<?php echo $phone; ?>" target="_blank" class="social-circle whatsapp-circle"
                        title="WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                <?php endif; ?>

                <?php if ($listing_details['phone'] != ""): ?>
                    <a href="tel:<?php echo $listing_details['phone']; ?>" class="social-circle phone-circle"
                        title="<?php echo get_phrase('call_now'); ?>">
                        <i class="fa-solid fa-phone"></i>
                    </a>
                <?php endif; ?>

                <?php if (!empty($listing_details['latitude']) && !empty($listing_details['longitude'])):
                    $lat = $listing_details['latitude'];
                    $lng = $listing_details['longitude'];

                    $mapsUrl = 'https://www.google.com/maps/dir/?api=1'
                            . '&destination=' . rawurlencode($lat . ',' . $lng)
                            . '&travelmode=driving'         // walking | bicycling | transit
                            . '&dir_action=navigate';        // opcional: abre navegación en móvil
                ?>
                <a href="<?= htmlspecialchars($mapsUrl, ENT_QUOTES) ?>"
                    target="_blank" rel="noopener"
                    class="social-circle location-circle"
                    title="Cómo llegar con Google Maps" aria-label="Cómo llegar">
                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                </a>
                <?php endif; ?>

            </div>

            <!-- Redes sociales dinámicas -->
            <?php
            $social = json_decode($listing_details['social'], true);
            if (!empty($social)):
                ?>
                <div class="social-icons">
                    <?php foreach ($social as $key => $url): ?>
                        <?php if (!empty($url)): ?>
                            <?php
                            $icons = [
                                'facebook' => ['icon' => 'fa-facebook-f', 'color' => '#1877F2'],
                                'instagram' => ['icon' => 'fa-instagram', 'color' => 'linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888)'],
                                'x' => ['icon' => 'fa-x-twitter', 'color' => '#000000'],
                                'linkedin' => ['icon' => 'fa-linkedin-in', 'color' => '#0077B5'],
                                'youtube' => ['icon' => 'fa-youtube', 'color' => '#FF0000'],
                                'tiktok' => ['icon' => 'fa-tiktok', 'color' => '#010101'],
                                'threads' => ['icon' => 'fa-threads', 'color' => '#000000'],
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

                            $iconClass = isset($icons[$key]) ? $icons[$key]['icon'] : 'fa-globe';
                            $bgStyle = isset($icons[$key])
                                ? (strpos($icons[$key]['color'], 'linear') === 0
                                    ? "background: {$icons[$key]['color']}"
                                    : "background-color: {$icons[$key]['color']}")
                                : "background-color: #6c757d;";
                            ?>

                            <a href="<?php echo $url; ?>" target="_blank" class="social-circle" style="<?php echo $bgStyle; ?>"
                                title="<?php echo ucfirst($key); ?>">
                                <i class="fa-brands <?php echo $iconClass; ?>"></i>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <style>
            /* === Distribución responsiva === */
            .social-wrapper {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .social-icons {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
                max-width: 700px;
            }

            @media (max-width: 768px) {
                .social-icons {
                    gap: 8px;
                    max-width: 100%;
                }

                .social-circle {
                    width: 42px;
                    height: 42px;
                    font-size: 18px;
                }
            }
        </style>

    </div>
</div>