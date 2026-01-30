import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-color-field]').forEach((field) => {
        const picker = field.querySelector('[data-color-picker]');
        const input = field.querySelector('[data-color-input]');

        if (!picker || !input) {
            return;
        }

        const syncToInput = () => {
            input.value = picker.value;
        };

        const syncToPicker = () => {
            if (/^#[0-9a-fA-F]{6}$/.test(input.value)) {
                picker.value = input.value;
            }
        };

        syncToPicker();

        picker.addEventListener('input', syncToInput);
        input.addEventListener('input', syncToPicker);
    });
});
