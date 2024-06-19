import { fetchAllEntries } from './webdirloader.js';

export async function afficherToutesLesEntrees() {
    try {
        const annuaire = await fetchAllEntries();

        annuaire.sort((a, b) => a.nom.localeCompare(b.nom)); // Tri par nom de famille
        afficherAnnuaire(annuaire);
    } catch (error) {
        console.error('Erreur:', error);
    }
}

function afficherAnnuaire(annuaire) {
    const annuaireDiv = document.getElementById('annuaire');
    annuaireDiv.innerHTML = `
        <!--<div id="divbtnTri"><button id="btnTrier">Trier (A...Z)</button></div>-->
        `;
    annuaire.forEach(entree => {
        const personDiv = document.createElement('div');
        personDiv.classList.add('entree');
        const dept = entree.departement.map(d => ({
            dpt : d.nomDep
        }));
        personDiv.innerHTML = `
            <div id="entree">
            <h2>${entree.nom}, ${entree.prenom}</h2>
            <p>Département : ${dept.dpt}</p>
            <p class="detailsEntree" data-id="${entree.id}">Voir la fiche détaillée</p>
            </div>
        `;

        annuaireDiv.appendChild(personDiv);
    });
}
