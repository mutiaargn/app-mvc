// Menu mobile
const toggle = document.getElementById('menuToggle');
const nav = document.getElementById('nav');
if (toggle && nav) {
  const setOpen = (open) => {
    nav.classList.toggle('open', open);
    toggle.setAttribute('aria-expanded', String(open));
  };
  toggle.addEventListener('click', () => setOpen(!nav.classList.contains('open')));
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setOpen(false); });
}

// Konfirmasi (form dengan data-confirm) + cegah klik ganda saat submit
document.addEventListener('submit', (e) => {
  const form = e.target;
  const msg = form.dataset ? form.dataset.confirm : null;
  if (msg && !window.confirm(msg)) {
    e.preventDefault();
    return;
  }
  const btn = form.querySelector('button[type="submit"], button:not([type])');
  if (btn) setTimeout(() => { btn.disabled = true; }, 0);
});

// Aktifkan lagi tombol jika halaman dipulihkan dari tombol "Kembali" browser
window.addEventListener('pageshow', (e) => {
  if (e.persisted) document.querySelectorAll('button[disabled]').forEach((b) => { b.disabled = false; });
});
