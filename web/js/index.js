import { afficherToutesLesEntrees } from './lib/dir_ui.js';
import { afficherFicheDetails } from './lib/fiche_ui.js';
import { afficherEntreesParService } from './lib/service_ui.js';
import { afficherEntreesParDepartement } from './lib/departement_ui.js';
import { afficherRechercheParNom } from './lib/recherche_ui.js';

document.addEventListener('DOMContentLoaded', function() {
    afficherToutesLesEntrees().then();
});

document.addEventListener('DOMContentLoaded', () => {
    document.body.addEventListener('click', (event) => {
        if (event.target.classList.contains('detailsEntree')) {
            const id = event.target.dataset.id;
            afficherFicheDetails(id).then();
        }
    });
});

document.getElementById('home').addEventListener('click', () => {
    location.reload();
});

document.getElementById('entreeService').addEventListener('click', () => {
    afficherEntreesParService().then();
});

document.getElementById('annuaire').addEventListener('click', (event) => {
    if (event.target.id === 'btnTrier') { afficherToutesLesEntrees(true).then() }
    });

document.getElementById('entreeDept').addEventListener('click', () => {
    afficherEntreesParDepartement().then();
});

document.getElementById('entreeNom').addEventListener('click', () => {
    afficherRechercheParNom().then();
});



