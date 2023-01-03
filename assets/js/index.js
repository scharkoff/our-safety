import fs from "fs";

const filePath = "../../csv/crime_articles.js";

fs.readFile(filePath, { encoding: 'utf-8' }, function (err, data) {
    if (!err) {
        console.log('received data: ' + data);
        response.writeHead(200, { 'Content-Type': 'text/html' });
        response.write(data);
        response.end();
    } else {
        console.log(err);
    }
});

