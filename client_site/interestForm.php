<?php
//Brandon Ezovski, 3/13/2026, new page featuring an interest form for assigmnent 7. Stores some data in cookies and other in session storage, see code comments for details.
//Brandon Ezovski, 4/1/2026, updated to add data to mySQL database after form is submitted and validated
    session_start();
    include 'php/validateForm.php';
    include 'php/database-connection.php'; //this is commented out for now until I am on anything but school wifi
    
    //function to check whether an email already exists in the database, returns true if email exists and false if it doesn't
    function check_data(PDO $pdo, $email){
        $sql = "SELECT email FROM Feedback WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() !== false;
    }

    //function to insert data into database
    function post_data(PDO $pdo, $data) {
		                                                    // SQL query to retrieve event information based on the event ID
		$sql = "INSERT INTO Feedback
        (firstName, lastName, age, email, student, interestedTournaments, interestedGameNight, interestedClubroom, interestedOther, feedback) 
			VALUES (:fname, :lname, :age, :email, :student, :tournament, :gameNight, :room, :other, :hear)";
		pdo($pdo, $sql, [
			':fname' => $data['fname'],
			':lname' => $data['lname'],
			':age' => $data['age'],
			':email' => $data['email'],
			':student' => ($data['student'] == "Yes") ? 1 : 0,
			':tournament' => isset($data['event']) && in_array('tournament', $data['event']) ? 1 : 0,
			':gameNight' => isset($data['event']) && in_array('gameNight', $data['event']) ? 1 : 0,
			':room' => isset($data['event']) && in_array('room', $data['event']) ? 1 : 0,
			':other' => isset($data['event']) && in_array('other', $data['event']) ? 1 : 0,
			':hear' => $data['hear']
		]);
    }

    //function to update data in database if email already exists
    function update_data(PDO $pdo, $data) {
        $sql = "UPDATE Feedback SET firstName = :fname, lastName = :lname, age = :age, student = :student, interestedTournaments = :tournament, interestedGameNight = :gameNight, interestedClubroom = :room, interestedOther = :other, feedback = :hear WHERE email = :email";
        pdo($pdo, $sql, [
            ':fname' => $data['fname'],
            ':lname' => $data['lname'],
            ':age' => $data['age'],
            ':email' => $data['email'],
            ':student' => ($data['student'] == "Yes") ? 1 : 0,
            ':tournament' => isset($data['event']) && in_array('tournament', $data['event']) ? 1 : 0,
            ':gameNight' => isset($data['event']) && in_array('gameNight', $data['event']) ? 1 : 0,
            ':room' => isset($data['event']) && in_array('room', $data['event']) ? 1 : 0,
            ':other' => isset($data['event']) && in_array('other', $data['event']) ? 1 : 0,
            ':hear' => $data['hear']
        ]);
    }

    //function to delete data if user requests it
    function delete_data(PDO $pdo, $email){
        $sql = "DELETE FROM Feedback WHERE email = :email";
        pdo($pdo, $sql, [':email' => $email]);
    }

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
        //
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
            $errorMsgs["fname"] = "First name must be between 2 and 50 characters.<br>";
            $responses["fname"] = "";
        }
        if(!checkName($responses["lname"])){
            $errorMsgs["lname"] = "Last name must be between 2 and 50 characters.<br>";
            $responses["lname"] = "";
        }
        if(!checkAge($responses["age"])){
            $errorMsgs["age"] = "Age must be a number between 10 and 120.<br>";
            $responses["age"] = "";
        }
        if(!checkName($responses["email"])){
            $errorMsgs["email"] = "Email must be between 2 and 50 characters.<br>";
            $responses["email"] = "";
        }
        if(!checkYesNo($responses["student"])){
            $errorMsgs["student"] = "Please select whether you are a URI student.<br>";
            $responses["student"] = "";
        }
        if(!checkText($responses["hear"])){
            $errorMsgs["hear"] = "Response must be between 2 and 100 characters.<br>";
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
            //check if data has already been posted to prevent duplicate entries
            if(!check_data($pdo, $responses["email"])){
                //submit form to database using function
                post_data($pdo, $responses);
            }
            else{
                update_data($pdo, $responses);
            }
        }
        else{
            $message = "Please correct the following errors:<br>" . $allErrors;
        }
        //display message at top of page (done in html header section)
    }
    //handle feedback removal request
    $feedbackmessage = "";
    if(isset($_POST["remove"]) && $_POST["remove"] == "Remove Feedback"){
        $emailToRemove = htmlspecialchars($_POST["remove_email"] ?? "");
        if(check_data($pdo, $emailToRemove)){
            delete_data($pdo, $emailToRemove);
            $feedbackmessage = "Your feedback has been removed!";
        }
        else{
            $feedbackmessage = "No feedback found for that email address.";
        }
    }

?>


<!DOCTYPE html>

<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URI Gaming Club Feedback Form</title>
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
            <a class="active" href="feedbackForm.php">Feedback Form</a>
        </div>
    </div>

    <h1>URI Gaming Club Feedback Form</h1>
    <p class="center">We'd love to hear your thoughts about our club! Please fill out the form below:</p>
    <div class="left-col">
        
        <div class="card">
            <div class="<?php echo (!empty(trim($message))) ? 'special' : 'card'; ?>">
                <h2><?php echo (!empty(trim($message))) ? $message : 'Feedback Form'; ?></h2>
            </div>
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
                <label for="hear">Is there anything else you'd like to see from us?</label><br>
                <textarea id="hear" name="hear"><?php echo $responses["hear"]; ?></textarea><br>
                <br>
                <input type="submit" name="submit" value="Submit">
            </form>
            <form action="" method="POST" style="display:inline;">
                <input type="submit" name="clear" value="Clear Session">
            </form>
        </div>
        <div class="card">
            <h3>Feedback Removal Request</h3>
            <div class="<?php echo (!empty(trim($feedbackmessage))) ? 'special' : 'card'; ?>">
                <h4><?php echo (!empty(trim($feedbackmessage))) ? $feedbackmessage : "If you would like to have your feedback removed from our database, please enter your email address below and click the button:"; ?></h4>
            </div>
            <form action="" method="POST">
                <input type="email" name="remove_email" placeholder="Enter your email" required>
                <input type="submit" name="remove" value="Remove Feedback">
            </form>
        </div>
    </div>
  </body>
</html>
