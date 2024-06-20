import {
    fetchDepartements,
    parseDepartements,
    fetchFilteredEntries,
    parseEntries,
    fetchAllEntries, fetchDepartementById, fetchServices, parseServices
} from './webdirloader.js';
import {afficherAnnuaire} from "./dir_ui.js";

export async function afficherTriParDepartement() {
    const selectedDepartement = document.getElementById('departementSelect').value;
    if (selectedDepartement) {
        let filtered = []
        const allEntries = await fetchAllEntries();
        if(selectedDepartement === "Tous") {
            filtered =  allEntries;
        } else {
            allEntries.forEach(ent => {
                const remaining_element = ent.departements.filter((val, key) => val.NomDep === selectedDepartement);
                if(remaining_element.length > 0) {
                    filtered.push(ent)
                }
            })
        }
        filtered.sort(function (a, b) {
            return a.nom.localeCompare(b.nom);
        });

        afficherAnnuaire(filtered);
    } else {
        alert('Veuillez sélectionner un département.');
    }
}

/*export async function afficherTriParDepartement() {
    const annuaireDiv = document.getElementById('annuaire');
    annuaireDiv.innerHTML = ''; // Clear previous content
    try {
        const data = await fetchDepartements();
        const departements = parseDepartements(data);
        const navDetailsDiv = document.getElementById('nav_details');
        // Création de la String de la liste déroulante
            let list = `<select id="departementSelect">`
            list += `<option value="" disabled selected>Sélectionner un département</option>`

            data.departements.forEach(dept => {

                // Ajout des items de la liste déroulante
                console.log(dept.departement)
                list += `<option value="${dept.departement.id}">${dept.departement.nom}</option>`
            })

            // Intégration de la liste dans le HTML final
            navDetailsDiv.innerHTML += list + `</select>
        <button id="validerDepartement">Valider</button>`
        const button = document.getElementById('validerDepartement');
        button.addEventListener('click', async () => {
            const selectedDeptId = document.getElementById('departementSelect').value;
            if (selectedDeptId !== null) {
                const data = await fetchAllEntries();
                const entrees = parseEntries(data);
                const dept = fetchDepartementById(selectedDeptId);
                const deptf = parseDepartements(dept);
                afficherResultatsParDepartement(entrees, deptf);
            }
        });
    } catch (error) {
        console.error('Error fetching or parsing departments:', error);
    }
}*/

function afficherResultatsParDepartement(entrees, deptf) {
    const annuaireDiv = document.getElementById('annuaire');
    annuaireDiv.innerHTML = ''; // Clear previous content

    entrees.forEach(entree => {
        let depte;
        for(let i = 0; i < entree.departements.length; i++){
           depte.add(entree.departements[i].NomDep)
        }
        if(depte.contains(deptf.nomDep)){
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

            annuaireDiv.appendChild(personDiv);
        }
    });
}

export async function remplirDepartements() {
    const data = await fetchDepartements();
    const departements = parseDepartements(data);

    console.log(departements);
    const departementSelect = document.getElementById('departementSelect');
    departements.forEach(departement => {
        const option = document.createElement('option');
        option.value = departement.departement.nom;
        option.text = departement.departement.nom;
        departementSelect.appendChild(option);
    });
}
