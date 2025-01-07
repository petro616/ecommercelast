import 'package:ecomerce_app2/core/class/crud.dart';
import 'package:ecomerce_app2/linkapi.dart';

class PendingData {
  Crud crud;
  PendingData(this.crud);

  getdata(String id) async {
    var response = await crud.postdata(Applink.pendingsorders, {"id": id});
    return response.fold((l) => l, (r) => r);
  }
}
