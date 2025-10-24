<?php if(has_package_feature('ability_to_add_video', $listing_details['user_id']) == 1): ?>
  <hr>
  <h3><?php echo get_phrase('videos'); ?></h3>
  <div class="video-gallery text-center">

    <?php
      $videos = !empty($listing_details['videos'])
        ? json_decode($listing_details['videos'], true)
        : [];

      // Compatibilidad con el formato antiguo (solo un video)
      if (empty($videos) && !empty($listing_details['video_url'])) {
        $videos[] = [
          'provider' => $listing_details['video_provider'],
          'url' => $listing_details['video_url']
        ];
      }
    ?>

    <?php if(!empty($videos)): ?>
      <link rel="stylesheet" href="<?php echo base_url('assets/global/plyr/plyr.css'); ?>">
      <?php foreach ($videos as $index => $video): ?>
        <div class="mb-4">
          <?php if ($video['provider'] == 'youtube'): ?>
            <div class="plyr__video-embed" id="player-<?php echo $index; ?>">
              <iframe src="<?php echo $video['url']; ?>?modestbranding=1&rel=0" allowfullscreen allow="autoplay"></iframe>
            </div>
          <?php elseif ($video['provider'] == 'vimeo'): ?>
            <?php 
              $video_details = $this->video_model->getVideoDetails($video['url']);
              $video_id = $video_details['video_id'];
            ?>
            <div class="plyr__video-embed" id="player-<?php echo $index; ?>">
              <iframe src="https://player.vimeo.com/video/<?php echo $video_id; ?>?loop=false&byline=false&title=false" allowfullscreen></iframe>
            </div>
          <?php else: ?>
            <video controls playsinline class="w-100 rounded shadow">
              <source src="<?php echo $video['url']; ?>" type="video/mp4">
            </video>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
      <script src="<?php echo base_url('assets/global/plyr/plyr.js'); ?>"></script>
      <script>
        document.addEventListener('DOMContentLoaded', () => {
          document.querySelectorAll('[id^="player-"]').forEach(el => new Plyr(el));
        });
      </script>
    <?php else: ?>
      <p><?php echo get_phrase('no_videos_available'); ?></p>
    <?php endif; ?>

  </div>
<?php endif; ?>
