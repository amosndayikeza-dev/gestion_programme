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
    public function create(array $data)
{
    $columns = implode(',', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
    
    $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
    $stmt = $this->db->prepare($sql);
    
    foreach ($data as $key => $value) {
        $stmt->bindValue(":{$key}", $value);
    }
    
    $stmt->execute();
    return $this->db->lastInsertId();
}

   public function update($id, array $data)
{
    $sets = [];
    foreach (array_keys($data) as $key) {
        $sets[] = "{$key} = :{$key}";
    }
    $sets = implode(', ', $sets);
    
    $sql = "UPDATE {$this->table} SET {$sets} WHERE {$this->primaryKey} = :id";
    $stmt = $this->db->prepare($sql);
    
    foreach ($data as $key => $value) {
        $stmt->bindValue(":{$key}", $value);
    }
    $stmt->bindValue(":id", $id);
    
    return $stmt->execute();
}

    public function delete($id){
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    
      /**
     * Compter le nombre d'enregistrements dans la table
     * @return int
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }

    /**
     * Compter avec condition WHERE
     * @param string $where Condition WHERE
     * @param array $params Paramètres
     * @return int
     */
    public function countWhere($where, $params = [])
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE {$where}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

}

















?>