@php
    $formId = $formId ?? 'search-form';
@endphp
<script>
(function () {
    var form = document.getElementById(@json($formId));
    if (!form) return;

    function filterOptionInputs() {
        return form.querySelectorAll(
            'input[name="selected_categories[]"]:not(:disabled), input[name="selected_brands[]"]'
        );
    }

    function selectedFilterCount() {
        var n = 0;
        filterOptionInputs().forEach(function (inp) {
            if (inp.checked && !inp.disabled) n++;
        });
        return n;
    }

    function updateApplyLabels() {
        var n = selectedFilterCount();
        form.querySelectorAll('.js-product-filter-apply-count').forEach(function (el) {
            el.textContent = n ? ' (' + n + ')' : '';
        });
    }

    filterOptionInputs().forEach(function (inp) {
        inp.addEventListener('change', updateApplyLabels);
    });

    form.querySelectorAll('.js-product-filter-clear').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            filterOptionInputs().forEach(function (inp) {
                inp.checked = false;
            });
            updateApplyLabels();
        });
    });

    form.querySelectorAll('.js-product-filter-apply').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            form.submit();
        });
    });

    updateApplyLabels();
})();
</script>
