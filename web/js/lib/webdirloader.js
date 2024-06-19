import { API_URL } from './config.js';

export async function fetchAllEntries() {
    try {
        const response = await fetch(API_URL);
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const data = await response.json();
        //console.log(data);
        return parseEntries(data);
    } catch (error) {
        console.error('Fetch error: ', error);
        throw error;
    }
}

function parseEntries(data) {
    let datamap = Object.values(data.entrees).map(item => ({
        id: item.entree.id,
        nom: item.entree.nom,
        prenom: item.entree.prenom,
        href: item.links.self.href,
        departement : item.entree.departements
    }));

    //console.log(datamap);
    return datamap;
}

export async function fetchEntryById(id) {
    try {
        const response = await fetch(`${API_URL}/${id}`);
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return await response.json();
    } catch (error) {
        console.error('Fetch error: ', error);
        throw error;
    }
}

export async function parseEntry(dataUser) {
    const usermap = Object.values(dataUser.entrees).map(item => ({
        id: item.entree.id,
        nom: item.entree.nom,
        prenom: item.entree.prenom,
        fonction: item.entree.fonction,
        numbureau: item.entree.NumeroBureau,
        numfixe: item.entree.NumeroFixe,
        nummobile: item.entree.NumeroMobile,
        email: item.entree.Email
    }));
    return usermap[0];

}

export async function fetchFilteredEntries(queryParams) {
    const query = new URLSearchParams(queryParams).toString();
    try {
        const response = await fetch(`${API_URL}?${query}`);
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return await response.json();
    } catch (error) {
        console.error('Fetch error: ', error);
        throw error;
    }
}
