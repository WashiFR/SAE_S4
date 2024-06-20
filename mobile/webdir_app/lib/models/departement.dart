class Departement {
  final int id;
  final String nomDep;
  final String etage;
  final String description;

  Departement({
    required this.id,
    required this.nomDep,
    required this.etage,
    required this.description,
  });

  factory Departement.fromJson(Map<String, dynamic> json) {
    return Departement(
      id: json['id'] as int? ?? 0,
      nomDep: json['nom'] ?? json['NomDep'] ?? '',
      etage: json['etage'] as String? ?? '',
      description: json['description'] as String? ?? '',
    );
  }
}
