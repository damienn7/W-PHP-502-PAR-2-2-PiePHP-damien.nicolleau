<?php

namespace src\Model;

class UserModel extends \Core\Entity
{

    private int $id;
    private string $email;

    private string $password;

    public function __construct($params=[]){
        parent::__construct($params,[""]);
        if ($params!= []) {
            $this->email=$this->params["email"];
            $this->password=$this->params["password"];
        }
    }

    // public function create()
    // {
    //     try {
    //         $stmt = $this->db->prepare("insert into users(email,password) values(:email,:password);");
    //         $stmt->bindParam(":email", $this->email, \PDO::PARAM_STR_CHAR);
    //         $stmt->bindParam(":password", $this->password, \PDO::PARAM_STR_CHAR);
    //         $stmt->execute();
    //     } catch (\PDOException $e) {
    //         die("Erreur : " . $e->getMessage());
    //     }

        
    // }

    // public function getUserByEmail()
    // {
    //     //select user by email
    //     try {
    //         $stmt = $this->db->prepare("select * from users where email=:email;");
    //         $stmt->bindParam(":email", $this->email, \PDO::PARAM_STR_CHAR);
    //         $stmt->execute();
    //         $user = $stmt->fetchAll();
    //     } catch (\PDOException $e) {
    //         die("Erreur : " . $e->getMessage());
    //     }
    //     if ($this->email == $user[0]["email"] && $this->password == $user[0]["password"]) {
    //         return $user;
    //     } else {
    //         return false;
    //     }
    // }

    // public function read($id)
    // {
    //     try {
    //         $stmt = $this->db->prepare("select * from users where id=:id;");
    //         $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
    //         $stmt->execute();
    //         $user = $stmt->fetchAll();
    //     } catch (\PDOException $e) {
    //         die("Erreur : " . $e->getMessage());
    //     }

    //     return $user;
    // }
    // public function update($email, $password, $id)
    // {

    //     try {
    //         switch ($this->email) {

    //             case $email != "" && $password != "":
    //                 $stmt = $this->db->prepare("update users set email=:email,password=:password where id=:id;");
    //                 $stmt->bindParam(":email", $this->email, \PDO::PARAM_STR_CHAR);
    //                 $stmt->bindParam(":password", $this->password, \PDO::PARAM_STR_CHAR);
    //                 $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
    //                 break;
    //             case '':
    //                 $stmt = $this->db->prepare("update users set password=:password where id=:id;");
    //                 $stmt->bindParam(":password", $this->password, \PDO::PARAM_STR_CHAR);
    //                 $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
    //                 break;
    //             case $password == "":
    //                 $stmt = $this->db->prepare("update users set email=:email where id=:id;");
    //                 $stmt->bindParam(":email", $this->email, \PDO::PARAM_STR_CHAR);
    //                 $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
    //                 break;

    //             default:
    //                 # code...
    //                 break;
    //         }
    //         $stmt = $this->db->prepare("update users set email=:email;");
    //     } catch (\PDOException $e) {
    //         die("Erreur : " . $e->getMessage());
    //     }

    //     $stmt->execute();
    // }
    // public function delete($id)
    // {
    //     try {
    //         $stmt = $this->db->prepare("delete from users where id=:id;");
    //         $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
    //         $stmt->execute();
    //     } catch (\PDOException $e) {
    //         die("Erreur : " . $e->getMessage());
    //     }
    // }
    // public function read_all()
    // {
    //     try {
    //         $stmt = $this->db->prepare("select * from users;");
    //         $stmt->execute();
    //         $users = $stmt->fetchAll();
    //     } catch (\PDOException $e) {
    //         die("Erreur : " . $e->getMessage());
    //     }

    //     return $users;
    // }
}