/*
 | Admin panel JavaScript: add / remove rows and confirm before deleting.
 */

// A new number for each new row, so form field names never repeat.
// Starting from the current time avoids clashing with existing row numbers.
let nextIndex = Date.now();

document.querySelectorAll('[data-repeater]').forEach((box) => {
    const rows = box.querySelector('[data-rows]');
    const template = box.querySelector('template');
    const addBtn = box.querySelector('[data-add]');
    const maxRows = Number(box.dataset.maxRows || 0);

    const syncLimit = () => {
        if (!maxRows || !addBtn) return;
        const count = rows.querySelectorAll('[data-row]').length;
        addBtn.disabled = count >= maxRows;
        addBtn.style.opacity = count >= maxRows ? '0.45' : '';
        addBtn.style.cursor = count >= maxRows ? 'not-allowed' : '';
    };

    syncLimit();
    box.syncLimit = syncLimit;

    // "+ Add" button: copy the blank row from <template>
    addBtn.addEventListener('click', () => {
        if (maxRows && rows.querySelectorAll('[data-row]').length >= maxRows) return;
        const html = template.innerHTML.replaceAll('__INDEX__', nextIndex++);
        rows.insertAdjacentHTML('beforeend', html);
        syncLimit();
    });
});

// "Delete" button on a row. The row is removed from the database after you click Save.
document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-remove]');
    if (button) {
        const box = button.closest('[data-repeater]');
        button.closest('[data-row]').remove();
        if (box?.syncLimit) box.syncLimit();
    }
});

// Ask "Are you sure?" before submitting delete forms
document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!confirm(form.dataset.confirm)) {
            event.preventDefault();
        }
    });
});

// Status popup (success / validation failed)
const statusPopup = document.getElementById('statusPopup');
if (statusPopup) {
    const closePopup = () => {
        statusPopup.hidden = true;
        const firstInvalid = document.querySelector('.is-invalid');
        if (firstInvalid) {
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstInvalid.focus({ preventScroll: true });
        }
    };

    statusPopup.querySelectorAll('[data-popup-close]').forEach((btn) => {
        btn.addEventListener('click', closePopup);
    });

    statusPopup.addEventListener('click', (event) => {
        if (event.target === statusPopup) {
            closePopup();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !statusPopup.hidden) {
            closePopup();
        }
    });
}

// Live character counter for all inputs/textareas with maxlength
function initCharCounters(root = document) {
    root.querySelectorAll('.pg-admin input[maxlength], .pg-admin textarea[maxlength]').forEach((input) => {
        if (input.type === 'password' || input.dataset.counterInit) return;
        const field = input.closest('.field');
        if (!field) return;

        input.dataset.counterInit = '1';
        const max = input.getAttribute('maxlength');
        let counter = field.querySelector('[data-char-counter]');

        if (!counter) {
            counter = document.createElement('span');
            counter.className = 'char-counter';
            const hint = field.querySelector(':scope > .field-hint');
            if (hint) {
                const meta = document.createElement('div');
                meta.className = 'field-meta';
                hint.replaceWith(meta);
                meta.append(hint, counter);
            } else {
                input.insertAdjacentElement('afterend', counter);
            }
        }

        const update = () => {
            counter.textContent = `${input.value.length} / ${max}`;
        };
        input.addEventListener('input', update);
        update();
    });
}

initCharCounters();

// Initialize counters on newly added repeater rows
document.querySelectorAll('[data-repeater] [data-add]').forEach((btn) => {
    btn.addEventListener('click', () => {
        const rows = btn.closest('[data-repeater]')?.querySelector('[data-rows]');
        if (rows) initCharCounters(rows);
    });
});
