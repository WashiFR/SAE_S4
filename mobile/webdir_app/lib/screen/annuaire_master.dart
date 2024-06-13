import 'package:flutter/material.dart';
import 'package:webdir_app/data_generator.dart';
import 'package:webdir_app/models/entree.dart';

class AnnuaireMaster extends StatefulWidget {
  @override
  _AnnuaireMasterState createState() => _AnnuaireMasterState();
}

class _AnnuaireMasterState extends State<AnnuaireMaster> {
  List<Entree>? entrees = DataGenerator().generateEntrees(6);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Annuaire en ligne'),
      ),
      body: ListView.builder(
        itemCount: entrees?.length ?? 0,
        itemBuilder: (context, index) {
          var entree = entrees?[index];
          return ListTile(
            title: Text('${entree?.nom} ${entree?.prenom}'),
            subtitle: Text(
                'Fonction: ${entree?.fonction}\nBureau: ${entree?.numBureau}'),
          );
        },
      ),
    );
  }
}
