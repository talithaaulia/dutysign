// DASAR REUSABLE
function tambahDasar(containerId, value = '') {
    const container = document.getElementById(containerId);
    const row = document.createElement('div');
    row.classList.add('row', 'mb-2', 'dasar-item', 'align-items-start');
    row.innerHTML = `
        <div class="col-auto pt-2 dasar-number">?</div>
        <div class="col">
            <textarea name="dasar[]" class="form-control" placeholder="Isi dasar peraturan atau referensi" required>${value}</textarea>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-outline-danger" onclick="hapusDasar(this, '${containerId}')">&times;</button>
        </div>
    `;
    container.appendChild(row);
    updateNomorDasar(containerId);
}

function hapusDasar(btn, containerId) {
    const item = btn.closest('.dasar-item');
    if (item) {
        item.remove();
        updateNomorDasar(containerId);
    }
}

function updateNomorDasar(containerId) {
    const items = document.querySelectorAll(`#${containerId} .dasar-item`);
    items.forEach((it, idx) => {
        const num = it.querySelector('.dasar-number');
        if (num) num.textContent = `${idx + 1}.`;
    });
}
