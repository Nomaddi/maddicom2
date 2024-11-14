<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

if (! function_exists('get_settings')) {
  function get_settings($type = '') {
    $CI	=&	get_instance();
    $CI->load->database();

    $CI->db->where('type', $type);
    $result = $CI->db->get('settings')->row('description');
    return $result;
  }
}

if (! function_exists('get_frontend_settings')) {
  function get_frontend_settings($type = '') {
    $CI	=&	get_instance();
    $CI->load->database();

    $CI->db->where('type', $type);
    $result = $CI->db->get('frontend_settings')->row('description');
    return $result;
  }
}

if ( ! function_exists('slugify'))
{
  function slugify($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        //$text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
            return 'n-a';
        return $text;
    }
}

if ( ! function_exists('get_video_extension'))
{
    // Checks if a video is youtube, vimeo or any other
    function get_video_extension($url) {
        if (strpos($url, '.mp4') > 0) {
            return 'mp4';
        } elseif (strpos($url, '.webm') > 0) {
            return 'webm';
        } else {
            return 'unknown';
        }
    }
}

// Currency helpers
if (! function_exists('currency')) {
  function currency($price = "") {
    $CI	=&	get_instance();
    $CI->load->database();
		if ($price != "") {
			$CI->db->where('type', 'system_currency');
			$currency_code = $CI->db->get('settings')->row()->description;

			$CI->db->where('code', $currency_code);
			$symbol = $CI->db->get('currency')->row()->symbol;

			$CI->db->where('type', 'currency_position');
			$position = $CI->db->get('settings')->row()->description;

			if ($position == 'right') {
				return $price.$symbol;
			}elseif ($position == 'right-space') {
				return $price.' '.$symbol;
			}elseif ($position == 'left') {
				return $symbol.$price;
			}elseif ($position == 'left-space') {
				return $symbol.' '.$price;
			}
		}
  }
}
if (! function_exists('currency_code_and_symbol')) {
  function currency_code_and_symbol($type = "") {
    $CI	=&	get_instance();
    $CI->load->database();
		$CI->db->where('type', 'system_currency');
		$currency_code = $CI->db->get('settings')->row()->description;

		$CI->db->where('code', $currency_code);
		$symbol = $CI->db->get('currency')->row()->symbol;
		if ($type == "") {
			return $symbol;
		}else {
			return $currency_code;
		}

  }
}

// Sanitize input fields
if (! function_exists('sanitizer')) {
  function sanitizer($string = "") {
    //$sanitized_string = preg_replace("/[^@ -.a-zA-Z0-9]+/", "", html_escape($string));
    $sanitized_string = html_escape($string);
    return $sanitized_string;
  }
}

// ------------------------------------------------------------------------
/* End of file user_helper.php */
/* Location: ./system/helpers/common.php */

if (! function_exists('oc_time')) {
  function oc_time($data) {
    $time_interval = explode('-', $data);
    if ($time_interval[0] == 'closed' || $time_interval[1] == 'closed') {
      return get_phrase('closed');
    }else {
      $start_time = explode(':', $time_interval[0]);
      $end_time = explode(':', $time_interval[1]);
      if(count($start_time) > 1){
        $start_time = date('h:i a', strtotime("$start_time[0]:30:00"));
      }else{
        $start_time = date('h:i a', strtotime("$time_interval[0]:00:00"));
      }
      if(count($end_time) > 1){
        $end_time = date('h:i a', strtotime("$end_time[0]:30:00"));
      }else{
        $end_time = date('h:i a', strtotime("$time_interval[1]:00:00"));
      }
      return $start_time.' - '.$end_time;
    }
  }
}
