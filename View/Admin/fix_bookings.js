const fs = require('fs');
const file = 'c:/xampp/htdocs/php/Hotel-Room-Booking-System/View/Admin/manage-bookings.php';
let content = fs.readFileSync(file, 'utf8');

// Replace tbody with id
content = content.replace(/<tbody>[\s\S]*?<\/tbody>/, '<tbody id="bookingsTableBody">\n                </tbody>');

fs.writeFileSync(file, content);
console.log('Fixed manage-bookings.php');
