// Reset guest form
function resetGuest() {
  qs("#guestForm").reset();
  qs("#guestId").value = "";
}

// Load guests and render table
async function loadGuests() {
  try {
    const response = await api("guest_register_controller.php", {
      action: "list",
      q: qs("#searchInput").value,
    });

    if (!response.success) {
      return showAlert(response.message, false);
    }

    const guests = response.data;

    const tableHTML = guests.length
      ? guests.map(renderGuestRow).join("")
      : '<tr><td colspan="7" class="empty">No guests found</td></tr>';

    qs("#guestTable").innerHTML = tableHTML;
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Render a single guest row
function renderGuestRow(guest) {
  return `
        <tr>
            <td>${guest.id}</td>
            <td>${esc(guest.name)}</td>
            <td>${esc(guest.email)}</td>
            <td>${esc(guest.phone)}</td>
            <td>${esc(guest.national_id)}</td>
            <td>${badge(guest.is_active == 1 ? "active" : "inactive")}</td>
            <td>
                <button 
                    class="btn btn-light" 
                    onclick='editGuest(${JSON.stringify(guest)})'
                >
                    Edit
                </button>
                <button 
                    class="btn btn-danger" 
                    onclick="deactivateGuest(${guest.id})"
                >
                    Deactivate
                </button>
            </td>
        </tr>
    `;
}

// Populate form for editing guest
function editGuest(guest) {
  for (const [key, value] of Object.entries(guest)) {
    const el = qs(`[name="${key}"]`);
    if (el) el.value = value;
  }
  qs("#guestId").value = guest.id;
  scrollTo(0, 0);
}

// Deactivate guest
async function deactivateGuest(id) {
  if (!confirm("Deactivate this guest?")) return;

  const response = await api("guest_register_controller.php", {
    action: "deactivate",
    id,
  });

  showAlert(response.message, response.success);
  loadGuests();
}

// Handle guest form submission
qs("#guestForm")?.addEventListener("submit", async (e) => {
  e.preventDefault();

  const data = Object.fromEntries(new FormData(e.target));
  data.action = data.id ? "update" : "create";

  try {
    const response = await api("guest_register_controller.php", data);
    showAlert(response.message, response.success);

    if (response.success) {
      resetGuest();
      loadGuests();
    }
  } catch (error) {
    showAlert(error.message, false);
  }
});

// Event listeners
qs("#searchInput")?.addEventListener("input", loadGuests);
qs("#refreshBtn")?.addEventListener("click", loadGuests);
qs("#resetBtn")?.addEventListener("click", resetGuest);

// Initial load
loadGuests();
