import { API_URL } from './config.js';
import {fetchEntryById, parseEntry} from './webdirloader.js';

export async function afficherFicheDetails(id) {
    try {
        const data = await fetchEntryById(id);
        console.log(data);
        const entree = await parseEntry(data);
        const ficheDetails = document.getElementById('ficheDetails');

        ficheDetails.innerHTML = `
            <h2>${entree.nom}, ${entree.prenom}</h2>
            <p>ID: ${entree.id}</p>
            <p>Fonction: ${entree.fonction}</p>
            <p>n° bureau: ${entree.numbureau}</p>
            <p>Téléphone fixe: ${entree.numfixe}</p>
            <p>Téléphone mobile: ${entree.nummobile}</p>
            <p>Email: ${entree.email}</p>
            <a href="mailto:${entree.email}">Envoyer un email</a>
        `;
    } catch (error) {
        console.error('Error fetching entry details:', error);
    }
}
