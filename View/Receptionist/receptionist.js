// ==========================================
// LOAD DYNAMIC PAGE
// ==========================================

function loadPage(page) {
  let xhr = new XMLHttpRequest();

  xhr.open("GET", page, true);

  xhr.onload = function () {
    if (this.status == 200) {
      document.getElementById("content-area").innerHTML = this.responseText;

      // LOAD PAGE DATA
      if (page === "bookings.php") {
        loadBookings();
      } else if (page === "rooms.php") {
        loadRooms();
      }
    }
  };

  xhr.send();
}

// ==========================================
// LOAD BOOKINGS
// ==========================================

function loadBookings() {
  let xhr = new XMLHttpRequest();

  xhr.open(
    "GET",
    "../../Controller/ReceptionistController/GetBookings.php",
    true,
  );

  xhr.onload = function () {
    if (this.status == 200) {
      let bookings = JSON.parse(this.responseText);

      renderBookingTable(bookings);

      initializeLiveSearch();
    }
  };

  xhr.send();
}

// ==========================================
// RENDER BOOKING TABLE
// ==========================================

function renderBookingTable(bookings) {
  let tableBody = document.getElementById("bookingTableBody");

  if (!tableBody) {
    return;
  }

  let output = "";

  if (bookings.length === 0) {
    output = `
            <tr>
                <td colspan="7" class="text-center">
                    No booking found
                </td>
            </tr>
        `;
  } else {
    bookings.forEach(function (booking) {
      output += `
                <tr>

                    <td>${booking.id}</td>

                    <td>${booking.name}</td>

                    <td>${booking.room_number}</td>

                    <td>${booking.checkin_date}</td>

                    <td>${booking.checkout_date}</td>

                    <td>${booking.status}</td>

                    <td>

                        <button
                            class="btn btn-success btn-sm me-1"
                            onclick="checkIn(${booking.id})"
                        >
                            Check In
                        </button>


                        <button
                            class="btn btn-danger btn-sm"
                            onclick="checkOut(${booking.id})"
                        >
                            Check Out
                        </button>

                    </td>

                </tr>
            `;
    });
  }

  tableBody.innerHTML = output;
}

// ==========================================
// LIVE SEARCH
// ==========================================

function initializeLiveSearch() {
  let searchInput = document.getElementById("bookingSearch");

  if (!searchInput) {
    return;
  }

  searchInput.onkeyup = function () {
    let search = this.value;

    let xhr = new XMLHttpRequest();

    xhr.open(
      "GET",
      "../../Controller/ReceptionistController/SearchBooking.php?search=" +
        encodeURIComponent(search),
      true,
    );

    xhr.onload = function () {
      if (this.status == 200) {
        let bookings = JSON.parse(this.responseText);

        renderBookingTable(bookings);
      }
    };

    xhr.send();
  };
}

// ==========================================
// CHECK IN
// ==========================================

function checkIn(bookingId) {
  let formData = new FormData();

  formData.append("booking_id", bookingId);

  let xhr = new XMLHttpRequest();

  xhr.open("POST", "../../Controller/ReceptionistController/CheckIn.php", true);

  xhr.onload = function () {
    if (this.status == 200) {
      let response = JSON.parse(this.responseText);

      alert(response.message);

      loadBookings();

      loadRooms();
    }
  };

  xhr.send(formData);
}

// ==========================================
// CHECK OUT
// ==========================================

function checkOut(bookingId) {
  let formData = new FormData();

  formData.append("booking_id", bookingId);

  let xhr = new XMLHttpRequest();

  xhr.open(
    "POST",
    "../../Controller/ReceptionistController/CheckOut.php",
    true,
  );

  xhr.onload = function () {
    if (this.status == 200) {
      let response = JSON.parse(this.responseText);

      alert(response.message);

      loadBookings();

      loadRooms();
    }
  };

  xhr.send(formData);
}

// ==========================================
// LOAD ROOM STATUS
// ==========================================

function loadRooms() {
  let xhr = new XMLHttpRequest();

  xhr.open(
    "GET",
    "../../Controller/ReceptionistController/RoomStatus.php",
    true,
  );

  xhr.onload = function () {
    if (this.status == 200) {
      let rooms = JSON.parse(this.responseText);

      let tableBody = document.getElementById("roomTableBody");

      if (!tableBody) {
        return;
      }

      let output = "";

      if (rooms.length === 0) {
        output = `
                    <tr>
                        <td colspan="4" class="text-center">
                            No room data found
                        </td>
                    </tr>
                `;
      } else {
        rooms.forEach(function (room) {
          output += `
                        <tr>

                            <td>${room.room_number}</td>

                            <td>${room.room_type}</td>

                            <td>${room.floor}</td>

                            <td class="${room.status}">
                                ${room.status}
                            </td>

                        </tr>
                    `;
        });
      }

      tableBody.innerHTML = output;
    }
  };

  xhr.send();
}

// ==========================================
// WALK-IN BOOKING
// ==========================================

function createWalkinBooking() {
  let form = document.getElementById("walkinForm");

  let formData = new FormData(form);

  let xhr = new XMLHttpRequest();

  xhr.open(
    "POST",
    "../../Controller/ReceptionistController/WalkinBooking.php",
    true,
  );

  xhr.onload = function () {
    if (this.status == 200) {
      let response = JSON.parse(this.responseText);

      alert(response.message);

      if (response.status === "success") {
        form.reset();
      }
    }
  };

  xhr.send(formData);
}
