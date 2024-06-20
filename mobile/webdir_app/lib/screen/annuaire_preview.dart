import 'package:flutter/material.dart';
import 'package:webdir_app/models/entree.dart';
import 'package:webdir_app/widget/initial_circle.dart';
import 'package:webdir_app/screen/annuaire_detail.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class AnnuairePreview extends StatelessWidget {
  final Entree entree;

  AnnuairePreview({required this.entree});

  String getInitials(String prenom, String nom) {
    return "${prenom[0].toUpperCase()}${nom[0].toUpperCase()}";
  }

  Future<Entree> fetchEntreeDetail(int id) async {
    final response = await http.get(
      Uri.parse('http://docketu.iutnc.univ-lorraine.fr:14201/api/entrees/$id'),
    );
    if (response.statusCode == 200) {
      var jsonResponse = json.decode(response.body);
      if (jsonResponse['entrees'] != null &&
          jsonResponse['entrees'].isNotEmpty) {
        return Entree.fromJson(jsonResponse['entrees'][0]['entree']);
      } else {
        throw Exception('No entree found');
      }
    } else {
      throw Exception('Failed to load entree details');
    }
  }

  @override
  Widget build(BuildContext context) {
    return ListTile(
      leading: InitialCircle(
        initials: getInitials(entree.prenom, entree.nom),
      ),
      title: Text('${entree.prenom} ${entree.nom}',
          style: const TextStyle(color: Color.fromARGB(255, 223, 223, 223))),
      subtitle: Text(entree.departements.map((d) => d.nomDep).join(", "),
          style: const TextStyle(color: Color.fromARGB(255, 171, 176, 180))),
      onTap: () async {
        try {
          Entree detailedEntree = await fetchEntreeDetail(entree.id);
          print(detailedEntree.numBureau);
          print(detailedEntree.numFixe);
          print(detailedEntree.numMobile);
          print(detailedEntree.fonction);
          Navigator.push(
            context,
            MaterialPageRoute(
              builder: (context) => AnnuaireDetail(entree: detailedEntree),
            ),
          );
        } catch (error) {
          print('Failed to load entree details: $error');
        }
      },
    );
  }
}
