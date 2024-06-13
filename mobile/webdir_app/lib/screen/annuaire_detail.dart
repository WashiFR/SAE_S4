import 'package:flutter/material.dart';
import 'package:webdir_app/models/entree.dart';

class AnnuaireDetail extends StatelessWidget {
  final Entree entree;

  AnnuaireDetail({required this.entree});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('${entree.nom} ${entree.prenom}'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('Fonction: ${entree.fonction}'),
            Text('Numéro de bureau: ${entree.numBureau}'),
            Text('Téléphone fixe: ${entree.numFixe}'),
            Text('Téléphone mobile: ${entree.numMobile}'),
            Text('Email: ${entree.email}'),
            SizedBox(height: 20),
            Text('Services:'),
            for (var service in entree.services)
              Text('${service.nom} (Étage: ${service.etage})'),
            SizedBox(height: 20),
            Text('Départements:'),
            for (var departement in entree.departements)
              Text('${departement.nom} (Étage: ${departement.etage})'),
          ],
        ),
      ),
    );
  }
}
