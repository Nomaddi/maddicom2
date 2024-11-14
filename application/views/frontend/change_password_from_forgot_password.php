<?php if(get_settings('recaptcha_status')): ?>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>
<div class="container margin_60">
  <div class="row justify-content-center">
    <div class="col-xl-6 col-lg-6 col-md-8">
      <div class="box_account">
        <h3 class="client"><?php echo get_phrase('change_your_password'); ?></h3>
        <form action="<?php echo site_url('login/change_password/'.$verification_code); ?>" method="post">
          <div class="form_container">
            <div class="form-group">
              <label for="new_password"><?php echo get_phrase('new_password'); ?></label>
              <div class="input-group mb-3">
                <span class="input-group-text bg-white" for="new_password"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" placeholder="<?php echo get_phrase('enter_your_new_password'); ?>" aria-label="<?php echo get_phrase('new_password'); ?>" aria-describedby="<?php echo get_phrase('new_password'); ?>" name="new_password" id="new_password" required>
              </div>

              <label for="confirm_password"><?php echo get_phrase('confirm_password'); ?></label>
              <div class="input-group">
                <span class="input-group-text bg-white" for="confirm_password"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" placeholder="<?php echo get_phrase('confirm_password'); ?>" aria-label="<?php echo get_phrase('confirm_password'); ?>" aria-describedby="<?php echo get_phrase('confirm_password'); ?>" name="confirm_password" id="confirm_password" required>
              </div>
            </div>

            <?php if(get_settings('recaptcha_status')): ?>
              <div class="form-group">
                <div class="g-recaptcha" data-sitekey="<?php echo get_settings('recaptcha_sitekey'); ?>"></div>
              </div>
            <?php endif; ?>

            <div class="form-group">
              <input type="submit" value="<?php echo get_phrase('continue'); ?>" class="btn_1 full-width">
            </div>

            <div class="form-group mt-4 mb-0 text-center">
              <?php echo get_phrase('want_to_go_back'); ?>?
              <a class="text-15px fw-700" href="<?php echo site_url('home/login') ?>"><?php echo get_phrase('login'); ?></a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
