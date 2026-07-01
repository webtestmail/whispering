(function () {
    function reindexRepeater(container) {
        container.querySelectorAll('[data-repeater-item]').forEach(function (item, index) {
            item.querySelectorAll('[name]').forEach(function (input) {
                input.name = input.name.replace(/\[\d+\]/, '[' + index + ']');
            });
        });
    }

    document.addEventListener('click', function (e) {
        var addBtn = e.target.closest('[data-repeater-add]');
        if (addBtn) {
            var container = document.querySelector(addBtn.getAttribute('data-target'));
            var template = document.querySelector(addBtn.getAttribute('data-template'));
            if (!container || !template) return;

            var clone = template.content.cloneNode(true);
            container.appendChild(clone);
            reindexRepeater(container);
            return;
        }

        var removeBtn = e.target.closest('[data-repeater-remove]');
        if (removeBtn) {
            var row = removeBtn.closest('[data-repeater-item]');
            var parent = row && row.parentElement;
            if (row && parent) {
                row.remove();
                reindexRepeater(parent);
            }
        }
    });
})();
