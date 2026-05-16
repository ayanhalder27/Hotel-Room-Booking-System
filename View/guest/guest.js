document.addEventListener("DOMContentLoaded", function () {

    // =====================================================
    // DYNAMIC PAGE LOADING
    // =====================================================

    const contentArea = document.getElementById("dynamic-content");

    document.querySelectorAll(".sidebar-link").forEach(link => {

        link.addEventListener("click", function (e) {

            e.preventDefault();

            const page = this.getAttribute("data-page");

            loadPage(page);

        });

    });


    function loadPage(page) {

        fetch(page)

            .then(response => response.text())

            .then(data => {

                contentArea.innerHTML = data;

                initializePageFeatures();

            })

            .catch(error => {

                console.error(error);

                contentArea.innerHTML = `
                    <div class="alert alert-danger">
                        Failed to load page.
                    </div>
                `;
            });
    }


    // =====================================================
    // INITIALIZE PAGE FEATURES
    // =====================================================

    function initializePageFeatures() {

        initializeRoomSearch();

        initializeBookingForm();

    }


    // =====================================================
    // ROOM SEARCH AJAX
    // =====================================================

    function initializeRoomSearch() {

        const searchForm = document.getElementById("room-search-form");

        if (!searchForm) return;


        searchForm.addEventListener("submit", function (e) {

            e.preventDefault();

            const checkinDate = document.getElementById("checkin_date").value;
            const checkoutDate = document.getElementById("checkout_date").value;
            const guests = document.getElementById("guests").value;

            const resultsContainer = document.getElementById("room-results");

            resultsContainer.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary"></div>
                </div>
            `;


            fetch("../../controllers/GuestController/GuestRoomController.php", {

                method: "POST",

                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },

                body: new URLSearchParams({

                    action: "search_rooms",
                    checkin_date: checkinDate,
                    checkout_date: checkoutDate,
                    guests: guests

                })

            })

            .then(response => response.json())

            .then(data => {

                if (!data.success) {

                    resultsContainer.innerHTML = `
                        <div class="alert alert-warning">
                            ${data.message}
                        </div>
                    `;

                    return;
                }


                let html = '';

                data.rooms.forEach(room => {

                    html += `
                    
                    <div class="room-card">

                        <img src="${room.thumbnail_path || 'https://via.placeholder.com/400x220'}"
                             class="room-image">

                        <div class="room-body">

                            <div class="d-flex justify-content-between align-items-start mb-2">

                                <div>
                                    <h4>${room.name}</h4>
                                    <p class="text-muted">
                                        Capacity: ${room.max_capacity} Guests
                                    </p>
                                </div>

                                <div class="text-end">

                                    <h5 class="text-primary">
                                        ৳${room.seasonal_price || room.price_per_night}
                                    </h5>

                                    <small>per night</small>

                                </div>

                            </div>

                            <p>
                                ${room.description.substring(0, 120)}...
                            </p>

                            ${
                                room.seasonal_label
                                ?
                                `
                                <div class="seasonal-notice mb-3">
                                    ${room.seasonal_label} pricing applied.
                                </div>
                                `
                                :
                                ''
                            }

                            <div class="d-flex gap-2">

                                <button 
                                    class="btn btn-outline-primary room-details-btn"
                                    data-room-id="${room.id}">
                                    Details
                                </button>

                                <button 
                                    class="btn btn-primary-custom book-room-btn"
                                    data-room-id="${room.id}"
                                    data-room-name="${room.name}"
                                    data-price="${room.seasonal_price || room.price_per_night}">
                                    Book Now
                                </button>

                            </div>

                        </div>

                    </div>

                    `;
                });

                resultsContainer.innerHTML = html;

                initializeBookButtons();

            })

            .catch(error => {

                console.error(error);

                resultsContainer.innerHTML = `
                    <div class="alert alert-danger">
                        Something went wrong.
                    </div>
                `;
            });

        });

    }



    // =====================================================
    // BOOK ROOM BUTTON
    // =====================================================

    function initializeBookButtons() {

        document.querySelectorAll(".book-room-btn").forEach(button => {

            button.addEventListener("click", function () {

                const roomTypeId = this.dataset.roomId;
                const roomName = this.dataset.roomName;
                const price = this.dataset.price;

                document.getElementById("booking_room_type_id").value = roomTypeId;

                document.getElementById("selected-room-name").innerText = roomName;

                document.getElementById("selected-room-price").innerText = price;

                document.getElementById("booking-section").scrollIntoView({
                    behavior: "smooth"
                });

            });

        });

    }



    // =====================================================
    // CREATE BOOKING AJAX
    // =====================================================

    function initializeBookingForm() {

        const bookingForm = document.getElementById("booking-form");

        if (!bookingForm) return;


        bookingForm.addEventListener("submit", function (e) {

            e.preventDefault();

            const formData = new FormData(bookingForm);

            formData.append("action", "create_booking");


            fetch("../../controllers/GuestController/GuestBookingController.php", {

                method: "POST",
                body: formData

            })

            .then(response => response.json())

            .then(data => {

                const bookingMessage = document.getElementById("booking-message");

                if (!data.success) {

                    bookingMessage.innerHTML = `
                        <div class="alert alert-danger">
                            ${data.message}
                        </div>
                    `;

                    return;
                }


                bookingMessage.innerHTML = `
                    <div class="alert alert-success">
                        Booking successful. Booking ID: #${data.booking_id}
                    </div>
                `;

                bookingForm.reset();

            })

            .catch(error => {

                console.error(error);

                document.getElementById("booking-message").innerHTML = `
                    <div class="alert alert-danger">
                        Server error occurred.
                    </div>
                `;
            });

        });

    }



    // =====================================================
    // LOAD DEFAULT PAGE
    // =====================================================

    loadPage("partials/search_rooms.php");

});