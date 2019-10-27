<?php
   require_once('settings.php');
   require_once('google-login-api.php');
   
   // Google passes a parameter 'code' in the Redirect Url
   if(isset($_GET['code'])) {
   	try {
   		$gapi = new GoogleLoginApi();
   		
   		// Get the access token 
   		$data = $gapi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);
   		
   		// Get user information
   		$user_info = $gapi->GetUserProfileInfo($data['access_token']);
   	}
   	catch(Exception $e) {
   		//echo $e->getMessage();
   		//header("Location: https://nmsproject.000webhostapp.com"); 
   		//exit();
   	}
   }
   else
   {
       	header("Location: https://nmsproject.000webhostapp.com"); 
   		exit(); 
   }
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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="sticky-footer.css" rel="stylesheet">	  	 
	  
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script>   

	  <link rel="stylesheet" type="text/css" href="https://nmsproject.000webhostapp.com/css/chart.css">	
   </head>
   <body class="d-flex flex-column h-100">
      <!-- Begin page content -->
      <main role="main" class="flex-shrink-0">
         <div class="container">
            <h2 class="mt-5">Welcome to your profile.</h2>
            </br>
            <p class="lead"> <?php
               include '../config.php';
               $conn = OpenCon();
               $sql1 = "SELECT User.username, User.email, Organization.name
               FROM User
               	LEFT JOIN Organization ON User.Organization = Organization.organizationID
               WHERE User.username = 'patient1'";
               $result1 = $conn->query($sql1);
               
               if ($result1->num_rows > 0) {
                   // output data of each row
                   while($row = $result1->fetch_assoc()) {
                       echo "Hello " . $row["username"]."!</br> Your details are as follow, email: " . $row["email"]. " and organization: " . $row["name"]."";
                   }
               } else {
                   echo "0 results";
               }
               ?>
               </br>
               </br>
            </p>
            <p class="lead">Material:</p>
            <p> 
               <iframe width="920" height="450" src="https://www.youtube.com/embed/1yCgLythe00" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>        
            </p>							
			<p class="lead">Exercise session (user data)<p>		
			
			<canvas id="myChart" width="1600" height="900"></canvas>
			
            <p class="lead"><a href="../index.php">Logout</a></p>
         </div>
      </main>
      <footer class="footer mt-auto py-3">
         <div class="container">
            <span class="text-muted">Partner login: <a href="../physician/">Physician</a> or <a href="../researcher/">Researcher</a></span>
         </div>
      </footer>
   </body>
   <script src="https://nmsproject.000webhostapp.com/js/script.js"></script>
</html>