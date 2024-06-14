import 'package:flutter/material.dart';

class SortOrderWidget extends StatelessWidget {
  final String sortOrder;
  final Function(String) onSortOrderChanged;

  const SortOrderWidget(
      {super.key, required this.sortOrder, required this.onSortOrderChanged});

  @override
  Widget build(BuildContext context) {
    return PopupMenuButton<String>(
      color: Colors.grey[900],
      onSelected: (value) {
        onSortOrderChanged(value);
      },
      itemBuilder: (context) => [
        const PopupMenuItem(
          value: 'asc',
          child: Text('Tri Ascendant',
              style: (TextStyle(
                color: Color.fromARGB(255, 223, 223, 223),
              ))),
        ),
        const PopupMenuItem(
          value: 'desc',
          child: Text('Tri Descendant',
              style: (TextStyle(
                color: Color.fromARGB(255, 223, 223, 223),
              ))),
        ),
      ],
      icon: const Icon(Icons.sort, color: Color.fromARGB(255, 223, 223, 223)),
    );
  }
}
