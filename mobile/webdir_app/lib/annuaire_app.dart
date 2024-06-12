import 'package:flutter/material.dart';
import 'package:webdir_app/screen/annuaire_master.dart';

class AnnuaireApp extends StatefulWidget {
  @override
  _AnnuaireAppState createState() => _AnnuaireAppState();
}

class _AnnuaireAppState extends State<AnnuaireApp> {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'ToDo List',
      home: Scaffold(
        appBar: AppBar(
          title: Text('ToDo List'),
        ),
        body: AnnuaireMaster(),
      ),
    );
  }
}
