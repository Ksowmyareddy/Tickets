<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_model extends CI_Model {

    public function insert_ticket($data)
    {
        return $this->db->insert('tickets', $data);
    }

    public function get_all_tickets($filters = array(), $limit = null, $offset = null)
    {
        $search = isset($filters['search']) ? trim($filters['search']) : '';
        $status_filter = isset($filters['status_filter']) ? trim($filters['status_filter']) : '';
        $priority_filter = isset($filters['priority_filter']) ? trim($filters['priority_filter']) : '';
        $classification_filter = isset($filters['classification_filter']) ? trim($filters['classification_filter']) : '';

        if ($search !== '') {
            $this->db->group_start();
            $this->db->like('contact_name', $search);
            $this->db->or_like('account_name', $search);
            $this->db->or_like('description', $search);

            if (preg_match('/^AZ\d+$/i', $search)) {
                $id = (int) preg_replace('/[^0-9]/', '', $search);
                $this->db->or_where('id', $id);
            } elseif (is_numeric($search)) {
                $this->db->or_where('id', (int) $search);
            }
            $this->db->group_end();
        }

        if ($status_filter !== '') {
            $this->db->where('status', $status_filter);
        }

        if ($priority_filter !== '') {
            $this->db->where('priority', $priority_filter);
        }

        if ($classification_filter !== '') {
            $this->db->where('classification', $classification_filter);
        }

        $this->db->order_by('id', 'DESC');

        if ($limit !== null) {
            $this->db->limit((int)$limit, (int)$offset);
        }

        return $this->db->get('tickets')->result();
    }

    public function get_ticket_count($filters = array())
    {
        $search = isset($filters['search']) ? trim($filters['search']) : '';
        $status_filter = isset($filters['status_filter']) ? trim($filters['status_filter']) : '';
        $priority_filter = isset($filters['priority_filter']) ? trim($filters['priority_filter']) : '';
        $classification_filter = isset($filters['classification_filter']) ? trim($filters['classification_filter']) : '';

        if ($search !== '') {
            $this->db->group_start();
            $this->db->like('contact_name', $search);
            $this->db->or_like('account_name', $search);
            $this->db->or_like('description', $search);

            if (preg_match('/^AZ\d+$/i', $search)) {
                $id = (int) preg_replace('/[^0-9]/', '', $search);
                $this->db->or_where('id', $id);
            } elseif (is_numeric($search)) {
                $this->db->or_where('id', (int) $search);
            }
            $this->db->group_end();
        }

        if ($status_filter !== '') {
            $this->db->where('status', $status_filter);
        }

        if ($priority_filter !== '') {
            $this->db->where('priority', $priority_filter);
        }

        if ($classification_filter !== '') {
            $this->db->where('classification', $classification_filter);
        }

        return $this->db->count_all_results('tickets');
    }

    public function get_ticket_by_id($id)
    {
        return $this->db->get_where('tickets', array('id' => $id))->row();
    }

    public function update_ticket($id, $data)
    {
        return $this->db->where('id', $id)->update('tickets', $data);
    }

    public function delete_ticket($id)
    {
        return $this->db->delete('tickets', array('id' => $id));
    }
}