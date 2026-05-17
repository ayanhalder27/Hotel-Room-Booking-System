const fs = require('fs');
const file = 'c:/xampp/htdocs/php/Hotel-Room-Booking-System/View/Admin/seasonal-pricing.js';
let content = fs.readFileSync(file, 'utf8');
content = content.replace('opt1.textContent = ${rt.name} (Base: $${rt.price_per_night});', 'opt1.textContent = `${rt.name} (Base: $${rt.price_per_night})`;');
fs.writeFileSync(file, content);
console.log('Fixed');
