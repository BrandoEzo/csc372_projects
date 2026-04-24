<?php 
    include 'php/database-connection.php';//this is commented out for now until I am on anything but school wifi
    function get_events(PDO $pdo) {
		                                                    // SQL query to retrieve event information based on the event ID
		$sql = "SELECT * 
			FROM Events
			ORDER BY name DESC";
		                                                    // Execute the SQL query using the pdo function and fetch the result
		$events = pdo($pdo, $sql)->fetchAll();		// Associative array where 'id' is the key and $id is the value. Used to bind the value of $id to the placeholder :id in SQL query.

		return $events;                                        // Return the event information (associative array)
	}

	$events = get_events($pdo);  
    
    ?>

<!--Update 4/1/2026: Updated to make use of MySQL database for event storage instead of events.php-->
<!--Brandon Ezovski, 3/4/26, Event page remade in php with dynamic content.-->

<!DOCTYPE html>

<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Event page for URI Gaming Club, listing all upcoming events and their details.">
    <meta charset="UTF-8">
    <title>URI Gaming Club Events</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>  
    <!--Nav Bar-->
    <div class="header">
			<a class="link" href="homepage.html"><img id="logo" src="images/logo.png" alt="URI Gaming Club Logo" fetchpriority="high" width="192" height="108"></a>
			<div class="header-right" >
				<a class="link" href="homepage.html">Home</a>
                <a class="active" href="eventsPage.php">Events</a>
                <a class="link" href="calendar.html">Calendar</a>
                <a class="link" href="interestForm.php">Feedback</a>
			</div>
		</div>
    <main role="main">
    <h1>URI Gaming Club Events Page</h1>
    <p class="center">Welcome to the URI Gaming Club Events Page!</p>
    
    <div class="left-col">
        <p>*pink event color designates an event as a competition/tournament. These events are open to the public as well as URI students.</p>
        <?php 
        if(empty($events)){ ?>
            <p>Sorry, there are no events to display at this time. Please check back later!</p>
        <?php } ?>
        <?php foreach($events as $event): ?>
            <div class="<?= $event['competition'] == 1 ? "special" : "card" ?>">       
                <h2>
                    <?= $event['name'] ?> 
                </h2>
                <h3>
                    <?= $event['special'] == 1 ? "<em>Special Event</em>" : "<em>Weekly Event</em>" ?>
                </h3>
                <p>
                    <?= $event['description'] ?>
                </p>
                <ul>
                    <li>
                        <?= $event['location']?>
                    </li>
                    <li>
                        <?= $event['day']?>, starts at <?=$event['time'] ?>
                    </li>
                    <li>
                        <?= $event['averageAttendees'] ?> average attendees
                    </li>
                    <li>Price of Admission: <?= $event['price'] == 0 ? "Free" : "$" . $event['price'] ?> </li>
                </ul>
                </div>
        <?php endforeach; ?>
    </main>
</html>