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
        title: Text('${entree.prenom} ${entree.nom}',
            style: const TextStyle(
              color: Color.fromARGB(255, 223, 223, 223),
            )),
        backgroundColor: Colors.grey[900],
        iconTheme: const IconThemeData(color: Colors.white),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Center(
              child: CircleAvatar(
                radius: 45,
                backgroundColor: Colors.blue,
                child: Text(
                  getInitials(entree.prenom, entree.nom),
                  style: const TextStyle(
                    fontSize: 36,
                    color: Color.fromARGB(255, 223, 223, 223),
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ),
            ),
            SizedBox(height: 20),
            Text(
              '${entree.prenom} ${entree.nom}',
              style: const TextStyle(
                fontSize: 20,
                fontWeight: FontWeight.bold,
                color: Color.fromARGB(255, 223, 223, 223),
              ),
            ),
            SizedBox(height: 10),
            Row(
              children: [
                const Icon(Icons.work,
                    color: Color.fromARGB(255, 223, 223, 223)),
                SizedBox(width: 10),
                Text(
                  entree.fonction,
                  style: const TextStyle(
                    fontSize: 14,
                    color: Color.fromARGB(255, 223, 223, 223),
                  ),
                ),
              ],
            ),
            SizedBox(height: 20),
            Row(
              children: [
                const Icon(Icons.business,
                    color: Color.fromARGB(255, 223, 223, 223)),
                SizedBox(width: 10),
                Text(
                  'Numéro de bureau: ${entree.numBureau}',
                  style: const TextStyle(
                    fontSize: 14,
                    color: Color.fromARGB(255, 223, 223, 223),
                  ),
                ),
              ],
            ),
            SizedBox(height: 10),
            Row(
              children: [
                const Icon(Icons.phone,
                    color: Color.fromARGB(255, 223, 223, 223)),
                SizedBox(width: 10),
                Text(
                  'Numéro fixe: ${entree.numFixe}',
                  style: const TextStyle(
                    fontSize: 14,
                    color: Color.fromARGB(255, 223, 223, 223),
                  ),
                ),
              ],
            ),
            SizedBox(height: 10),
            Row(
              children: [
                const Icon(Icons.phone_android, color: Colors.white),
                SizedBox(width: 10),
                Text(
                  'Numéro mobile: ${entree.numMobile}',
                  style: const TextStyle(
                    fontSize: 14,
                    color: Color.fromARGB(255, 223, 223, 223),
                  ),
                ),
              ],
            ),
            SizedBox(height: 10),
            Row(
              children: [
                const Icon(Icons.email, color: Colors.white),
                SizedBox(width: 10),
                Text(
                  'Email: ${entree.email}',
                  style: const TextStyle(
                    fontSize: 14,
                    color: Color.fromARGB(255, 223, 223, 223),
                  ),
                ),
              ],
            ),
            SizedBox(height: 20),
            const Text(
              'Services:',
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.bold,
                color: Color.fromARGB(255, 223, 223, 223),
              ),
            ),
            for (var service in entree.services)
              Text(
                '- ${service.nom} (${service.description})',
                style: const TextStyle(
                  fontSize: 14,
                  color: Color.fromARGB(255, 223, 223, 223),
                ),
              ),
            SizedBox(height: 20),
            const Text(
              'Départements:',
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.bold,
                color: Color.fromARGB(255, 223, 223, 223),
              ),
            ),
            for (var departement in entree.departements)
              Text(
                '- ${departement.nom} (${departement.description})',
                style: const TextStyle(
                  fontSize: 16,
                  color: Color.fromARGB(255, 223, 223, 223),
                ),
              ),
          ],
        ),
      ),
      backgroundColor: Colors.grey[900],
    );
  }
}
