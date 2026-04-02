<?php

class Notification_model extends CI_Model
{

    public function get_notifications($from,$to)
    {

        $this->db->from(
            'az_account_notification_messages'
        );

        // if both dates given
        if(!empty($from) && !empty($to))
        {

            $this->db->where(
                "DATE(created_at) >=",
                $from
            );

            $this->db->where(
                "DATE(created_at) <=",
                $to
            );

        }

        // if only from date given
        elseif(!empty($from))
        {

            $this->db->where(
                "DATE(created_at)",
                $from
            );

        }

        // if no date → show all

        return $this->db->get()->result();

    }

}