import { fetchAllEntries } from './webdirloader.js';

export async function afficherEntreesParService() {
    try {
        const annuaire = await fetchAllEntries();
        const entreesParService = annuaire.reduce((acc, entree) => {
            const service = entree.service;
            if (!acc[service]) {
                acc[service] = [];
            }
            acc[service].push(entree);
            return acc;
        }, {});

        afficherAnnuaireParService(entreesParService);
    } catch (error) {
        console.error('Error displaying entries by service:', error);
    }
}

function afficherAnnuaireParService(entreesParService) {
    const annuaireDiv = document.getElementById('annuaire');
    annuaireDiv.innerHTML = ''; // Clear the current content

    for (const service in entreesParService) {
        const serviceDiv = document.createElement('div');
        serviceDiv.classList.add('service');
        serviceDiv.innerHTML = `<h2>Service: ${service}</h2>`;

        entreesParService[service].forEach(entree => {
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
            serviceDiv.appendChild(personDiv);
        });

        annuaireDiv.appendChild(serviceDiv);
    }
}
