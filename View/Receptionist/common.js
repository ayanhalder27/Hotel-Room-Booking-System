function showAlert(id, message, type = 'success') {
    const box = document.getElementById(id);
    if (!box) return;
    box.className = `alert show ${type === 'success' ? 'alert-success' : 'alert-error'}`;
    box.textContent = message;
    setTimeout(() => { box.className = 'alert'; box.textContent = ''; }, 4000);
}
async function postForm(url, formData) {
    const response = await fetch(url, { method: 'POST', body: formData });
    return await response.json();
}
async function getJson(url) {
    const response = await fetch(url);
    return await response.json();
}
function badge(status) {
    const s = String(status || '').toLowerCase();
    let cls = 'badge-muted';
    if (['available','paid','completed','checked_in'].includes(s)) cls = 'badge-success';
    if (['pending','dirty','in_progress'].includes(s)) cls = 'badge-warning';
    if (['cancelled','maintenance','blocked'].includes(s)) cls = 'badge-danger';
    if (['confirmed','occupied'].includes(s)) cls = 'badge-info';
    return `<span class="badge ${cls}">${s.replaceAll('_',' ')}</span>`;
}
