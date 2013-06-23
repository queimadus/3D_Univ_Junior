<?php
	include_once('../database/creds.php');
	include_once('./database/consult.php');

	function project($name, $full_name, $url,$image,$week,$day,$filtered){
		$filter_class="";
		if($filtered)
			$filter_class="filtered";

		$str = <<< EOD

		<div class="project one-forth-div $filter_class" data-week="$week" data-day="$day">
			<div class="project-inner">
				<img class="project-image" src="$image" alt="project thumbnail">
				<span class="project-author">$name</span>
				<div class="project-date">
					<div class="project-week">$week</div>
					<div class="project-day">$day</div>
				</div>
				<div class="project-dropdown">
					<span class="project-dropdown-name">$full_name</span>
					<span class="project-dropdown-download">Descarregar</span>
					<span class="project-dropdown-week">º Semana</span>
					<span class="project-dropdown-day">de Julho</span>
				</div>
				<a class="project-download" href="$url"></a>
			</div>
		</div>

EOD;
		echo $str;
	}
?>

<section class="content trabalhos-content">
	<div class="container">
		<div class="hero trabalhos-hero">
			<h1>Trabalhos</h1>
		</div>
	</div>

	<div class="container">
		<div id="weeks" class="week-selector btcf">
			<a href="/trabalhos/semana1" class="one-forth-div week-item" data-week="1" data-start="1" >
				<span class="week-name">Semana 1</span>
				<span class="week-subname">1-5 Julho</span>
			</a>
			<a href="/trabalhos/semana2" class="one-forth-div week-item" data-week="2"  data-start="8" >
				<span class="week-name">Semana 2</span>
				<span class="week-subname">8-12 Julho</span>
			</a>
			<a href="/trabalhos/semana3" class="one-forth-div week-item" data-week="3"  data-start="15" >
				<span class="week-name">Semana 3</span>
				<span class="week-subname">15-19 Julho</span>
			</a>
			<a href="/trabalhos/semana4" class="one-forth-div week-item" data-week="4"  data-start="22" >
				<span class="week-name">Semana 4</span>
				<span class="week-subname">22-26 Julho</span>
			</a>
		</div>
	</div>

	<div id="days" class="container">
		<div class="day-selector btcf">
			<a href="" class="one-fifth-div week-item">
				<span class="week-name">Segunda</span>
				<span class="week-subname"></span>
			</a>
			<a href="" class="one-fifth-div week-item">
				<span class="week-name">Terça</span>
				<span class="week-subname"></span>
			</a>
			<a href="" class="one-fifth-div week-item">
				<span class="week-name">Quarta</span>
				<span class="week-subname"></span>
			</a>
			<a href="" class="one-fifth-div week-item">
				<span class="week-name">Quinta</span>
				<span class="week-subname"></span>
			</a>
			<a href="" class="one-fifth-div week-item">
				<span class="week-name">Sexta</span>
				<span class="week-subname"></span>
			</a>
		</div>
	</div>

	<div class="container">
		<div id="projects">
			<?php
				init_database('../database/');
				for($i = 1; $i <= 4; $i++) 
				{
					$week = get_students_by_week($i);
					if($week) 
					{
						foreach($week as $student) 
						{
							$names = explode(' ', $student['studentName']);
							$name = $names[0] . ' ' . $names[count($names) - 1];
							$filename = generate_file_name($student['studentID']);
							$pre_path = '/~ujr3d13/';
							$date = explode('-', $student['day']);
							$day = intval($date[0]);
							if(file_exists('./images/' .$filename))
								project($name, $student['studentName'], $pre_path . 'files/' . $filename . '.zip', $pre_path . 'images/' . $filename . '.jpg', $i, $day, false);
							else
								project($name, $student['studentName'], $pre_path . 'files/' . $filename . '.zip', $pre_path . 'images/default.jpg', $i, $day, false);
						}
					}
				} 
			?>
		</div>
	</div>

</section>
