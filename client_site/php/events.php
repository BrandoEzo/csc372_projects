<?php
//Brandon Ezovski, 3/4/26, php object file for Events page
class Event{ //Event class for various events hosted by the uri gaming club
    public string $name; //event name
    public string $day; //day of event
    public string $time; //start time of event
    public string $description; //event description
    public string $location; //location of event
    public bool $special; //true if special event, false if weekly
    public string $averageAttendees; //average number of attendees
    public float $dollarPrice; //entry price
    public string $displayPrice; //string used to display the price or the word "Free"
    public bool $competition; //true if event is competitive, false otherwise

    function __construct($name, $day, $time, $description, $location, $special, $averageAttendees, $dollarPrice, $competition) {
    $this->name = $name;
    $this->day = $day;
    $this->time = $time;
    $this->description = $description;
    $this->location = $location;
    $this->special = $special;
    $this->averageAttendees = $averageAttendees;
    $this->dollarPrice = $dollarPrice;
    $this->competition = $competition;
  }
  //function to get the event price
  function checkPrice(){
        if($this->dollarPrice > 0){
            $this->displayPrice =  "$". $this->dollarPrice;
        }
        else{
            $this->displayPrice = "Free!";
        }
        return $this->displayPrice;
    }
    
    //function to set the card type based on whether the event is competitive or not
    function cardType(){
        $card = "";
        if($this->competition == True){
            $card = "special";
        }
        else{
            $card = "card";
        }
        return $card;
    }
}

//3 book instances
$events = [new Event("URI Rhody Rumble Weekly", "Friday", "6:00 pm", "The University of Rhode Island Gaming Club's premier weekly <em>Super Smash Bros</em> and <em>Rivals of Aether 2</em> tournament!", "Held in room Room 312A / 360 of the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881, USA",  False, "10-30", "0", True), 
        new Event("Weekly Game Night", "Thursday", "6:30 pm", "A new event hosted by Gaming Club to appeal to a more casual audience. Designated times for people to come together and try out some new games they haven't played before! Our entire video game and board game selection is availible to be played during these events!", "Held in room Room 312A of the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881, USA", False, "10-20", 0, False)];
$spEvents = [new Event("URI Rhody Ruckus Monthly", "Saturday", "12:00 pm", "The University of Rhode Island Gaming Club's (slighly inconsistent) monthly event, featuring <em>Super Smash Bros Ultimate</em> singles and doubles, <em>Rivals of Aether 2</em>, as well as other fighting game side brackets such as <em>Street Fighter 6</em>, <em>Tekken 8</em>, <em>Guilty Gear: Strive</em>, and more! $5 per main event.",  "Held in Atrium 1/2 or Rainville Ballroom of the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881, USA", True, "20-100", 5, True),
        new Event("Rhody Fest", "First Saturday of the Fall Semester", "12 pm", "The URI Gaming Club is featured at URI's Rhody Fest, a welcome event designed for Freshman and new URI students to get to know the clubs and activities availible on campus. We bring out a handful of video game consoles and typically run a challenge where if you can beat one of our <em>Super Smash Bros</em> players you win a $5 Dunkin Donuts Gift Card! We bring out some casual games too such as <em>Mario Kart</em> and <em>Mario Party</em>.", "Held outside the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881, USA", True, "500-1000", 0, False),
        new Event("Sugar Rush", "Wednesday Night around late December", "6:00 pm", "The URI Gaming Club takes part in Sugar Rush, the annual Student Affairs event that takes place around the holidays. This event features several clubs and activities, with the Gaming Club bringing out a few different game consoles like <em>Nintendo Switch</em> and <em>Nintendo Wii</em> for students to play while they enjoy copious amounts of free sugary snacks and drinks. A movie is normally played during this event, as well as music by the URI Radio.", "Held in the Ram's Den Dining Hall, located within the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881, USA", True, "100-500", 0, False)];
?>