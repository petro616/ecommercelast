import 'package:ecomerce_app2/core/class/status_request.dart';
import 'package:ecomerce_app2/core/constant/routes.dart';
import 'package:ecomerce_app2/core/function/handlingdatacontroller.dart';
import 'package:ecomerce_app2/core/services/servisess.dart';
import 'package:ecomerce_app2/data/datasource/remote/address.dart';
import 'package:ecomerce_app2/data/datasource/remote/checkout.dart';
import 'package:ecomerce_app2/data/model/addressmodel.dart';
import 'package:get/get.dart';

class CheckoutController extends GetxController {
  List<Addressmodel> dataaddress = [];
  AddressData addressData = Get.put(AddressData(Get.find()));
  CheckoutData checkoutData = CheckoutData(Get.find());
  MyServices myservices = Get.find();
  StatusRequest statusRequest = StatusRequest.none;
  String? paymentmethod;
  String? deliverytype;
  String shippingaddressid = "0";
  late String couponid;
  late String copondiscount;
  late String priceorder;
  choosepaymentmethod(String val) {
    paymentmethod = val;
    update();
  }

  choosedeliverytype(String val) {
    deliverytype = val;
    update();
  }

  chooseshippingaddress(String val) {
    shippingaddressid = val;
    update();
  }

  getshippingaddress() async {
    dataaddress.clear();
    statusRequest = StatusRequest.loading;
    var response = await addressData
        .viewdata(myservices.sharedPreferences.getString("id")!);
    statusRequest = handlingdata(response);
    if (StatusRequest.success == statusRequest) {
      if (response["status"] == "success") {
        List listdata = response["data"];
        dataaddress.addAll(listdata.map((e) => Addressmodel.fromJson(e)));
      } else {
        statusRequest = StatusRequest.none;
      }
    }
    update();
  }

  checkout() async {
    if (paymentmethod == null) {
      return Get.snackbar("What Happen", "Please Choose Payment Method");
    }

    if (deliverytype == null) {
      return Get.snackbar("What Happen", "Please Choose Delivery Type");
    }

    statusRequest = StatusRequest.loading;
    update();
    Map data = {
      "usersid": myservices.sharedPreferences.getString("id"),
      "ordertype": deliverytype.toString(),
      "address": shippingaddressid.toString(),
      "shippingprice": "10",
      "orderprice": priceorder,
      "couponnid": couponid.toString(),
      "paymentmethod": paymentmethod.toString(),
      "copondiscount": copondiscount.toString(),
    };
    var response = await checkoutData.getdata(data);
    statusRequest = handlingdata(response);
    if (StatusRequest.success == statusRequest) {
      if (response["status"] == "success") {
        Get.snackbar("Success", "Your Order Have Been Now With Us");
        Get.offAllNamed(AppRoute.homescreen);
      } else {
        statusRequest = StatusRequest.none;
        Get.snackbar("Eroor", "Please Try Again");
      }
    }
    update();
  }

  @override
  void onInit() {
    couponid = Get.arguments["couponid"].toString();
    priceorder = Get.arguments["priceorder"];
    copondiscount = Get.arguments["discountcopon"].toString();
    getshippingaddress();
    super.onInit();
  }
}
