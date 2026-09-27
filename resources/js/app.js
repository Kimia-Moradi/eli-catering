  (function () {
    var toggle = document.getElementById('navToggle');
    var panel = document.getElementById('mobileNavPanel');
    if (!toggle || !panel) return;

    function closePanel() {
      panel.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
    }
    function togglePanel() {
      var isOpen = panel.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', String(isOpen));
    }

    toggle.addEventListener('click', togglePanel);
    panel.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', closePanel);
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closePanel();
    });
  })();

  (function () {
    // Admin menu-management page only — auto-submits the date-jump form on
    // change so picking a date navigates immediately, instead of requiring
    // an extra click on "برو". The form still works with this disabled.
    var datePicker = document.getElementById('menuDatePicker');
    if (!datePicker) return;

    datePicker.addEventListener('change', function () {
      this.form.submit();
    });
  })();
