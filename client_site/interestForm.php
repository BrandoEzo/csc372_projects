<?php
//Brandon Ezovski, 3/13/2026, new page featuring an interest form for assigmnent 7. Stores some data in cookies and other in session storage, see code comments for details.

    session_start();
    include 'php/validateForm.php';
    
    //handle clearing session
    if(isset($_POST["clear"]) && $_POST["clear"] == "Clear Session") {
        session_destroy();
        session_start();
    }
    
    //array to hold initial values for each form control
    $responses = array(
        "fname" => isset($_COOKIE["fname"]) ? htmlspecialchars($_COOKIE["fname"]) : "",
        "lname" => isset($_COOKIE["lname"]) ? htmlspecialchars($_COOKIE["lname"]) : "",
        "age" => $_SESSION["age"] ?? "",
        "email" => isset($_COOKIE["email"]) ? htmlspecialchars($_COOKIE["email"]) : "",
        "student" => $_SESSION["student"] ?? "",
        "event" => $_SESSION["event"] ?? array(),
        "hear" => $_SESSION["hear"] ?? ""
    );
    //array to hold error messages for each control, initialized as blank
    $errorMsgs = array(
        "fname" => "",
        "lname" => "",
        "age" => "",
        "email" => "",
        "student" => "",
        "event" => "",
        "hear" => ""
    );
    //variable for success/error messages, initialized as blank
    $message = "";
    //check whether the form has been submitted using the appropriate method
    if(isset($_POST["submit"]) && $_POST["submit"] == "Submit") {
        $responses["fname"] = htmlspecialchars($_POST["fname"] ?? "");
        $responses["lname"] = htmlspecialchars($_POST["lname"] ?? "");
        $responses["age"] = htmlspecialchars($_POST["age"] ?? "");
        $responses["email"] = htmlspecialchars($_POST["email"] ?? "");
        $responses["student"] = $_POST["student"] ?? "";
        
        // really dumb workaround I had to do because it wasn't saving the checkbox responses on reload/submit. Took me way too much time and googling :(
        $events = array();
        $raw = file_get_contents('php://input');
        // Parse the raw form data to get all event values
        if(preg_match_all('/event=([^&]+)/', $raw, $matches)) {
            $events = array_map('urldecode', $matches[1]);
        }
        $responses["event"] = !empty($events) ? $events : array();
        
        $responses["hear"] = htmlspecialchars($_POST["hear"] ?? "");
        //validate each input with corresponding function
        if(!checkName($responses["fname"])){
            $errorMsgs["fname"] = "First name must be between 2 and 50 characters.";
            $responses["fname"] = "";
        }
        if(!checkName($responses["lname"])){
            $errorMsgs["lname"] = "Last name must be between 2 and 50 characters.";
            $responses["lname"] = "";
        }
        if(!checkAge($responses["age"])){
            $errorMsgs["age"] = "Age must be a number between 10 and 120.";
            $responses["age"] = "";
        }
        if(!checkName($responses["email"])){
            $errorMsgs["email"] = "Email must be between 2 and 50 characters.";
            $responses["email"] = "";
        }
        if(!checkYesNo($responses["student"])){
            $errorMsgs["student"] = "Please select whether you are a URI student.";
            $responses["student"] = "";
        }
        if(!checkText($responses["hear"])){
            $errorMsgs["hear"] = "Response must be between 2 and 100 characters.";
            $responses["hear"] = "";
        }
        //combine all error messages using implode() to determine whether the form is valid
        $allErrors = implode(" ", array_filter($errorMsgs));
        if(empty($allErrors)){
            $message = "Thank you for your submission!";
            //store name and email in cookies
            setcookie("fname", $responses["fname"], time() + (86400 * 30));
            setcookie("lname", $responses["lname"], time() + (86400 * 30));
            setcookie("email", $responses["email"], time() + (86400 * 30));
            //store age, student, event, and hear in session
            $_SESSION["age"] = $responses["age"];
            $_SESSION["student"] = $responses["student"];
            $_SESSION["event"] = $responses["event"];
            $_SESSION["hear"] = $responses["hear"];
        }
        else{
            $message = "Please correct the following errors: " . $allErrors;
        }
        //display message at top of page (done in html header section)
    }
    

?>


<!DOCTYPE html>

<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URI Gaming Club Interest Form</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
  
    <!--Nav Bar-->
    <div class="header">
		<a class="link" href="homepage.html"><img id="logo" src="images/logo.png" alt="URI Gaming Club Logo" fetchpriority="high" width="192" height="108"></a>
		<div class="header-right" >
            <a class="link" href="homepage.html">Home</a>
            <a class="link" href="eventsPage.php">Events</a>
            <a class="link" href="calendar.html">Calendar</a>
            <a class="active" href="interestForm.php">Interest Form</a>
        </div>
    </div>

    <h1>URI Gaming Club Interest Form</h1>
    <p class="center">Thank you for expressing interest in joining our club! Please fill out the form below:</p>
    <div class="left-col">
        
        <div class="card">
            <h2><?php echo $message; ?></h2>
            <form action="" method="POST">
                <label for="fname">First name:</label><br>
                <input type="text" id="fname" name="fname" value="<?php echo $responses["fname"]; ?>"><br>
                <br>
                <label for="lname">Last name:</label><br>
                <input type="text" id="lname" name="lname" value="<?php echo $responses["lname"]; ?>"><br>
                <br>
                <label for="age">Age:</label><br>
                <input type="number" id="age" name="age" value="<?php echo $responses["age"]; ?>"><br>
                <br>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" value="<?php echo $responses["email"]; ?>"><br>
                <br>
                <p>Are you currently a URI Student?</p>
                <input type="radio" id="yes" name="student" value="Yes" <?php if($responses["student"] == "Yes") echo "checked"; ?>>
                <label for="yes">Yes</label><br>
                <input type="radio" id="no" name="student" value="No" <?php if($responses["student"] == "No") echo "checked"; ?>>
                <label for="no">No</label><br>
                <br>
                <p>What events are you interested in?</p>
                <input type="checkbox" id="tournament" name="event" value="tournament" <?php if(is_array($responses["event"]) && in_array("tournament", $responses["event"])) echo "checked"; ?>>
                <label for="tournament">Competitive Tournaments (Weekly or Monthly)</label><br>
                <input type="checkbox" id="gameNight" name="event" value="gameNight" <?php if(is_array($responses["event"]) && in_array("gameNight", $responses["event"])) echo "checked"; ?>>
                <label for="gameNight">Weekly Game Night</label><br>
                <input type="checkbox" id="room" name="event" value="room" <?php if(is_array($responses["event"]) && in_array("room", $responses["event"])) echo "checked"; ?>>
                <label for="room">Just Hanging Out In The Club Room</label><br>
                <input type="checkbox" id="other" name="event" value="other" <?php if(is_array($responses["event"]) && in_array("other", $responses["event"])) echo "checked"; ?>>
                <label for="other">Other</label><br>
                <br>
                <label for="hear">How did you hear about us?</label><br>
                <textarea id="hear" name="hear"><?php echo $responses["hear"]; ?></textarea><br>
                <br>
                <input type="submit" name="submit" value="Submit">
            </form>
            <form action="" method="POST" style="display:inline;">
                <input type="submit" name="clear" value="Clear Session">
            </form>
        </div>
    </div>
  </body>
</html>
