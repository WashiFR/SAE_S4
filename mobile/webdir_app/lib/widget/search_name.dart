import 'package:flutter/material.dart';

class SearchName extends StatelessWidget {
  final TextEditingController controller;
  final Function(String) onChanged;

  SearchName({required this.controller, required this.onChanged});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: TextField(
        controller: controller,
        style: const TextStyle(color: Color.fromARGB(255, 223, 223, 223)),
        decoration: const InputDecoration(
          labelText: 'Rechercher par nom',
          labelStyle: TextStyle(color: Color.fromARGB(255, 223, 223, 223)),
          enabledBorder: OutlineInputBorder(
            borderSide: BorderSide(color: Colors.white),
          ),
          focusedBorder: OutlineInputBorder(
            borderSide: BorderSide(color: Colors.white),
          ),
          border: OutlineInputBorder(
            borderSide: BorderSide(color: Colors.white),
          ),
        ),
        onChanged: onChanged,
      ),
    );
  }
}
