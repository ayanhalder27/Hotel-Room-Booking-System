const fs = require('fs');
const file = 'c:/xampp/htdocs/php/Hotel-Room-Booking-System/View/Admin/service-requests.php';
let content = fs.readFileSync(file, 'utf8');

// Replace tbody with id
content = content.replace(/<tbody>[\s\S]*?<\/tbody>/, '<tbody id="requestsTableBody">\n                </tbody>');

fs.writeFileSync(file, content);
console.log('Fixed service-requests.php');
