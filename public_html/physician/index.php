<?php
   include '../config.php';
   session_start(); 
   ?>
<!doctype html>
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
      <link href="../css/d3.css" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css" rel="stylesheet">
      <link href="sticky-footer.css" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link href="../css/j3.css" rel="stylesheet">
    <script type="text/javascript" src="../js/spiralVis.js"></script>      
     		<script src="../js/d3.v3.min.js"></script>
 
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
   </head>
   <body class="d-flex flex-column h-100">
      <!-- Begin page content -->
      <main role="main" class="flex-shrink-0">
         <div class="container">
            <h2 class="mt-5">Physician profile</h2>
            <p class="lead">
               <?php if (isset($_SESSION['FBID'])): ?>      <!--  After user login  -->
               <?php
                  $conn = OpenCon();
                  $sql1 = "SELECT User.username, User.email, Organization.name
                  FROM User
                  	LEFT JOIN Organization ON User.Organization = Organization.organizationID
                  WHERE User.username = 'doc'";
                  $result1 = $conn->query($sql1);
                  
                  if ($result1->num_rows > 0) {
                      // output data of each row
                      while($row = $result1->fetch_assoc()) {
                          echo "Hello " . $row["username"]. "! Your details are as follow, email: " . $row["email"]. " and organization: " . $row["name"]."<br><br>";
                      }
                  } else {
                      echo "0 results";
                  }
                  ?>
                  <a href="logout.php">Logout</a>
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
                              ?></p>
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                           <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"><i class="fa fa-plus"></i>Patient Notes and RAW Data</button>
                        </h2>
                     </div>
                     <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                           <div class="row">
                              <div class="col">
                                 <p class="lead"><?php
                                    $sql2 = "SELECT Therapy.User_IDpatient, Test.testID, Test.dateTime, Test.Therapy_IDtherapy, Test_Session.test_SessionID, Test_Session.Test_IDtest, Test_Session.DataURL, Note.noteID, Note.Test_Session_IDtest_session, Note.note
                                      FROM Therapy
                                        LEFT JOIN Test ON Test.Therapy_IDtherapy = Therapy.therapyID
                                        LEFT JOIN Test_Session ON Test_Session.Test_IDtest = Test.testID
                                        LEFT JOIN Note ON Note.Test_Session_IDtest_session = Test_Session.test_SessionID
                                      WHERE Therapy.User_IDpatient = 3";
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
                                 <p class="lead"><?php
                                    $sql3 = "SELECT Therapy.User_IDpatient, Test.testID, Test.dateTime, Test.Therapy_IDtherapy, Test_Session.test_SessionID, Test_Session.Test_IDtest, Test_Session.DataURL, Note.noteID, Note.Test_Session_IDtest_session, Note.note
                                      FROM Therapy
                                        LEFT JOIN Test ON Test.Therapy_IDtherapy = Therapy.therapyID
                                        LEFT JOIN Test_Session ON Test_Session.Test_IDtest = Test.testID
                                        LEFT JOIN Note ON Note.Test_Session_IDtest_session = Test_Session.test_SessionID
                                      WHERE Therapy.User_IDpatient = 4";
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
                           </div>
                        </div>
                        
                     </div>
                     
                  </div>
               </div>
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
            
 
 
            
            </br>
            
            <?php else: ?>     <!-- Before login --> 
            <p class="lead">Click the "Sign in with Facebook" button to login as physician. After successful login the patient's details and data will be available.</p>
            <p class="lead">All data are fetched from the DB provided for this assignment with queries.</p>
            <a href="fbconfig.php" class="btn btn-social btn-facebook"><i class="fa fa-facebook"></i> Sign in with <b>Facebook</b></a>
            <?php endif ?>
            </p>
         </div>
      </main>
      <footer class="footer mt-auto py-3">
         <div class="container">
            <span class="text-muted">Login as <a href="../researcher/">Researcher</a> or <a href="https://nmsproject.000webhostapp.com">Patient</a></span>
         </div>
      </footer>
   </body>
</html>