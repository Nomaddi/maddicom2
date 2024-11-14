<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        // Set the timezone
		date_default_timezone_set(get_settings('timezone'));
    }

    public function index() {
        if ($this->session->userdata('admin_login') == true) {
            redirect(site_url('admin/dashboard'), 'refresh');
        }elseif ($this->session->userdata('user_login') == true) {
            redirect(site_url('user/dashboard'), 'refresh');
        }else {
            redirect(site_url('home/login'), 'refresh');
        }
    }

    public function validate_login($from = "") {
        if(!$this->crud_model->check_rechaptcha()  && get_settings('recaptcha_status') == 1){
            $this->session->set_flashdata('error_message', get_phrase('recaptcha_validation_failed'));
            redirect(site_url('home/login'), 'refresh');
        }

        $email = sanitizer($this->input->post('email'));
        $password = sanitizer($this->input->post('password'));
        $credential = array('email' => $email, 'password' => sha1($password), 'is_verified' => 1);

        // Checking login credential for admin
        $query = $this->db->get_where('user', $credential);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('is_logged_in', 1);
            $this->session->set_userdata('user_id', $row->id);
            $this->session->set_userdata('role_id', $row->role_id);
            $this->session->set_userdata('role', get_user_role('user_role', $row->id));
            $this->session->set_userdata('name', $row->name);
            if ($row->role_id == 1) {
                $this->session->set_userdata('admin_login', '1');
                redirect(site_url('admin/dashboard'), 'refresh');
            }else if($row->role_id == 2){
                $this->session->set_userdata('user_login', '1');
                redirect(site_url('user/dashboard'), 'refresh');
            }
        }else {
            $this->session->set_flashdata('error_message', get_phrase('provided_credentials_are_invalid'));
            redirect(site_url('home/login'), 'refresh');

        }

    }

    public function register_user() {
        if(!$this->crud_model->check_rechaptcha() && get_settings('recaptcha_status') == 1){
            $this->session->set_flashdata('error_message', get_phrase('recaptcha_validation_failed'));
            redirect(site_url('home/sign_up'), 'refresh');
        }
        $email = sanitizer($this->input->post('email'));
        $name = sanitizer($this->input->post('name'));
        $password = sha1(sanitizer($this->input->post('password')));
        $address = sanitizer($this->input->post('address'));
        $phone = sanitizer($this->input->post('phone'));

        if(empty($email) || empty($name) || empty($password) || empty($address) || empty($phone)){
            $this->session->set_flashdata('error_message', get_phrase('fill_in_all_the_fields'));
            redirect(site_url('home/login'), 'refresh');    
        }

		$this->user_model->add_user('sign_up');
		redirect(site_url('home/login'), 'refresh');
	}

    function logout() {
        $this->session->sess_destroy();
        redirect(site_url('home/login'), 'refresh');
    }

    function forgot_password($from = "") {
        if(!$this->crud_model->check_rechaptcha() && get_settings('recaptcha_status') == 1){
            $this->session->set_flashdata('error_message', get_phrase('recaptcha_validation_failed'));
            redirect(site_url('home/forgot_password'), 'refresh');
        }
        $email = $this->input->post('email');
        $query = $this->db->get_where('user' , array('email' => $email, 'is_verified' => 1));
        if ($query->num_rows() > 0)
        {
            $verification_code = str_replace('=', '', base64_encode($email.'_Uh6#@#6hU_'.rand(111111, 9999999)));
            $this->db->where('email', $email);
            $this->db->update('user', array('verification_code' => $verification_code, 'updated_date' => time()));
            // send new password to user email
            $this->email_model->password_reset_email($verification_code, $email);
            $this->session->set_flashdata('flash_message', get_phrase('check_your_inbox_for_the_request'));
        }else{
            $this->session->set_flashdata('error_message', get_phrase('user_not_found'));
            redirect(site_url('home/forgot_password'), 'refresh');
        }
        redirect(site_url('home/login'), 'refresh');
    }

    function change_password($verification_code = ""){
        
        if($verification_code == ""){
            $this->session->set_flashdata('error_message', get_phrase('invalid_verification_code').'. '.get_phrase('please_send_a_new_forgot_password_request'));
            redirect(site_url('home/login'), 'refresh');
        }else{
            $decoded_verification_code = explode('_Uh6#@#6hU_', base64_decode($verification_code));
            $email = $decoded_verification_code[0];

            $current_time = time();
            $expired_time = $current_time-900;
            $this->db->where('email', $email);
            $this->db->where('verification_code', $verification_code);
            $row = $this->db->get('user');

            if($row->row('updated_date') < $expired_time || $row->num_rows() <= 0){
                $this->session->set_flashdata('error_message', get_phrase('this_link_is_expired'));
                    redirect(site_url('home/forgot_password'), 'refresh');
            }
        }


        if(isset($_POST['new_password']) && isset($_POST['confirm_password']) && !empty($_POST['confirm_password']) && $verification_code){
            if(!$this->crud_model->check_rechaptcha() && get_settings('recaptcha_status') == 1){
                $this->session->set_flashdata('error_message', get_phrase('recaptcha_validation_failed'));
                redirect(site_url('login/change_password/'.$verification_code), 'refresh');
            }
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');
            if($new_password == $confirm_password):
                $this->crud_model->change_password_from_forgot_passord($verification_code);
                $this->session->set_flashdata('flash_message', get_phrase('password_has_changed_successfully'));
                redirect(site_url('home/login'), 'refresh');
            else:
                $this->session->set_flashdata('error_message', get_phrase('the_confirmed_password_is_not_matching_with_the_new_password'));
                redirect(site_url('login/change_password/'.$verification_code), 'refresh');
            endif;
        }


        $page_data['verification_code'] = $verification_code;
        $page_data['page_name'] = 'change_password_from_forgot_password';
        $page_data['title'] = get_phrase('change_password');
        $this->load->view('frontend/index', $page_data);

    }

    // function for user verification
    public function verify_email_address($verification_code = "") {
        $user_details = $this->db->get_where('user', array('verification_code' => $verification_code));
        if($user_details->num_rows() == 0) {
            $this->session->set_flashdata('error_message', get_phrase('verification_failed'));
        }else {
            $user_details = $user_details->row_array();
            $updater = array(
                'is_verified' => 1
            );
            $this->db->where('id', $user_details['id']);
            $this->db->update('user', $updater);
            $this->session->set_flashdata('flash_message', get_phrase('congratulations').'!'.get_phrase('your_email_address_has_been_successfully_verified').'.');
        }
        redirect(site_url('home'), 'refresh');
    }
}
