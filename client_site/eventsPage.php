<?php include 'php/events.php';?>

<!--Brandon Ezovski, 3/4/26, Event page remade in php with dynamic content.-->

<!DOCTYPE html>

<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <a class="link" href="interestForm.php">Interest Form</a>
			</div>
		</div>

    <h1>URI Gaming Club Events Page</h1>
    <p class="center">Welcome to the URI Gaming Club Events Page!</p>
    
    <div class="left-col">
        <h2>Weekly Events</h2>
        <?php  for($i = 0; $i < sizeof($events); $i++) {?>
            <div class="<?= $events[$i]->cardType() ?>">       
                <h3>
                    <?= $events[$i]->name ?> 
                </h3>
                <p>
                    <?= $events[$i]->description ?>
                </p>
                <ul>
                    <li>
                        <?= $events[$i]->location?>
                    </li>
                    <li>
                        <?= $events[$i]->day?>, starts at <?=$events[$i]->time ?>
                    </li>
                    <li>
                        <?= $events[$i]->averageAttendees ?> average attendees
                    </li>
                    <li>Price of Admission: <?= $events[$i]->checkPrice() ?> </li>
                </ul>
                </div>
            <?php } ?>
    
            <h2>Special Events</h2>

            <?php  for($i = 0; $i < sizeof($spEvents); $i++) {?>
            <div class="<?= $spEvents[$i]->cardType() ?>">       
                <h3>
                    <?= $spEvents[$i]->name ?> 
                </h3>
                <p>
                    <?= $spEvents[$i]->description ?>
                </p>
                <ul>
                    <li>
                        <?= $spEvents[$i]->location?>
                    </li>
                    <li>
                        <?= $spEvents[$i]->day?>, starts at <?=$spEvents[$i]->time ?>
                    </li>
                    <li>
                        <?= $spEvents[$i]->averageAttendees ?> average attendees
                    </li>
                    <li>Price of Admission: <?= $spEvents[$i]->checkPrice() ?> </li>
                </ul>
                </div>
            <?php } ?>
    <p>*pink event color designates an event as a competition/tournament. These events are open to the public as well as URI students.</p>
</body>
</html>