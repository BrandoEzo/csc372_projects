<?php
// navbar code that is repeated across all pages
// include this function at the top of each page for consistency and ease of maintenance
function navBar($currentPage = ""){
    $homeClass = ($currentPage == "homepage") ? "active" : "link";
    $eventsClass = ($currentPage == "eventsPage") ? "active" : "link";
    $calendarClass = ($currentPage == "calendar") ? "active" : "link";
    $feedbackClass = ($currentPage == "interestForm") ? "active" : "link";
    
    echo <<<HTML
    <div class="header">
        <a class="link" href="homepage.php"><img id="logo" src="images/logo.png" alt="URI Gaming Club Logo" fetchpriority="high" width="192" height="108"></a>
        <div class="header-right">
            <a class="$homeClass" href="homepage.php">Home</a>
            <a class="$eventsClass" href="eventsPage.php">Events</a>
            <a class="$calendarClass" href="calendar.php">Calendar</a>
            <a class="$feedbackClass" href="feedbackForm.php">Feedback</a>
        </div>
    </div>
    HTML;
}
?>