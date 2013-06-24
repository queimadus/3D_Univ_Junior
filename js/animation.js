function initAnimation() {

	// Fallback image style
	var style = "background: white url('img/fallback.png');";
		
	if (! Detector.webgl) {
		$('div#canvas').attr('style', style);
	} else {
		try {
			// Canvas definitions
			var width = 1040;
			var height = 400;
			var canvasSelector = 'div#canvas';
			if ($(canvasSelector).length <= 0)
				return;

			// Renderer
			var renderer = new THREE.WebGLRenderer({antialias: true});
			renderer.setSize(width, height);
			$(canvasSelector).remove('canvas');
			$(canvasSelector).append(renderer.domElement);
			renderer.shadowMapEnabled = true;
			renderer.setClearColorHex(0x000000, 0.0);
			renderer.clear();
		
			// Scene
			var scene = new THREE.Scene();

			// Camera
			var camera = new THREE.PerspectiveCamera(20, width/height, 1, 10000);
			camera.position.z = 0;
			camera.position.x = 300;
			camera.position.y = 400;
			scene.add(camera);
		
			// Ambient light
			var ambientLight = new THREE.AmbientLight(0x585858);
			scene.add(ambientLight);

			// Spotlight
			var light = new THREE.SpotLight();
			light.position.set( 170, 330, -160 );
			light.castShadow = false;
			scene.add(light);

			// Materials
			var redWireMat = new THREE.MeshBasicMaterial({color: 0xd84f56, wireframe: true, transparent: true});
			var greenWireMat = new THREE.MeshBasicMaterial({color: 0xb0d353, wireframe: true, transparent: true});
			var blueWireMat = new THREE.MeshBasicMaterial({color: 0x5295c9, wireframe: true, transparent: true});
			var orangeWireMat = new THREE.MeshBasicMaterial({color: 0xe49550, wireframe: true, transparent: true});
			var redShadowMat = new THREE.MeshLambertMaterial({color: 0x262626});
			var greenShadowMat = new THREE.MeshLambertMaterial({color: 0x262626});
			var blueShadowMat = new THREE.MeshLambertMaterial({color: 0x262626});
			var orangeShadowMat = new THREE.MeshLambertMaterial({color: 0x262626});

			// Cube
			var cubeWire = new THREE.Mesh(new THREE.CubeGeometry(50,50,50), redWireMat);
			cubeWire.castShadow = false;
			cubeWire.receiveShadow = false;
			scene.add(cubeWire);
			var cube = new THREE.Mesh(new THREE.CubeGeometry(45,45,45), redShadowMat);
			cube.castShadow = false;
			cube.receiveShadow = false;
			scene.add(cube);
			var fastCube = false;

			// Cylinder
			var cylinderWire = new THREE.Mesh(new THREE.CylinderGeometry(25, 25, 50, 16, 5, false), greenWireMat);
			cylinderWire.castShadow = false;
			cylinderWire.receiveShadow = false;
			scene.add(cylinderWire);
			var cylinder = new THREE.Mesh(new THREE.CylinderGeometry(22.5, 22.5, 45, 16, 5, false), greenShadowMat);
			cylinder.castShadow = false;
			cylinder.receiveShadow = false;
			scene.add(cylinder);
			var fastCylinder = false;
		
			// Cone
			var coneWire = new THREE.Mesh(new THREE.CylinderGeometry(0, 25, 50, 16, 5, false), blueWireMat);
			coneWire.castShadow = false;
			coneWire.receiveShadow = false;
			scene.add(coneWire);  
			var cone = new THREE.Mesh(new THREE.CylinderGeometry(0, 22.5, 45, 16, 5, false), blueShadowMat);
			cone.castShadow = false;
			cone.receiveShadow = false;
			scene.add(cone);
			var fastCone = false;

			// Octahedron
			var octaWire = new THREE.Mesh(new THREE.OctahedronGeometry(40, false), orangeWireMat);
			octaWire.castShadow = false;
			octaWire.receiveShadow = false;
			scene.add(octaWire);  
			var octahedron = new THREE.Mesh(new THREE.OctahedronGeometry(35, false), orangeShadowMat);
			octahedron.castShadow = false;
			octahedron.receiveShadow = false;
			scene.add(octahedron);
			var fastOctahedron = false;

			// FPS values (counters)
			var fps = 0;
			var now = 0;
			var lastUpdate = (new Date)*1 - 1;
			var fpsTimeout = 0;
			// Minimizes FPS flutuation (higher => less flutuation)
			var fpsFilter = 50;
			// If true page goes into fallback mode
			var fallback = false;
			// If FPS go below this value, fallback is triggered
			var fpsMin = 20.0;
			// Sets how much time the FPS must be below fpsMin before trigger
			var fpsMinTimeout = 5000;
			// Time between every FPS sample
			var fpsSampleTime = 1000;

			// Acceleration variables
			var timespanToNextAccel = 2500;
			var timespanToStopAccel = 0;
			var accelDuration = 2500;
			var accelTimespanDiff = 2500;

			// Fallback callback
			function checkFallback() {
				if(fps != 0 && fps < fpsMin) {
					fpsTimeout += fpsSampleTime;
					if(fpsTimeout >= fpsMinTimeout)
						fallback = true;
				} else
					fpsTimeout = 0;
			}

			// Animation callback
			function animate(t) {

				// Fallback 
				if(fallback) {
					$('canvas').remove();
					$('body').attr('style', style);
					return;
				}

				// FPS calculation
				var thisFrameFPS = 1000 / ((now=new Date) - lastUpdate);
				fps += (thisFrameFPS - fps) / fpsFilter;
				var timespan = now - lastUpdate;
				lastUpdate = now;

				var rot1 = t/4000;
				var rot2 = t/3000;
				var rot3 = t/5000;

				// Acceleration processing
				if(fastOctahedron || fastCone || fastCylinder || fastCube) {
					timespanToStopAccel -= timespan;
					if(timespanToStopAccel <= 0) {
						fastCube = false;
						fastCylinder = false;
						fastCone = false;
						fastOctahedron = false;
						timespanToNextAccel = accelTimespanDiff;
					}
				} else if(timespanToNextAccel <= 0) {
					var chosen = Math.ceil(Math.random()*4);
					if(chosen == 1)
						fastCube = true;
					else if(chosen == 2)
						fastOctahedron = true;
					else if(chosen == 3)
						fastCone = true;
					else if(chosen == 4)
						fastCylinder = true;
					timespanToStopAccel = accelDuration;
				} else {
					timespanToNextAccel -= timespan;
				}
			
				// Cube animation
				if(fastCube) {
					cube.position.x = 30; cubeWire.position.x = 30;
					cube.position.z = 150; cubeWire.position.z = 150;
					cube.rotation.x = rot1 * 25; cubeWire.rotation.x = rot1 * 30;
					cube.rotation.y = rot3 * 25; cubeWire.rotation.y = rot3 * 30;
					cube.rotation.z = rot2 * 25; cubeWire.rotation.z = rot2 * 30;
				}
				else {
					cube.position.x = 30; cubeWire.position.x = 30;
					cube.position.z = 150; cubeWire.position.z = 150;
					cube.rotation.x = rot1; cubeWire.rotation.x = rot1;
					cube.rotation.y = rot3; cubeWire.rotation.y = rot3;
					cube.rotation.z = rot2; cubeWire.rotation.z = rot2;
				}

				// Cylinder animation
				if(fastCylinder) {
					cylinder.position.x = 30; cylinderWire.position.x = 30;
					cylinder.position.z = 50; cylinderWire.position.z = 50;
					cylinder.rotation.x = -rot2 * 25; cylinderWire.rotation.x = -rot2 * 25;
					cylinder.rotation.y = -rot1 * 25; cylinderWire.rotation.y = -rot1 * 25;
					cylinder.rotation.z = rot3 * 25; cylinderWire.rotation.z = rot3 * 25;
				}
				else {
					cylinder.position.x = 30; cylinderWire.position.x = 30;
					cylinder.position.z = 50; cylinderWire.position.z = 50;
					cylinder.rotation.x = -rot2; cylinderWire.rotation.x = -rot2;
					cylinder.rotation.y = -rot1; cylinderWire.rotation.y = -rot1;
					cylinder.rotation.z = rot3; cylinderWire.rotation.z = rot3;
				}

				// Cone animation
				if(fastCone) {
					cone.position.x = 30; coneWire.position.x = 30;
					cone.position.z = -50; coneWire.position.z = -50;
					cone.rotation.x = rot1 * 25; coneWire.rotation.x = rot1 * 25;
					cone.rotation.y = rot2 * 25; coneWire.rotation.y = rot2 * 25;
					cone.rotation.z = -rot3 * 25; coneWire.rotation.z = -rot3 * 25;
				}
				else {
					cone.position.x = 30; coneWire.position.x = 30;
					cone.position.z = -50; coneWire.position.z = -50;
					cone.rotation.x = rot1; coneWire.rotation.x = rot1;
					cone.rotation.y = rot2; coneWire.rotation.y = rot2;
					cone.rotation.z = -rot3; coneWire.rotation.z = -rot3;
				}

				// Octahedron animation
				if(fastOctahedron) {
					octahedron.position.x = 30; octaWire.position.x = 30;
					octahedron.position.z = -150; octaWire.position.z = -150;
					octahedron.rotation.x = rot2 * 25; octaWire.rotation.x = rot2 * 30;
					octahedron.rotation.y = -rot1 * 25; octaWire.rotation.y = -rot1 * 30;
					octahedron.rotation.z = -rot3 * 25; octaWire.rotation.z = -rot3 * 30;
				}
				else {
					octahedron.position.x = 30; octaWire.position.x = 30;
					octahedron.position.z = -150; octaWire.position.z = -150;
					octahedron.rotation.x = rot2; octaWire.rotation.x = rot2;
					octahedron.rotation.y = -rot1; octaWire.rotation.y = -rot1;
					octahedron.rotation.z = -rot3; octaWire.rotation.z = -rot3;
				}

				// Scene refresh
				camera.lookAt(scene.position);
				renderer.render(scene, camera);
				window.requestAnimationFrame(animate, renderer.domElement);
			};

			// Start animation
			setInterval(checkFallback, fpsSampleTime);
			animate(new Date().getTime());
		} catch (ex) {
			$('div#canvas').attr('style', style);
		}
	}
}
