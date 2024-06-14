import 'package:flutter/material.dart';
import 'package:webdir_app/data/data_generator.dart';
import 'package:webdir_app/models/entree.dart';
import 'package:webdir_app/screen/annuaire_detail.dart';
import 'package:webdir_app/models/service.dart';
import 'package:webdir_app/models/departement.dart';
import 'package:webdir_app/widget/filter_dialog.dart';
import 'package:webdir_app/widget/search_name.dart';
import 'package:webdir_app/widget/initial_circle.dart';
import 'package:webdir_app/widget/sort_order_widget.dart'; // Importez le nouveau widget

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
  String sortOrder = 'asc';
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

  @override
  void initState() {
    super.initState();
    filterEntrees();
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
      sortEntrees();
    });
  }

  void sortEntrees() {
    setState(() {
      filteredEntrees.sort((a, b) {
        int cmp = a.nom.compareTo(b.nom);
        if (cmp == 0) {
          cmp = a.prenom.compareTo(b.prenom);
        }
        return sortOrder == 'asc' ? cmp : -cmp;
      });
    });
  }

  void resetFilters() {
    setState(() {
      selectedService = null;
      selectedDepartement = null;
      searchController.clear();
      filteredEntrees = entrees;
      sortEntrees();
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
        title: Text('Annuaire',
            style: TextStyle(color: Color.fromARGB(255, 223, 223, 223))),
        backgroundColor: Colors.grey[900],
        actions: [
          IconButton(
            icon: Icon(Icons.filter_list,
                color: Color.fromARGB(255, 223, 223, 223)),
            onPressed: openFilterDialog,
          ),
          SortOrderWidget(
            sortOrder: sortOrder,
            onSortOrderChanged: (value) {
              setState(() {
                sortOrder = value;
                sortEntrees();
              });
            },
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
                      title: Text('${entree.prenom} ${entree.nom}',
                          style: TextStyle(
                              color: Color.fromARGB(255, 223, 223, 223))),
                      subtitle: Text(
                          'Fonction: ${entree.fonction}\nBureau: ${entree.numBureau}',
                          style: TextStyle(
                              color: Color.fromARGB(255, 171, 176, 180))),
                      onTap: () => Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (context) => AnnuaireDetail(entree: entree),
                        ),
                      ),
                    ),
                    Divider(color: const Color.fromARGB(255, 90, 90, 90)),
                  ],
                );
              },
            ),
          ),
        ],
      ),
      backgroundColor: Colors.grey[900],
    );
  }
}
