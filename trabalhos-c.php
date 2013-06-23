<?php
	include_once('../database/creds.php');
	include_once('./database/consult.php');

	if(isset($_GET["semana"])){

		$semana = $_GET["semana"];
		if($semana < 1 && $semana > 4)
			$semana=NULL;

		if(isset($_GET["dia"])){

			if( ($semana==1 && $dia<1 && $dia > 5) ||
				($semana==2 && $dia<8 && $dia > 12) ||
				($semana==3 && $dia<15 && $dia > 19) ||
				($semana==4 && $dia<22 && $dia > 26))
				$dia = NULL;
			else
				$dia = $_GET["dia"];
		}
	}

	function activate_week_item($semana,$week){
		if( $semana != NULL && $semana==$week){
			echo "active";
		}
	}

	function activate_days_tab($semana){
		if( $semana != NULL){
			echo 'style="display:block;"';
		}
	}

	function activate_day_item($semana, $dia,$day){
		if( $semana != NULL && $dia!= NULL && $dia==day_from_week($semana,$day)){
			echo "active";
		}
	}

	function link_for_day($semana,$day_i){
		if($semana==NULL) return false;
		$day =  day_from_week($semana,$day_i);
		echo "/~ujr3d13/trabalhos.php?semana=".$semana."&dia=".$day;
	}

	function day_datas($semana,$day,$day_i){
		if($semana==NULL) return false;
		echo ' data-week="'.$semana.'" ';
		echo ' data-day="'.(day_from_week($semana,$day_i)).'"';
	}

	function day_from_week($semana,$day_i){
		if($semana==NULL) return "";
		if($semana==1){
			return 0+$day_i;
		} else if($semana==2){
			return 7+$day_i;
		} else if($semana==3){
			return 14+$day_i;
		} else if($semana==4){
			return 21+$day_i;
		} 
	}

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
			<a href="/~ujr3d13/trabalhos.php?semana=1" class="one-forth-div week-item <?php activate_week_item($semana,1); ?>" data-week="1" data-start="1" >
				<span class="week-name">Semana 1</span>
				<span class="week-subname">1-5 Julho</span>
			</a>
			<a href="/~ujr3d13/trabalhos.php?semana=2" class="one-forth-div week-item <?php activate_week_item($semana,2); ?>" data-week="2"  data-start="8" >
				<span class="week-name">Semana 2</span>
				<span class="week-subname">8-12 Julho</span>
			</a>
			<a href="/~ujr3d13/trabalhos.php?semana=3" class="one-forth-div week-item <?php activate_week_item($semana,3); ?>" data-week="3"  data-start="15" >
				<span class="week-name">Semana 3</span>
				<span class="week-subname">15-19 Julho</span>
			</a>
			<a href="/~ujr3d13/trabalhos.php?semana=4" class="one-forth-div week-item <?php activate_week_item($semana,4); ?>" data-week="4"  data-start="22" >
				<span class="week-name">Semana 4</span>
				<span class="week-subname">22-26 Julho</span>
			</a>
		</div>
	</div>

	<div id="days" class="container" <?php activate_days_tab($semana); ?> >
		<div class="day-selector btcf">
			<a href="<?php link_for_day($semana,1); ?>" class="one-fifth-div week-item <?php activate_day_item($semana,$dia,1); ?> " <?php day_datas($semana,$day,1); ?> >
				<span class="week-name">Segunda</span>
				<span class="week-subname"><?php echo(day_from_week($semana,1)); ?></span>
			</a>
			<a href="<?php link_for_day($semana,2); ?>" class="one-fifth-div week-item <?php activate_day_item($semana,$dia,2); ?>" <?php day_datas($semana,$day,2); ?>>
				<span class="week-name">Terça</span>
				<span class="week-subname"><?php echo(day_from_week($semana,2)); ?></span>
			</a>
			<a href="<?php link_for_day($semana,3); ?>" class="one-fifth-div week-item <?php activate_day_item($semana,$dia,3); ?>" <?php day_datas($semana,$day,3); ?>>
				<span class="week-name">Quarta</span>
				<span class="week-subname"><?php echo(day_from_week($semana,3)); ?></span>
			</a>
			<a href="<?php link_for_day($semana,4); ?>" class="one-fifth-div week-item <?php activate_day_item($semana,$dia,4); ?>" <?php day_datas($semana,$day,4); ?>>
				<span class="week-name">Quinta</span>
				<span class="week-subname"><?php echo(day_from_week($semana,4)); ?></span>
			</a>
			<a href="<?php link_for_day($semana,5); ?>" class="one-fifth-div week-item <?php activate_day_item($semana,$dia,5); ?>" <?php day_datas($semana,$day,5); ?>>
				<span class="week-name">Sexta</span>
				<span class="week-subname"><?php echo(day_from_week($semana,5)); ?></span>
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

							$filtered=false;	
							$filtered = $semana != NULL && $semana!=$i;
							$filtered = ($dia != NULL && $dia!=$day) || $filtered;

							if(file_exists('./images/' . $filename . '.jpg'))
								project($name, $student['studentName'], $pre_path . 'files/' . $filename . '.zip', $pre_path . 'images/' . $filename . '.jpg', $i, $day, $filtered);
							else
								project($name, $student['studentName'], $pre_path . 'files/' . $filename . '.zip', $pre_path . 'images/default.jpg', $i, $day, $filtered);
						}
					}
				} 
			?>
		</div>
	</div>

</section>
