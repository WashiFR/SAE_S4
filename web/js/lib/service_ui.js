import {fetchAllEntries, fetchServices, parseServices} from './webdirloader.js';
import {afficherAnnuaire} from "./dir_ui.js";

export async function afficherEntreesParService() {
    const selectedService = document.getElementById('serviceSelect').value;
    if (selectedService) {
        const allEntries = await fetchAllEntries();
        const parsedEntries = parseServices(allEntries);
        const filteredEntries = parsedEntries.filter(entree =>
            entree.service && entree.service.some(serv => serv.NomService === selectedService)
        );
        console.log(filteredEntries);
        afficherAnnuaire(filteredEntries);
    } else {
        alert('Veuillez sélectionner un service.');
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
