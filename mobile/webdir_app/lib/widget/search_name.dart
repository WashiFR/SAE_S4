import 'package:flutter/material.dart';

class SearchName extends StatelessWidget {
  final TextEditingController controller;
  final ValueChanged<String> onChanged;

  SearchName({required this.controller, required this.onChanged});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: TextField(
        controller: controller,
        decoration: InputDecoration(
          labelText: 'Rechercher par nom',
          prefixIcon: Icon(Icons.search),
          border: OutlineInputBorder(),
        ),
        onChanged: onChanged,
      ),
    );
  }
}
