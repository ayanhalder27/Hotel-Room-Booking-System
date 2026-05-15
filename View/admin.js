// document.addEventListener('DOMContentLoaded', () => {
//     const mobileToggle = document.getElementById('mobileToggle');
//     const sidebar = document.getElementById('sidebar');

//     // Mobile menu toggle logic
//     mobileToggle.addEventListener('click', () => {
//         sidebar.classList.toggle('show');
//     });

//     // Close sidebar when clicking outside on mobile
//     document.addEventListener('click', (e) => {
//         if (window.innerWidth <= 768) {
//             if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
//                 sidebar.classList.remove('show');
//             }
//         }
//     });

//     // Handle active states on navigation menu
//     const navItems = document.querySelectorAll('.nav-item');
//     navItems.forEach(item => {
//         item.addEventListener('click', function(e) {
//             e.preventDefault(); // Prevent jump to top
//             // Remove active class from all
//             navItems.forEach(nav => nav.classList.remove('active'));
//             // Add to clicked
//             this.classList.add('active');

//             // On mobile, auto close sidebar after selection
//             if (window.innerWidth <= 768) {
//                 sidebar.classList.remove('show');
//             }
//         });
//     });
// });