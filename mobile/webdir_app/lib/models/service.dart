class Service {
  final int id;
  final String nomService;
  final String etage;
  final String description;

  Service({
    required this.id,
    required this.nomService,
    required this.etage,
    required this.description,
  });

  factory Service.fromJson(Map<String, dynamic> json) {
    return Service(
      id: json['id'] as int? ?? 0,
      nomService: json['nom'] ?? json['NomService'] ?? '',
      etage: json['etage'] as String? ?? '',
      description: json['description'] as String? ?? '',
    );
  }
}
