document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.getElementById("menu-toggle");
  const sidebar = document.getElementById("sidebar");
  const contentArea = document.getElementById("guest-content");
  const menuLinks = document.querySelectorAll(".menu-link");

  // =========================
  // SIDEBAR TOGGLE
  // =========================
  if (menuToggle && sidebar) {
    menuToggle.addEventListener("click", function () {
      sidebar.classList.toggle("show");
    });
  }

  // =========================
  // DYNAMIC PAGE LOADING
  // =========================
  if (contentArea && menuLinks.length > 0) {
    menuLinks.forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();

        menuLinks.forEach((item) => item.classList.remove("active"));
        this.classList.add("active");

        const page = this.getAttribute("data-page");

        contentArea.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary"></div>
                    </div>
                `;

        fetch(page)
          .then((response) => response.text())
          .then((data) => {
            setTimeout(() => {
              contentArea.innerHTML = data;
            }, 300);
          })
          .catch((error) => {
            contentArea.innerHTML = `
                            <div class="alert alert-danger">
                                Failed to load content.
                            </div>
                        `;
          });

        if (window.innerWidth < 768 && sidebar) {
          sidebar.classList.remove("show");
        }
      });
    });
  }
});
