import {fetchAllEntries, fetchServices, parseServices} from './webdirloader.js';
import {afficherAnnuaire} from "./dir_ui.js";

export async function afficherEntreesParService() {
    const selectedService = document.getElementById('serviceSelect').value;
    if (selectedService) {
        let filtered = []
        const allEntries = await fetchAllEntries();
        if(selectedService === "Tous") {
            filtered =  allEntries;
        } else {
            allEntries.forEach(ent => {
                const remaining_element = ent.service.filter((val, key) => val.NomService === selectedService);
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
        alert('Veuillez sélectionner un service.');
    }
}

export async function remplirServices() {
    const data = await fetchServices();
    const services = parseServices(data);
    const serviceSelect = document.getElementById('serviceSelect');
    //console.log(services);
    services.forEach(item =>  {
        const option = document.createElement('option');
        option.value = item.NomService;
        option.text = item.NomService;
        serviceSelect.appendChild(option);
    });

}


/*function afficherAnnuaireParService(entreesParService) {
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
*/