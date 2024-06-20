import { afficherToutesLesEntrees } from './lib/dir_ui.js';
import { afficherFicheDetails } from './lib/fiche_ui.js';
import {afficherEntreesParService, remplirServices} from './lib/service_ui.js';
import {afficherTriParDepartement, remplirDepartements} from './lib/departement_ui.js';
import { afficherRechercheParNom } from './lib/recherche_ui.js';
import {fetchAllEntries} from "./lib/webdirloader.js";
import {afficherAnnuaire} from "./lib/dir_ui.js";


// affiche les entrees et remplit les select
document.addEventListener('DOMContentLoaded', function() {
    afficherToutesLesEntrees().then();
    remplirDepartements().then();
    remplirServices().then();
});

// affiche le detail d'une entree au clic sur le lien
document.addEventListener('DOMContentLoaded', () => {
    document.body.addEventListener('click', (event) => {
        if (event.target.classList.contains('detailsEntree')) {
            const id = event.target.dataset.id;
            afficherFicheDetails(id).then();
        }
    });
});

// bouton retour depuis une fiche detaillee
document.addEventListener('DOMContentLoaded', () => {
    document.body.addEventListener('click', (event) => {
        if (document.getElementById('retour')) {
            document.getElementById('annuaire').innerHTML = '';
            afficherToutesLesEntrees().then();
        }
    });
});

//reset la page
document.getElementById('reset').addEventListener('click', () => {
    location.reload();
});

//affiche les entrees par service
document.getElementById('validerService').addEventListener('click', async function() {
    afficherEntreesParService().then();
});

//affiche les entrees par departement
document.getElementById('validerDepartement').addEventListener('click', async function() {
    afficherTriParDepartement().then();
});


//affiche les entrees par recherche
document.getElementById('validerRecherche').addEventListener('click', () => {
    var search= document.getElementById('searchInput').value;
    afficherRechercheParNom(search).then();
});



