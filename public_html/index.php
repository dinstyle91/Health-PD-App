<?php
   require_once('./patient/settings.php');
   
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
      <link href="./css/bootstrap.css" rel="stylesheet">
      <link href="./css/mycustom.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="sticky-footer.css" rel="stylesheet">
   </head>
   <body class="d-flex flex-column h-100">
      <!-- Begin page content -->
      <main role="main" class="flex-shrink-0">
         <div class="container">
            <h2 class="mt-5">Welcome to e-Health</h2>
            <p class="lead">This APP is created with PHP, SQL, JS & Bootstrap.</p>
            <p class="lead">Please click the "Sign in with Google" button to login as patient. Links to login as partner (physician & researcher) are located on the footer.</p>
            <p> 
               <a href="<?= 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>" class="btn btn-danger"><i class="fa fa-google"></i> Sign in with <b>Google</b></a>
            </p>
         </div>
      </main>
      <footer class="footer mt-auto py-3">
         <div class="container">
            <span class="text-muted">Partner login: <a href="./physician/">Physician</a> or <a href="./researcher/">Researcher</a></span>
         </div>
      </footer>
   </body>
</html>