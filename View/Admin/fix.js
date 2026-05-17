const fs = require('fs');
const file = 'c:/xampp/htdocs/php/Hotel-Room-Booking-System/View/Admin/manage-room-types.php';
let content = fs.readFileSync(file, 'utf8');
content = content.replace(/<tbody>[\s\S]*?<\/tbody>/g, '<tbody id="roomTypesTableBody">\n                </tbody>');
fs.writeFileSync(file, content);
console.log('Done');
