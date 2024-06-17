import { API_URL } from './config.js';

export async function fetchAllEntries() {
    try {
        const response = await fetch(API_URL);
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return await response.json();
    } catch (error) {
        console.error('Fetch error: ', error);
        throw error;
    }
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
