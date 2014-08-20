<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="includes/styles.css" rel="stylesheet" type="text/css" />
        <link href="includes/text.css" rel="stylesheet" type="text/css" />
        <link href="includes/reset.css" rel="stylesheet" type="text/css" />
        <link href="includes/960_12_col.css" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Dosis:400,700' rel='stylesheet' type='text/css'>
    </head>
    <body>
        
        <a href="signOut.php" id="signOut"> Sign out? </a><br>
        <?php
        session_start();
        if (isset($_SESSION["id"])){
            //stuff
          }  else {
              header('location: login.php');
          }
        ?>
        <script>
            var curUser = "<?php  echo $_SESSION['id']?>";
        </script>
        
        <div id ="words">People Online</div>
        <div id ="messagebox"></div>
        <script type="text/javascript" src="message.js"></script>
    </body>
</html>