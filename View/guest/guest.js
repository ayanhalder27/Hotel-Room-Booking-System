document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.getElementById("menu-toggle");
  const sidebar = document.getElementById("sidebar");
  const contentArea = document.getElementById("guest-content");
  const menuLinks = document.querySelectorAll(".menu-link");

  // =========================
  // 1. NAVIGATION & SIDEBAR
  // =========================
  if (menuToggle && sidebar) {
    menuToggle.addEventListener("click", () =>
      sidebar.classList.toggle("show"),
    );
  }

  if (contentArea && menuLinks.length > 0) {
    menuLinks.forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        menuLinks.forEach((item) => item.classList.remove("active"));
        this.classList.add("active");
        const page = this.getAttribute("data-page");
        loadView(page);
        if (window.innerWidth < 768 && sidebar)
          sidebar.classList.remove("show");
      });
    });
  }

  // Global View Loader
  function loadView(page) {
    contentArea.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary"></div>
            <p class="mt-2 text-muted">Synchronizing with server...</p>
        </div>`;

    fetch(page)
      .then((response) => response.text())
      .then((data) => {
        contentArea.innerHTML = data;
        // CRITICAL: Initialize specific logic for the newly loaded HTML
        initViewSpecificLogic(page);
      })
      .catch(() => {
        contentArea.innerHTML = `<div class="alert alert-danger m-3">Error loading ${page}. Please check your connection.</div>`;
      });
  }

  // ===================================
  // 2. VIEW INITIALIZATION ROUTER
  // ===================================
  function initViewSpecificLogic(page) {
    if (page.includes("dashboard_home.php")) loadDashboardData();
    if (page.includes("search_rooms.php")) setupSearchForm();
    if (page.includes("book_room.php")) setupBookingPage();
    if (page.includes("profile.php")) loadProfileData();
    if (page.includes("my_bookings.php")) loadBookingHistory();
    if (page.includes("billing.php")) loadBillingData();
    if (page.includes("loyalty.php")) loadLoyaltyData();
    if (page.includes("service_requests.php")) setupServiceRequests();
  }

  // ===================================
  // 3. CORE FEATURE FUNCTIONS (AJAX)
  // ===================================

  // --- DASHBOARD ---
  function loadDashboardData() {
    const fd = new FormData();
    fd.append("action", "load_dashboard");
    fetch("../../controllers/GuestController/GuestDashboardController.php", {
      method: "POST",
      body: fd,
    })
      .then((res) => res.json())
      .then((data) => {
        if (!data.success) return;
        setElementText("stat-bookings", data.stats.upcoming_bookings);
        setElementText("stat-points", data.stats.loyalty_points);
        setElementText("stat-spent", "$" + data.stats.total_spent);

        const list = document.getElementById("announcement-list");
        if (list) {
          list.innerHTML =
            data.announcements
              .map(
                (a) => `
            <div class="list-group-item border-0 border-bottom py-3">
              <div class="d-flex justify-content-between">
                <h6 class="mb-1 text-primary fw-bold">${a.title}</h6>
                <small class="text-muted">${a.created_at}</small>
              </div>
              <p class="mb-0 text-secondary small">${a.content}</p>
            </div>`,
              )
              .join("") ||
            "<p class='p-3 text-center text-muted'>No active announcements.</p>";
        }
      });
  }

  // --- ROOM SEARCH ---
  function setupSearchForm() {
    const form = document.getElementById("room-search-form");
    if (form) {
      form.onsubmit = function (e) {
        e.preventDefault();
        const formData = new FormData(form);
        formData.append("action", "search_rooms");
        const container = document.getElementById("search-results");
        container.innerHTML =
          '<div class="col-12 text-center py-5"><div class="spinner-border"></div></div>';

        fetch("../../controllers/GuestController/GuestRoomController.php", {
          method: "POST",
          body: formData,
        })
          .then((res) => res.json())
          .then((data) => {
            if (!data.success || data.rooms.length === 0) {
              container.innerHTML = `<div class="col-12"><p class='alert alert-light text-center'>No rooms found matching your criteria.</p></div>`;
              return;
            }
            // Store search dates for booking process
            sessionStorage.setItem(
              "lastSearch",
              JSON.stringify(Object.fromEntries(formData)),
            );

            container.innerHTML = data.rooms
              .map(
                (room) => `
              <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0 room-card">
                  <img src="../../public/uploads/rooms/${room.thumbnail_path || "default.jpg"}" class="card-img-top" style="height:200px; object-fit:cover;">
                  <div class="card-body">
                    <h5 class="card-title fw-bold">${room.name}</h5>
                    <p class="h4 text-primary mb-3">$${room.price_per_night} <small class="text-muted" style="font-size:12px">/ night</small></p>
                    <button class="btn btn-primary w-100 rounded-pill" onclick="selectRoom(${room.id})">Reserve Now</button>
                  </div>
                </div>
              </div>`,
              )
              .join("");
          });
      };
    }
  }

  window.selectRoom = (id) => {
    sessionStorage.setItem("selectedRoomId", id);
    loadView("book_room.php");
  };

  // --- BOOKING PROCESS ---
  function setupBookingPage() {
    const search = JSON.parse(sessionStorage.getItem("lastSearch") || "{}");
    const roomId = sessionStorage.getItem("selectedRoomId");

    if (document.getElementById("booking-summary"))
      document.getElementById("booking-summary").innerHTML =
        `Dates: <b>${search.checkin}</b> to <b>${search.checkout}</b>`;

    const confirmBtn = document.getElementById("confirm-booking-btn");
    if (confirmBtn) {
      confirmBtn.onclick = () => {
        const fd = new FormData();
        fd.append("action", "create_booking");
        fd.append("room_type_id", roomId);
        fd.append("checkin", search.checkin);
        fd.append("checkout", search.checkout);
        fd.append(
          "special_requests",
          document.getElementById("special-requests")?.value || "",
        );

        fetch("../../controllers/GuestController/GuestBookingController.php", {
          method: "POST",
          body: fd,
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.success) loadView("booking_confirmation.php");
            else alert("Error: " + data.message);
          });
      };
    }
  }

  // --- BILLING & LOYALTY ---
  function loadBillingData() {
    const fd = new FormData();
    fd.append("action", "get_invoices");
    fetch("../../controllers/GuestController/GuestBillingController.php", {
      method: "POST",
      body: fd,
    })
      .then((res) => res.json())
      .then((data) => {
        const list = document.getElementById("billing-list");
        if (list) {
          list.innerHTML =
            data.data
              .map(
                (b) => `
              <div class="card mb-3 border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                   <div>
                     <h6 class="mb-0 fw-bold">${b.room_name}</h6>
                     <small class="text-muted">Invoice Ref: #${b.id}</small>
                   </div>
                   <div class="text-end">
                     <span class="badge ${b.payment_status === "paid" ? "bg-success" : "bg-warning text-dark"} mb-1">${b.payment_status.toUpperCase()}</span>
                     <div class="h5 mb-0">$${b.total_amount}</div>
                   </div>
                </div>
              </div>`,
              )
              .join("") ||
            "<p class='text-center py-4'>No billing history found.</p>";
        }
      });
  }

  // --- HELPERS ---
  function setElementText(id, text) {
    const el = document.getElementById(id);
    if (el) el.innerText = text;
  }

  // Default Entry Point
  loadView("dashboard_home.php");
});
