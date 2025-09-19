<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function get_all_users($user_id = 0) {
        if ($user_id > 0) {
            $this->db->where('id', $user_id);
        }
        return $this->db->get('user');
    }

    public function get_users() {
        $this->db->where('role_id', 1);
        return $this->db->get('user');
    }

    function add_user($param1 = "") {
        $data['email'] = sanitizer($this->input->post('email'));
        $data['name'] = sanitizer($this->input->post('name'));
        $data['password'] = sha1(sanitizer($this->input->post('password')));
        $data['address'] = sanitizer($this->input->post('address'));
        $data['phone'] = sanitizer($this->input->post('phone'));
        $data['website'] = sanitizer($this->input->post('website'));
        $data['about'] = sanitizer($this->input->post('about'));
        $social_links = array(
            'facebook' => sanitizer($this->input->post('facebook')),
            'twitter' => sanitizer($this->input->post('twitter')),
            'linkedin' => sanitizer($this->input->post('linkedin')),
        );
        $data['social'] = json_encode($social_links);
        $data['role_id'] = 1;
        $data['wishlists'] = '[]';
        $verification_code =  md5(rand(100000000, 200000000));
        $data['verification_code'] = $verification_code;

        $validity = $this->check_duplication('on_create', $data['email']);
        if($validity){
            if (strtolower($this->session->userdata('role')) == 'admin') {
                $data['is_verified'] = 1;
                $this->db->insert('user', $data);
                $user_id = $this->db->insert_id();
                $this->upload_user_image($user_id);
                $this->session->set_flashdata('flash_message', get_phrase('user_registration_successfully_done'));
            }else {
                $data['is_verified'] = 0;
                $this->db->insert('user', $data);
                $user_id = $this->db->insert_id();
                $this->upload_user_image($user_id);
                $this->email_model->send_email_verification_mail($data['email'], $verification_code);
                $this->session->set_flashdata('flash_message', get_phrase('your_registration_has_been_successfully_done').'. '.get_phrase('please_check_your_mail_inbox_to_verify_your_email_address').'.');
            }
            
        }else {
            if($param1 == 'sign_up'){
                $this->db->where('email', $data['email']);
                $this->db->where('is_verified', 0);
                $unverified_user = $this->db->get('user');
                if($unverified_user->num_rows() > 0){
                    $unverified_user_row = $unverified_user->row_array();
                    $this->email_model->send_email_verification_mail($unverified_user_row['email'], $unverified_user_row['verification_code']);
                    $this->session->set_flashdata('flash_message', get_phrase('You have already registered').'. '.get_phrase('please_check_your_mail_inbox_to_verify_your_email_address').'.');
                    return;
                }
            }
            $this->session->set_flashdata('error_message', get_phrase('this_email_id_has_been_taken'));
        }
        return;
    }

    function edit_user($user_id="") {
        $data['email'] = sanitizer($this->input->post('email'));
        $data['name'] = sanitizer($this->input->post('name'));
        $data['address'] = sanitizer($this->input->post('address'));
        $data['about'] = sanitizer($this->input->post('about'));
        $data['phone'] = sanitizer($this->input->post('phone'));
        $data['meta_pixel'] = sanitizer($this->input->post('meta_pixel'));
        $data['website'] = sanitizer($this->input->post('website'));
        $data['about'] = sanitizer($this->input->post('about'));
        $social_links = array(
            'facebook' => sanitizer($this->input->post('facebook')),
            'twitter' => sanitizer($this->input->post('twitter')),
            'linkedin' => sanitizer($this->input->post('linkedin')),
        );
        $data['social'] = json_encode($social_links);

        $validity = $this->check_duplication('on_update', $data['email'], $user_id);

        if($validity){
            $this->db->where('id', $user_id);
            $this->db->update('user', $data);
            $this->upload_user_image($user_id);
            $this->upload_user_background_image($user_id);
            $this->session->set_flashdata('flash_message', get_phrase('user_updated_successfully'));
        }else {
            $this->session->set_flashdata('error_message', get_phrase('this_email_id_has_been_taken'));
        }
        return;
    }

    public function upload_user_image($user_id="") {
        if (isset($_FILES['user_image']) && $_FILES['user_image']['name'] != "") {
            move_uploaded_file($_FILES['user_image']['tmp_name'], 'uploads/user_image/'.$user_id.'.jpg');
        }
    }

     public function upload_user_background_image($user_id="") {
        if (isset($_FILES['user_background']) && $_FILES['user_background']['name'] != "") {
            move_uploaded_file($_FILES['user_background']['tmp_name'], 'uploads/user_background/'.$user_id.'.jpg');
        }
    }

    function get_user_thumbnail($user_id = "") {
        if (file_exists('uploads/user_image/'.$user_id.'.jpg')) {
            return base_url('uploads/user_image/'.$user_id.'.jpg');
        }else {
            return base_url('uploads/user_image/user.png');
        }
    }

    public function check_duplication($action = "", $email = "", $user_id = "") {
        $duplicate_email_check = $this->db->get_where('user', array('email' => $email));

        if ($action == 'on_create') {
            if ($duplicate_email_check->num_rows() > 0) {
                return false;
            }else {
                return true;
            }
        }elseif ($action == 'on_update') {
            if ($duplicate_email_check->num_rows() > 0) {
                if ($duplicate_email_check->row()->id == $user_id) {
                    return true;
                }else {
                    return false;
                }
            }else {
                return true;
            }
        }
    }

    public function change_password($user_id="") {
        $data = array();
        if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
            $user_details = $this->get_all_users($user_id)->row_array();
            $current_password = sanitizer($this->input->post('current_password'));
            $new_password = sanitizer($this->input->post('new_password'));
            $confirm_password = sanitizer($this->input->post('confirm_password'));

            if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
                $data['password'] = sha1($new_password);
            }else {
                $this->session->set_flashdata('error_message', get_phrase('mismatch_password'));
                return;
            }
        }

        $this->db->where('id', $user_id);
        $this->db->update('user', $data);
        $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
    }

    public function get_listing_by_user_id($user_id = ""){
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'active');
        return $this->db->get('listing');
    }

    public function listing_import(){
		
		$file_name = $_FILES['csv_file']['name'];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $filename_without_ext = pathinfo($file_name, PATHINFO_FILENAME).(bin2hex(random_bytes(3)));
		move_uploaded_file($_FILES['csv_file']['tmp_name'],'assets/importCSV/'.$filename_without_ext.'.'.$ext);
        // $user_data;

		if (($handle = fopen('assets/importCSV/'.$filename_without_ext.'.'.$ext, 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if($count > 0){
                    $user_data['code'] = bin2hex(random_bytes(16));
					$user_data['name'] = html_escape($all_data[0]);
					$user_data['email'] = html_escape($all_data[1]);
                    $this->db->where('id', html_escape($all_data[2]));
                    $catagory= $this->db->get('category');
                    if( $catagory->num_rows()>0)
                    {$user_data['categories'] = '["'.html_escape($all_data[2]).'"]';}
                    else
                    {
                        $by_default= $this->db->get('category')->row_array();
                        $user_data['categories'] ='["'.$by_default.'"]';
                    }
				
					$user_data['address'] = html_escape($all_data[3]);
					$user_data['phone'] = html_escape($all_data[4]);

                    $latitude=html_escape($all_data[5]);
                    $longitude=html_escape($all_data[6]);
                    if( $latitude!="" &&  $longitude!="" )
                    { 
                        $user_data['latitude'] = $latitude;
					    $user_data['longitude'] = $longitude;
                    }
                    else
                    {
                        $user_data['latitude'] = "40.714340351475286";
					    $user_data['longitude'] = "-73.93590002150955";

                    }
                    $listing_type=strtolower(html_escape($all_data[7]));
                    if($listing_type=='hotel' ||$listing_type=='restaurant' ||$listing_type=='general' ||$listing_type=='shop' ||$listing_type=='beauty' )
                    {   $user_data['listing_type'] = $listing_type;  }
                    else
                    {    $user_data['listing_type'] = "general";}

					$user_data['date_added'] = strtotime("now");
					$user_data['date_modified'] =strtotime("now");
                    $is_featured=strtolower(html_escape($all_data[8]));
                    if($is_featured=='yes')
                    {  $user_data['is_featured'] =1;  }
                    else
                    {$user_data['is_featured'] =0;}
					$user_data['social'] = '{"facebook":"In qui laborum excep","twitter":"Id aut aut assumend","linkedin":"Corporis consequatur"}';
					$user_data['user_id'] = $this->session->userdata('user_id');
                    if($this->session->userdata('role_id')==1)
                    {
                        $user_data['package_expiry_date'] = 'admin';
                        $user_data['status'] = 'active';
                    }
                    else
                    {
                        $this->db->where('user_id',$this->session->userdata('user_id'));
                        $package_expire_date= $this->db->get('package_purchased_history')->row_array();
                        $user_data['package_expiry_date'] = $package_expire_date['expired_date'];
                        
                        $user_data['status'] = 'pending';
                        

                    }

                    $user_data['amenities'] = '[]';
                    $user_data['photos'] = '[]';
                    $user_data['video_provider'] = 'youtube';
                  

                    $city_id=html_escape($all_data[9]);
                    if($city_id!="")
                    {
                        $this->db->where('id', $city_id);
                        $all_city_state_country_from_city_table= $this->db->get('city')->row_array();
                        $user_data['city_id'] = $all_city_state_country_from_city_table['id'];
                        $user_data['state_id'] = $all_city_state_country_from_city_table['state_id'];
                        $user_data['country_id'] =$all_city_state_country_from_city_table['country_id'];

                    }
                  
            
                    $this->db->insert('listing', $user_data);
				
				}
				$count++;
			}
			fclose($handle);

  
		}

	}

    public function get_user_meta_pixel_id($user_id="")
    {
        $this->db->where('id', $user_id);
        $info= $this->db->get('user');
        if($info->num_rows()>0)
        {
            $info=$info->row_array();
            $meta_pixel_id=$info['meta_pixel'];
            return  $meta_pixel_id;

        }
        else
        {
            return 0;
        }
      
    }

	

}
