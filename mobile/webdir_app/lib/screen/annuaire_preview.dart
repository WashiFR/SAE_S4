import 'package:flutter/material.dart';
import '../models/entree.dart';

class AnnuairePreview extends StatelessWidget {
  final Entree personne;

  AnnuairePreview({required this.personne});

  @override
  Widget build(BuildContext context) {
    return ListTile(
      title: Text(personne.nom),
      subtitle: Text(personne.numMobile),
    );
  }
}
