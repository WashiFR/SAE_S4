import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:webdir_app/models/entree.dart';
import 'package:webdir_app/models/service.dart';
import 'package:webdir_app/models/departement.dart';
import 'package:webdir_app/screen/annuaire_preview.dart';
import 'package:webdir_app/widget/search_name.dart';
import 'package:webdir_app/widget/filter_dialog.dart';

class AnnuaireMaster extends StatefulWidget {
  @override
  _AnnuaireMasterState createState() => _AnnuaireMasterState();
}

class _AnnuaireMasterState extends State<AnnuaireMaster> {
  late Future<List<Entree>> futureEntrees;
  final TextEditingController searchController = TextEditingController();
  String searchQuery = '';
  List<Entree> entrees = [];
  List<Service> services = [];
  List<Departement> departements = [];
  String? selectedService;
  String? selectedDepartement;

  @override
  void initState() {
    super.initState();
    fetchServicesAndDepartments();
    futureEntrees = fetchEntrees();
    searchController.addListener(() {
      setState(() {
        searchQuery = searchController.text;
        applyFilters();
      });
    });
  }

  Future<List<Entree>> fetchEntrees() async {
    final url = 'http://docketu.iutnc.univ-lorraine.fr:14201/api/entrees';
    final response = await http.get(Uri.parse(url));
    if (response.statusCode == 200) {
      var jsonResponse = json.decode(response.body);
      List<Entree> entrees = [];
      for (var e in jsonResponse['entrees']) {
        try {
          var entree = Entree.fromJson(e['entree']);
          entrees.add(entree);
        } catch (error) {
          print('Error parsing entree: $error');
        }
      }
      return entrees;
    } else {
      throw Exception('Failed to load entrees');
    }
  }

  Future<void> fetchServicesAndDepartments() async {
    final servicesResponse = await http.get(
        Uri.parse('http://docketu.iutnc.univ-lorraine.fr:14201/api/services'));
    if (servicesResponse.statusCode == 200) {
      var jsonResponse = json.decode(servicesResponse.body);
      setState(() {
        services = (jsonResponse['services'] as List)
            .map((data) => Service.fromJson(data['service']))
            .toList();
      });
    } else {
      throw Exception('Failed to load services');
    }

    final departmentsResponse = await http.get(Uri.parse(
        'http://docketu.iutnc.univ-lorraine.fr:14201/api/departements'));
    if (departmentsResponse.statusCode == 200) {
      var jsonResponse = json.decode(departmentsResponse.body);
      setState(() {
        departements = (jsonResponse['départements'] as List)
            .map((data) => Departement.fromJson(data['département']))
            .toList();
      });
    } else {
      throw Exception('Failed to load departments');
    }
  }

  void applyFilters() {
    setState(() {
      futureEntrees = fetchEntrees().then((entries) {
        return filterAndSortEntrees(entries);
      });
    });
  }

  List<Entree> filterAndSortEntrees(List<Entree> entries) {
    List<Entree> filteredEntries = entries;

    if (selectedService != null && selectedService!.isNotEmpty) {
      filteredEntries = filteredEntries.where((entry) {
        return entry.services.any((s) => s.nomService == selectedService);
      }).toList();
    }

    if (selectedDepartement != null && selectedDepartement!.isNotEmpty) {
      filteredEntries = filteredEntries.where((entry) {
        return entry.departements.any((d) => d.nomDep == selectedDepartement);
      }).toList();
    }

    if (searchQuery.isNotEmpty) {
      filteredEntries = filteredEntries.where((entry) {
        return entry.nom.toLowerCase().contains(searchQuery.toLowerCase()) ||
            entry.prenom.toLowerCase().contains(searchQuery.toLowerCase());
      }).toList();
    }

    return filteredEntries;
  }

  void openFilterDialog() {
    showDialog(
      context: context,
      builder: (context) {
        return FilterDialog(
          services: services,
          departements: departements,
          selectedService: selectedService,
          selectedDepartement: selectedDepartement,
          onServiceChanged: (value) {
            setState(() {
              selectedService = value;
              applyFilters();
            });
          },
          onDepartementChanged: (value) {
            setState(() {
              selectedDepartement = value;
              applyFilters();
            });
          },
          onReset: () {
            setState(() {
              selectedService = null;
              selectedDepartement = null;
              applyFilters();
            });
          },
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Annuaire des Entrées'),
        backgroundColor: Colors.grey[900],
        iconTheme: IconThemeData(color: Colors.white),
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
            onChanged: (text) {
              setState(() {
                searchQuery = text;
                applyFilters();
              });
            },
          ),
          Row(
            children: [
              Expanded(
                child: DropdownButton<String>(
                  value: selectedService,
                  hint: const Text(
                    'Service',
                    style: TextStyle(
                      color: Color.fromARGB(255, 223, 223, 223),
                    ),
                  ),
                  items: services.map((service) {
                    return DropdownMenuItem<String>(
                      value: service.nomService,
                      child: Text(service.nomService,
                          style: const TextStyle(
                            fontSize: 12,
                            color: Color.fromARGB(255, 223, 223, 223),
                          )),
                    );
                  }).toList(),
                  dropdownColor: Colors.grey[900],
                  onChanged: (value) {
                    setState(() {
                      selectedService = value;
                      applyFilters();
                    });
                  },
                ),
              ),
              Expanded(
                child: DropdownButton<String>(
                  value: selectedDepartement,
                  hint: const Text(
                    'Departement',
                    style: TextStyle(
                      color: Color.fromARGB(255, 223, 223, 223),
                    ),
                  ),
                  items: departements.map((departement) {
                    return DropdownMenuItem<String>(
                      value: departement.nomDep,
                      child: Text(departement.nomDep,
                          style: const TextStyle(
                            fontSize: 12,
                            color: Color.fromARGB(255, 223, 223, 223),
                          )),
                    );
                  }).toList(),
                  dropdownColor: Colors.grey[900],
                  onChanged: (value) {
                    setState(() {
                      selectedDepartement = value;
                      applyFilters();
                    });
                  },
                ),
              ),
            ],
          ),
          Expanded(
            child: FutureBuilder<List<Entree>>(
              future: futureEntrees,
              builder: (context, snapshot) {
                if (snapshot.hasData) {
                  final filteredEntrees = filterAndSortEntrees(snapshot.data!);
                  return ListView.builder(
                    itemCount: filteredEntrees.length,
                    itemBuilder: (context, index) {
                      return Column(
                        children: [
                          AnnuairePreview(entree: filteredEntrees[index]),
                          Divider(color: const Color.fromARGB(255, 90, 90, 90)),
                        ],
                      );
                    },
                  );
                } else if (snapshot.hasError) {
                  return Center(child: Text('Error: ${snapshot.error}'));
                }
                return Center(child: CircularProgressIndicator());
              },
            ),
          ),
        ],
      ),
      backgroundColor: Colors.grey[900],
    );
  }
}
