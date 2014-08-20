<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Connections</title>
 
        <link href="includes/styles.css" rel="stylesheet" type="text/css" />
        <link href="includes/text.css" rel="stylesheet" type="text/css" />
        <link href="includes/reset.css" rel="stylesheet" type="text/css" />
        <link href="includes/960_12_col.css" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
     <body> 
                    <table>
                    <tr><td>
                    <div id="makeAccount" class="grid_4" align="center">
                        <strong><div id="errorMessage"><?php
                             
                              if (isset($_SESSION["error"])){
                                    echo "Error! Fill out the entire form please! ";
                                    unset($_SESSION["error"]);
                             } 
                             
                             if (isset($_SESSION["errorCheck"])){
                                    echo "Please choose another username that is unique";
                                    unset($_SESSION["errorCheck"]);
                             }
                             
                             if (isset($_SESSION["errorCheck2"])){
                                    echo "Please enter a unique email";
                                    unset($_SESSION["errorCheck2"]);
                             }
                         ?></div></strong><br>
                        <form method="post" action="newCheck.php">
                            <table>
                            <tr><td><div id="loginWords">Create</div></td></tr>
                            <tr><td><input name="username" type="text" id="text" placeholder ="Desired Username"> </td></tr>
                            <tr><td><input name="password" type="password" id="mypassword" placeholder ="Desired Password"> </td></tr>
                            <tr><td><input type="submit" name="Submit" value="Create!"></td></tr>
                            <tr><td><a href="login.php" class="a-btn">Login Page</a></td></tr>
                            </table>
                        </form>
                   </div><!-- end of makeAccount -->
    </body>
</html>

