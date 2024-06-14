import 'package:webdir_app/models/service.dart';
import 'package:webdir_app/models/departement.dart';

class Entree {
  final int id;
  final String nom;
  final String prenom;
  final String fonction;
  final String numBureau;
  final String numFixe;
  final String numMobile;
  final String email;
  List<Service> services = [];
  List<Departement> departements = [];

  Entree({
    required this.id,
    required this.nom,
    required this.prenom,
    required this.fonction,
    required this.numBureau,
    required this.numFixe,
    required this.numMobile,
    required this.email,
  });
}
