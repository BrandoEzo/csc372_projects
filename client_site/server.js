//Brandon Ezovski, 2/20/2026: JavaScript server that will allow for the web page to be built and
//viewable using node.js. Includes error handling and 404 page for bad links
//Update 2/25/2026: refactored using Express and Handlebars

// Load the Express module
const express = require('express');
// Load the Express Handlebars module
const { engine } = require('express-handlebars');
const handlebars = require('handlebars');

// Create an Express application
const app = express();

// Define the port number
const port = 3000;

// Register custom helper for equality checking, used for setting the active link on the header
handlebars.registerHelper('eq', (a, b) => a === b);

// Configure Handlebars as the view engine with main as the default layout
app.engine('handlebars', engine({ 
    defaultLayout: 'main'
}));
app.set('view engine', 'handlebars');
app.set('views', './views');

// Configure Express to serve static files from the public folder
app.use(express.static('public'));

// Define routes
app.get('/', (req, res) => {
    res.render('homepage',{
        title: 'URI Gaming Club Homepage',
        activePage: 'home'
    });
});

app.get('/calendar', (req, res) => {
    res.render('calendar',{
        title: 'URI Gaming Club Calendar',
        activePage: 'calendar'
    });
});

app.get('/events', (req, res) => {
    res.render('events', {
        title: 'URI Gaming Club Events',
        activePage: 'events'
    });
});

// Handle 404 errors
app.use((req, res) => {
    res.status(404).render('404Error', {
        title: '404 Error'
    });
});

// Handle 500 errors
app.use((err, req, res, next) => {
    res.status(500).render('500Error', {
        title: '500 Error'
    });
});

// Tell the server which port to listen on and output the server URL to the console
app.listen(port, () => {
    console.log(`Server is running at http://localhost:${port}`);
});









