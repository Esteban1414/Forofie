<?php

namespace app\classes;

class DB
{

    private $host;
    private $db;
    private $db_user;
    private $db_pass;

    protected $table;
    public $cone;
    public $j = "";
    public $s = " * ";
    public $w = " 1 ";
    public $o = "";
    public $l = "";

    public function __construct($dbh = DB_HOST, $dbn = DB_NAME, $dbu = DB_USER, $dbp = DB_PASS)
    {
        $this->host = $dbh;
        $this->db = $dbn;
        $this->db_user = $dbu;
        $this->db_pass = $dbp;
    }

    public function connect()
    {
        $this->cone = new \mysqli($this->host, $this->db_user, $this->db_pass, $this->db);
        if ($this->cone->connect_errno) {
            echo "Error al conectar db" . $this->cone->connect_errno;
            return;
        }
        $this->cone->set_charset("utf8");
        return $this->cone;
    }

    public function select($cc = [])
    {
        if (count($cc) > 0) {
            $this->s = implode(",", $cc);
            return $this;
        }
    }

    public function join($join = "", $on = "")
    {
        $this->j = "";
        if ($join != "" && $on != "") {
            $this->j .= ' join ' . $join . ' on ' . $on;
        }
        return $this;
    }

    public function where($ww = [])
    {
        $this->w = "";
        if (count($ww) > 0) {
            foreach ($ww as $where) {
                $this->w .= $where[0] . " like '" . $where[1] . "' " . ' and ';
            }
        }
        $this->w .= ' 1 ';
        $this->w = ' (' . $this->w . ') ';
        return $this;
    }

    public function orderBy($ob = [])
    {
        $this->o = "";
        if (count($ob) > 0) {
            foreach ($ob as $orderBy) {

                $this->o .= $orderBy[0] . ' ' . $orderBy[1] . ',';
            }
            $this->o = ' order by ' . trim($this->o, ',');
        }
        return $this;
    }

    public function limit($l = "")
    {
        $this->l = "";
        if ($l != "") {
            $this->l = ' limit ' . $l;
        }

        return $this;
    }


    public function all()
    {
        return $this;
    }

    public function get()
    {
        $sql = "SELECT" . $this->s . " FROM " . str_replace(
            "app\\models\\","",get_class($this)) .
            ($this->j != "" ? " a " . $this->j : "") .
            " WHERE" .
            $this->w .
            $this->o .
            $this->l;

        $r = $this->table->query($sql);

        while ($f = mysqli_fetch_assoc($r)) {
            $result[] = $f;
        }

        return json_encode($result);
    }
}
