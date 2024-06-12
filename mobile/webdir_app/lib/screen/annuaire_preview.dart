import 'package:flutter/material.dart';
import '../models/personne.dart';

class AnnuairePreview extends StatelessWidget {
  final Personne personne;

  AnnuairePreview({required this.personne});

  @override
  Widget build(BuildContext context) {
    return ListTile(
      title: Text(personne.nom),
      subtitle: Text(personne.telephoneMobile),
    );
  }
}
