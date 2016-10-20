<?php
require_once "config_class.php";
require_once "checkvalid_class.php";
require_once "database_class.php";

abstract class GlobalClass {
    
    private $db;
    private $table_name;
    protected $config;
    protected $valid;
    
            
    protected function __construct($table_name, $db) {
        $this->db = $db;
        $this->table_name = $table_name;
        $this->config = new Config();
        $this->valid = new CheckValid();
    }
    
    protected function add($new_values) {        
        return $this->db->insert($this->table_name, $new_values);
    }
    
    protected function edit($id, $upd_fields) {
        return $this->db->updateOnID($this->table_name, $id, $upd_fields);
    }
    
    public function delete($id) {
        return $this->db->deleteOnID($this->table_name, $id);
    }
    
    public function deleteOnField($field, $value){
        return $this->db->deleteOnFiled($this->table_name, $field, $value);
    }
    
    public function deleteAll(){
        return $this->db->deleteAll($this->table_name);
    }
    
    protected function getField($field_out, $field_in, $value_in) {
        return $this->db->getField($this->table_name, $field_out, $field_in, $value_in);
    }
    
     protected function getFieldToID($id, $field) {
          return $this->db->getFieldOnID($this->table_name, $id, $field);
     }
    
     protected function setFieldOnID($id, $field, $value) {
         return $this->db->setFieldOnID($this->table_name, $id, $field, $value);
     }
    
    public function getAllOnIds($arrayids) {
        return $this->db->getAllOnArrayId($this->table_name, $arrayids);
    }
    
    public function get($id) {
        return $this->db->getElementOnID($this->table_name, $id);
    }

    // OBJ

    public function getAllOnFields($fields_values, $un_fields_values = array(), $order, $up) {
        return $this->db->getAllOnFields($this->table_name, $fields_values, $un_fields_values, $order, $up);
    }

    public function getAll($order = "", $up = true) {
        return $this->db->getAll($this->table_name, $order, $up);
    }

    public function getAllOnField($field, $value, $order = "", $up = true) {
         return $this->db->getAllOnField($this->table_name, $field, $value, $order, $up);
     }
    
    public function getAllOnNoField($field, $value, $order = "", $up = true){
        return $this->db->getAllNoField($this->table_name, $field, $value, $order, $up);
    }
    public function getAllOnFieldAndField($field_on, $value_on, $field_off, $value_off, $order="", $up = true) {
        return $this->db->getAllOnFieldAndField($this->table_name, $field_on, $value_on, $field_off, $value_off, $order, $up);
    }

    public function getAllOnFieldAndFieldAndField($field_on, $value_on, $field_off, $value_off, $field, $value, $order="", $up = true) {
        return $this->db->getAllOnFieldAndFieldAndField($this->table_name, $field_on, $value_on, $field_off, $value_off, $field, $value, $order, $up);
    }

    public function getAllOnFieldAndNotField($field_on, $value_on, $field_off, $value_off, $order="", $up = true) {
        return $this->db->getAllOnFieldAndNoField($this->table_name, $field_on, $value_on, $field_off, $value_off, $order, $up);
    }

    //COUNT

    public function getCountOnNoField($field, $value){
        return $this->db->getCountNoField($this->table_name, $field, $value);
    }
    
    public function getCountOnFieldAndNotField($field_on, $value_on, $field_off, $value_off) {
        return $this->db->getCountOnFieldAndNoField($this->table_name, $field_on, $value_on, $field_off, $value_off);
    }

    public function getCountOnField($field, $value){
        return $this->db->getCountOnField($this->table_name, $field, $value);
    }

    public function getCountOnFieldAndOnField($field_on, $value_on, $field_off, $value_off){
        return $this->db->getCountOnFieldAndOnField($this->table_name, $field_on, $value_on, $field_off, $value_off);
    }

    public function getCountOnFields($fields_values, $un_fields_values = array()) {
        return $this->db->getCountOnFields($this->table_name, $fields_values, $un_fields_values);
    }

    public function getCountOnFieldAndOnFieldAndField($field_on, $value_on, $field_off, $value_off, $field, $value){
        return $this->db->getCountOnFieldAndOnFieldAndField($this->table_name, $field_on, $value_on, $field_off, $value_off, $field, $value);
    }

    public function getCount() {
        return $this->db->getCount($this->table_name);
    }
    
    
    public function getRandomElement ($count) {
        return $this->db->getRandomElements($this->table_name, $count);
    }

    public function getLastIDIn(){
        return $this->db->getLastID($this->table_name);
    }
    
    public function search($fieldsandvalues, $order = "date", $up = false) {
        return $this->db->searchObj($this->table_name, $fieldsandvalues, $order, $up);
    }
    
    
     protected function isExists($field, $value){
         return $this->db->isExists($this->table_name, $field, $value);
     }
    
}


?>