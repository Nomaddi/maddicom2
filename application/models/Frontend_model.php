<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Frontend_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    /*cache control*/
    $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    $this->output->set_header('Pragma: no-cache');
    // $this->load->dbforge();
  }

  function get_listings()
  {

    $this->db->group_start();
    $this->db->where('status', 'active');
    $this->db->group_end();

    $this->db->group_start();
    $this->db->where('package_expiry_date >', time());
    $this->db->or_where('package_expiry_date', 'admin');
    $this->db->group_end();

    return $this->db->get('listing');
  }


  function filter_listing($search_string,$category_ids = array(), $amenity_ids = array(), $certification_ids = array(), $state_id = "", $city_id = "", $price_range = 0, $with_video = 0, $with_open = 'all', $page_number = 1)
  {
    //for custom pagination
    if ($page_number <= 1) :
      $starting_value = 0;
    else :
      $starting_value = $page_number * 12 - 12;
    endif;


    $this->db->order_by('is_featured', 'desc');
    $this->db->limit(12, $starting_value);

    if($search_string!="")
    {
      $this->db->group_start();
        $this->db->like('name', $search_string);
        $this->db->or_like('description', $search_string);
        $this->db->or_like('listing_type', $search_string);
        $this->db->or_like('seo_meta_tags', $search_string);
      $this->db->group_end();
    }

    if(count($category_ids) > 0){
      $this->db->group_start();
        foreach($category_ids as $category_key => $category_id){
          if($category_key == 0){
            $this->db->like('categories', '"'.$category_id.'"');
          }else{
            $this->db->or_like('categories', '"'.$category_id.'"');
          }
        }
      $this->db->group_end();
    }

    if(count($amenity_ids) > 0){
      $this->db->group_start();
        foreach($amenity_ids as $amenity_key => $amenity_id){
          if($amenity_key == 0){
            $this->db->like('amenities', '"'.$amenity_id.'"');
          }else{
            $this->db->or_like('amenities', '"'.$amenity_id.'"');
          }
        }
      $this->db->group_end();
    }

    // Filtro por certificaciones (JSON con IDs)
    if (count($certification_ids) > 0) {
      $this->db->group_start();
        foreach ($certification_ids as $cert_key => $cert_id) {
          if ($cert_key == 0) {
            $this->db->like('certifications', '"'.$cert_id.'"');
          } else {
            $this->db->or_like('certifications', '"'.$cert_id.'"');
          }
        }
      $this->db->group_end();
    }


    if($state_id != 'all'){
      $this->db->group_start();
        $this->db->where('state_id', $state_id);
      $this->db->group_end();
    }

    if($city_id > 0){
      $this->db->group_start();
        $this->db->where('city_id', $city_id);
      $this->db->group_end();
    }

    if($price_range > 0){
      $this->db->group_start();
        $this->db->where('price_range <=', $price_range);
      $this->db->group_end();
    }

    if($with_video != 0){
      $this->db->group_start();
        $this->db->where('video_url !=', '');
      $this->db->group_end();
    }

    if($with_open != 'all'){
      $current_time_minutes = date('H') * 60;
      $this->db->group_start();
        $this->db->where('opened_minutes <=', $current_time_minutes);
        $this->db->where('closed_minutes >=', $current_time_minutes);
      $this->db->group_end();
    }
    // ✅ Agregar este filtro
    $this->db->where('status !=', 'pending');

    return $this->db->get('listing')->result_array();
  }


  function filter_listing_all_rows($search_string,$category_ids = array(), $amenity_ids = array(), $certification_ids = array(), $state_id = "", $city_id = "", $price_range = 0, $with_video = 0, $with_open = 'all')
  {
    $this->listing_table_data_centralized();

    if($search_string!="")
    {
      $this->db->group_start();
        $this->db->like('name', $search_string);
        $this->db->or_like('description', $search_string);
        $this->db->or_like('listing_type', $search_string);
      $this->db->group_end();
    }

    if(count($category_ids) > 0){
      $this->db->group_start();
        foreach($category_ids as $category_key => $category_id){
          if($category_key == 0){
            $this->db->like('categories', '"'.$category_id.'"');
          }else{
            $this->db->or_like('categories', '"'.$category_id.'"');
          }
        }
      $this->db->group_end();
    }

    if(count($amenity_ids) > 0){
      $this->db->group_start();
        foreach($amenity_ids as $amenity_key => $amenity_id){
          if($amenity_key == 0){
            $this->db->like('amenities', '"'.$amenity_id.'"');
          }else{
            $this->db->or_like('amenities', '"'.$amenity_id.'"');
          }
        }
      $this->db->group_end();
    }

    // Filtro por certificaciones (JSON con IDs)
    if (count($certification_ids) > 0) {
      $this->db->group_start();
        foreach ($certification_ids as $cert_key => $cert_id) {
          if ($cert_key == 0) {
            $this->db->like('certifications', '"'.$cert_id.'"');
          } else {
            $this->db->or_like('certifications', '"'.$cert_id.'"');
          }
        }
      $this->db->group_end();
    }


    if($state_id != 'all'){
      $this->db->group_start();
        $this->db->where('state_id', $state_id);
      $this->db->group_end();
    }

    if($city_id > 0){
      $this->db->group_start();
        $this->db->where('city_id', $city_id);
      $this->db->group_end();
    }

    if($price_range > 0){
      $this->db->group_start();
        $this->db->where('price_range <=', $price_range);
      $this->db->group_end();
    }

    if($with_video != 0){
      $this->db->group_start();
        $this->db->where('video_url !=', '');
      $this->db->group_end();
    }

    if($with_open != 'all'){
      $current_time_minutes = date('H') * 60;
      $this->db->group_start();
        $this->db->where('opened_minutes <=', $current_time_minutes);
        $this->db->where('closed_minutes >=', $current_time_minutes);
      $this->db->group_end();
    }

    // ✅ Excluir los pendientes
    $this->db->where('status !=', 'pending');

    return $this->db->get('listing')->result_array();
  }

  function listing_table_data_centralized(){

    // $column_name = 'price_range';
    // $table_name = 'listing';

    // if (!$this->db->field_exists($column_name, $table_name)) {
    //     $fields = array(
    //         $column_name => array(
    //             'type' => 'VARCHAR',
    //             'constraint' => '100',
    //             'null' => TRUE,
    //             'default' => 'no'
    //         ),
    //     );

    //     $this->dbforge->add_column($table_name, $fields);
    // }

    // $column_name = 'opened_minutes';
    // if (!$this->db->field_exists($column_name, $table_name)) {
    //     $fields = array(
    //         $column_name => array(
    //             'type' => 'VARCHAR',
    //             'constraint' => '100',
    //             'null' => TRUE,
    //             'default' => 'no'
    //         ),
    //     );

    //     $this->dbforge->add_column($table_name, $fields);
    // }

    // $column_name = 'closed_minutes';
    // if (!$this->db->field_exists($column_name, $table_name)) {
    //     $fields = array(
    //         $column_name => array(
    //             'type' => 'VARCHAR',
    //             'constraint' => '100',
    //             'null' => TRUE,
    //             'default' => 'no'
    //         ),
    //     );

    //     $this->dbforge->add_column($table_name, $fields);
    //     return;
    // }
    

    $price_range_listings = $this->db->where('opened_minutes', 'no')->or_where('price_range', 'no')->limit(10000)->get('listing');
    if($price_range_listings->num_rows() > 0){
      foreach($price_range_listings->result_array() as $price_range_listing){
        if ($price_range_listing['listing_type'] == 'hotel') {
          $this->db->select_max('price');
          $maximum_price = $this->db->get_where('hotel_room_specification', array('listing_id' => $price_range_listing['id']))->row()->price;
        } elseif ($price_range_listing['listing_type'] == 'shop') {
          $this->db->select_max('price');
          $maximum_price = $this->db->get_where('product_details', array('listing_id' => $price_range_listing['id']))->row()->price;
        } elseif ($price_range_listing['listing_type'] == 'restaurant') {
          $this->db->select_max('price');
          $maximum_price = $this->db->get_where('food_menu', array('listing_id' => $price_range_listing['id']))->row()->price;
        } elseif ($price_range_listing['listing_type'] == 'beauty_service') {
          $this->db->select_max('price');
          $maximum_price = $this->db->get_where('beauty_service', array('listing_id' => $price_range_listing['id']))->row()->price;
        }else{
          $maximum_price = 0;
        }


        $time_conf = $this->db->get_where('time_configuration', array('listing_id' => $price_range_listing['id']));
        if($time_conf->num_rows() > 0){
          $time_conf = $time_conf->row_array();
          $exploded_time = explode('-', $time_conf[strtolower(date("l"))]);
          $data['opened_minutes'] = $this->convertToMinutes($exploded_time[0]);
          $data['closed_minutes'] = $this->convertToMinutes($exploded_time[1]);
        }

        $data['price_range'] = $maximum_price;
        $this->db->where('id', $price_range_listing['id'])->update('listing', $data);
      }
    }

  }

  function convertToMinutes($time="") {
    // Split the time string by colon (if it exists)
    $parts = explode(':', $time);

    // If there's no colon, consider it as just hours
    if (count($parts) == 1) {
        $hours = (int)$parts[0];  // Get the hours
        $minutes = 0;             // Set minutes to 0
    } else {
        $hours = (int)$parts[0];  // Get the hours
        $minutes = (int)$parts[1];  // Get the minutes
    }

    // Convert hours to minutes and add the remaining minutes
    $totalMinutes = ($hours * 60) + $minutes;

    return $totalMinutes;
}

  function get_amenity($amenity_id = "", $attribute = "")
  {
    if ($attribute != "") {
      $this->db->select($attribute);
    }

    if ($amenity_id != "") {
      $this->db->where('id', $amenity_id);
    }


    return $this->db->get('amenities');
  }

public function get_certification($id, $field = '')
  {
    if ($field != "") {
      $this->db->select($field);
    }

    if ($id != "") {
      $this->db->where('id', $id);
    }


    return $this->db->get('certifications');
  }

  // Functions related to review
  function post_review()
  {
    $data['reviewer_id'] = $this->input->post('reviewer_id');
    $data['listing_id'] = sanitizer($this->input->post('listing_id'));
    $data['review_rating'] = sanitizer($this->input->post('review_rating'));
    $data['review_comment'] = sanitizer($this->input->post('review_comment'));
    $data['timestamp'] = strtotime(date('D, d-M-Y'));
    $this->db->insert('review', $data);
  }

  function get_listing_wise_review($listing_id = "")
  {
    return $this->db->get_where('review', array('listing_id' => $listing_id))->result_array();
  }

  function get_listing_wise_rating($listing_id = "")
  {
    $this->db->select_avg('review_rating');
    $rating = $this->db->get_where('review', array('listing_id' => $listing_id))->row()->review_rating;
    return number_format((float)$rating, 1, '.', '');
  }

  function get_rating_wise_quality($listing_id = "")
  {
    $rating = $this->get_listing_wise_rating($listing_id);
    $this->db->where('rating_to >=', $rating);
    $this->db->where('rating_from <=', $rating);
    return $this->db->get('review_wise_quality')->row_array();
  }

  public function get_percentage_of_specific_rating($listing_id = "", $rating = "")
  {
    $total_number_of_reviewers = count($this->get_listing_wise_review($listing_id));
    $total_number_of_reviewers_of_specific_rating = $this->db->get_where('review', array('listing_id' => $listing_id, 'review_rating' => $rating))->num_rows();

    if ($total_number_of_reviewers_of_specific_rating > 0) {
      $percentage = ($total_number_of_reviewers_of_specific_rating / $total_number_of_reviewers) * 100;
    } else {
      $percentage = 0;
    }
    return floor($percentage);
  }

  public function get_reviewers_image($email = "")
  {
    $user_details = $this->db->get_where('user', array('email' => $email));
    if ($user_details->num_rows() > 0) {
      return base_url("uploads/user_image/" . $user_details->row()->id . '.jpg');
    } else {
      return base_url('uploads/user_image/user.png');
    }
  }

  public function toggle_wishlist($listing_id = "")
  {

    $existing_wishlist = array();
    $status = "";
    $user_details = $this->db->get_where('user', array('id' => $this->session->userdata('user_id')))->row_array();
    if ($user_details['wishlists'] != "") {
      $existing_wishlist = json_decode($user_details['wishlists'], true);
      if (in_array($listing_id, $existing_wishlist)) {
        if (($key = array_search($listing_id, $existing_wishlist)) !== false) {
          unset($existing_wishlist[$key]);
        }
        $status = 'removed';
      } else {
        array_push($existing_wishlist, $listing_id);
        $status = 'added';
      }
    } else {
      array_push($existing_wishlist, $listing_id);
      $status = 'added';
    }
    $updater = array(
      'wishlists' => json_encode($existing_wishlist)
    );
    $this->db->where('id', $this->session->userdata('user_id'));
    $this->db->update('user', $updater);
    return $status;
  }

  function claim_this_listing()
  {
    $data['listing_id'] = sanitizer($this->input->post('listing_id'));
    $data['user_id'] = sanitizer($this->input->post('user_id'));
    $data['full_name'] = sanitizer($this->input->post('full_name'));
    $data['phone'] = sanitizer($this->input->post('phone'));
    $data['additional_information'] = sanitizer($this->input->post('additional_information'));
    $data['status'] = 0;
    $this->db->insert('claimed_listing', $data);
  }

  function report_this_listing()
  {
    $data['listing_id'] = sanitizer($this->input->post('listing_id'));
    $data['reporter_id'] = sanitizer($this->input->post('reporter_id'));
    $data['report'] = sanitizer($this->input->post('report'));
    $data['status'] = 0;
    $data['date_added'] = strtotime(date('D, d M Y'));
    $this->db->insert('reported_listing', $data);
  }

  function restaurant_booking()
  {
    $data['user_id']             = $this->input->post('user_id');
    $data['requester_id']             = $this->input->post('requester_id');
    $data['listing_id']               = $this->input->post('listing_id');
    $data['listing_type']               = $this->input->post('listing_type');
    $data['booking_date']             = strtotime($this->input->post('dates'));

    $additional_data['adult_guests']  = $this->input->post('adult_guests_for_booking');
    $additional_data['child_guests']  = $this->input->post('child_guests_for_booking');
    $additional_data['time']          = $this->input->post('time');
    $data['additional_information']   = json_encode($additional_data);

    $data['created_at']               = strtotime(date('dMY'));
    $data['status']                   = 0;
    $this->db->insert('booking', $data);
  }

  function beauty_service()
  {
    $data['user_id']             = $this->input->post('user_id');
    $data['requester_id']             = $this->input->post('requester_id');
    $data['listing_id']               = $this->input->post('listing_id');
    $data['listing_type']               = $this->input->post('listing_type');
    $data['booking_date']             = strtotime($this->input->post('dates'));

    $additional_data['time']          = strtotime($this->input->post('time'));
    $additional_data['service']          = $this->input->post('service');
    $additional_data['note']          = $this->input->post('note');
    $data['additional_information']   = json_encode($additional_data);

    $data['created_at']               = strtotime(date('dMY'));
    $data['status']                   = 0;
    $this->db->insert('booking', $data);
  }

  function hotel_booking()
  {
    $data['user_id']                  = $this->input->post('user_id');
    $data['requester_id']                  = $this->input->post('requester_id');
    $data['listing_id']               = $this->input->post('listing_id');
    $data['listing_type']               = $this->input->post('listing_type');

    $dates = explode('>', $this->input->post('dates'));

    //$fromdate = DateTime::createFromFormat('m-d-y', trim($dates[0]));
    //$todate = DateTime::createFromFormat('m-d-y', trim($dates[1]));

    //this don't garbage code
    //echo "<span style='display: none;'>";
    //print_r($fromdate);
    //print_r($todate);
    //echo "</span>";
    //this don't garbage code


    $start_date_arr = explode('-', $dates[0]);

    $for_month = strtotime('20-' . $start_date_arr[0] . '-2021');


    $start_date = $start_date_arr[1] . '-' . date('M', $for_month) . '-' . date('Y');



    $end_date_arr = explode('-', $dates[1]);

    $for_months = strtotime('25-' . trim($end_date_arr[0]) . '-2021');


    $end_date = $end_date_arr[1] . ' ' . date('M', $for_months) . ' ' . date('Y');


    $data['booking_date']             = strtotime($start_date) . ' - ' . strtotime($todend_dateate);
    $additional_data['adult_guests']  = $this->input->post('adult_guests_for_booking');
    $additional_data['child_guests']  = $this->input->post('child_guests_for_booking');
    $additional_data['room_type']          = $this->input->post('room_type');
    $data['additional_information']   = json_encode($additional_data);

    $data['created_at']               = strtotime(date('d M Y'));
    $data['status']                   = 0;
    $this->db->insert('booking', $data);
  }

  function get_category_wise_listings($category_id = "")
  {
      $this->db->like('categories', '"'.$category_id.'"');
      $this->db->where('status', 'active');
      return  $this->db->get('listing')->result_array();
  }

  function get_top_ten_listings()
  {
    $listing_ids = array();
    $listing_id_with_rating = array();
    $listings = $this->get_listings()->result_array();
    foreach ($listings as $listing) {
      if (!has_package($listing['user_id']) > 0) {
        continue;
      }
      $listing_id_with_rating[$listing['id']] = $this->get_listing_wise_rating($listing['id']);
    }
    arsort($listing_id_with_rating);
    foreach ($listing_id_with_rating as $key => $value) {
      if (count($listing_ids) <= 10) {
        array_push($listing_ids, $key);
      }
    }
    if (count($listing_ids) > 0) {
      $this->db->where_in('id', $listing_ids);
      $this->db->where('status', 'active');
      return  $this->db->get('listing')->result_array();
    } else {
      return array();
    }
  }

  public function get_top_listings_by_certs($limit = 8)
  {
      $listing_ids = array();
      $listing_id_with_cert_count = array();
      $listings = $this->get_listings()->result_array();
      foreach ($listings as $listing) {
          if (!has_package($listing['user_id']) > 0) {
              continue;
          }
          // Obtener la cantidad de certificaciones
          $certs = json_decode($listing['certifications'] ?? '[]', true);
          $listing_id_with_cert_count[$listing['id']] = count($certs);
      }

      // Ordenamos por la cantidad de certificaciones
      arsort($listing_id_with_cert_count);
      foreach ($listing_id_with_cert_count as $key => $value) {
          if (count($listing_ids) <= $limit) {
              array_push($listing_ids, $key);
          }
      }

      // Filtrar solo aquellos con paquetes activos
      $final = [];
      foreach ($listing_ids as $listing_id) {
          $listing = $this->db->get_where('listing', ['id' => $listing_id])->row_array();
          if (has_package($listing['user_id']) > 0) {
              $final[] = $listing;
              if (count($final) >= $limit) break;
          }
      }
      return $final;
  }


  ////Search function For custom pagination
  function search_listing($search_string = '', $selected_city_id = '', $selected_category_id = '', $page_number = 1)
  {
    if ($page_number <= 1) :
      $starting_value = 0;
    else :
      $starting_value = $page_number * 12 - 12;
    endif;

    $this->db->where('status', 'active');
    $this->db->where('package_expiry_date >', time());
    $this->db->or_where('package_expiry_date', 'admin');

    if ($search_string != "") {
      $this->db->group_start();
      $this->db->like('name', $search_string);
      $this->db->or_like('description', $search_string);
      $this->db->or_like('seo_meta_tags', $search_string);
      $this->db->or_like('meta_description', $search_string);
      $this->db->group_end();
    }

    if ($selected_city_id != "") {
      $this->db->like('city_id', "$selected_city_id");
    }

    if ($selected_category_id != "") {
      $this->db->like('categories', "$selected_category_id");
    }
    $this->db->order_by('is_featured', 'desc');


    return  $this->db->get('listing', 12, $starting_value)->result_array();
  }

  // function search_listing($search_string = '', $selected_category_id = '') {
  //     if ($search_string != "") {
  //         $this->db->like('name', $search_string);
  //         $this->db->or_like('description', $search_string);
  //     }

  //     if ($selected_category_id != "") {
  //         $this->db->like('categories', "$selected_category_id");
  //     }

  //     $this->db->order_by('is_featured', 'desc');

  //     $this->db->where('status', 'active');
  //     return  $this->db->get('listing')->result_array();
  // }

  function search_listing_all_rows($search_string = '', $selected_city_id = '', $selected_category_id = '')
  {
    $this->db->where('status', 'active');
    $this->db->where('package_expiry_date >', time());
    $this->db->or_where('package_expiry_date', 'admin');
    if ($search_string != "") {
      $this->db->like('name', $search_string);
      $this->db->or_like('description', $search_string);
      $this->db->or_like('seo_meta_tags', $search_string);
    }

    if ($selected_city_id != "") {
      $this->db->like('city_id', "$selected_city_id");
    }

    if ($selected_category_id != "") {
      $this->db->like('categories', "$selected_category_id");
    }

    $this->db->order_by('is_featured', 'desc');
    return  $this->db->get('listing')->result_array();
  }

  function get_the_maximum_price_limit_of_all_listings()
  {
    $related_tables = array('hotel_room_specification', 'food_menu', 'product_details', 'beauty_service');
    $maximum_prices = array();
    for ($i = 0; $i < count($related_tables); $i++) { // select_max active record didn't work, thats why i had to do in this shitty style
      $prices = array();
      $this->db->select('price');
      $query_price = $this->db->get($related_tables[$i])->result_array();
      foreach ($query_price as $query) {
        array_push($prices, $query['price']);
      }
      if (count($prices) > 0) {
        array_push($maximum_prices, max($prices));
      } else {
        array_push($maximum_prices, 0);
      }
    }
    return max($maximum_prices);
  }

  function check_if_this_listing_lies_in_price_range($listing_id = "", $price_range = "")
  {

    $maximum_price = 0;

    if ($price_range > 0) {
      $listing_details = $this->db->get_where('listing', array('id' => $listing_id))->row_array();

      if ($listing_details['listing_type'] == 'hotel') {
        $this->db->select_max('price');
        $maximum_price = $this->db->get_where('hotel_room_specification', array('listing_id' => $listing_id))->row()->price;
      } elseif ($listing_details['listing_type'] == 'shop') {
        $this->db->select_max('price');
        $maximum_price = $this->db->get_where('product_details', array('listing_id' => $listing_id))->row()->price;
      } elseif ($listing_details['listing_type'] == 'restaurant') {
        $this->db->select_max('price');
        $maximum_price = $this->db->get_where('food_menu', array('listing_id' => $listing_id))->row()->price;
      } elseif ($listing_details['listing_type'] == 'beauty_service') {
        $this->db->select_max('price');
        $maximum_price = $this->db->get_where('beauty_service', array('listing_id' => $listing_id))->row()->price;
      }

      // echo $listing_id.'-'.$maximum_price.'--'.$price_range.'<br/>';

      // returning part
      if ($price_range >= $maximum_price) {
        return $listing_id;
      } else {
        return 0;
      }
    } else {
      return 0;
    }
  }

  //user select
  function get_users($user_id = 0)
  {
    if ($user_id > 0) {
      $this->db->where('id', $user_id);
    }
    return $this->db->get('user');
  }

  //category select
  function get_categories($category_id = 0)
  {
    if ($category_id > 0) {
      $this->db->where('id', $category_id);
    }
    return $this->db->get('category');
  }

  //blog select
  public function get_blogs($blog_id = "")
  {
    if ($blog_id > 0) {
      $this->db->where('id', $blog_id);
    } else {
      $this->db->where('status', 1);
    }
    return $this->db->get('blogs');
  }

  //comment select
  public function get_comments($blog_id = 0, $under_comment_id = 0)
  {
    if ($blog_id > 0) {
      $this->db->where('blog_id', $blog_id);
    }
    if ($under_comment_id > 0) {
      $this->db->where('under_comment_id', $under_comment_id);
    } else {
      $this->db->where('under_comment_id', 0);
    }
    return $this->db->get('blog_comments');
  }

  //comment select
  public function get_comment_row($comment_id = 0)
  {
    if ($comment_id > 0) {
      $this->db->where('id', $comment_id);
    }
    return $this->db->get('blog_comments');
  }

  //blog search
  public function blog_search($searching_key = "")
  {
    $this->db->like('name', $searching_key);
    $categories = $this->db->get('category')->result_array();

    $this->db->like('title', $searching_key);
    foreach ($categories as $category) :
      $this->db->or_like('category_id', $category['id']);
    endforeach;
    $this->db->or_like('blog_text', $searching_key);
    $this->db->where('status', 1);
    return $this->db->get('blogs')->result_array();
  }

  public function blog_category_search($category_id = "")
  {

    $this->db->where('category_id', $category_id);
    $this->db->where('status', 1);
    return $this->db->get('blogs')->result_array();
  }

  public function latest_blog_post()
  {
    $this->db->order_by('added_date', 'desc');
    $this->db->limit(4);
    $this->db->where('status', 1);
    return $this->db->get('blogs')->result_array();
  }

  public function comment_add()
  {
    $data['blog_id'] = sanitizer($this->input->post('blog_id'));
    $data['comment'] = sanitizer($this->input->post('comment'));
    $data['user_id'] = sanitizer($this->session->userdata('user_id'));
    $data['under_comment_id'] = sanitizer($this->input->post('under_comment_id'));
    $data['added_date'] = strtotime(date('dMY'));
    $this->db->insert('blog_comments', $data);
  }

  public function update_blog_comment($comment_id = "")
  {
    $data['modified_date'] = strtotime(date('dMY'));
    $data['comment'] = sanitizer($this->input->post('comment'));
    $this->db->where('id', $comment_id);
    $this->db->update('blog_comments', $data);
  }

  function get_parent_categories($category_id = 0)
  {
    if ($category_id > 0) {
      $this->db->where('id', $category_id);
    }
    $this->db->where('parent', 0);
    return $this->db->get('category');
  }
}
