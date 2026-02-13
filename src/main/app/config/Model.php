<?php
namespace App\Config;

abstract class Model{
    protected $db;//database connection
    protected $table;
    protected $primaryKey = "id";
    protected $email;


    public function __construct(){
        $database = new Database();
        $this->db = $database->getConnexion();
    }
    public function find($id){
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function findByEmail($email){
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    public function all($columns = ['*']){
        $columns = implode(',', $columns);
        $sql = "SELECT {$columns} FROM {$this->table}";
        return $this->db->query($sql)->fetchAll();
    }
    public function  create(array $data){
        $columns = implode(',',array_keys($data));
        $placeholders = implode(',',array_fill(0,count($data),'?'));
        $sql = "INSERT INTO {$this->table}($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));

        return $this->db->lastInsertId();
    }

    public function update($id, array $data){
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = ?";
        }
        $set = implode(',',$set);
        $sql = "UPDATE {$this->table} SET $set WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        $values = array_values($data);
        $values[] = $id;

        return $stmt->execute($values);
    }

    public function delete($id){
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}

















?>