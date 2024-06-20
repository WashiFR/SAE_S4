import 'package:flutter/material.dart';
import 'package:webdir_app/models/entree.dart';
import 'package:url_launcher/url_launcher.dart';

class AnnuaireDetail extends StatelessWidget {
  final Entree entree;

  AnnuaireDetail({required this.entree});

  String getInitials(String prenom, String nom) {
    return "${prenom[0].toUpperCase()}${nom[0].toUpperCase()}";
  }

  Future<void> _launchEmail(String email) async {
    final Uri emailUri = Uri(
      scheme: 'mailto',
      path: email,
    );
    if (await canLaunch(emailUri.toString())) {
      await launch(emailUri.toString());
    } else {
      throw 'Could not launch $emailUri';
    }
  }

  Future<void> _launchPhone(String phoneNumber) async {
    final Uri phoneUri = Uri(
      scheme: 'tel',
      path: phoneNumber,
    );
    if (await canLaunch(phoneUri.toString())) {
      await launch(phoneUri.toString());
    } else {
      throw 'Could not launch $phoneUri';
    }
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
            const SizedBox(height: 10),
            Row(
              children: [
                const Icon(Icons.work,
                    color: Color.fromARGB(255, 233, 233, 233)),
                const SizedBox(width: 10),
                const Text(
                  'Fonction:',
                  style: TextStyle(
                    fontSize: 14,
                    color: Color.fromARGB(255, 223, 223, 223),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 5),
            Text(
              entree.fonction,
              style: const TextStyle(
                fontSize: 14,
                color: Color.fromARGB(255, 223, 223, 223),
              ),
            ),
            const SizedBox(height: 20),
            const Divider(color: Color.fromARGB(255, 90, 90, 90)),
            Row(
              children: [
                const Icon(Icons.business,
                    color: Color.fromARGB(255, 223, 223, 223)),
                const SizedBox(width: 10),
                const Text(
                  'Numéro de bureau:',
                  style: TextStyle(
                    fontSize: 14,
                    color: Color.fromARGB(255, 223, 223, 223),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 5),
            Text(
              entree.numBureau,
              style: const TextStyle(
                fontSize: 14,
                color: Color.fromARGB(255, 223, 223, 223),
              ),
            ),
            const SizedBox(height: 20),
            const Divider(color: Color.fromARGB(255, 90, 90, 90)),
            Row(
              children: [
                const Icon(Icons.phone,
                    color: Color.fromARGB(255, 223, 223, 223)),
                const SizedBox(width: 10),
                const Text(
                  'Numéro fixe:',
                  style: TextStyle(
                    fontSize: 14,
                    color: Color.fromARGB(255, 223, 223, 223),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 5),
            Text(
              entree.numFixe,
              style: const TextStyle(
                fontSize: 14,
                color: Color.fromARGB(255, 223, 223, 223),
              ),
            ),
            const SizedBox(height: 20),
            const Divider(color: Color.fromARGB(255, 90, 90, 90)),
            Row(
              children: [
                const Icon(Icons.phone_android, color: Colors.white),
                const SizedBox(width: 10),
                const Text(
                  'Numéro mobile:',
                  style: TextStyle(
                    fontSize: 14,
                    color: Color.fromARGB(255, 223, 223, 223),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 5),
            GestureDetector(
              onTap: () => _launchPhone(entree.numMobile),
              child: Text(
                entree.numMobile,
                style: const TextStyle(
                  fontSize: 14,
                  color: Color.fromARGB(255, 26, 115, 189),
                  decoration: TextDecoration.underline,
                ),
              ),
            ),
            const SizedBox(height: 20),
            const Divider(color: Color.fromARGB(255, 90, 90, 90)),
            Row(
              children: [
                const Icon(Icons.email, color: Colors.white),
                const SizedBox(width: 10),
                const Text(
                  'Email:',
                  style: TextStyle(
                    fontSize: 14,
                    color: Color.fromARGB(255, 223, 223, 223),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 5),
            GestureDetector(
              onTap: () => _launchEmail(entree.email),
              child: Text(
                entree.email,
                style: const TextStyle(
                  fontSize: 14,
                  color: Color.fromARGB(255, 26, 115, 189),
                  decoration: TextDecoration.underline,
                ),
              ),
            ),
            const SizedBox(height: 20),
            const Divider(color: Color.fromARGB(255, 90, 90, 90)),
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
                '- ${departement.nomDep}',
                style: const TextStyle(
                  fontSize: 14,
                  color: Color.fromARGB(255, 223, 223, 223),
                ),
              ),
            const Divider(color: Color.fromARGB(255, 90, 90, 90)),
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
                '- ${service.nomService}',
                style: const TextStyle(
                  fontSize: 14,
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
