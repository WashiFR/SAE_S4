import 'package:flutter/material.dart';
import 'package:webdir_app/models/entree.dart';

class AnnuaireDetail extends StatelessWidget {
  final Entree entree;

  AnnuaireDetail({required this.entree});

  String getInitials(String prenom, String nom) {
    return "${prenom[0].toUpperCase()}${nom[0].toUpperCase()}";
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('${entree.prenom} ${entree.nom}'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Center(
              child: CircleAvatar(
                radius: 50,
                backgroundColor: Colors.blue,
                child: Text(
                  getInitials(entree.prenom, entree.nom),
                  style: TextStyle(
                    fontSize: 40,
                    color: Colors.white,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ),
            ),
            SizedBox(height: 20),
            Text(
              '${entree.prenom} ${entree.nom}',
              style: TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.bold,
              ),
            ),
            SizedBox(height: 10),
            Text(
              'Fonction: ${entree.fonction}',
              style: TextStyle(
                fontSize: 18,
              ),
            ),
            SizedBox(height: 20),
            Row(
              children: [
                Icon(Icons.business),
                SizedBox(width: 10),
                Text(
                  'Numéro de bureau: ${entree.numBureau}',
                  style: TextStyle(
                    fontSize: 18,
                  ),
                ),
              ],
            ),
            SizedBox(height: 10),
            Row(
              children: [
                Icon(Icons.phone),
                SizedBox(width: 10),
                Text(
                  'Numéro fixe: ${entree.numFixe}',
                  style: TextStyle(
                    fontSize: 18,
                  ),
                ),
              ],
            ),
            SizedBox(height: 10),
            Row(
              children: [
                Icon(Icons.phone_android),
                SizedBox(width: 10),
                Text(
                  'Numéro mobile: ${entree.numMobile}',
                  style: TextStyle(
                    fontSize: 18,
                  ),
                ),
              ],
            ),
            SizedBox(height: 10),
            Row(
              children: [
                Icon(Icons.email),
                SizedBox(width: 10),
                Text(
                  'Email: ${entree.email}',
                  style: TextStyle(
                    fontSize: 18,
                  ),
                ),
              ],
            ),
            SizedBox(height: 20),
            Text(
              'Services:',
              style: TextStyle(
                fontSize: 20,
                fontWeight: FontWeight.bold,
              ),
            ),
            for (var service in entree.services)
              Text(
                '- ${service.nom} (${service.description})',
                style: TextStyle(
                  fontSize: 18,
                ),
              ),
            SizedBox(height: 20),
            Text(
              'Départements:',
              style: TextStyle(
                fontSize: 20,
                fontWeight: FontWeight.bold,
              ),
            ),
            for (var departement in entree.departements)
              Text(
                '- ${departement.nom} (${departement.description})',
                style: TextStyle(
                  fontSize: 18,
                ),
              ),
          ],
        ),
      ),
    );
  }
}
