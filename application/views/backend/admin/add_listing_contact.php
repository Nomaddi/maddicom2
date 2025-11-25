<div class="form-group">
  <label class="col-sm-3 control-label" for="website"><?php echo get_phrase('website'); ?></label>
  <div class="col-sm-7">
    <input type="text" class="form-control" id="website" name="website" placeholder="<?php echo get_phrase('website'); ?>">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label" for="email"><?php echo get_phrase('email'); ?></label>
  <div class="col-sm-7">
    <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo get_phrase('email'); ?>">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label" for="phone_number"><?php echo get_phrase('phone_number'); ?></label>
  <div class="col-sm-7">
    <input type="text" class="form-control" id="phone_number" name="phone" placeholder="<?php echo get_phrase('phone_number'); ?>">
  </div>
</div>
<?php 
// Puedes mover esta lista a un archivo config o helper si prefieres
$social_networks = array(
    // Redes sociales principales
    'calificame'   => 'Google Review',
    'facebook'     => 'Facebook',
    'instagram'    => 'Instagram',
    'x'            => 'X (antes Twitter)',
    'linkedin'     => 'LinkedIn',
    'youtube'      => 'YouTube',
    'tiktok'       => 'TikTok',
    'threads'      => 'Threads',

    // Comunicación directa
    'whatsapp'     => 'WhatsApp',
    'telegram'     => 'Telegram',
    'messenger'    => 'Facebook Messenger',

    // Geolocalización y mapas
    'google_maps'  => 'Google Maps',
    'waze'         => 'Waze',

    // Contenido y streaming
    'spotify'      => 'Spotify',
    'soundcloud'   => 'SoundCloud',
    'twitch'       => 'Twitch',

    // Imagen, diseño y fotografía
    'pinterest'    => 'Pinterest',
    'behance'      => 'Behance',
    'dribbble'     => 'Dribbble',

    // Negocios y reseñas
    'tripadvisor'  => 'Tripadvisor',
    'trustpilot'   => 'Trustpilot',

    // Desarrollo y comunidades tech
    'github'       => 'GitHub',
    'gitlab'       => 'GitLab',
    'stackoverflow'=> 'Stack Overflow',

    // Otros (redes de nicho o globales)
    'snapchat'     => 'Snapchat',
    'reddit'       => 'Reddit',
    'medium'       => 'Medium',
    'vimeo'        => 'Vimeo'
);

?>

<?php foreach ($social_networks as $key => $label): ?>
  <div class="form-group">
    <label class="col-sm-3 control-label" for="<?php echo $key; ?>">
      <?php echo $label; ?>
    </label>
    <div class="col-sm-7">
      <input type="text" 
             class="form-control" 
             name="social[<?php echo $key; ?>]" 
             placeholder="https://www.<?php echo strtolower($label); ?>.com/tu_pagina"
             value="<?php echo isset($social_links[$key]) ? $social_links[$key] : ''; ?>">
    </div>
  </div>
<?php endforeach; ?>

