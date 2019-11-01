<?php
class User extends Db_object{
	//Abstracting the table name
	protected static $db_table= "users";
	protected static $db_table_fields= array('username', 'password', 'first_name', 'last_name', 'user_image');
	//End of abstracting tables
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $user_image;
	public $upload_directory= "images";
	public $image_placeholder= "http://placeholder.it/400x400&text=image";
	public $errors= array();



	public function save_user_and_image(){
		if ($this->id) {
			$this->update();
		}else{

			if (!empty($this->errors)) {
				return false;
			}

			if (empty($this->user_image) || empty($this->tmp_path)) {
				$this->errors[]= "The file was not available";
				return false;
			}

			$target_path= SITE_ROOT.DS.'admin'.DS. $this->upload_directory. DS . $this->user_image;


			if (file_exists($target_path)) {
				$this->errors[]= "The file {$this->user_image} already exists";
				return false;
			}


			if (move_uploaded_file($this->tmp_path, $target_path)) {
				if ($this->create()) {
					unset($this->tmp_path);
					return true;
				}
			}else{
				$this->errors[]= "The file directory probably does not have permissions";
				return false;
			}
		}
	}


	public function upload_photo(){
			if (!empty($this->errors)) {
				return false;
			}

			if (empty($this->user_image) || empty($this->tmp_path)) {
				$this->errors[]= "The file was not available";
				return false;
			}

			$target_path= SITE_ROOT.DS.'admin'.DS. $this->upload_directory. DS . $this->user_image;


			if (file_exists($target_path)) {
				$this->errors[]= "The file {$this->user_image} already exists";
				return false;
			}


			if (move_uploaded_file($this->tmp_path, $target_path)) {
				//if ($this->create()) { Duplicating the records Unneccessarily 16.15
					unset($this->tmp_path);
					return true;
				//}
			}else{
				$this->errors[]= "The file directory probably does not have permissions";
				return false;
			}		
	}

	public function image_path_and_placeholder(){
		return empty($this->user_image)? $this->image_placeholder: $this->upload_directory.DS.$this->user_image;
	}

	public static function verify_user($username, $password){
		global $database;
		$username= $database->escape_string($username);
		$password= $database->escape_string($password);

		$sql = "SELECT * FROM " .self::$db_table. " WHERE ";
		$sql .= "username='{$username}' ";
		$sql .= "AND password ='{$password}' ";
		$sql .= "LIMIT 1";
		$the_result_array= self::find_by_query($sql);

		return !empty($the_result_array)? array_shift($the_result_array): false;
	}



	public function delete_user(){
		return $this->delete() ? true : false;
	}

	public function ajax_save_user_image($user_image, $user_id){
		// $this->user_image= $user_image;
		// $this->id= $user_id;
		// $this->save();

		global $database;
		$user_image= $database->escape_string($user_image);
		$user_id= $database->escape_string($user_id);

		$this->user_image= $user_image;
		$this->id= $user_id;
		$sql= "UPDATE ".self::$db_table. " SET user_image= '{$this->user_image}' ";
		$sql.=" WHERE id={$this->id} ";
		$update_image= $database->query($sql);
		echo $this->image_path_and_placeholder();
	}


	public function delete_photo(){
		if ($this->delete()) {
			$target_path= SITE_ROOT.DS.'admin'.DS.$this->upload_directory. DS . $this->user_image;
			unlink($target_path)?true:false;
		}else{
			return false;
		}
	}


	// public function delete_photo(){
	// 	if ($this->delete()) {
	// 		$target_path= SITE_ROOT.DS.'admin'.DS.$this->picture_path();
	// 		unlink($target_path)?true:false;
	// 	}else{
	// 		return false;
	// 	}
	// }
}



//=========================================================================//

/*
*	All working without using the inheritance class
*
*/

// class User{
// 	//Abstracting the table name
// 	protected static $db_table= "users";
// 	protected static $db_table_fields= array('username', 'password', 'first_name', 'last_name');
// 	//End of abstracting tables
// 	public $id;
// 	public $username;
// 	public $password;
// 	public $first_name;
// 	public $last_name;
// // 	public function find_all_users(){
// // 		// Coming from the instantiation of database.php
// // 		global $database;
// // 		$result_set= $database->query("SELECT * FROM users");
// // 		return $result_set;
// // 	}
// // }


// 	public static function find_all_users(){
// 		// Coming from the instantiation of database.php
// 		// global $database;
// 		// $result_set= $database->query("SELECT * FROM users");
// 		// return $result_set;

// 		// Before creating the method find_by_query()
// 		return self::find_this_query("SELECT * FROM " .self::$db_table. " ");
// 	}
 	

// 	// public static function find_user_by_id($user_id){
// 	// 	global $database;
// 	// 	//$result_set= $database->query("SELECT * FROM users WHERE id='$id'");
// 	// 	$result_set= self::find_this_query("SELECT * FROM users WHERE id='$user_id' LIMIT 1");
// 	// 	$found_user= mysqli_fetch_array($result_set);
// 	// 	return $found_user;
// 	// }



// 	public static function find_user_by_id($user_id){
// 		global $database;
// 		//$result_set= $database->query("SELECT * FROM users WHERE id='$id'");
// 		$the_result_array= self::find_this_query("SELECT * FROM " .self::$db_table. " WHERE id='$user_id' LIMIT 1");
// 		return !empty($the_result_array)? array_shift($the_result_array): false;
// 		// if (!empty($the_result_array)) {
// 		// 	$first_item= mysqli_fetch_array($the_result_array);
// 		// 	return $first_item;
// 		// }else{
// 		// 	return false;
// 		// }	
// 	}
	
// 	public static function find_this_query($sql){
// 		global $database;
// 		$result_set= $database->query($sql);
// 		//return $result_set;
// 		$the_object_array= array();
// 		while ($row= mysqli_fetch_array($result_set)) {
// 			$the_object_array[]= self::instantiation($row);
// 		}
// 		return $the_object_array;
// 	}



// 	public static function verify_user($username, $password){
// 		global $database;
// 		$username= $database->escape_string($username);
// 		$password= $database->escape_string($password);

// 		$sql = "SELECT * FROM " .self::$db_table. " WHERE ";
// 		$sql .= "username='{$username}' ";
// 		$sql .= "AND password ='{$password}' ";
// 		$sql .= "LIMIT 1";
// 		$the_result_array= self::find_this_query($sql);

// 		return !empty($the_result_array)? array_shift($the_result_array): false;
// 	}


// 	public static function instantiation($the_record){
// 		// Instantiation according to lecture 5.8
// 		// $the_object= new self;
//         // $the_object->id=      	$found_user['id'];
//         // $the_object->username=	$found_user['username'];
//         // $the_object->password=	$found_user['password'];
//         // $the_object->first_name=$found_user['first_name'];
//         // $the_object->last_name= $found_user['last_name'];
//         // //echo $user->id;
//         // return $the_object;

// 		$the_object= new self;
// 		foreach ($the_record as $the_attribute => $value) {
// 			if($the_object->has_the_attribute($the_attribute)){
// 				$the_object->$the_attribute= $value;
// 			}
// 		}
// 		return $the_object;
// 	}
	

// 	private function has_the_attribute($the_attribute){
// 		$object_properties= get_object_vars($this);
// 		return array_key_exists($the_attribute, $object_properties);
// 	}

// 	protected function properties(){
// 		// Abstracting the properties for the create method

// 		No more useful so far we can easily  pull from $db_table_fields

// 		return get_object_vars($this);

		
// 		$properties= array();
// 		foreach (self::$db_table_fields as $db_field) {
// 			if (property_exists($this, $db_field)) {
// 				$properties[$db_field]= $this->$db_field;
// 			}
// 		}
// 		return $properties;
// 	}

// 	protected function clean_properties(){
// 		global $database;
// 		$clean_properties= array();
// 		foreach ($this->properties() as $key => $value) {
// 			$clean_properties[$key]= $database->escape_string($value);

// 		}
// 		return $clean_properties;
// 	}
	

// 	public function save(){
// 		// Abstraction
// 		return isset($this->id) ? $this->update(): $this->create();
// 	}

// 	public function create(){
// 		global $database;
// 		//$properties= $this->properties();
// 		$properties= $this->clean_properties();
// 		$sql= "INSERT INTO " .self::$db_table. "(". implode(",", array_keys($properties)).")";

// 		$sql.="VALUES('". implode("','", array_values($properties))."')";
		
		
// 		if ($database->query($sql)) {
// 			$this->id= $database->the_insert_id();
// 			return true;
// 		}else{
// 			return false;
// 		}
// 	}



// 	public function update(){
// 		// Using the abstraction properties
// 		global $database;

// 		//$properties= $this->properties();

// 		$properties= $this->clean_properties;

// 		$properties_pairs= array();

// 		foreach ($properties as $key => $value) {
// 			$properties_pairs[]= "{$key}='{$value}'";
// 		}

// 		//$sql= "UPDATE users SET ";
// 		$sql= "UPDATE " .self::$db_table. " SET ";
// 		$sql.= implode(", ", $properties_pairs);

// 		$sql .=	" WHERE id=" .  $database->escape_string($this->id);

// 		$database->query($sql);
// 		return (mysqli_affected_rows($database->connection)==1) ? true:false;
// 	}

// 	// Without abstracting the properties

// 	// public function create(){
// 	// 	global $database;
// 	// 	//$sql= "INSERT INTO users(username, password, first_name, last_name)";
// 	// 	// Before abtracting the tables from line 3
// 	// 	$sql= "INSERT INTO " .self::$db_table. " (username, password, first_name, last_name)";
// 	// 	$sql.="VALUES('";
// 	// 	$sql .=$database->escape_string($this->username)."', '";
// 	// 	$sql .=$database->escape_string($this->password)."', '";
// 	// 	$sql .=$database->escape_string($this->first_name)."', '";
// 	// 	$sql .=$database->escape_string($this->last_name)."')";
		
// 	// 	if ($database->query($sql)) {
// 	// 		$this->id= $database->the_insert_id();
// 	// 		return true;
// 	// 	}else{
// 	// 		return false;
// 	// 	}
// 	// }

	

// 	// public function update(){
// 	// 	global $database;

// 	// 	//$sql= "UPDATE users SET ";
// 	// 	$sql= "UPDATE " .self::$db_table. " SET ";
// 	// 	$sql .= "username='" . $database->escape_string($this->username)   . "', ";
// 	// 	$sql .= "password='" . $database->escape_string($this->password)   . "', ";
// 	// 	$sql .= "first_name='". $database->escape_string($this->first_name) . "', ";
// 	// 	$sql .= "last_name='" .  $database->escape_string($this->last_name)  .  "' ";
// 	// 	$sql .=	" WHERE id=" .  $database->escape_string($this->id);

// 	// 	$database->query($sql);
// 	// 	return (mysqli_affected_rows($database->connection)==1) ? true:false;
// 	// }


// 	public function delete(){
// 		global $database;

// 		//$sql= "DELETE FROM users ";
// 		$sql= "DELETE FROM " .self::$db_table. " ";
// 		$sql.="WHERE id=".$database->escape_string($this->id);
// 		$sql.=" LIMIT 1";

// 		$database->query($sql);
// 		return (mysqli_affected_rows($database->connection)==1) ? true: false;
// 		//$query= "DELETE FROM posts WHERE post_id='{$the_delete_id}'";
// 	}
// }
?>