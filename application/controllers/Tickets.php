<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** @property Ticket_model $Ticket_model
 *  @property CI_Session $session
 *  @property CI_Upload $upload
 *  @property CI_Input $input
 *  @property CI_Config $config
 */

class Tickets extends CI_Controller {

    private $gemini_api_key = '';
    private $gemini_model   = 'gemini-2.5-flash-lite';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Ticket_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('session', 'upload'));

        $this->config->load('gemini', TRUE);
        $this->gemini_api_key = (string) $this->config->item('api_key', 'gemini');
        $this->gemini_model   = (string) $this->config->item('model', 'gemini');

        if ($this->gemini_model === '') {
            $this->gemini_model = 'gemini-2.5-flash-lite';
        }
    }

    public function index()
    {
        $search         = trim($this->input->get('search', TRUE));
        $status_filter  = trim($this->input->get('status_filter', TRUE));
        $priority_filter = trim($this->input->get('priority_filter', TRUE));
        $classification_filter = trim($this->input->get('classification_filter', TRUE));
        $page           = (int) $this->input->get('page');

        if ($page < 1) {
            $page = 1;
        }

        $per_page = 10;
        $offset   = ($page - 1) * $per_page;

        $filters = array(
            'search'                => $search,
            'status_filter'         => $status_filter,
            'priority_filter'       => $priority_filter,
            'classification_filter' => $classification_filter
        );

        $ticket_count = $this->Ticket_model->get_ticket_count($filters);

        if ($ticket_count <= 10) {
            $page = 1;
            $offset = 0;
        }

        $tickets = $this->Ticket_model->get_all_tickets($filters, $per_page, $offset);

        $data['search'] = $search;
        $data['status_filter'] = $status_filter;
        $data['priority_filter'] = $priority_filter;
        $data['classification_filter'] = $classification_filter;

        $data['tickets'] = $tickets;
        $data['ticket_count'] = $ticket_count;

        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        $data['show_pagination'] = ($ticket_count > 10);
        $data['has_previous'] = ($page > 1);
        $data['has_next'] = (($offset + $per_page) < $ticket_count);

        $this->load->view('tickets_list', $data);
    }

    public function create()
    {
        $this->load->view('ticket_create');
    }

    private function upload_multiple_ticket_attachments($field_name = 'attachment')
    {
        $uploaded_files = array();

        if (!isset($_FILES[$field_name])) {
            return array(
                'status' => true,
                'file_names' => array()
            );
        }

        $files = $_FILES[$field_name];

        if (!is_array($files['name'])) {
            if (empty($files['name'])) {
                return array(
                    'status' => true,
                    'file_names' => array()
                );
            }

            $files = array(
                'name'     => array($files['name']),
                'type'     => array($files['type']),
                'tmp_name' => array($files['tmp_name']),
                'error'    => array($files['error']),
                'size'     => array($files['size'])
            );
        }

        if (empty(array_filter($files['name']))) {
            return array(
                'status' => true,
                'file_names' => array()
            );
        }

        $upload_path = FCPATH . 'uploads/tickets/';

        if (!is_dir($upload_path)) {
            if (!mkdir($upload_path, 0777, true)) {
                return array(
                    'status' => false,
                    'error'  => 'Unable to create upload folder: ' . $upload_path
                );
            }
        }

        if (!is_writable($upload_path)) {
            return array(
                'status' => false,
                'error'  => 'Upload folder is not writable: ' . $upload_path
            );
        }

        $file_count = count($files['name']);

        $config = array(
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif|webp|pdf|doc|docx|xls|xlsx',
            'max_size'      => 40960,
            'encrypt_name'  => TRUE,
            'remove_spaces' => TRUE
        );

        for ($i = 0; $i < $file_count; $i++) {
            if (empty($files['name'][$i])) {
                continue;
            }

            $_FILES['single_attachment']['name']     = $files['name'][$i];
            $_FILES['single_attachment']['type']     = $files['type'][$i];
            $_FILES['single_attachment']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['single_attachment']['error']    = $files['error'][$i];
            $_FILES['single_attachment']['size']     = $files['size'][$i];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('single_attachment')) {
                $upload_data = $this->upload->data();
                $uploaded_files[] = $upload_data['file_name'];
            } else {
                return array(
                    'status' => false,
                    'error'  => strip_tags($this->upload->display_errors())
                );
            }
        }

        return array(
            'status' => true,
            'file_names' => $uploaded_files
        );
    }

    private function get_attachment_array($attachment_value = '')
    {
        if (empty($attachment_value)) {
            return array();
        }

        $decoded = json_decode($attachment_value, true);

        if (is_array($decoded)) {
            return $decoded;
        }

        return array_filter(array_map('trim', explode(',', $attachment_value)));
    }

    public function store()
    {
        $upload_result = $this->upload_multiple_ticket_attachments('attachment');

        if (!$upload_result['status']) {
            $this->session->set_flashdata('error', $upload_result['error']);
            redirect('tickets');
            return;
        }

        $data = array(
            'contact_name'   => trim($this->input->post('contact_name', TRUE)),
            'account_name'   => trim($this->input->post('account_name', TRUE)),
            'description'    => trim($this->input->post('description')),
            'status'         => trim($this->input->post('status', TRUE)),
            'assign_to'      => trim($this->input->post('assign_to', TRUE)),
            'qa_by'          => trim($this->input->post('qa_by', TRUE)),
            'timeline'       => $this->input->post('timeline', TRUE) ? $this->input->post('timeline', TRUE) : NULL,
            'priority'       => trim($this->input->post('priority', TRUE)),
            'classification' => trim($this->input->post('classification', TRUE)),
            'attachment'     => json_encode($upload_result['file_names']),
            'created_at'     => date('Y-m-d H:i:s')
        );

        $this->Ticket_model->insert_ticket($data);
        $this->session->set_flashdata('success', 'Ticket created successfully.');
        redirect('tickets');
    }

    public function update_ticket()
    {
        $id = (int) $this->input->post('id');

        if (!$id) {
            redirect('tickets');
            return;
        }

        $old_ticket = $this->Ticket_model->get_ticket_by_id($id);

        if (!$old_ticket) {
            $this->session->set_flashdata('error', 'Ticket not found.');
            redirect('tickets');
            return;
        }

        $old_files = $this->get_attachment_array($old_ticket->attachment);

        $kept_existing_files = $this->input->post('existing_attachments');
        if (!is_array($kept_existing_files)) {
            $kept_existing_files = array();
        }
        $kept_existing_files = array_values(array_filter($kept_existing_files));

        $removed_files = array_diff($old_files, $kept_existing_files);
        foreach ($removed_files as $removed_file) {
            $file_path = FCPATH . 'uploads/tickets/' . $removed_file;
            if (!empty($removed_file) && file_exists($file_path)) {
                @unlink($file_path);
            }
        }

        $new_uploaded_files = array();

        if (isset($_FILES['attachment'])) {
            $has_new_files = false;

            if (is_array($_FILES['attachment']['name'])) {
                $has_new_files = !empty(array_filter($_FILES['attachment']['name']));
            } else {
                $has_new_files = !empty($_FILES['attachment']['name']);
            }

            if ($has_new_files) {
                $upload_result = $this->upload_multiple_ticket_attachments('attachment');

                if (!$upload_result['status']) {
                    $this->session->set_flashdata('error', $upload_result['error']);
                    redirect('tickets');
                    return;
                }

                $new_uploaded_files = $upload_result['file_names'];
            }
        }

        $final_attachments = array_values(array_unique(array_merge($kept_existing_files, $new_uploaded_files)));

        $data = array(
            'contact_name'   => trim($this->input->post('contact_name', TRUE)),
            'account_name'   => trim($this->input->post('account_name', TRUE)),
            'description'    => trim($this->input->post('description')),
            'status'         => trim($this->input->post('status', TRUE)),
            'assign_to'      => trim($this->input->post('assign_to', TRUE)),
            'qa_by'          => trim($this->input->post('qa_by', TRUE)),
            'timeline'       => $this->input->post('timeline', TRUE) ? $this->input->post('timeline', TRUE) : NULL,
            'priority'       => trim($this->input->post('priority', TRUE)),
            'classification' => trim($this->input->post('classification', TRUE)),
            'attachment'     => json_encode($final_attachments)
        );

        $this->Ticket_model->update_ticket($id, $data);
        $this->session->set_flashdata('success', 'Ticket updated successfully.');
        redirect('tickets');
    }

    public function update_inline()
    {
        $id       = (int) $this->input->post('id');
        $status   = trim($this->input->post('status', TRUE));
        $timeline = $this->input->post('timeline', TRUE);

        header('Content-Type: application/json');

        if (!$id) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Invalid ticket ID'
            ));
            return;
        }

        $data = array(
            'status'   => $status,
            'timeline' => !empty($timeline) ? $timeline : NULL
        );

        $updated = $this->Ticket_model->update_ticket($id, $data);

        if ($updated) {
            echo json_encode(array(
                'status'  => true,
                'message' => 'Ticket updated successfully'
            ));
        } else {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Failed to update ticket'
            ));
        }
    }

    public function delete_ticket($id = 0)
    {
        $id = (int) $id;

        if ($id) {
            $ticket = $this->Ticket_model->get_ticket_by_id($id);

            if ($ticket) {
                $files = $this->get_attachment_array($ticket->attachment);

                foreach ($files as $file) {
                    $file_path = FCPATH . 'uploads/tickets/' . $file;
                    if (!empty($file) && file_exists($file_path)) {
                        @unlink($file_path);
                    }
                }

                $this->Ticket_model->delete_ticket($id);
                $this->session->set_flashdata('success', 'Ticket deleted successfully.');
            }
        }

        redirect('tickets');
    }

    public function export()
    {
        $filters = array(
            'search'                => trim($this->input->get('search', TRUE)),
            'status_filter'         => trim($this->input->get('status_filter', TRUE)),
            'priority_filter'       => trim($this->input->get('priority_filter', TRUE)),
            'classification_filter' => trim($this->input->get('classification_filter', TRUE))
        );

        $tickets = $this->Ticket_model->get_all_tickets($filters);

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=tickets.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "Ticket ID\tContact Name\tAccount Name\tDescription\tStatus\tTimeline\tPriority\tClassification\tAssign To\tQA By\tAttachments\tCreated At\n";

        foreach ($tickets as $ticket) {
            $timeline = '-';
            if (!empty($ticket->timeline) && $ticket->timeline != '0000-00-00 00:00:00') {
               $timeline = date('d-M-Y', strtotime($ticket->timeline));
            }

            $created_at = '-';
            if (!empty($ticket->created_at) && $ticket->created_at != '0000-00-00 00:00:00') {
                $created_at = date('d-M-Y h:i A', strtotime($ticket->created_at));
            }

            $ticket_code = 'AZ' . str_pad($ticket->id, 7, '0', STR_PAD_LEFT);
            $description = preg_replace("/[\r\n\t]+/", " ", (string) $ticket->description);

            $attachments = $this->get_attachment_array($ticket->attachment);
            $attachment_text = implode(', ', $attachments);

            echo $ticket_code . "\t" .
                 $ticket->contact_name . "\t" .
                 $ticket->account_name . "\t" .
                 $description . "\t" .
                 $ticket->status . "\t" .
                 $timeline . "\t" .
                 $ticket->priority . "\t" .
                 $ticket->classification . "\t" .
                 $ticket->assign_to . "\t" .
                 $ticket->qa_by . "\t" .
                 $attachment_text . "\t" .
                 $created_at . "\n";
        }
    }

    public function improve_description()
    {
        header('Content-Type: application/json');

        $text = trim($this->input->post('description'));

        if ($text === '') {
            echo json_encode(array(
                'status' => false,
                'message' => 'Description is empty.'
            ));
            return;
        }

        if ($this->gemini_api_key === '') {
            echo json_encode(array(
                'status' => false,
                'message' => 'Gemini API key not configured.'
            ));
            return;
        }

        $prompt = 'Convert this into one short professional IT support ticket sentence in clear English. 
        Fix spelling and grammar. 
        If Telugu is typed in English letters, convert it to proper English. 
        Keep only the main issue. 
        Return only the final sentence: ' . $text;

        $payload = array(
            "contents" => array(
                array(
                    "parts" => array(
                        array("text" => $prompt)
                    )
                )
            ),
            "generationConfig" => array(
                "temperature" => 0.1,
                "maxOutputTokens" => 40,
                "topP" => 0.8,
                "topK" => 20
            )
        );

        $url = "https://generativelanguage.googleapis.com/v1beta/models/" . rawurlencode($this->gemini_model) . ":generateContent";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'x-goog-api-key: ' . $this->gemini_api_key
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_error) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Curl error: ' . $curl_error
            ));
            return;
        }

        $result = json_decode($response, true);

        if ($http_code != 200) {
            $error_message = 'Gemini API request failed.';
            if (!empty($result['error']['message'])) {
                $error_message = $result['error']['message'];
            }

            echo json_encode(array(
                'status' => false,
                'message' => $error_message
            ));
            return;
        }

        $improved = '';
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $improved = trim($result['candidates'][0]['content']['parts'][0]['text']);
        }

        $improved = trim($improved, " \t\n\r\0\x0B\"'");

        if ($improved === '') {
            echo json_encode(array(
                'status' => false,
                'message' => 'No improved text returned from Gemini.'
            ));
            return;
        }

        echo json_encode(array(
            'status' => true,
            'description' => $improved
        ));
    }
}