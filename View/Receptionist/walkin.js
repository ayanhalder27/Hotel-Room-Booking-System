// Load room types and then available rooms
async function loadTypes() {
  try {
    const response = await api("walkin_controller.php", {
      action: "room_types",
    });

    qs("#roomTypeSelect").innerHTML = (response.data || [])
      .map(
        (type) => `
                <option value="${type.id}">
                    ${esc(type.name)} - ${money(type.price_per_night)}
                </option>
            `,
      )
      .join("");

    await loadRooms();
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Load available rooms based on form inputs
async function loadRooms() {
  try {
    const form = qs("#walkinForm");

    const response = await api("walkin_controller.php", {
      action: "available_rooms",
      room_type_id: form.room_type_id.value,
      checkin_date: form.checkin_date.value,
      checkout_date: form.checkout_date.value,
    });

    qs("#roomSelect").innerHTML =
      (response.data || [])
        .map(
          (room) => `
                <option value="${room.id}">
                    ${esc(room.room_number)} - Floor ${room.floor}
                </option>
            `,
        )
        .join("") || '<option value="">No room available</option>';
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Handle form changes that affect room availability
qs("#walkinForm")?.addEventListener("change", (e) => {
  if (
    ["room_type_id", "checkin_date", "checkout_date"].includes(e.target.name)
  ) {
    loadRooms();
  }
});

// Handle form submission for walk-in booking
qs("#walkinForm")?.addEventListener("submit", async (e) => {
  e.preventDefault();

  const data = Object.fromEntries(new FormData(e.target));
  data.action = "create";

  try {
    const response = await api("walkin_controller.php", data);
    showAlert(response.message, response.success);

    if (response.success) {
      e.target.reset();
    }
  } catch (error) {
    showAlert(error.message, false);
  }
});

// Initialize form with default dates and load types
(function initWalkinForm() {
  const today = new Date().toISOString().slice(0, 10);

  const checkinInput = qs('[name="checkin_date"]');
  const checkoutInput = qs('[name="checkout_date"]');

  if (checkinInput && !checkinInput.value) {
    checkinInput.value = today;
  }

  if (checkoutInput && !checkoutInput.value) {
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    checkoutInput.value = tomorrow.toISOString().slice(0, 10);
  }

  loadTypes();
})();
