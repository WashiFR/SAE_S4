import 'package:flutter/material.dart';
import 'package:webdir_app/data/data_generator.dart';
import 'package:webdir_app/models/entree.dart';
import 'package:webdir_app/screen/annuaire_detail.dart';
import 'package:webdir_app/models/service.dart';
import 'package:webdir_app/models/departement.dart';
import 'package:webdir_app/widget/filter_dialog.dart';
import 'package:webdir_app/widget/search_name.dart';
import 'package:webdir_app/widget/initial_circle.dart';

class AnnuaireMaster extends StatefulWidget {
  @override
  _AnnuaireMasterState createState() => _AnnuaireMasterState();
}

class _AnnuaireMasterState extends State<AnnuaireMaster> {
  List<Entree> entrees;
  List<Entree> filteredEntrees;
  List<Service> services;
  List<Departement> departements;
  String? selectedService;
  String? selectedDepartement;
  TextEditingController searchController = TextEditingController();

  _AnnuaireMasterState()
      : entrees = DataGenerator().generateEntrees(10),
        filteredEntrees = [],
        services = [],
        departements = [] {
    filteredEntrees = entrees;
    services = entrees.expand((e) => e.services).toSet().toList();
    departements = entrees.expand((e) => e.departements).toSet().toList();
  }

  void filterEntrees() {
    setState(() {
      filteredEntrees = entrees.where((entree) {
        final matchesService = selectedService == null ||
            selectedService!.isEmpty ||
            entree.services.any((s) => s.nom.contains(selectedService!));
        final matchesDepartement = selectedDepartement == null ||
            selectedDepartement!.isEmpty ||
            entree.departements
                .any((d) => d.nom.contains(selectedDepartement!));
        final matchesName = searchController.text.isEmpty ||
            entree.nom
                .toLowerCase()
                .contains(searchController.text.toLowerCase()) ||
            entree.prenom
                .toLowerCase()
                .contains(searchController.text.toLowerCase());
        return matchesService && matchesDepartement && matchesName;
      }).toList();
    });
  }

  void resetFilters() {
    setState(() {
      selectedService = null;
      selectedDepartement = null;
      searchController.clear();
      filteredEntrees = entrees;
    });
  }

  void openFilterDialog() {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return FilterDialog(
          services: services,
          departements: departements,
          selectedService: selectedService,
          selectedDepartement: selectedDepartement,
          onServiceChanged: (value) {
            setState(() {
              selectedService = value;
            });
          },
          onDepartementChanged: (value) {
            setState(() {
              selectedDepartement = value;
            });
          },
          onReset: resetFilters,
        );
      },
    ).then((_) {
      filterEntrees();
    });
  }

  String getInitials(String prenom, String nom) {
    return "${prenom[0].toUpperCase()}${nom[0].toUpperCase()}";
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Annuaire'),
        actions: [
          IconButton(
            icon: Icon(Icons.filter_list),
            onPressed: openFilterDialog,
          ),
        ],
      ),
      body: Column(
        children: [
          SearchName(
            controller: searchController,
            onChanged: (value) {
              filterEntrees();
            },
          ),
          Expanded(
            child: ListView.builder(
              itemCount: filteredEntrees.length,
              itemBuilder: (context, index) {
                var entree = filteredEntrees[index];
                return Column(
                  children: [
                    ListTile(
                      leading: InitialCircle(
                        initials: getInitials(entree.prenom, entree.nom),
                      ),
                      title: Text('${entree.prenom} ${entree.nom}'),
                      subtitle: Text(
                        'Fonction: ${entree.fonction}\nBureau: ${entree.numBureau}',
                      ),
                      onTap: () => Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (context) => AnnuaireDetail(entree: entree),
                        ),
                      ),
                    ),
                    Divider(color: Colors.black),
                  ],
                );
              },
            ),
          ),
        ],
      ),
    );
  }
}
