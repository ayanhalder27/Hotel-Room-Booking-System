const fs = require('fs');
const file = 'c:/xampp/htdocs/php/Hotel-Room-Booking-System/View/Admin/seasonal-pricing.php';
let content = fs.readFileSync(file, 'utf8');

// Replace tbody with id
content = content.replace(/<tbody>[\s\S]*?<\/tbody>/, '<tbody id="pricingTableBody">\n                </tbody>');

// Remove hardcoded room type options in filter
content = content.replace(/<select name="room_type_filter".*?>[\s\S]*?<\/select>/, '<select name="room_type_filter" class="form-control">\n                        <option value="all">All Room Types</option>\n                    </select>');

// Remove hardcoded room type options in modal
content = content.replace(/<select id="roomTypeId" name="room_type_id".*?>[\s\S]*?<\/select>/, '<select id="roomTypeId" name="room_type_id" class="form-control" required>\n                        <option value="">Select a Room Type...</option>\n                    </select>');

fs.writeFileSync(file, content);
console.log('Fixed seasonal-pricing.php');
