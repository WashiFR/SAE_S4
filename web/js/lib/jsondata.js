const { faker } = require('@faker-js/faker');

function generateData() {
    const data = [];
    for (let i = 0; i < 100; i++) {
        data.push({
            id: i,
            firstName: faker.name.firstName(),
            lastName: faker.name.lastName(),
            jobTitle: faker.name.jobTitle(),
            department: faker.commerce.department(),
            phone: faker.phone.phoneNumber(),
            mobile: faker.phone.phoneNumber(),
            email: faker.internet.email()
        });
    }
    return data;
}

const directoryData = generateData();
console.log(JSON.stringify(directoryData, null, 2));