<?PHP
//SQL is for masochists
class Debaser {

	var $DBhost = "";
	var $DBuser = "";
	var $DBpass = "";
	var $DBname = "";

	var $linkid = null;
	var $result = null;

	var $dbh = null;

	function Debaser($host, $user, $pass, $name) {

		$this->DBhost = $host;
		$this->DBuser = $user;
		$this->DBpass = $pass;
		$this->DBname = $name;
		
	}

	function connect() {
		try 
		{
    		$this->dbh = new PDO("mysql:host=$this->DBhost;dbname=$this->DBname", $this->DBuser, $this->DBpass);

    	}
		catch(PDOException $e)
    	{
    		die("Unable to connect to database ".$e->getMessage());
    	}
	}

	function disconnect() {
		try 
		{
    		$this->dbh = null;
    	}
		catch(PDOException $e)
    	{
    		die("Unable to connect to disconnect ".$e->getMessage());
    	}
	}

	//only for select sql statements. returns array of results.
	function select($sql) {
		try 
		{
			return $this->dbh->query($sql);
		}
		catch (PDOException $e) 
		{
			die("Unable to select ".$e->getMessage());
		}
	}

	//only for update / insert sql statements. returns count of rows affected.
	function write($sql) {
		try 
		{
			return $this->dbh->exec($sql);
		}
		catch(PDOException $e)
		{
			die("Unable to write ".$e->getMessage());
		}
	}
}

?>