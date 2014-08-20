<!doctype html>
<html>
  <head>
    <script src='https://cdn.firebase.com/js/client/1.0.11/firebase.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
    <link href="includes/styles.css" rel="stylesheet" type="text/css" />
    <link href="includes/text.css" rel="stylesheet" type="text/css" />
    <link href="includes/reset.css" rel="stylesheet" type="text/css" />
    <link href="includes/960_12_col.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Dosis:400,700' rel='stylesheet' type='text/css'>
  </head>
  <body>
      <a href="signOut.php" id="signOut"> Sign out? </a><br>
      <div id ="words">Chatroom</div>
      <?php 
    session_start();
        ?>
       <div id ="curUser" hidden><?php echo  $_SESSION['id']; ?></div>
    <div id='messagesDiv'></div>
    <div id="messageInputBox">
    <input type='text' id='messageInput' placeholder='Message'>
    </div>
    <script>
            var curUser = document.getElementById("curUser").innerHTML;
                function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
      var myDataRef = new Firebase('https://iicnlgcro07.firebaseio-demo.com/');
      var getParam = getParameterByName("target");
      $('#messageInput').keypress(function (e) {
        if (e.keyCode == 13) {
          var text = $('#messageInput').val();
          console.log(curUser);
          myDataRef.push({"person_1": curUser, "person_2": getParam, "message": text});
          $('#messageInput').val('');
        }
      });
      myDataRef.on('child_added', function(snapshot) {
        var message = snapshot.val();
        if((message.person_1 == curUser && message.person_2 == getParam) || (message.person_2 == curUser && message.person_1 == getParam)){
            displayChatMessage(message.person_1, message.message);
        }
      });
      function displayChatMessage(name, text) {
        $('<div/>').text(text).prepend($('<em/>').text(name+': ')).appendTo($('#messagesDiv'));
        $('#messagesDiv')[0].scrollTop = $('#messagesDiv')[0].scrollHeight;
      };
    </script>
  </body>
</html>