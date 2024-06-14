import 'package:flutter/material.dart';
import 'package:webdir_app/models/service.dart';
import 'package:webdir_app/models/departement.dart';

class FilterDialog extends StatelessWidget {
  final List<Service> services;
  final List<Departement> departements;
  final String? selectedService;
  final String? selectedDepartement;
  final Function(String?) onServiceChanged;
  final Function(String?) onDepartementChanged;
  final Function onReset;

  FilterDialog({
    required this.services,
    required this.departements,
    this.selectedService,
    this.selectedDepartement,
    required this.onServiceChanged,
    required this.onDepartementChanged,
    required this.onReset,
  });

  @override
  Widget build(BuildContext context) {
    return AlertDialog(
      title: Text('Filtrer les entrées'),
      content: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          DropdownButton<String>(
            value: selectedService,
            hint: Text('Sélectionner un service'),
            items: services.map((service) {
              return DropdownMenuItem<String>(
                value: service.nom,
                child: Text(service.nom),
              );
            }).toList(),
            onChanged: onServiceChanged,
          ),
          DropdownButton<String>(
            value: selectedDepartement,
            hint: Text('Sélectionner un département'),
            items: departements.map((departement) {
              return DropdownMenuItem<String>(
                value: departement.nom,
                child: Text(departement.nom),
              );
            }).toList(),
            onChanged: onDepartementChanged,
          ),
        ],
      ),
      actions: [
        TextButton(
          onPressed: () {
            onReset();
            Navigator.of(context).pop();
          },
          child: Text('Réinitialiser'),
        ),
        TextButton(
          onPressed: () {
            Navigator.of(context).pop();
          },
          child: Text('Appliquer'),
        ),
      ],
    );
  }
}
