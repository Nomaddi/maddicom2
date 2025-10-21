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

    .facebook-circle { background-color: #3b5998; }
    .instagram-circle {
        background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
    }
    .whatsapp-circle { background-color: #25D366; }
    .phone-circle { background-color: #34b7f1; }
    .location-circle { background-color: #ea4335; } /* Rojo estilo Google Maps */
</style>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">
        <h5 class="mb-3 text-primary">
            <i class="fa-solid fa-address-card me-2"></i> <?php echo get_phrase('contact_information'); ?>
        </h5>

        <div class="d-flex flex-column gap-2">
            <?php if(!empty($listing_details['owner_name'])): ?>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-user me-2 text-secondary"></i>
                    <strong class="me-1">∙<?php echo get_phrase('name'); ?>: </strong>
                    <span><?php echo $listing_details['owner_name']; ?></span>
                </div>
            <?php endif; ?>

            <?php if(!empty($listing_details['owner_phone'])): ?>
                <?php
                    $phone = preg_replace('/\D/', '', $listing_details['owner_phone']);
                    if (strpos($phone, '57') !== 0) {
                        $phone = '57' . $phone;
                    }
                ?>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-brands fa-whatsapp me-2 text-success"></i>
                    <strong class="me-1">∙WhatsApp: </strong>
                    <a href="https://wa.me/<?php echo $phone; ?>" 
                       target="_blank" 
                       class="text-success text-decoration-none">
                       <?php echo $listing_details['owner_phone']; ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php if(!empty($listing_details['owner_email'])): ?>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-envelope me-2 text-danger"></i> <strong class="me-1">∙
						<?php echo get_phrase('email'); ?>: </strong>
                    <a href="mailto:<?php echo $listing_details['owner_email']; ?>" 
                       class="text-decoration-none">
                       <?php echo $listing_details['owner_email']; ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <hr>

        <!-- 🔵 ICONOS CIRCULARES DE CONTACTO -->
        <div class="d-flex flex-wrap align-items-center mt-3">

            <?php if($listing_details['website'] != ""): ?>
                <a href="<?php echo $listing_details['website']; ?>" target="_blank" class="social-circle facebook-circle" title="<?php echo get_phrase('website'); ?>">
                    <i class="fa-solid fa-globe"></i>
                </a>
            <?php endif; ?>

            <?php if(!empty($listing_details['owner_phone'])): ?>
                <a href="https://wa.me/<?php echo $phone; ?>" target="_blank" class="social-circle whatsapp-circle" title="WhatsApp">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
            <?php endif; ?>

            <?php if($listing_details['phone'] != ""): ?>
                <a href="tel:<?php echo $listing_details['phone']; ?>" class="social-circle phone-circle" title="<?php echo get_phrase('call_now'); ?>">
                    <i class="fa-solid fa-phone"></i>
                </a>
            <?php endif; ?>

            <!-- 🔴 NUEVO: BOTÓN DE UBICACIÓN -->
            <?php if ($listing_details['latitude'] != "" && $listing_details['longitude'] != ""): ?>
                <a href="https://maps.google.com/maps?q=<?php echo $listing_details['latitude']; ?>,<?php echo $listing_details['longitude']; ?>" 
                   target="_blank" 
                   class="social-circle location-circle" 
                   title="Ver ubicación en Google Maps">
                    <i class="fa-solid fa-location-dot"></i>
                </a>
            <?php endif; ?>

            <!-- Redes Sociales -->
            <?php 
                $social = json_decode($listing_details['social'], true); 
                if(!empty($social)):
            ?>
                <?php if(!empty($social['facebook'])): ?>
                    <a href="<?php echo $social['facebook']; ?>" target="_blank" class="social-circle facebook-circle" title="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                <?php endif; ?>

                <?php if(!empty($social['instagram'])): ?>
                    <a href="<?php echo $social['instagram']; ?>" target="_blank" class="social-circle instagram-circle" title="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
