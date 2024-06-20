import { fetchFilteredEntries, parseEntries } from './webdirloader.js';
import {afficherAnnuaire} from "./dir_ui.js";

export async function afficherRechercheParNom(search) {
    const annuaireDiv = document.getElementById('annuaire');
    const data = await fetchFilteredEntries(search);
    const annuaire = parseEntries(data);
    afficherAnnuaire(annuaire);
}
