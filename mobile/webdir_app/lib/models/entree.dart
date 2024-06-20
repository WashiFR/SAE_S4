import 'service.dart';
import 'departement.dart';

class Entree {
  final int id;
  final String nom;
  final String prenom;
  final String fonction;
  final String numBureau;
  final String numFixe;
  final String numMobile;
  final String email;
  final List<Service> services;
  final List<Departement> departements;

  Entree({
    required this.id,
    required this.nom,
    required this.prenom,
    required this.fonction,
    required this.numBureau,
    required this.numFixe,
    required this.numMobile,
    required this.email,
    required this.services,
    required this.departements,
  });

  factory Entree.fromJson(Map<String, dynamic> json) {
    var servicesFromJson = json['services'] as List? ?? [];
    var departementsFromJson = json['departements'] as List? ?? [];
    List<Service> servicesList =
        servicesFromJson.map((i) => Service.fromJson(i)).toList();
    List<Departement> departementsList =
        departementsFromJson.map((i) => Departement.fromJson(i)).toList();

    return Entree(
      id: json['id'] ?? 0,
      nom: json['nom'] ?? '',
      prenom: json['prenom'] ?? '',
      fonction: json['fonction'] ?? '',
      numBureau: json['NumeroBureau'] ?? '',
      numFixe: json['NumeroFixe'] ?? '',
      numMobile: json['NumeroMobile'] ?? '',
      email: json['Email'] ?? '',
      services: servicesList,
      departements: departementsList,
    );
  }
}
