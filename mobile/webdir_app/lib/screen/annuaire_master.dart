import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:webdir_app/models/entree.dart';
import 'package:webdir_app/models/service.dart';
import 'package:webdir_app/models/departement.dart';
import 'package:webdir_app/screen/annuaire_preview.dart';
import 'package:webdir_app/widget/search_name.dart';
import 'package:webdir_app/widget/filter_dialog.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';

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
  bool isAscending = true;

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

  Future<List<Entree>> fetchEntrees({String query = ''}) async {
    final order = isAscending ? 'nom-asc' : 'nom-desc';
    final baseUrl = dotenv.env['API_BASE_URL']!;
    final url = query.isEmpty
        ? '$baseUrl/entrees?sort=$order'
        : '$baseUrl/entrees/search?q=$query&sort=$order';
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
    final baseUrl = dotenv.env['API_BASE_URL']!;
    final servicesResponse = await http.get(Uri.parse('$baseUrl/services'));
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

    final departmentsResponse =
        await http.get(Uri.parse('$baseUrl/departements'));
    if (departmentsResponse.statusCode == 200) {
      var jsonResponse = json.decode(departmentsResponse.body);
      setState(() {
        departements = (jsonResponse['departements'] as List)
            .map((data) => Departement.fromJson(data['departement']))
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

  void toggleSortOrder() {
    setState(() {
      isAscending = !isAscending;
      futureEntrees = fetchEntrees(query: searchQuery);
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Annuaire', style: TextStyle(color: Colors.white)),
        backgroundColor: Colors.grey[900],
        iconTheme: const IconThemeData(color: Colors.white),
        actions: [
          IconButton(
            icon: Icon(isAscending ? Icons.arrow_upward : Icons.arrow_downward),
            onPressed: toggleSortOrder,
          ),
          IconButton(
            icon: const Icon(Icons.filter_list),
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
                          const Divider(color: Color.fromARGB(255, 90, 90, 90)),
                        ],
                      );
                    },
                  );
                } else if (snapshot.hasError) {
                  return Center(child: Text('Error: ${snapshot.error}'));
                }
                return const Center(child: CircularProgressIndicator());
              },
            ),
          ),
        ],
      ),
      backgroundColor: Colors.grey[900],
    );
  }
}
