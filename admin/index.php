<?php
	include_once('../../database/creds.php');
	include_once('../database/consult.php');

	if (!isset($_SERVER['PHP_AUTH_USER'])) {
	   	header('WWW-Authenticate: Basic realm="UJR3D2012"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Access Denied';
		exit;
	} else {
		$user = $_SERVER['PHP_AUTH_USER'];
		$pass = $_SERVER['PHP_AUTH_PW'];
		$pass = hash('sha512', $pass);

		// Invalid credentials
		if(strcasecmp($user, $admin_name) != 0 || strcasecmp($pass, $admin_pass) != 0) {
			header('WWW-Authenticate: Basic realm="UJR3D2012"');
			header('HTTP/1.0 401 Unauthorized');
			echo 'Access Denied';
			exit;
		}
	}
	init_database('../../database/');

	// Form used	
	if($_POST['action_type']) {
		// Add projects
		if(strcasecmp($_POST['action_type'], 'add_project') == 0) {
			foreach($_FILES as $id => $file) {
				if($file['error'] == UPLOAD_ERR_OK) {
					// Save image file
					if(preg_match('/_image$/', $id))
					{
						preg_match('/^\d+/', $id, $match);
						$id = $match[0];
						$name = generate_file_name($id) . '.jpg';
						move_uploaded_file($file['tmp_name'], '../images/' . $name);
					}
					// Save project file
					else
					{
						$name = generate_file_name($id) . '.zip';
						move_uploaded_file($file['tmp_name'], '../files/' . $name);
					}
					$db->queryExec("UPDATE Student SET submited = 'true' WHERE studentID = {$id}");
				}
			}
		} 
		// Add students
		elseif(strcasecmp($_POST['action_type'], 'add_student') == 0) {
			if(!$_POST['name'] || !$_POST['week'] || !$_POST['day'])
				$add_user_error = 'All fields must have value';
			else {
				$aDate_parts = preg_split("/[\s-]+/", $_POST['day']);
				error_reporting(E_ERROR | E_PARSE);
				$valid = checkdate($aDate_parts[1], $aDate_parts[0], $aDate_parts[2]);
				error_reporting(E_ALL | E_ERROR | E_PARSE | E_WARNING);
				if(!$valid)
					$add_user_error = 'Invalid date';
				// Insert student
				else {
					$name = trim(sqlite_escape_string($_POST['name']));
					$week = sqlite_escape_string($_POST['week']);
					$day = sqlite_escape_string($_POST['day']);
					$db->queryExec("INSERT INTO Student VALUES (null, '{$name}', {$week}, '{$day}', 'false')");
					$add_user_error = "Added";
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Admin :: UJr 2012</title>
		<meta charset="utf-8">
		<meta name="description" content="Universidade Junior 2012: Area de Administrador">
		<meta name="author" content="Diogo Teixeira, Francisco Pinto">
		<link rel="stylesheet" href="../css/style_ref.css">
		<script src="../js/jquery.js"></script>
	</head>
	<body>
		<script type="text/javascript">
			$('document').ready(function() {
				$("form#file_form").submit(function() {
					$("form#file_form input.input_file").each(function() {
						if($(this).val() == '') {
							$(this).remove();
						}
					});
				});
			});
		</script>
		<div id="new_user_div">
			<h1>Add new student</h1>
			<form method="post" action="index.php">
				<input type="hidden" name="action_type" value="add_student"/>
				<table>
					<tr><td>Name</td><td><input class="input" type="text" name="name"/></td></tr>
					<tr><td>Week</td><td><select class="input" name="week" value=1>
						<option value=1>Week 1</option>
						<option value=2>Week 2</option>
						<option value=3>Week 3</option>
						<option value=4>Week 4</option>
					</td></tr>
					<tr><td>Day</td><td><input class="input" type="text" name="day" placeholder="dd-mm-yyyy"/></td></tr>
					<tr><td><input class="button" type="submit" value="Add"></td><td><?php echo $add_user_error; ?></td></tr>
				</table>
			</form> 
		</div>
		<div id="file_div">
			<h1>Upload projects</h1>
			<form id="file_form" method="post" enctype="multipart/form-data" action="index.php">
			<input type="hidden" name="action_type" value="add_project"/>
			<input type="hidden" name="MAX_FILE_SIZE" value="104857600"/>
			<?php
				for($i = 1; $i <= 4; $i++) {
					echo '<h2 class="week">Semana ' . $i . '</h1>'; 
					$week = get_students_by_week($i);
					if($week) {
						echo '<table class="student_table">';
						$day = '';
						$background = 0;
						foreach($week as $student) {
							if(strcasecmp($day, $student['day'])) {
								echo '<tr><td colspan=4><h3 class = "day">' . $student['day'] . '</h2></td></tr>';
								$day = $student['day'];
							}

							// Change row background
							$background++;
							if($background & 1)
								$color_class = "odd_color";
							else
								$color_class = "even_color";

							echo '<tr class="' . $color_class . '"><td class="name" rowspan="2">' . stripslashes($student['studentName']) . '</td>';
							echo '<td><label class="form_label">PROJECTO</label></td><td class="file"><input class="input_file" type="file" name="' . $student['studentID'] . '"/></td>';
							if(strcasecmp($student['submited'], 'true') == 0)
								echo '<td class="submited" rowspan="2">Submited</td></tr>';
							else
								echo '<td class="not_submited" rowspan="2">Not submited</td></tr>';
							echo '<tr class="' . $color_class . '"><td><label class="form_label">IMAGEM</label></td><td class="file"><input class="input_file" type="file" name="' . $student['studentID'] . '_image"/></td></tr>';
						}
						echo '</table>';
					} else {
						echo '<h3 class="error">No students for this week</h2>';
					}
				}
			?>
			<input class="button" type="submit" value="Upload"/>
			</form>
		</div>
	</body>
</html>
