import { fetchAllEntries } from './webdirloader.js';

export async function afficherEntreesParDepartement() {
    try {
        const annuaire = await fetchAllEntries();
        const entreesParDepartement = annuaire.reduce((acc, entree) => {
            entree.departement.forEach(dept => {
                const nomDep = dept.nomDep;
                if (!acc[nomDep]) {
                    acc[nomDep] = [];
                }
                acc[nomDep].push(entree);
            });
            return acc;
        }, {});

        afficherAnnuaireParDepartement(entreesParDepartement);
    } catch (error) {
        console.error('Error displaying entries by department:', error);
    }
}

function afficherAnnuaireParDepartement(entreesParDepartement) {
    const annuaireDiv = document.getElementById('annuaire');
    annuaireDiv.innerHTML = ''; // Clear the current content

    for (const departement in entreesParDepartement) {
        const deptDiv = document.createElement('div');
        deptDiv.classList.add('departement');
        deptDiv.innerHTML = `<h2>Département: ${departement}</h2>`;

        entreesParDepartement[departement].forEach(entree => {
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
            deptDiv.appendChild(personDiv);
        });

        annuaireDiv.appendChild(deptDiv);
    }
}
