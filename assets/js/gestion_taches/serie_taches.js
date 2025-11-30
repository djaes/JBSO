    document.addEventListener('DOMContentLoaded', () => {
        const list = document.getElementById('tache-list');
        if (!list) return;

        // Logique de glisser-déposer ici
        console.log("Script série_taches.js chargé pour la série");
    });
        let draggedItem = null;
    // Fonction pour mettre à jour l'ordre dans la base de données
    async function updateOrdre(tache_id, nouveau_ordre) {
        const response = await fetch(window.location.href, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `update_ordre=true&tache_id=${tache_id}&nouveau_ordre=${nouveau_ordre}`
        });
        return response.ok;
    }

    // Fonction pour recalculer et mettre à jour tous les ordres
    async function updateAllOrdres() {
        const list = document.getElementById('tache-list');
        const items = list.querySelectorAll('.list-group-item');

        // Met à jour visuellement les ordres
        items.forEach((item, index) => {
            const newOrdre = index + 1;
            item.dataset.ordre = newOrdre;
            item.querySelector('.ordre-value').textContent = newOrdre;
        });

        // Met à jour la base de données
        const updates = Array.from(items).map((item, index) => ({
            tache_id: item.dataset.id,
            nouveau_ordre: index + 1
        }));

        try {
            const response = await fetch(window.location.href, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ update_all_ordres: true, updates })
            });
            if (!response.ok) throw new Error("Erreur lors de la mise à jour");
            return true;
        } catch (error) {
            console.error("Erreur:", error);
            return false;
        }
    }

    // Gestion du glisser-déposer
    document.addEventListener('DOMContentLoaded', () => {
        const list = document.getElementById('tache-list');
        if (!list) return;

        let draggedItem = null;


        // Rendre les éléments "draggable"
        Array.from(list.children).forEach(item => {
            item.setAttribute('draggable', true);
        });

        list.addEventListener('dragstart', (e) => {
            if (e.target.tagName === 'LI') {
                draggedItem = e.target;
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/html', e.target.innerHTML);
                setTimeout(() => {
                    e.target.style.display = 'none'; // Masque l'élément glissé
                }, 0);
            }
        });

        list.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            const targetItem = e.target.closest('li');
            if (targetItem && targetItem !== draggedItem) {
                const rect = targetItem.getBoundingClientRect();
                const next = (e.clientY - rect.top) / (rect.bottom - rect.top) > 0.5;
                list.insertBefore(draggedItem, next ? targetItem.nextSibling : targetItem);
            }
        });

        list.addEventListener('dragend', async (e) => {
            e.preventDefault();
            draggedItem.style.display = ''; // Réaffiche l'élément

            // Récupère les nouveaux ordres
            const items = Array.from(list.children);
            const updates = items.map((item, index) => ({
                tache_id: item.dataset.id,
                nouveau_ordre: index + 1
            }));

            // Envoie toutes les mises à jour en une seule requête
            try {
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ update_all_ordres: true, updates })
                });
                if (!response.ok) throw new Error("Erreur lors de la mise à jour");
                window.location.reload(); // Recharge pour afficher les changements
            } catch (error) {
                console.error("Erreur:", error);
                alert("Une erreur est survenue. Veuillez réessayer.");
            }
        });
    });
