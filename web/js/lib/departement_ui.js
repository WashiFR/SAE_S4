import {
    fetchDepartements,
    parseDepartements,
    fetchAllEntries
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
