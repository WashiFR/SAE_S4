import 'package:flutter/material.dart';
import 'package:faker/faker.dart';
import 'package:webdir_app/models/personne.dart';
import 'package:webdir_app/models/service.dart';
import 'package:webdir_app/screen/annuaire_preview.dart';

class AnnuaireMaster extends StatefulWidget {
  @override
  _AnnuaireMasterState createState() => _AnnuaireMasterState();
}

class _AnnuaireMasterState extends State<AnnuaireMaster> {
  List<Personne>? _personnes;
  List<Service>? _services;

  @override
  void initState() {
    super.initState();
    _fetchPersonnes().then((personnes) {
      setState(() {
        _personnes = personnes;
      });
    });
    _fetchServices().then((services) {
      setState(() {
        _services = services;
      });
    });
  }

  Future<List<Personne>> _fetchPersonnes() async {
    final faker = Faker();
    return List.generate(10, (index) {
      return Personne(
        id: index,
        nom: faker.lorem.word(),
        prenom: faker.lorem.word(),
        numeroBureau: faker.lorem.word(),
        telephoneFixe: faker.lorem.word(),
        telephoneMobile: faker.lorem.word(),
        email: faker.lorem.word(),
        serviceId: index,
      );
    });
  }

  Future<List<Service>> _fetchServices() async {
    final faker = Faker();
    return List.generate(100, (index) {
      return Service(
        id: index,
        nom: faker.lorem.word(),
        description: faker.lorem.sentence(),
        etage: faker.lorem.word(),
      );
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: Text('Annuaire'),
        ),
        body: _personnes == null
            ? Center(child: CircularProgressIndicator())
            : ListView.builder(
                itemCount: _personnes!.length,
                itemBuilder: (context, index) {
                  final personne = _personnes![index];
                  return GestureDetector(
                      child: AnnuairePreview(personne: personne));
                },
              ));
  }
}
