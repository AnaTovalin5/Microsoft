<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="includes/styles.css" rel="stylesheet" type="text/css" />
        <link href="includes/text.css" rel="stylesheet" type="text/css" />
        <link href="includes/reset.css" rel="stylesheet" type="text/css" />
        <link href="includes/960_12_col.css" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Dosis:400,700' rel='stylesheet' type='text/css'>
        <title>Connections</title>
    </head>
    <body>
            <div id="login" class="grid_4"><table>
                        <tr><td><div id="errorMessage">
                        <form method="post" action="loginCheck.php">
                            <strong><?php
                                 session_start();

                                  if (isset($_SESSION["errorWrong"])){
                                      if ($_SESSION["errorWrong"] == "error") {
                                        echo "This Username does not exist! "; 
                                        unset ($_SESSION["errorWrong"]);
                                      }
                                 }  else  if (isset($_SESSION["loginError"]) ){
                                        echo "This Password does not exist! ";
                                        unset ($_SESSION["loginError"]);
                                 } else if (isset($_SESSION["errorGone"])) {
                                     echo "Please fill out the entire form";
                                     unset ($_SESSION["errorGone"]);
                                 }

                             ?> </strong></div> </td> </tr>
                            <tr><td><div id="loginWords">Login</div></td></tr>
                            <tr><td><input name="username" type="text" id="text" placeholder ="Username"> </td></tr>
                            <tr><td><input name="mypassword" type="password" id="mypassword" placeholder ="Password"> </td></tr>
                            <tr><td><input type="submit" name="Submit" value="Login" id="loginButton"></td></tr> 
                            <tr><td><a href="newAccount.php" class="a-btn">New Account</a></td></tr>
                        </form>
                        </table>
    </body>
</html>
