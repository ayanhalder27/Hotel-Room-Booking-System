// Base API path
const API_BASE = "../../Controler/ReceptionistController/";

// DOM helpers
function qs(selector, root = document) {
  return root.querySelector(selector);
}

function qsa(selector, root = document) {
  return [...root.querySelectorAll(selector)];
}

// Escape HTML entities
function esc(value) {
  return String(value ?? "").replace(
    /[&<>'"]/g,
    (c) =>
      ({
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        "'": "&#039;",
        '"': "&quot;",
      })[c],
  );
}

// Status badge generator
function badge(status) {
  const s = String(status || "").toLowerCase();

  const cls =
    s.includes("paid") || s.includes("available") || s.includes("completed")
      ? "success"
      : s.includes("pending") || s.includes("dirty")
        ? "warning"
        : s.includes("occupied") || s.includes("progress")
          ? "info"
          : s.includes("cancel") ||
              s.includes("maintenance") ||
              s.includes("blocked")
            ? "danger"
            : "muted";

  return `<span class="badge badge-${cls}">${esc(s.replaceAll("_", " "))}</span>`;
}

// Format money
function money(value) {
  return Number(value || 0).toFixed(2);
}

// Alert box handler
function showAlert(message, ok = true) {
  const box = qs("#alertBox");

  if (!box) {
    alert(message);
    return;
  }

  box.className = `alert show ${ok ? "alert-success" : "alert-error"}`;
  box.textContent = message;

  setTimeout(() => box.classList.remove("show"), 4000);
}

// API wrapper
async function api(controller, data = {}) {
  const fd = new FormData();
  Object.entries(data).forEach(([key, value]) => fd.append(key, value));

  const res = await fetch(API_BASE + controller, {
    method: "POST",
    body: fd,
    credentials: "same-origin",
  });

  const text = await res.text();

  try {
    return JSON.parse(text);
  } catch (e) {
    throw new Error(`Invalid JSON from ${controller}: ${text.slice(0, 250)}`);
  }
}

// Page loader
async function loadPage(url, push = true) {
  const content = qs("#appContent");
  content.innerHTML = '<div class="card loading">Loading...</div>';

  const res = await fetch(url + (url.includes("?") ? "&" : "?") + "partial=1", {
    credentials: "same-origin",
  });

  const html = await res.text();
  content.innerHTML = html;

  const section = content.querySelector("[data-page-title]");
  const title = section?.dataset.pageTitle || "Receptionist Panel";

  qs("#pageHeading").textContent = title;
  document.title = title;

  qsa(".nav-link").forEach((a) =>
    a.classList.toggle("active", a.getAttribute("href") === url),
  );

  if (push) {
    history.pushState({ url }, "", url);
  }

  const script = section?.dataset.pageScript;
  if (script) loadScript(script);
}

// Load page-specific script
function loadScript(src) {
  document
    .querySelectorAll("script[data-page-script]")
    .forEach((s) => s.remove());

  const script = document.createElement("script");
  script.src = src + "?v=" + Date.now();
  script.dataset.pageScript = "1";

  document.body.appendChild(script);
}

// Navigation handling
document.addEventListener("click", (e) => {
  const link = e.target.closest("a.nav-link");
  if (!link || link.dataset.normalLink === "true") return;

  e.preventDefault();
  loadPage(link.getAttribute("href"));
});

// Browser history handling
window.addEventListener("popstate", (e) => {
  if (e.state?.url) loadPage(e.state.url, false);
});
