//Brandon Ezovski, 2/20/2026: JavaScript server that will allow for the web page to be built and
//viewable using node.js. Includes error handling and 404 page for bad links
/*
Update your server.js file to serve your website files. Your server must include:
- Load the http module
- Load the file system module
- Create a constant that stores the port number (e.g., 3000)
*/
const http = require('http');
//file system module:
const fs = require('fs');
//port
const port = 3000;

/*
- Create a function named serveStaticFile that:
    - Attempts to read the file at the given path
    - Sets status code 200 when successful
    - Sets status code 500 if a server error occurs
    - Sends the correct Content-Type header based on the file type
    - Sends the file data in the response
*/
const serveStaticFile = (res, path, contentType, responseCode = 200) => {
  fs.readFile(__dirname + path, (err, data) => {
    if (err) {
      res.writeHead(500, { 'Content-Type': 'text/plain' });
      return res.end('500 - Internal Error');
    }
    res.writeHead(responseCode, { 'Content-Type': contentType });
    res.end(data);
  });
};

/*
- Use createServer to:
    - Normalize the URL path by removing query strings and trailing slashes, and converting to lowercase.
    - Map the URL paths to files inside the public folder.
    - Serve your HTML pages, CSS files, JavaScript files, and images.
    - If the requested path or file is not found, serve your custom 404 page and set HTTP status code to 404.
    - Tell the server which port to listen on and output the server URL to the console.
*/

const server = http.createServer((req, res)=>{
    let path = req.url.replace(/\/?(?:\?.*)?$/, '').toLowerCase();
    switch(path){
        case '':
        case '/homepage.html':
            serveStaticFile(res, '/public/homepage.html', 'text/html');
            break;
        case '/calendar.html':
            serveStaticFile(res, '/public/calendar.html', 'text/html');
            break;
        case '/events.html':
            serveStaticFile(res, '/public/events.html', 'text/html');
            break;
        case '/css/style.css':
            serveStaticFile(res, '/public/css/style.css', 'text/css');
            break;
        case '/js/homepage.js':
            serveStaticFile(res, '/public/js/homepage.js', 'text/javascript');
            break;
        case '/js/startgg-api.js':
            serveStaticFile(res, '/public/js/startgg-api.js', 'text/javascript');
            break;
        default:
            if (path.startsWith('/images/')) {
                const ext = path.split('.').pop().toLowerCase();
                const mimeTypes = {
                    'png': 'image/png',
                    'jpg': 'image/jpeg',
                    'jpeg': 'image/jpeg'
                    };
                const contentType = mimeTypes[ext] || 'application/octet-stream';
                serveStaticFile(res, '/public' + path, contentType);
            } else {
                serveStaticFile(res, '/public/404Error.html', 'text/html', 404);
            }
            break;
        }
});
    server.listen(port, () => {
    console.log(`Server is running at http://localhost:${port}`);
});









