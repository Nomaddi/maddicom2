<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_model extends CI_Model {
    
    public function get_logs($limit = 50, $offset = 0, $filters = array()) {
        if (!empty($filters['module'])) {
            $this->db->where('module', $filters['module']);
        }
        if (!empty($filters['action'])) {
            $this->db->where('action', $filters['action']);
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('DATE(created_at) >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('DATE(created_at) <=', $filters['date_to']);
        }

        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get('audit_logs')->result();
    }

    public function count_logs($filters = array()) {
        if (!empty($filters['module'])) {
            $this->db->where('module', $filters['module']);
        }
        if (!empty($filters['action'])) {
            $this->db->where('action', $filters['action']);
        }
        return $this->db->count_all_results('audit_logs');
    }
}