const GuestDashboard = (() => {
  const state = {
    currentPage: "dashboard_home",
    partialPath: "../../views/guest/partials/",
    cache: new Map(),
  };

  const selectors = {
    app: ".guest-app",
    content: "#guest-content",
    sidebarToggle: "[data-sidebar-toggle]",
    sidebarClose: "[data-sidebar-close]",
    navItem: "[data-page]",
    navTarget: "[data-nav-target]",
    toast: "[data-toast]",
    toastStack: "#guest-toast-stack",
  };

  const $ = (selector, root = document) => root.querySelector(selector);
  const $$ = (selector, root = document) => [
    ...root.querySelectorAll(selector),
  ];

  function init() {
    bindNavigation();
    bindSidebar();
    bindGlobalActions(document);
    window.addEventListener("popstate", handlePopState);
    const initial = new URLSearchParams(window.location.search).get("page");
    if (initial && initial !== state.currentPage) {
      loadPage(initial, { push: false });
    }
  }

  function bindNavigation() {
    $$(selectors.navItem).forEach((item) => {
      item.addEventListener("click", () => loadPage(item.dataset.page));
    });
  }

  function bindGlobalActions(root) {
    $$(selectors.navTarget, root).forEach((item) => {
      item.addEventListener("click", () => loadPage(item.dataset.navTarget));
    });

    $$(selectors.toast, root).forEach((item) => {
      item.addEventListener("click", () => showToast(item.dataset.toast));
    });
  }

  function bindSidebar() {
    const app = $(selectors.app);
    $(selectors.sidebarToggle)?.addEventListener("click", () =>
      app.classList.add("sidebar-open"),
    );
    $(selectors.sidebarClose)?.addEventListener("click", () =>
      app.classList.remove("sidebar-open"),
    );
    window.addEventListener("resize", () => {
      if (window.innerWidth >= 992) app.classList.remove("sidebar-open");
    });
  }

  async function loadPage(page, options = { push: true }) {
    if (!page) return;
    const content = $(selectors.content);
    setActiveNav(page);
    closeSidebar();
    renderLoading(content);

    try {
      const html = await fetchPartial(page);
      content.innerHTML = html;
      content.classList.remove("content-stage");
      void content.offsetWidth;
      content.classList.add("content-stage");
      state.currentPage = page;
      bindGlobalActions(content);
      hydrateLocalInteractions(content);
      if (options.push) updateUrl(page);
    } catch (error) {
      content.innerHTML = renderError(page);
      showToast("Could not load this section. Please try again.");
      console.error(error);
    }
  }

  async function fetchPartial(page) {
    if (state.cache.has(page)) return state.cache.get(page);
    const response = await fetch(`${state.partialPath}${page}.php`, {
      headers: {
        "X-Requested-With": "XMLHttpRequest",
        Accept: "text/html, application/json",
      },
    });
    if (!response.ok)
      throw new Error(`Partial ${page} failed with ${response.status}`);
    const html = await response.text();
    state.cache.set(page, html);
    return html;
  }

  function setActiveNav(page) {
    $$(selectors.navItem).forEach((item) =>
      item.classList.toggle("active", item.dataset.page === page),
    );
  }

  function updateUrl(page) {
    const url = new URL(window.location.href);
    if (page === "dashboard_home") url.searchParams.delete("page");
    else url.searchParams.set("page", page);
    history.pushState({ page }, "", url);
  }

  function handlePopState(event) {
    const page =
      event.state?.page ||
      new URLSearchParams(window.location.search).get("page") ||
      "dashboard_home";
    loadPage(page, { push: false });
  }

  function renderLoading(content) {
    content.innerHTML =
      '<div class="loading-state"><div class="loader" aria-label="Loading"></div></div>';
  }

  function renderError(page) {
    return `
            <section class="panel confirmation-panel">
                <div class="success-orb"><i class="bi bi-exclamation-lg"></i></div>
                <h2>Section unavailable</h2>
                <p>The ${escapeHtml(page.replaceAll("_", " "))} workspace could not be loaded.</p>
                <button class="btn btn-navy" data-nav-target="dashboard_home">Return to dashboard</button>
            </section>
        `;
  }

  function hydrateLocalInteractions(root) {
    const results = $("#room-results", root);
    $(".filter-panel .btn", root)?.addEventListener("click", () => {
      if (!results) return;
      results.style.opacity = ".45";
      window.setTimeout(() => {
        results.style.opacity = "1";
        showToast("Availability results updated.");
      }, 420);
    });

    $$(".coupon-box button", root).forEach((button) => {
      button.addEventListener("click", () =>
        showToast("Coupon validation is ready for backend integration."),
      );
    });
  }

  function showToast(message) {
    const stack = $(selectors.toastStack);
    if (!stack || !message) return;
    const toast = document.createElement("div");
    toast.className = "guest-toast";
    toast.textContent = message;
    stack.appendChild(toast);
    window.setTimeout(() => toast.remove(), 3200);
  }

  function closeSidebar() {
    $(selectors.app)?.classList.remove("sidebar-open");
  }

  function escapeHtml(value) {
    return value.replace(
      /[&<>"']/g,
      (char) =>
        ({
          "&": "&amp;",
          "<": "&lt;",
          ">": "&gt;",
          '"': "&quot;",
          "'": "&#039;",
        })[char],
    );
  }

  return { init, loadPage, showToast };
})();

document.addEventListener("DOMContentLoaded", GuestDashboard.init);
