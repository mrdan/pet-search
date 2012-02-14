<?PHP
//SQL is for masochists
class Debaser {

	private static $DBhost = "127.0.0.1";
	private static $DBuser = "pet_user";
	private static $DBpass = "234rewf2";
	private static $DBname = "petsearch";

	private static $instance = null;

	private function __construct() {}

	private function __clone(){}

	private static function getInstance() {
		try
		{
			if (!self::$instance)
    		{
    			self::$instance = new PDO("mysql:host=".self::$DBhost.";dbname=".self::$DBname, self::$DBuser, self::$DBpass);
    			self::$instance-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		}
			return self::$instance;
		}
		catch(PDOException $e)
    	{
    		die("Unable to create instance ".$e->getMessage());
    	}
	}

	public static function disconnect() {
		try 
		{
    		self::$instance = null;
    	}
		catch(PDOException $e)
    	{
    		die("Unable to connect to disconnect ".$e->getMessage());
    	}
	}

	//only for select sql statements. returns array of results. probably not a good idea to use on massive result sets.
	public static function select($sql) {
		try 
		{
			self::getInstance();
			return self::$instance->query($sql)->fetchAll();
		}
		catch (PDOException $e) 
		{
			die("Unable to select ".$e->getMessage());
		}
	}

	//only for update / insert sql statements. returns count of rows affected.
	public static function write($sql) {
		try 
		{
			self::getInstance();
			return self::$instance->exec($sql);
		}
		catch(PDOException $e)
		{
			die("Unable to write ".$e->getMessage());
		}
	}
}

?>