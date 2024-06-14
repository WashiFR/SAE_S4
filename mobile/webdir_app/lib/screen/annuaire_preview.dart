import 'package:flutter/material.dart';
import 'package:webdir_app/models/entree.dart';
import 'package:webdir_app/widget/initial_circle.dart';
import 'package:webdir_app/screen/annuaire_detail.dart';

class AnnuairePreview extends StatelessWidget {
  final Entree entree;

  AnnuairePreview({required this.entree});

  String getInitials(String prenom, String nom) {
    return "${prenom[0].toUpperCase()}${nom[0].toUpperCase()}";
  }

  @override
  Widget build(BuildContext context) {
    return ListTile(
      leading: InitialCircle(
        initials: getInitials(entree.prenom, entree.nom),
      ),
      title: Text('${entree.prenom} ${entree.nom}',
          style: const TextStyle(color: Color.fromARGB(255, 223, 223, 223))),
      subtitle: Text('Fonction: ${entree.fonction}',
          style: const TextStyle(color: Color.fromARGB(255, 171, 176, 180))),
      onTap: () => Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => AnnuaireDetail(entree: entree),
        ),
      ),
    );
  }
}
