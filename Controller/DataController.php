<?php

require_once("AbstractController.php");
require_once(__DIR__ . '/../app/db.php');

class DataController extends AbstractController {

    public function __construct() {
        parent::__construct();
    }

    public function get_latest_data_by_field_name($user_id, $organisation_id, $field_name, $lastX = 1) {
        $query_result = $this->db_ops->get_data_by_field_name($user_id, $organisation_id, $field_name);
        if($query_result->num_rows == 0) {
            return false;
        }
        $query_result = $this->format_query_result($query_result);

        $data = [];
        for($i = 0; $i < sizeof($query_result) && $i < $lastX; $i++) {
            $date = $query_result[$i]['date'];
            unset($query_result[$i]['date']);
            $data[$date] = $query_result[$i];
        }

        $self_link = $this->get_self_link('data', $organisation_id, $field_name);

        return $this->format_json($self_link, $data);
    }

    public function get_latest_data_by_field_id($user_id, $organisation_id, $field_id, $lastX = 1) {
        $query_result = $this->db_ops->get_data_by_field_id($user_id, $organisation_id, $field_id);
        if($query_result->num_rows == 0) {
            return false;
        }
        $query_result = $this->format_query_result($query_result);

        $data = [];
        for($i = 0; $i < sizeof($query_result) && $i < $lastX; $i++) {
            $date = $query_result[$i]['date'];
            unset($query_result[$i]['date']);
            $data[$date] = $query_result[$i];
        }

        $self_link = $this->get_self_link('data', $organisation_id, $field_id);

        return $this->format_json($self_link, $data);
    }

    public function insert_multiple_values_for_date($user_id, $field_values, $date) {
        foreach ($field_values as $field_id => $field_value) {
            $this->db_ops->insert_value_for_date($user_id, $field_id, $field_value, $date);
        }
    }

    public function insert_multiple_values_for_date_by_field_name($user_id, $organisation_id, $field_values, $date) {
        foreach ($field_values as $field_name => $field_value) {
            $this->db_ops->insert_value_for_date_by_field_name($user_id, $organisation_id, $field_name, $field_value, $date);
        }
    }

    protected function format_json($self_link, $query_result, $next_entity_type = '', $next_entities = []) {
        $json_array = $query_result;
        $json_array['links']['self'] = $self_link;
        return $json_array;
    }
}

?>
