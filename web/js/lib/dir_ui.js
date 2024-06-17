import { fetchAllEntries } from './webdirloader.js';

export async function afficherToutesLesEntrees() {
    try {
        const data = await fetchAllEntries();
        const annuaire = data.entrees;
        //data.filter((a, b) => a.nom.localeCompare(b.nom)); // Tri par nom de famille
        afficherAnnuaire(data);
    } catch (error) {
        console.error('Erreur:', error);
    }
}

function afficherAnnuaire(annuaire) {
    const annuaireDiv = document.getElementById('annuaire');
    annuaireDiv.innerHTML = '';  // Clear any existing content
    annuaire.forEach(entree => {
        const personDiv = document.createElement('div');
        personDiv.classList.add('entree');

        personDiv.innerHTML = `
            <div id="entree">
            <h2>${person.nom}, ${person.prenom}</h2>
            <p>Fonction: ${person.fonction}</p>
            <a id="detailsEntree">Voir la fiche détaillée</a>
            </div>
        `;

        annuaireDiv.appendChild(personDiv);
    });
}
