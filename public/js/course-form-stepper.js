(() => {
    const stepNames = ['Course details', 'Materials', 'Post-course ToDo', 'Review'];
    const todoTypes = { '1': 'Survey answers', '2': 'Tests', '3': 'Reports' };

    function initStepper(root) {
        const form = root.querySelector('[data-course-form]');
        const panels = Array.from(root.querySelectorAll('[data-step-panel]'));
        const indicators = Array.from(root.querySelectorAll('[data-step-indicator]'));
        const back = root.querySelector('[data-step-previous]');
        const next = root.querySelector('[data-step-next]');
        const submit = root.querySelector('[data-step-submit]');
        const count = root.querySelector('[data-step-count]');
        if (!form || panels.length !== indicators.length || !panels.length) return;

        let current = 0;
        let enhanced = false;

        const visibleControls = (panel) => Array.from(panel.querySelectorAll('input, select, textarea, button'))
            .filter((control) => !control.disabled && control.getClientRects().length > 0);

        function activate(index, focusHeading = false) {
            current = Math.max(0, Math.min(index, panels.length - 1));
            panels.forEach((panel, panelIndex) => {
                const active = panelIndex === current;
                panel.hidden = !active;
                panel.setAttribute('aria-hidden', String(!active));
                if ('inert' in panel) panel.inert = !active;
            });
            indicators.forEach((button, buttonIndex) => {
                button.classList.toggle('is-current', buttonIndex === current);
                button.classList.toggle('is-complete', buttonIndex < current);
                if (buttonIndex === current) button.setAttribute('aria-current', 'step');
                else button.removeAttribute('aria-current');
            });
            back.hidden = current === 0;
            next.hidden = current === panels.length - 1;
            submit.hidden = current !== panels.length - 1;
            count.textContent = `Step ${current + 1} of ${panels.length}: ${stepNames[current] || panels[current].dataset.stepLabel}`;
            if (focusHeading) {
                const heading = panels[current].querySelector('h2');
                if (heading) {
                    heading.setAttribute('tabindex', '-1');
                    heading.focus({ preventScroll: true });
                }
            }
        }

        function firstInvalid(panel) {
            return visibleControls(panel).find((control) => typeof control.checkValidity === 'function' && !control.checkValidity());
        }

        function validateCurrent() {
            const invalid = firstInvalid(panels[current]);
            if (!invalid) return true;
            invalid.reportValidity();
            invalid.focus();
            return false;
        }

        function updateSummary() {
            const value = (selector) => form.querySelector(selector)?.value?.trim() || '-';
            const setText = (key, text) => {
                const target = root.querySelector(`[data-course-summary="${key}"]`);
                if (target) target.textContent = text;
            };
            setText('name', value('[name="coursename"]'));
            setText('classification', form.querySelector('#course_classification_id option:checked')?.textContent?.trim() || '-');
            setText('detail', form.querySelector('#course_classification_details_id option:checked')?.textContent?.trim() || '-');
            setText('todo-type', todoTypes[form.querySelector('[name="todo_type"]:checked')?.value] || '-');
            setText('todo-description', value('[name="todo_description"]'));
            setText('questions', String(form.querySelectorAll('[name^="todo["][name$="[question]"]').length));

            const materialList = root.querySelector('[data-course-summary="materials"]');
            if (materialList) {
                const names = Array.from(form.querySelectorAll('[name^="teaching_material["][name$="[teaching_material_name]"]'))
                    .map((input) => input.value.trim()).filter(Boolean);
                materialList.replaceChildren();
                if (!names.length) {
                    const empty = document.createElement('li');
                    empty.textContent = 'No material added';
                    materialList.append(empty);
                } else {
                    names.forEach((name) => {
                        const item = document.createElement('li');
                        item.textContent = name;
                        materialList.append(item);
                    });
                }
            }
        }

        function stepForErrors() {
            let errors = [];
            try { errors = JSON.parse(form.dataset.validationErrors || '[]'); } catch (_) { return 0; }
            for (const key of errors) {
                if (key.startsWith('teaching_material')) return 1;
                if (key === 'todo_type' || key === 'todo_description' || key === 'repeated_retest' || key === 'test_passed_score' || key.startsWith('todo.')) return 2;
            }
            return 0;
        }

        root.classList.add('is-enhanced');
        enhanced = true;
        activate(stepForErrors());
        updateSummary();

        back.addEventListener('click', () => activate(current - 1, true));
        next.addEventListener('click', () => {
            if (validateCurrent()) activate(current + 1, true);
        });
        indicators.forEach((button, index) => button.addEventListener('click', () => {
            if (index < current) activate(index, true);
            else if (index === current + 1 && validateCurrent()) activate(index, true);
        }));
        form.addEventListener('input', updateSummary);
        form.addEventListener('change', updateSummary);
        form.addEventListener('submit', (event) => {
            for (let index = 0; index < panels.length; index += 1) {
                const invalid = firstInvalid(panels[index]);
                if (invalid) {
                    event.preventDefault();
                    activate(index, true);
                    requestAnimationFrame(() => {
                        invalid.reportValidity();
                        invalid.focus();
                    });
                    return;
                }
            }
        });
    }

    document.querySelectorAll('[data-course-stepper]').forEach(initStepper);
})();
