import { API_URL } from './config.js';

export async function fetchAllEntries() {
    try {
        const response = await fetch(API_URL+'/entrees');
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const data = await response.json();
        console.log(data);
        return parseEntries(data);
    } catch (error) {
        console.error('Fetch error: ', error);
        throw error;
    }
}

export function parseEntries(data) {
    let datamap = Object.values(data.entrees).map(item => ({
        id: item.entree.id,
        nom: item.entree.nom,
        prenom: item.entree.prenom,
        href: item.links.self.href,
        departements : item.entree.departements,
        service : item.entree.services,
    }));

    console.log(datamap);
    return datamap;
}

export async function fetchEntryById(id) {
    try {
        const response = await fetch(`${API_URL}/entrees/${id}`);
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

export async function fetchFilteredEntries(search) {
    try {
        const response = await fetch(`${API_URL}/entrees/search?q=${search}`);
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return await response.json();
    } catch (error) {
        console.error('Fetch error: ', error);
        throw error;
    }
}

export async function fetchDepartements() {
    try {
        const response = await fetch(`${API_URL}/departements`);
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return await response.json();
    } catch (error) {
        console.error('Fetch error: ', error);
        throw error;
    }
}

export async function fetchDepartementById(id) {
    try {
        const response = await fetch(`${API_URL}/departements/${id}`);
    } catch (error) {
        console.error('Fetch error: ', error);
        throw error;
    }
}

    export function parseDepartements(data) {

    return data.departements;
    //     sortie.sort((a, b) => a.nom.localeCompare(b.nom));
    //
    // //console.log(data);
    //     return Object.values(data.departements).map(item => ({
    //         id: item.departement.id,
    //         NomDep: item.departement.nom,
    //         description: item.departement.description
    //     }));
    }

export async function fetchServices() {
    try {
        const response = await fetch(`${API_URL}/services`);
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return await response.json();
    } catch (error) {
        console.error('Fetch error: ', error);
    }
}

export function parseServices(data) {
    //console.log(data);
    return Object.values(data.services).map(item => ({
        id: item.service.id,
        NomService: item.service.nom,
        description: item.service.description
    }));
}

