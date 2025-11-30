<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validation du formulaire
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    // Validation des dates
    document.getElementById('date_debut').addEventListener('change', function() {
        var dateDebut = new Date(this.value);
        var dateFinInput = document.getElementById('date_fin');
        if (dateFinInput.value) {
            var dateFin = new Date(dateFinInput.value);
            if (dateFin < dateDebut) {
                dateFinInput.setCustomValidity("La date de fin doit être postérieure à la date de début");
            } else {
                dateFinInput.setCustomValidity('');
            }
        }
    });

    document.getElementById('date_fin').addEventListener('change', function() {
        var dateFin = new Date(this.value);
        var dateDebut = new Date(document.getElementById('date_debut').value);
        if (dateFin < dateDebut) {
            this.setCustomValidity("La date de fin doit être postérieure à la date de début");
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>
