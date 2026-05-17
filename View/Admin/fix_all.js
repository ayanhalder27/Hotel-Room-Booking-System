const fs = require('fs');

const files = [
    { name: 'manage-staff.php', id: 'staffTableBody' },
    { name: 'manage-reviews.php', id: 'reviewsTableBody' },
    { name: 'manage-guests.php', id: 'guestsTableBody' },
    { name: 'announcements.php', id: 'announcementsTableBody' }
];

files.forEach(f => {
    const file = `c:/xampp/htdocs/php/Hotel-Room-Booking-System/View/Admin/${f.name}`;
    let content = fs.readFileSync(file, 'utf8');
    content = content.replace(/<tbody>[\s\S]*?<\/tbody>/, `<tbody id="${f.id}">\n                </tbody>`);
    fs.writeFileSync(file, content);
    console.log(`Fixed ${f.name}`);
});
