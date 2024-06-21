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