<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

if (!function_exists('get_current_season')) {
    function get_current_season() {
        $month = (int)date('n');
        $day = (int)date('j');

        // Halloween: Del 20 al 31 de Octubre
        if ($month == 10 && $day >= 20 && $day <= 31) {
            return 'halloween';
        }

        // Navidad: Del 15 de Noviembre al 6 de Enero
        if (($month == 11 && $day >= 15) || ($month == 1 && $day <= 6)) {
            return 'christmas';
        }

        return 'normal';
    }
}

// ------------------------------------------------------------------------
/* End of file package_helper.php */
/* Location: ./system/helpers/package_helper.php */