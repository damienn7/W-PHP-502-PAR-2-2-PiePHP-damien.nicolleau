<?php

namespace Core;

class ORM extends Database
{

    public array $relation = [];
    protected array $params = [];

    public function __construct(array $params = [], array $rel = [])
    {
        $this->params = $params;
        $this->relation = $rel;
        parent::__construct();
    }

    public function create(string $table,array $fields)
    {
        $champs = "";
        $values = "";
        foreach ($fields as $key => $value) {
            $champs .= $key . ",";
            $values .= "\"" . $value . "\",";
        }

        $champs = substr($champs, 0, -1);
        $values = substr($values, 0, -1);

        // echo "insert into $table(".$champs.") values(".$values.");";

        try {
            $stmt = $this->db->prepare("insert into $table(" . $champs . ") values(" . $values . ");");
            $stmt->execute();
        } catch (\PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    public function update(string $table,int|string $id, array $fields)
    {
        $champs = "";
        foreach ($fields as $key => $value) {
            $champs .= $key . "=\"" . $value . "\",";
        }

        $champs = substr($champs, 0, -1);

        // echo "update $table set ".$champs." where id=:id;";

        try {
            $stmt = $this->db->prepare("update $table set " . $champs . " where id=:id;");
            $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    public function delete(string $table, int|string $id)
    {
        try {
            $stmt = $this->db->prepare("delete from $table where id=:id;");
            $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    public function resetAutoIncrement(string $table)
    {
        try {
            $stmt = $this->db->prepare("ALTER TABLE $table DROP id;ALTER TABLE $table ADD id int NOT NULL AUTO_INCREMENT FIRST ,ADD PRIMARY KEY (id);");
            $stmt->execute();
        } catch (\PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    public function find(string $table, array $params = array('WHERE' => '1', 'ORDER BY' => 'id ASC', 'LIMIT' => ''))
    {
        //condition de la table avec ses relations
        try {
            if ($params["LIMIT"] == '') {
                $query = "select * from $table where " . $params["WHERE"] . " order by " . $params["ORDER BY"] . ";";
                $stmt = $this->db->prepare($query);
            } else {
                $stmt = $this->db->prepare("select * from $table where :where order by " . $params['ORDER BY'] . " limit " . $params['LIMIT'] . ";");
            }
            $stmt->execute();
            $element = $stmt->fetchAll();
        } catch (\PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
        // var_dump($element);
        return $element;


    }

    public function read(string $table, int|string $id,string $where_table="")
    {
        if (!isset(explode("_",$table)[1])) {
            
            $join = "";
            foreach ($this->relation as $key => $value) {
                if (is_string($value)) {
                    if (isset(explode("one", $value)[1])) {
                        $join .= " join " . explode("one", $value)[1] . " on" . explode("one", $value)[1] . ".id=$table." . substr(explode("one", $value)[1], 0, -1) . "_id";
                    } elseif (isset(explode("many", $value)[1])) {
                        $join .= " join " . explode("many", $value)[1] . " on" . explode("many", $value)[1] . "." . substr($table, 0, -1) . "_id=$table.id";
                    } else {
                        $join = "";
                    }
                }
            }
            $query = "select * from $table" . $join . " where $table.id=:id;";
        }else{
            $query = "select * from $table" . " join ".explode("_",$table)[0]." on $table.".substr(explode("_",$table)[0],0,-1)."_id=".explode("_",$table)[0].".id join ".explode("_",$table)[1]." on $table.".substr(explode("_",$table)[1],0,-1)."_id=".explode("_",$table)[1].".id where $where_table.id=:id;";
        }

        // echo $query;
        // echo "<br>";
        // echo "<br>";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
            $stmt->execute();
            $element = $stmt->fetchAll();
        } catch (\PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }

        return $element;
    }
}