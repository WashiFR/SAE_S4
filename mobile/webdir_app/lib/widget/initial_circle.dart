import 'package:flutter/material.dart';

class InitialCircle extends StatelessWidget {
  final String initials;
  final double size;

  InitialCircle({required this.initials, required this.size});

  @override
  Widget build(BuildContext context) {
    return CircleAvatar(
      backgroundColor: Colors.blue,
      radius: size,
      child: Text(
        initials,
        style: TextStyle(
          color: Colors.white,
          fontWeight: FontWeight.bold,
        ),
      ),
    );
  }
}
