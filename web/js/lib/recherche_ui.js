import { fetchFilteredEntries, parseEntries } from './webdirloader.js';

export async function afficherRechercheParNom() {
    const annuaireDiv = document.getElementById('annuaire');
    annuaireDiv.innerHTML = `
        <div id="recherche">
            <input type="text" id="rechercheNom" placeholder="Rechercher par nom">
            <button id="btnRechercher">Rechercher</button>
        </div>
        <div id="resultatsRecherche"></div>
    `;

    document.getElementById('btnRechercher').addEventListener('click', async () => {
        const termeRecherche = document.getElementById('rechercheNom').value.trim().toLowerCase();
        if (termeRecherche) {
            const resultats = await rechercherParNom(termeRecherche);
            afficherResultatsRecherche(resultats);
        }
    });
}

async function rechercherParNom(terme) {
    try {
        const resultatsAPI = await fetchFilteredEntries({ q: terme });
        return parseEntries(resultatsAPI);
    } catch (error) {
        console.error('Error searching entries:', error);
    }
}

function afficherResultatsRecherche(resultats) {
    const resultatsDiv = document.getElementById('resultatsRecherche');
    resultatsDiv.innerHTML = ''; // Clear previous results

    resultats.forEach(entree => {
        const personDiv = document.createElement('div');
        personDiv.classList.add('entree');
        const dept = entree.departement.map(d => d.nomDep).join(', ');
        personDiv.innerHTML = `
            <div id="entree">
            <h2>${entree.nom}, ${entree.prenom}</h2>
            <p>Département : ${dept}</p>
            <p class="detailsEntree" data-id="${entree.id}">Voir la fiche détaillée</p>
            </div>
        `;

        resultatsDiv.appendChild(personDiv);
    });
}
