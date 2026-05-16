// LOAD PAGE
function loadPage(page) {
  let xhr = new XMLHttpRequest();

  xhr.open("GET", page, true);

  xhr.onload = function () {
    if (this.status == 200) {
      document.getElementById("content-area").innerHTML = this.responseText;

      // AFTER PAGE LOAD
      if (page == "bookings.php") {
        loadBookings();
      }

      if (page == "rooms.php") {
        loadRooms();
      }
    }
  };

  xhr.send();
}

// LOAD BOOKINGS
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

      let output = "";

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
                                class="btn btn-success btn-sm"
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

      document.getElementById("bookingTableBody").innerHTML = output;

      liveSearch();
    }
  };

  xhr.send();
}

// LIVE SEARCH
function liveSearch() {
  let searchInput = document.getElementById("bookingSearch");

  searchInput.addEventListener("keyup", function () {
    let search = this.value;

    let xhr = new XMLHttpRequest();

    xhr.open(
      "GET",
      "../../Controller/ReceptionistController/SearchBooking.php?search=" +
        search,
      true,
    );

    xhr.onload = function () {
      if (this.status == 200) {
        let bookings = JSON.parse(this.responseText);

        let output = "";

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
                                    class="btn btn-success btn-sm"
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

        document.getElementById("bookingTableBody").innerHTML = output;
      }
    };

    xhr.send();
  });
}

// CHECK IN
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
    }
  };

  xhr.send(formData);
}

// CHECK OUT
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

// LOAD ROOMS
function loadRooms() {
  let xhr = new XMLHttpRequest();

  xhr.open(
    "GET",
    "../../Controller/ReceptionistController/RoomStatus.php",
    true,
  );

  // CREATE WALK-IN BOOKING
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

        form.reset();
      }
    };

    xhr.send(formData);
  }

  xhr.onload = function () {
    if (this.status == 200) {
      let rooms = JSON.parse(this.responseText);

      let output = "";

      rooms.forEach(function (room) {
        output += `
                    <tr>

                        <td>${room.room_number}</td>

                        <td>${room.room_type}</td>

                        <td>${room.floor}</td>

                        <td>${room.status}</td>

                    </tr>
                `;
      });

      document.getElementById("roomTableBody").innerHTML = output;
    }
  };

  xhr.send();
}
