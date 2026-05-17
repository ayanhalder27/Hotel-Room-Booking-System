const fs = require('fs');
const file = 'c:/xampp/htdocs/php/Hotel-Room-Booking-System/View/Admin/report-occupancy.js';
let content = fs.readFileSync(file, 'utf8');

content = content.replace(
    'innerHTML = ${json.data.avg_stay}',
    'innerHTML = `${json.data.avg_stay}'
);

fs.writeFileSync(file, content);
console.log('Fixed');
