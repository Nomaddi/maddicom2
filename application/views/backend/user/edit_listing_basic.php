<div class="form-group">
  <label for="title" class="col-sm-3 control-label"><?php echo get_phrase('title'); ?></label>
  <div class="col-sm-7">
    <input type="hidden" name="user_id" value="<?php echo $listing_details['user_id']?>">
    <input type="text" class="form-control" id="title" name="title" value="<?php echo $listing_details['name']; ?>" required>
  </div>
</div>

<div class="form-group">
  <label for="description" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>
  <div class="col-sm-7">
    <textarea name="description" id = "description" class="form-control" rows="8" cols="80" required><?php echo $listing_details['description']; ?></textarea>
  </div>
</div>
<div class="form-group">
  <label for="featured_type" class="col-sm-3 control-label"><?php echo get_phrase('featured_type'); ?></label>
  <div class="col-sm-7">
    <?php $user_id = $this->session->userdata('user_id'); ?>
    <?php $package_id = has_package($user_id, 'package_id'); ?>
    <?php $featured_status = $this->db->get_where('package', array('id' => $package_id['package_id']))->row('featured'); ?>
    <select name="is_featured" id = "featured_type" class="select2" <?php if($featured_status != 1) echo 'disabled'; ?> required>
      <option value=""><?php echo get_phrase('select_featured_type'); ?></option>
      <option value="1"  <?php if($listing_details['is_featured'] == 1 && $featured_status == 1) echo 'selected'; ?>><?php echo get_phrase('featured'); ?></option>
      <option value="0" <?php if($listing_details['is_featured'] == 0 || $featured_status == 0) echo 'selected'; ?>><?php echo get_phrase('none_featured'); ?></option>
    </select>
  </div>
</div>
<div class="form-group">
  <label for="google_analytics_id" class="col-sm-3 control-label"><?php echo get_phrase('google_analytics_id'); ?></label>
  <div class="col-sm-7">
    <input type="text" class="form-control" value="<?php echo $listing_details['google_analytics_id']; ?>" id="google_analytics_id" name="google_analytics_id" placeholder="GA_MEASUREMENT_ID">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label" for="category"> <?php echo get_phrase('category'); ?></label>
  <div class="col-sm-7">
    <div id="category_area">
        <?php foreach ($listing_categories as $key => $listing_category): ?>
            <?php if ($key == 0): ?>
            <div class="row">
                <div class="col-sm-7 pr-0">
                    <select class="form-control select2" data-toggle="select2" name="categories[]" id = "category_default" required>
                        <option value=""><?php echo get_phrase('select_category'); ?></option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $listing_category): ?> selected <?php endif; ?>><?php echo $category['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-primary btn-sm" style="margin-top: 2px; float: right;" name="button" onclick="appendCategory()"> <i class="fa fa-plus"></i> </button>
                </div>
            </div>

            <?php else: ?>
                <div class="row mt-2 appendedCategoryFields" style="margin-top: 10px;">
                    <div class="col-sm-7 pr-0">
                        <select class="form-control select2" name="categories[]">
                            <option value=""><?php echo get_phrase('select_category'); ?></option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $listing_category): ?> selected <?php endif; ?>><?php echo $category['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-danger btn-sm" style="margin-top: 2px; float: right;" name="button" onclick="removeCategory(this)"> <i class="fa fa-minus"></i> </button>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div id="blank_category_field">
      <div class="row appendedCategoryFields" style="margin-top: 10px;">
        <div class="col-sm-7 pr-0">
          <select class="form-control" name="categories[]">
            <option value=""><?php echo get_phrase('select_category'); ?></option>
            <?php foreach ($categories as $category): ?>
              <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-sm-2">
          <button type="button" class="btn btn-danger btn-sm" style="margin-top: 2px; float: right;" name="button" onclick="removeCategory(this)"> <i class="fa fa-minus"></i> </button>
        </div>
      </div>
    </div>
  </div>
</div>





<div class="form-group">
  <label for="country_id" class="col-sm-3 control-label"><?php echo get_phrase('country'); ?></label>

  <div class="col-sm-7">
    <select name="country_id" id = "country_id" class="select2" data-allow-clear="true" data-placeholder="<?php echo get_phrase('select_country'); ?>" onchange="countryWiseStateOnCreate(this.value)">
      <option value="0"><?php echo get_phrase('none'); ?></option>
      <?php foreach ($countries as $country): ?>
          <option value="<?php echo $country['id']; ?>" <?php if($listing_details['country_id'] == $country['id']): ?> selected <?php endif;?>><?php echo $country['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label" for="city_id"> <?php echo get_phrase('city'); ?></label>
  <div class="col-sm-7">
    <select class="form-control select2" name="city_id" id="city_id">
      <?php foreach ($this->crud_model->get_cities_by_country_id($listing_details['country_id'])->result_array() as $city): ?>
          <option value="<?php echo $city['id']; ?>" <?php if($listing_details['city_id'] == $city['id']): ?> selected <?php endif;?>><?php echo $city['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<div class="form-group ">
						<label for="name"  class="col-sm-3 control-label" ><?php echo get_phrase('state'); ?></label>
						<div class="col-sm-7">
						<select name="state_id" id="state_id_on_create" class="form-control select2" data-bs-toggle="select2" required>
						<?php foreach ($states as $state): ?>
							<option value="<?php echo $state['id']; ?>" <?php if($listing_details['state_id'] == $state['id']) echo 'selected'; ?>><?php echo $state['name']; ?></option>
							<?php endforeach; ?>
						</select>
						</div>

					</div>
          

<div class="form-group">
  <label class="col-sm-3 control-label" for="address"><?php echo get_phrase('address'); ?></label>
  <div class="col-sm-7">
    <textarea name="address" rows="5" class="form-control" id = "address"><?php echo $listing_details['address']; ?></textarea>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label" for="latitude"><?php echo get_phrase('latitude'); ?></label>
  <div class="col-sm-7">
    <input type="text" class="form-control" id="latitude" value="<?php echo $listing_details['latitude']; ?>" name="latitude">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label" for="longitude"><?php echo get_phrase('longitude'); ?></label>
  <div class="col-sm-7">
    <input type="text" class="form-control" id="longitude" value="<?php echo $listing_details['longitude']; ?>" name="longitude">
  </div>
</div>

<div class="form-group">


  <label class="col-sm-3 control-label" for="select_location"> <?php echo get_phrase('select_location'); ?></label>
  <div class="col-sm-7">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
       integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
       crossorigin=""></script>
     <div id="map" style="height: 200px; cursor: pointer;"></div>

     <script type="text/javascript">
       <?php if(get_settings("active_map") == 'openstreetmap'): ?>
          //free map
          var map = L.map('map').setView([<?php echo $listing_details['latitude']; ?>, <?php echo $listing_details['longitude']; ?>], 13);
          L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '<a href="<?= site_url(); ?>" target="_blank"><?= get_settings("system_title"); ?></a>',
            gestureHandling: true
          }).addTo(map);
        <?php else: ?>
          //paid maps
          var map = L.map('map').setView([<?php echo $listing_details['latitude']; ?>, <?php echo $listing_details['longitude']; ?>], 13);
          L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: '<a href="<?= site_url(); ?>" target="_blank"><?= get_settings("system_title"); ?></a>',
            id: 'mapbox/streets-v11',
            accessToken: '<?= get_settings("map_access_token"); ?>',
            gestureHandling: true
          }).addTo(map);
        <?php endif; ?>
        L.marker([<?php echo $listing_details['latitude']; ?>, <?php echo $listing_details['longitude']; ?>]).addTo(map).openPopup();




        var popup = L.popup();
        map.on('click', onMapClick);
        function onMapClick(e) {
          popup.setLatLng(e.latlng).setContent("<?php echo get_phrase('your_selected'); ?> " + e.latlng.toString()).openOn(map);

          var lat_lan_string =  e.latlng.toString();
          var lat_lan_string_arr = lat_lan_string.split(", ");
          var lat_string_arr = lat_lan_string_arr[0].split('LatLng(');
          var lan_string_arr = lat_lan_string_arr[1].split(')');
          var lat = lat_string_arr[1];
          var lan = lan_string_arr[0];
          $('#latitude').val(lat);
          $('#longitude').val(lan);
        }

        function set_previous_lat_lan(){
          if($('.leaflet-pane.leaflet-popup-pane').html() === ""){
            $('#latitude').val(<?php echo $listing_details['latitude']; ?>);
            $('#longitude').val(<?php echo $listing_details['longitude']; ?>);
          }
        }

     </script>
   </div>
 </div>