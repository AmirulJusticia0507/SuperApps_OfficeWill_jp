import './bootstrap';

document.addEventListener('show.bs.modal', (event) => {
    const modal = event.target;
    if (modal instanceof HTMLElement && modal.classList.contains('modal') && modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }
});
