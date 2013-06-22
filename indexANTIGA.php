<!DOCTYPE html>

<html>
	<head>
		<title>Modelação 3D de objectos :: UJr 2012</title>
		<meta charset="utf-8">
		<meta name="description" content="Universidade Junior 2012: Modelação 3D de objectos">
		<meta name="author" content="Diogo Teixeira, Francisco Pinto">
		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/styles.css">

		<script src="js/Three.js"></script>
		<script src="js/jquery.js"></script>
		<script src="js/Detector.js"></script>
		<script src="js/animation.js"></script>
		<script src="js/bxslider.js"></script>
		<script src="js/collapse.js"></script>
		<script src="js/scripts.js"></script>
	</head>

	<body>
		<div id="topbar">
			<ul>
				<li><a id="inicio-link" href="#inicio"><img src="img/home.png"/>Início</a></li>
				<li><a id="guioes-link" href="#guioes"><img src="img/book.png"/>Guião</a></li>
				<li><a id="trabalhos-link" href="#trabalhos"><img src="img/projects.png">Trabalhos</a></li>
				<li><a id="contactos-link" href="#contactos"><img src="img/contacts.png">Contactos</a></li>
				<li><a id="download-link" target="_blank" href="http://sketchup.google.com/"><img src="img/download.png">Download do SketchUp</a></li>
			</ul>
		</div>	



		<div id="main">
			<div id="slider">
				<div class="slider-element">
					<div id="first">
						<h1 id="title">Modelação 3D de Objectos</h1>
						<p>Aqui podes encontrar informação relacionada com o <em>workshop.</em></p>
						<div id="splash"></div>
						<div id="logos">
							<a class="logo" href="http://fe.up.pt/" >
								<img src="img/feup_logo.png"/>
							</a>
							<a class="logo"href="http://universidadejunior.up.pt/">
								<img src="img/ujr_logo.png"/>
							</a>
						</div>
					</div>
				</div>
				<div class="slider-element">
					<div id="download-slide" class="regular-slide">
						<h1>
							Descarregar o guião
						</h1>

						<div id="download-container">
							<div id="full">
								<p>Este guião inclui o conteudo que abordaste no <em>workshop</em> com a adição de alguns tópicos avançados.</p>
								<a href="pdf/apontamentos_UJr_2012.pdf"><img src="img/download.png"/>Download</a>
							</div>
						</div>
					</div>
				</div>
				<div class="slider-element">
					<div class="regular-slide">
						<h1>Descarregar trabalhos</h1>
						<p>Descarrega os teus trabalhos e os dos teus colegas.</p>

						<div id="collapser">
						<?php
							include_once('database/consult.php'); init_database('../database/');
							for($i = 1; $i < 5; $i++) {
								echo "<h3>Semana {$i}</h3>";
								echo "<ul>";
								$students = get_students_by_week($i); 
								$day = '';
								foreach($students as $student) {
									if(strcasecmp($day, $student['day']) != 0) {
										if($day) echo "</ul>";
										$day = $student['day'];
										echo "<h3>{$day}</h3><ul>";
									}
									if(strcasecmp($student['submited'], 'true') == 0) {
										$file = 'files/' . generate_file_name($student['studentID']) . '.zip';
										echo "<li><a href=\"{$file}\">{$student['studentName']}</a></li>";
									}
									else
										echo "<li>{$student['studentName']}</li>";
								}
								echo "</ul></ul>";
							}
						?>
						</div>

					</div>
				</div>
				<div class="slider-element">
					<div class="slider-element">
						<div id="first">
							<h1>Contactos</h1>
							<p>Aqui tens informação dos contactos dos monitores. Por favor contacta em caso de problemas ou se tiveres alguma sugestão.</p>
							<p>André Ferreira</br>ei10004@fe.up.pt</p>
							<p>Diogo Teixeira</br>diogo.teixeira@fe.up.pt</p>
							<p>Francisco Pinto</br>francisco.pinto@fe.up.pt</p>
							<p>Pedro Machado</br>machado.pedro@fe.up.pt</p>
						</div>
					</div>
				</div>
			</div>	
		</div>

		<div id="canvas">
		</div>
	</body>
</html>
