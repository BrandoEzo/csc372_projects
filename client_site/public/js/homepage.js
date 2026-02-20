//Brandon Ezovski, 2/6/2026: javascript file to handle club interest buttons on homepage.html
// when the user clicks the interested button it increments the number of interested people and changes the button image


// get event buttons after DOM loads
document.addEventListener('DOMContentLoaded', function() {
    var interestedCard = document.querySelector('.interestCard');
    var header = interestedCard.querySelector('h5');
    var image = interestedCard.querySelector('.interestImage');

    // number of players interested in the event 
    var interested = 65;

    // initialize header
    if (header) {
        header.textContent = 'Currently interested: ' + interested;
    }

    // attach click handler to the button
    interestedCard.addEventListener('click', function() {
        if (!image || !header) return;
        var filename = image.src.split('/').pop();
        if (filename === 'interested_question_button.png') {
            // user is selecting interest
            interested = (interested || 0) + 1;
            image.src = 'images/interested_button.png';
        } else {
            // user is deselecting; don't allow negative counts
            interested = Math.max(0, (interested || 0) - 1);
            image.src = 'images/interested_question_button.png';
        }
        header.textContent = 'Currently interested: ' + interested;
    });
});