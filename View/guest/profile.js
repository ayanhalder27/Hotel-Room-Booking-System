async function loadProfile() {
  try {
    const r = await api("profile_controller.php", { action: "get" });
    if (!r.success) return showAlert(r.message, false);
    Object.entries(r.data).forEach(([k, v]) => {
      const el = qs(`[name="${k}"]`);
      if (el) el.value = v ?? "";
    });
  } catch (e) {
    showAlert(e.message, false);
  }
}
qs("#profileForm")?.addEventListener("submit", async (e) => {
  e.preventDefault();
  const d = Object.fromEntries(new FormData(e.target));
  d.action = "update_profile";
  try {
    const r = await api("profile_controller.php", d);
    showAlert(r.message, r.success);
  } catch (err) {
    showAlert(err.message, false);
  }
});
qs("#passwordForm")?.addEventListener("submit", async (e) => {
  e.preventDefault();
  const d = Object.fromEntries(new FormData(e.target));
  d.action = "change_password";
  try {
    const r = await api("profile_controller.php", d);
    showAlert(r.message, r.success);
    if (r.success) e.target.reset();
  } catch (err) {
    showAlert(err.message, false);
  }
});
loadProfile();
