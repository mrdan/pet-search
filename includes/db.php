<?PHP
//SQL is for masochists
class Debaser {

	var $DBhost = "";
	var $DBuser = "";
	var $DBpass = "";
	var $DBname = "";

	var $linkid;
	var $result;

	function Debaser($host, $user, $pass, $name) {

		$this->DBhost = $host;
		$this->DBuser = $user;
		$this->DBpass = $pass;
		$this->DBname = $name;
		
	}

	function connect() {
		$this->linkid = mysql_connect($this->DBhost,$this->DBuser,$this->DBpass);
		if (!$this->linkid) {
    		die("Unable to connect to database".mysql_error());
    	}
		mysql_select_db($this->DBname,$this->linkid);
	}

	function disconnect() {
		mysql_close($this->linkid);
	}

	function change_db($newdb) {
		$this->DBname = $newdb;
		mysql_select_db($this->DBname, $this->linkid);
	}


	function select($sql) {
		$this->result = mysql_query($sql,$this->linkid);
		if(!$this->result)
			die('Error in debaser select: ' . mysql_error());
		return $this->result;
	}

	function write($sql) {
		$this->result = mysql_query($sql,$this->linkid);
		if(!$this->result)
			die('Error in debaser select: ' . mysql_error());
		return $this->result;
	}
}

?>