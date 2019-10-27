<?php
   //start session
   
   session_start();
   //connect to local databse
   include_once("../config.php");
   //connect to Twitter API
   include_once("config.php");
   include_once("inc/twitteroauth.php");

   ?>
<html lang="en" class="h-100">
   <head>
   
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="Nikolaos Mendrinos, Konstantinos Kousoulidis">
      <title>E-Health App</title>
      <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sticky-footer/">
      <!-- Bootstrap core CSS -->
      <link href="../css/bootstrap.css" rel="stylesheet">
      <link href="../css/mycustom.css" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
          <link href="../css/j3.css" rel="stylesheet">
    <script type="text/javascript" src="../js/spiralVis.js"></script>      
     		<script src="../js/d3.v3.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>			
			
			
      <script>
         $(document).ready(function(){
             // Add minus icon for collapse element which is open by default
             $(".collapse.show").each(function(){
             	$(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
             });
             
             // Toggle plus minus icon on show hide of collapse element
             $(".collapse").on('show.bs.collapse', function(){
             	$(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
             }).on('hide.bs.collapse', function(){
             	$(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
             });
         });
      </script>
	  	<style>
		html, body {
			height: 100%;
			margin: 0;
		}
		#map {
			width: 100%;
			height: 400px;
		}
	</style>
   </head>
   <body class="d-flex flex-column h-100">
      <!-- Begin page content -->
      <main role="main" class="main">
         <div class="container">
            <p class="lead"> 
            <div class="row">
               <div class="col-12">
                  <h2 class="mt-5">Researcher profile</h2>
                  <p class="lead">
                     <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'verified')
                        {
                                         
                             $conn = OpenCon();
                             $sql1 = "SELECT User.username, User.email, Organization.name
                             FROM User
                             	LEFT JOIN Organization ON User.Organization = Organization.organizationID
                             WHERE User.username = 'researcher'";
                             $result1 = $conn->query($sql1);
                        
                             if ($result1->num_rows > 0) 
                             {
                                 // output data of each row
                                 while($row = $result1->fetch_assoc()) {
                                     echo "Hello " . $row["username"]. "! Your details are as follow, email: " . $row["email"]. " and organizatiorn: " . $row["name"]."<br><br>"; 
                                    // <br>"."<br> Patient records:<br>"; 
                                    ?>
                                    <a href='logout.php'>Logout</a>
                  </p>
                  
            <div class="bs-example">
               <div class="accordion" id="accordionExample">
                  <div class="card">
                     <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                           <button type="button" class="btn btn-link lead" data-toggle="collapse" data-target="#collapseOne"><i class="fa fa-plus"></i> Patient Records</button>									
                        </h2>
                     </div>
                     <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                           <p class="lead"> <?php
                              $sql = "SELECT User.username, Therapy_List.therapyName, Medicine.medicineName, Therapy_List.Dosage FROM Role LEFT JOIN User ON User.Role_IDrole = Role.roleID , Therapy_List LEFT JOIN Medicine ON Therapy_List.Medicine_IDmedicine = Medicine.medicineID WHERE Role.roleID = 1";
                              $result = $conn->query($sql);
                              
                              if ($result->num_rows > 0) {
                                  // output data of each row
                                  while($row = $result->fetch_assoc()) {
                                      echo "Patient Name: " . $row["username"]. "<br>Therapy: " . $row["therapyName"]. "<br>Medicine Name: " . $row["medicineName"]. "<br>Dosage: " . $row["Dosage"]. "<br><br>";
                                  }
                              } else {
                                  echo "0 results";
                              }
                              //CloseCon($conn);
                              ?></p>                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                           <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"><i class="fa fa-plus"></i> Patient Notes and RAW Data</button>
                        </h2>
                     </div>
                     <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                           <div class="row">			

						   <?php

								// php code to Update data from mysql database Table

								if(isset($_POST['update']))
								{
									
								   $hostname = "localhost";
								   $username = "id11299704_root";
								   $password = "nikos";
								   $databaseName = "id11299704_ehealth";
								   
								   $connect = mysqli_connect($hostname, $username, $password, $databaseName);
								   
								   // get values form input text and number
								   
								   $id = $_POST['id'];
								   $note = $_POST['note'];
										   
								   // mysql query to Update data
								   $query = "UPDATE `Note` SET `note` = '".$note."' WHERE `Note`.`noteID` = $id";
											   
								   $result = mysqli_query($connect, $query);
								   
								   if($result)
								   {
									  echo '<meta http-equiv=Refresh content="0;url=index.php?reload=1">';
									
								   }else{
									   echo 'Data Not Updated';
								   }
								   mysqli_close($connect);

								}

								?>
						   
						   
						   
                              <div class="col">
                                 <p class="lead"><?php
                                    $sql2 = "SELECT Therapy.User_IDpatient, Test.testID, Test.dateTime, Test.Therapy_IDtherapy, Test_Session.test_SessionID, Test_Session.Test_IDtest, Test_Session.DataURL, Note.noteID, Note.Test_Session_IDtest_session, Note.note
                                      FROM Therapy
                                        LEFT JOIN Test ON Test.Therapy_IDtherapy = Therapy.therapyID
                                        LEFT JOIN Test_Session ON Test_Session.Test_IDtest = Test.testID
                                        LEFT JOIN Note ON Note.Test_Session_IDtest_session = Test_Session.test_SessionID
                                      WHERE Therapy.User_IDpatient = 3 AND NoteID = 1";
                                    $result1 = $conn->query($sql2);
                                    
                                    if ($result1->num_rows > 0) {
                                        // output data of each row
                                        while($row = $result1->fetch_assoc()) {
                                            echo "Patient UID: ". $row["User_IDpatient"]." <br>Test ID: ". $row["testID"]." <br>Date & Time: ". $row["dateTime"]." <br>Therapy ID: ". $row["Therapy_IDtherapy"]." <br>Session ID: ". $row["test_SessionID"]." <br>Test ID: ". $row["Test_IDtest"]."<br>Data: <a href=".$row['DataURL'].">Download</a> <br> Note ID: ". $row["noteID"]." <br>Test Session ID: ". $row["Test_Session_IDtest_session"]." <br>Note: ". $row["note"]."<br><br>";
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    //CloseCon($conn);
                                    ?></p>
                              </div>
                              <div class="col">												  
                                 <p class="lead">								 <?php
                                    $sql3 = "SELECT Therapy.User_IDpatient, Test.testID, Test.dateTime, Test.Therapy_IDtherapy, Test_Session.test_SessionID, Test_Session.Test_IDtest, Test_Session.DataURL, Note.noteID, Note.Test_Session_IDtest_session, Note.note
                                      FROM Therapy
                                        LEFT JOIN Test ON Test.Therapy_IDtherapy = Therapy.therapyID
                                        LEFT JOIN Test_Session ON Test_Session.Test_IDtest = Test.testID
                                        LEFT JOIN Note ON Note.Test_Session_IDtest_session = Test_Session.test_SessionID
                                     WHERE Therapy.User_IDpatient = 3 AND NoteID = 2";
                                    $result1 = $conn->query($sql3);
                                    
                                    if ($result1->num_rows > 0) {
                                        // output data of each row
                                        while($row = $result1->fetch_assoc()) {
                                            echo "Patient UID: ". $row["User_IDpatient"]." <br>Test ID: ". $row["testID"]." <br>Date & Time: ". $row["dateTime"]." <br>Therapy ID: ". $row["Therapy_IDtherapy"]." <br>Session ID: ". $row["test_SessionID"]." <br>Test ID: ". $row["Test_IDtest"]."<br>Data: <a href=".$row['DataURL'].">Download</a> <br> Note ID: ". $row["noteID"]." <br>Test Session ID: ". $row["Test_Session_IDtest_session"]." <br>Note: ". $row["note"]."<br><br>";
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    CloseCon($conn);
                                    ?></p>
                              </div>
							<div class="col-12">
						   <form action="./index.php" method="post">
										Update Note (NoteID 1 or 2) : <input type="text" name="id" required>

										New note : <input type="text" name="note" required> 

										<input type="submit" name="update" value="Update Data">
							</form>
							</div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
               </div>
               <div class="col-12">
			   
				<div id='map'></div>

				<script src="../js/sample-geojson.js" type="text/javascript"></script>

				<script>
					var map = L.map('map').setView([57.3365,12.5164], 4);

					L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
						maxZoom: 18,
						attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
							'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
							'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
						id: 'mapbox.light'
					}).addTo(map);

					var patientmarker = L.icon({
						iconUrl: '../img/markerpng.png',
						iconSize: [32, 37],
						iconAnchor: [16, 37],
						popupAnchor: [0, -28]
					});

					function onEachFeature(feature, layer) {
						var popupContent = "<p>Patient details: ";

						if (feature.properties && feature.properties.popupContent) {
							popupContent += feature.properties.popupContent;
						}

						layer.bindPopup(popupContent);
					}

					L.geoJSON([patient], {

						style: function (feature) {
							return feature.properties && feature.properties.style;
						},

						onEachFeature: onEachFeature,

						pointToLayer: function (feature, latlng) {
							return L.marker(latlng, {icon: patientmarker});
						},

						onEachFeature: onEachFeature
					}).addTo(map);

				</script> 			   
			   
			   
                  </br></br>
              <h2 class="lead"><strong>Patient Data Visualization</strong></h> 
                <p class="lead">
                    <ul>
                  <li>Blue line - drawing speed (distance over change in time)</li>
                  <li>Orange line - displacement around the ideal trajectory (change in radius)</li>
                </ul></p>
               	<div id="graph" class="aGraph"></div>

            	<script type="text/javascript">
                  renderVis("../data/data4.csv");
            	</script>

                </br>
                 <div id="control" class="aGraph">

                <p class="lead">Select different experiment: 
                <select class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" name="aa" onchange="reload(this.value)"> 
                <option value="../data/data1.csv">Patient 1 exp. 1</option>
                <option value="../data/data2.csv">Patient 1 exp. 2</option>
                <option value="../data/data3.csv">Patient 1 exp. 3</option>
                <option value="../data/data4.csv">Patient 1 exp. 4</option>
                <option value="../data/data5.csv">Patient 2 exp. 5</option>
                <option value="../data/data6.csv">Patient 2 exp. 6</option>
                </select> </p>
            </div>         
                   
                   
                   
               </div>
               <div class="col-12">	<?php
                  echo "<h2 class='mt-5'>".'My feed'."</h2>";
                  $rss = new DOMDocument();
                  $rss->load('https://www.news-medical.net/tag/feed/Parkinsons-Disease.aspx');
                  $feed = array();
                  foreach ($rss->getElementsByTagName('item') as $node) {
                  $item = array (
                  	'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                  	'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                  	'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                  	'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
                  	);
                  array_push($feed, $item);
                  }
                  $limit = 10;
                  for($x=0;$x<$limit;$x++) {
                  $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
                  $link = $feed[$x]['link'];
                  $description = $feed[$x]['desc'];
                  $date = date('l F d, Y', strtotime($feed[$x]['date']));
                  echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
                  echo '<small><em>Posted on '.$date.'</em></small></p>';
                  echo '<p>'.$description.'</p>';
                  }
                  
                        
                        
                  
                  }
                  } 
                  else 
                  {
                    echo "0 results";
                  }
                  
                  }
                  else
                  {
                  //Display login button
                  echo '<p class="lead">'."Login with Twitter.".'</p>';
                  
                  echo '<a href="./process.php" class="btn btn-social btn-twitter">'.'<i class="fa fa-twitter"></i>'." Sign in with Twitter".'</a>';
                  
                  }
                  ?>
                  </br>
               </div>
            </div>
         </div>
      </main>
      <footer class="footer mt-auto py-3">
         <div class="container">
            <span class="text-muted">Login as <a href="../physician/">Physician</a> or <a href="https://nmsproject.000webhostapp.com">Patient</a></span>
         </div>
      </footer>
   </body>
</html>