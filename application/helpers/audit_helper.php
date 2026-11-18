<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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

if (!function_exists('log_activity')) {
    function log_activity($action, $module, $description) {
        $CI =& get_instance();
        
        // Obtener datos de la sesión del usuario actual (si está logueado)
        $user_id = $CI->session->userdata('user_id') ? $CI->session->userdata('user_id') : null;
        $user_name = $CI->session->userdata('name') ? $CI->session->userdata('name') : 'Anónimo';

        $data = array(
            'user_id'     => $user_id,
            'user_name'   => $user_name,
            'action'      => strtoupper($action),
            'module'      => strtolower($module),
            'description' => $description,
            'ip_address'  => $CI->input->ip_address(),
            'created_at'  => date('Y-m-d H:i:s')
        );

        $CI->db->insert('audit_logs', $data);
    }
}