<?php

/**
 * @author 
 * @copyright 2016
 */

require_once "config_class.php";
require_once "checkvalid_class.php";

class DataBase {
    private $config;
    private $mysqli;
    private $valid;
    
    public  function __construct() {
        $this->config = new Config();
        $this->valid = new CheckValid();
        $this->mysqli = new mysqli($this->config->host, $this->config->user, $this->config->password, $this->config->db );
        $this->mysqli->query("SET NAMES 'utf8'");
    }
    
    private function query($query) {
        return $this->mysqli->query($query);
    }

    /**
     * @param $table_name
     * @param $fields
     * @param string $where
     * @param string $order
     * @param bool $up
     * @param string $limit
     * @return bool
     */
    private function select($table_name, $fields, $where = "", $order = "", $up = true, $limit = "") {
        for ($i = 0; $i < count($fields); $i++) {
            if ((strpos($fields[$i], "(") === false) && ($fields[$i] != "*")) $fields[$i] = "`".$fields[$i]."`";
        }
        $fields = implode(",", $fields);
        $table_name = $this->config->db_prefix.$table_name;
        if (!$order) $order =  "ORDER BY 'id'";
        else {
            if ($order != "RAND() ") {
                $order = "ORDER BY $order";
                if (!$up) $order .= " DESC";
            }
            else $order = "ORDER BY '$order'";
        }
        if ($limit) $limit = "LIMIT $limit";
        if ($where) $query = "SELECT $fields FROM $table_name WHERE $where $order $limit";
        else $query = "SELECT $fields FROM $table_name $order $limit";        
        $result_set = $this->query($query);
        if (!$result_set) return false;
        $i = 0;
        while ($row = $result_set->fetch_assoc()) {
            $data[$i] = $row;
            $i++;            
        }
        $result_set->close();
        return $data;
    }
    
    public function insert ($table_name, $new_values) {
        $table_name = $this->config->db_prefix.$table_name;
        $query = "INSERT INTO $table_name (";
        foreach ($new_values as $field => $value) $query .= "`".$field."`,";
        $query = substr($query, 0, -1);
        $query .= ") VALUES (";
        foreach ($new_values as $value) $query .= "'".addslashes($value)."',";
        $query = substr($query, 0 , -1);
        $query .= ")";
        
        return $this->query($query);
    }
    
    private function update($table_name, $upd_fields, $where) {
        $table_name = $this->config->db_prefix.$table_name;
        $query = "UPDATE $table_name SET ";
        foreach ($upd_fields as $field => $value) $query .= "`$field` = '".addslashes($value)."',";
        $query = substr($query, 0, -1);        
        if ($where) {
            $query .= " WHERE $where";
            return $this->query($query);
        }
        else return false;
    }
    
    public function delete($table_name, $where = "") {
        $table_name = $this->config->db_prefix.$table_name;
        if ($where) {
            $query = "DELETE FROM $table_name WHERE $where";
            return $this->query($query);
        }
        else return false;
    }
    
    public function deleteAll($table_name) {
        $table_name = $this->config->db_prefix.$table_name;
        $query = "TRUNCATE TABLE `$table_name`";
        return $this->query($query);
    }
    
    public function getField($table_name, $field_out, $field_in, $value_in) {        
        $data = $this->select($table_name, array($field_out), "`$field_in` = '".addslashes($value_in)."'");
        if (count($data) != 1) return false;        
        return $data[0][$field_out];
    }
    
    public function getFieldOnID($table_name, $id, $field_out) {
        if(!$this->existsID($table_name, $id)) return false;
        return $this->getField($table_name, $field_out, "id", $id);
    }
    
    public function deleteOnID($table_name, $id)  {
        if(!$this->existsID($table_name, $id)) return false;
        return $this->delete($table_name, "`id` = '$id'");
    }
    
    public function setField($table_name, $field, $value, $field_in, $value_in) {        
        return $this->update($table_name, array($field => $value), "`$field_in` = '".addslashes($value_in)."'");
    }
    
    public function setFieldOnID ($table_name, $id, $field, $value) {
        if(!$this->existsID($table_name, $id)) return false;
        return $this->setField($table_name, $field, $value, "id", $id);
    }

    public function updateOnID ($table_name, $id, $upd_fields) {        
        return $this->update($table_name, $upd_fields, "`id` = '".addslashes($id)."'");
    }
    
    public function getElementOnID($table_name, $id) {
        if(!$this->existsID($table_name, $id)) return false;
        $arr = $this->select($table_name, array("*"), "`id` = '$id'");
        return $arr[0];
    }
    
    public function getRandomElements($table_name, $count) {
        return $this->select($table_name, array("*"), "", "RAND()", true, $count);
    }


    //get Объекты

    public function getAll($table_name, $order, $up){
        return $this->select($table_name, array("*"), "", $order, $up);
    }

    public function getAllOnField($table_name, $field, $value, $order, $up) {
        return $this->select($table_name, array("*"), "`$field` = '".addslashes($value)."'", $order, $up);
    }

    public function getAllNoField($table_name, $field, $value, $order, $up){
        return $this->select($table_name, array("*"), "`$field` != '".addslashes($value)."'", $order, $up);
    }

    public function getAllOnFieldAndNoField($table_name, $field_on, $value_on, $field_off, $value_off, $order, $up){
        return $this->select($table_name, array("*"), "`$field_on` = '".addslashes($value_on)."' AND `$field_off` != '".addslashes($value_off)."'", $order, $up);
    }

    public function getAllOnFieldAndField($table_name, $field_on, $value_on, $field_off, $value_off, $order, $up){
        return $this->select($table_name, array("*"), "`$field_on` = '".addslashes($value_on)."' AND `$field_off` = '".addslashes($value_off)."'", $order, $up);
    }

    public function getAllOnFieldAndFieldAndField($table_name, $field_on, $value_on, $field_off, $value_off, $field, $value, $order, $up){
        return $this->select($table_name, array("*"), "`$field_on` = '".addslashes($value_on)."' AND `$field_off` = '".addslashes($value_off)."' AND `$field` = '".addslashes($value)."'", $order, $up);
    }

    public function getAllOnFields($table_name, $fields_values, $un_fields_values, $order, $up) {
        $where = "";
        $count = 0;
        foreach ($fields_values as $key => $value) {
            if ($count > 0) $where .= " AND";
            $where .= "`$key` = '".addslashes($value)."'";
            $count++;
        }
        if (isset($un_fields_values)) {
            foreach ($un_fields_values as $key => $value) {
                if ($count > 0) $where .= " AND";
                $where .= "`$key` != '".addslashes($value)."'";
                $count++;
            } 
        }
        return $this->select($table_name, array("*"), $where, $order, $up);
    }

    // конец get Объект

    //get количество

    public function getCountOnField ($table_name, $field, $value) {
        $data = $this->select($table_name, array("COUNT(`$field`)"), "`$field` = '".addslashes($value)."'");
        return $data[0]["COUNT(`$field`)"];
    }

    public function getCount($table_name){
        $data = $this->select($table_name, array("COUNT(`id`)"));
        return $data[0]["COUNT(`id`)"];
    }

    public function getCountOnFieldAndOnField ($table_name, $field_on, $value_on, $field_off, $value_off) {
        $data = $this->select($table_name, array("COUNT(*)"), "`$field_on` = '".addslashes($value_on)."' AND `$field_off` = '".addslashes($value_off)."'");
        return $data[0]["COUNT(*)"];
    }

    public function getCountOnFields ($table_name, $fields_values, $un_fields_values) {
        $where = "";
        $count = 0;
        foreach ($fields_values as $key => $value) {
            if ($count > 0) $where .= " AND";
            $where .= "`$key` = '".addslashes($value)."'";
            $count++;
        }
        if (isset($un_fields_values)) {
            foreach ($un_fields_values as $key => $value) {
                if ($count > 0) $where .= " AND";
                $where .= "`$key` != '".addslashes($value)."'";
                $count++;
            }
        }
        $data = $this->select($table_name, array("COUNT(*)"), $where);
        return $data[0]["COUNT(*)"];
    }

    public function getCountNoField($table_name, $field, $value){
        $data = $this->select($table_name, array("COUNT(*)"), "`$field` != '".addslashes($value)."'");
        return $data[0]["COUNT(*)"];
    }

    public function getCountOnFieldAndNoField($table_name, $field_on, $value_on, $field_off, $value_off){
        $data = $this->select($table_name, array("COUNT(*)"), "`$field_on` = '".addslashes($value_on)."' AND `$field_off` != '".addslashes($value_off)."'");
        return $data[0]["COUNT(*)"];
    }

    //конец get количество


    public function getLastOnField($table_name, $field) {
    $data = $this->select($table_name, array("`$field`"), "", "id", false , 1);
    return $data[0]["$field"];
    }
    
    public function getAllOnArrayId($table_name, $arrayids) {
        $where = "`id` IN (";
        for ($i = 0; $i < count($arrayids); $i++) {
            $where .= "'".addslashes($arrayids[$i])."',";
        }
        $where = substr($where, 0 , -1);
        $where .= ")";
        return $this->select($table_name, array("*"), $where);
    }

    public function getLastID ($table_name){
        $data = $this->select($table_name, array("MAX(`id`)"));
        return $data[0]["MAX(`id`)"];
    }
    
    public function isExists($table_name, $field, $value) {
        $data = $this->select($table_name, array("id"), "`$field` = '".addslashes($value)."'");
        if (count($data) === 0) return false;
        return true;
    }
    
    private function existsID($table_name, $id) {
        if(!$this->valid->validID($id)) return false;
        $data = $this->select($table_name, array("id"), "`id` = '".addslashes($id)."'");
        if (count($data) === 0) return false;
        return true;
    }
    
    public function __destruct() {
        if ($this->mysqli) $this->mysqli->close();
    }

    public function searchObj($table_name, $fieldsandvalues, $order, $up) {
        $where = "";
        $con = 0;
        foreach ($fieldsandvalues as $key => $values) {
            if (!isset($values[1]) || $values[1] == "") continue;
            if ($con != 0) $where .= " AND";
            $logic = $values[0];
            switch ($logic) {
                case "LIKE":
                    for ($i = 1; $i < count($values); $i++) {
                        $words = mb_strtolower($values[$i]);
                        $words = trim($words);
                        $words = quotemeta($words);
                        $arraywords = explode(" " ,$words);
                        foreach ($arraywords as $keys => $value) {
                            if (isset($arraywords[$keys - 1])) $where .= " AND";
                            $where .= "`".$key."` LIKE '%".addslashes($value)."%'";
                        }
                        if (($i + 1) != count($values)) $where .= " OR";
                    }
                break;
                case ">": for ($i = 1; $i < count($values); $i++) {
                    $dop_logic = ($i == 1) ? ">=" : "<=";
                    $where .= "`" . $key . "` " . $dop_logic . " '" . addslashes($values[$i]) . "'";
                    if (($i + 1) != count($values)) $where .= " AND";
                }
                break;
                case "OR": $where .= "`".$key."` IN (";
                    for ($i = 1; $i < count($values); $i++) {
                        $where .= "'".addslashes($values[$i])."',";
                    }
                    $where = substr($where, 0 , -1);
                $where .= ")";
                    break;
                case "=":
                    for ($i = 1; $i < count($values); $i++) {
                        $where .= "`".$key."` = '".addslashes($values[$i])."'";
                    }
                break;
                default: break;
            }            
            $con ++;
        }
        $result = $this->select($table_name, array("*"), $where, $order, $up);
        return $result;
}
    
}

?>