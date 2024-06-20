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
      backgroundColor: Colors.grey[900],
      title: const Text('Filtrer les entrées',
          style: TextStyle(
            color: Color.fromARGB(255, 223, 223, 223),
          )),
      content: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          DropdownButton<String>(
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
            onChanged: onServiceChanged,
            dropdownColor: Colors.grey[900],
          ),
          DropdownButton<String>(
            value: selectedDepartement,
            hint: const Text(
              'Département',
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
            onChanged: onDepartementChanged,
            dropdownColor: Colors.grey[900],
          ),
        ],
      ),
      actions: [
        TextButton(
          onPressed: () {
            onReset();
            Navigator.of(context).pop();
          },
          child: const Text('Réinitialiser',
              style: TextStyle(color: Color.fromARGB(255, 235, 235, 235))),
        ),
        TextButton(
          onPressed: () {
            Navigator.of(context).pop();
          },
          child: const Text(
            'Appliquer',
            style: TextStyle(color: Color.fromARGB(255, 235, 235, 235)),
          ),
        ),
      ],
    );
  }
}
