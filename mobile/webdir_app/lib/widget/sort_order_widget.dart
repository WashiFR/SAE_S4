import 'package:flutter/material.dart';

class SortOrderWidget extends StatelessWidget {
  final String sortOrder;
  final Function(String) onSortOrderChanged;

  SortOrderWidget({required this.sortOrder, required this.onSortOrderChanged});

  @override
  Widget build(BuildContext context) {
    return PopupMenuButton<String>(
      onSelected: (value) {
        onSortOrderChanged(value);
      },
      itemBuilder: (context) => [
        PopupMenuItem(
          value: 'asc',
          child: Text('Tri Ascendant'),
        ),
        PopupMenuItem(
          value: 'desc',
          child: Text('Tri Descendant'),
        ),
      ],
      icon: Icon(Icons.sort),
    );
  }
}
