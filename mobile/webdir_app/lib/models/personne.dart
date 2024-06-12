class Personne {
  final int id;
  final String nom;
  final String prenom;
  final String numeroBureau;
  final String? telephoneFixe;
  final String telephoneMobile;
  final String email;
  final String? imageUrl;
  final int serviceId;

  Personne({
    required this.id,
    required this.nom,
    required this.prenom,
    required this.numeroBureau,
    required this.telephoneFixe,
    required this.telephoneMobile,
    required this.email,
    this.imageUrl,
    required this.serviceId,
  });
}
