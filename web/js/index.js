import { afficherToutesLesEntrees } from './lib/dir_ui.js';
import { afficherFicheDetails } from './lib/fiche_ui.js';

document.addEventListener('DOMContentLoaded', function() {
    afficherToutesLesEntrees().then();
});

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('annuaire').addEventListener('click', (event) => {
        if (event.target.classList.contains('detailsEntree')) {
            const id = event.target.dataset.id;
            afficherFicheDetails(id).then();
        }
    });
});


