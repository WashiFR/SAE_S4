import 'package:faker/faker.dart';
import 'package:webdir_app/models/entree.dart';
import 'package:webdir_app/models/departement.dart';
import 'package:webdir_app/models/service.dart';

class DataGenerator {
  final faker = Faker();

  List<Service> generateServices(int count) {
    return List.generate(count, (index) {
      return Service(
        id: index,
        nom: faker.company.name(),
        etage: faker.randomGenerator.integer(10).toString(),
        description: faker.lorem.sentence(),
      );
    });
  }

  List<Departement> generateDepartements(int count) {
    return List.generate(count, (index) {
      return Departement(
        id: index,
        nom: faker.company.name(),
        etage: faker.randomGenerator.integer(10).toString(),
        description: faker.lorem.sentence(),
      );
    });
  }

  List<Entree> generateEntrees(int count) {
    var services = generateServices(5);
    var departements = generateDepartements(5);

    return List.generate(count, (index) {
      var entree = Entree(
        id: index,
        nom: faker.person.lastName(),
        prenom: faker.person.firstName(),
        fonction: faker.job.title(),
        numBureau: faker.randomGenerator.integer(100).toString(),
        numFixe: faker.phoneNumber.us(),
        numMobile: faker.phoneNumber.us(),
        email: faker.internet.email(),
      );

      entree.services = (services..shuffle()).take(2).toList();
      entree.departements = (departements..shuffle()).take(2).toList();

      return entree;
    })
      ..sort((a, b) => a.nom.compareTo(b.nom));
  }
}
