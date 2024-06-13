import 'package:flutter/material.dart';
import 'package:webdir_app/models/service.dart';
import 'package:webdir_app/models/departement.dart';

class FilterDialog extends StatelessWidget {
  final List<Service> services;
  final List<Departement> departements;
  final String? selectedService;
  final String? selectedDepartement;
  final ValueChanged<String?> onServiceChanged;
  final ValueChanged<String?> onDepartementChanged;
  final VoidCallback onReset;

  FilterDialog({
    required this.services,
    required this.departements,
    required this.selectedService,
    required this.selectedDepartement,
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
            hint: Text('Filtrer par service'),
            value: selectedService,
            onChanged: onServiceChanged,
            items: services
                .map((service) => DropdownMenuItem<String>(
                      child: Text(service.nom),
                      value: service.nom,
                    ))
                .toList(),
          ),
          SizedBox(height: 10),
          DropdownButton<String>(
            hint: Text('Filtrer par département'),
            value: selectedDepartement,
            onChanged: onDepartementChanged,
            items: departements
                .map((departement) => DropdownMenuItem<String>(
                      child: Text(departement.nom),
                      value: departement.nom,
                    ))
                .toList(),
          ),
        ],
      ),
      actions: [
        TextButton(
          onPressed: () {
            Navigator.of(context).pop();
          },
          child: Text('Valider'),
        ),
        TextButton(
          onPressed: () {
            onReset();
            Navigator.of(context).pop();
          },
          child: Text('Réinitialiser'),
        ),
      ],
    );
  }
}
