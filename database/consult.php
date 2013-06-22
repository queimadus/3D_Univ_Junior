<?php
	function init_database($path) {
		$db_name = $path . "ujr3d12.db";
		$db_access_mode = 0666;

		global $db;
	   	$db	= new SQLiteDatabase($db_name, $db_access_mode, $message);
		return $db;
	}

	function get_all_students() {
		global $db;

		$stmt = $db->query('SELECT * FROM Student');
		if(!$stmt)
			return false;
		else
			return $stmt->fetchAll(SQLITE_ASSOC);
	}

	function get_student_by_id($id) {
		global $db;

		$id = sqlite_escape_string($id);
		$stmt = $db->query("SELECT * FROM Student WHERE studentID = {$id}");
		if(!$stmt)
			return false;
		else
			return $stmt->fetch(SQLITE_ASSOC);
	}

	function get_students_by_week($week) {
		global $db;

		$week = sqlite_escape_string($week);
		$stmt = $db->query("SELECT * FROM Student WHERE week = {$week} ORDER BY day ASC, studentName ASC");
		if(!$stmt)
			return false;
		else
			return $stmt->fetchAll(SQLITE_ASSOC);
	}
	
	function get_students_by_day($day) {
		global $db;

		$day = sqlite_escape_string($day);
		$stmt = $db->query("SELECT * FROM Student WHERE day = '{$day}'");
		if(!$stmt)
			return false;
		else
			return $stmt->fetchAll(SQLITE_ASSOC);
	}

	function generate_file_name($id) {
		$student = get_student_by_id($id);
		if(!$student)
			return false;
		
		$res = preg_match('/^[^\s]*/', $student['studentName'], $matches);
		$filename = strip_accents(strtolower($matches[0]));
		$res = preg_match('/[^\s]*$/', $student['studentName'], $matches);
		$filename .= '_' . strip_accents(strtolower($matches[0])) . '_' . $student['day'] . '_' . $student['studentID'];
		$filename = str_replace('-', '_', $filename);
		return $filename;
	}

	function strip_accents($str) {
		$normalizeChars = array( 
           		 'Á'=>'A', 'À'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Å'=>'A', 'Ä'=>'A', 'Æ'=>'AE', 'Ç'=>'C', 
			    'É'=>'E', 'È'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Í'=>'I', 'Ì'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ð'=>'Eth', 
			    'Ñ'=>'N', 'Ó'=>'O', 'Ò'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 
			    'Ú'=>'U', 'Ù'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 
			    'á'=>'a', 'à'=>'a', 'â'=>'a', 'ã'=>'a', 'å'=>'a', 'ä'=>'a', 'æ'=>'ae', 'ç'=>'c', 
			    'é'=>'e', 'è'=>'e', 'ê'=>'e', 'ë'=>'e', 'í'=>'i', 'ì'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'eth', 
			    'ñ'=>'n', 'ó'=>'o', 'ò'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 
			    'ú'=>'u', 'ù'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y',  
			    'ß'=>'sz', 'þ'=>'thorn', 'ÿ'=>'y'); 
		return strtr($str, $normalizeChars);
	}
?>
