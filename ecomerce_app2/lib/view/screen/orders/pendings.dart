import 'package:ecomerce_app2/controller/orders/pending_controller.dart';
import 'package:ecomerce_app2/core/class/handlingdataview.dart';
import 'package:ecomerce_app2/core/constant/colors.dart';
import 'package:ecomerce_app2/data/model/ordersmodel.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class Pendings extends StatelessWidget {
  const Pendings({super.key});

  @override
  Widget build(BuildContext context) {
    Get.put(PendingController());
    return Scaffold(
        backgroundColor: AppColor.colorscaffoldLogin,
        appBar: AppBar(
          title: Text("ORDERS"),
        ),
        body: GetBuilder<PendingController>(builder: (controller) {
          return Handlingdataview(
              statusRequest: controller.statusRequest,
              widget: ListView.builder(
                  itemCount: controller.data.length,
                  itemBuilder: (context, i) {
                    return Cardlistorders(ordersModel: controller.data[i]);
                  }));
        }));
  }
}

class Cardlistorders extends GetView<PendingController> {
  final OrdersModel ordersModel;
  const Cardlistorders({super.key, required this.ordersModel});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(5.0),
      child: Card(
        child: Container(
          padding: EdgeInsets.all(10),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                "Order Number : ${ordersModel.ordersId}",
                style: TextStyle(
                    fontWeight: FontWeight.bold,
                    fontSize: 23,
                    fontFamily: "BebasNeue",
                    color: Colors.grey),
              ),
              Divider(),
              Text(
                "Order Type : ${controller.printOrderType(ordersModel.ordersType!)}",
                style: TextStyle(
                    fontWeight: FontWeight.bold, color: Colors.blueGrey),
              ),
              SizedBox(height: 3),
              Text(
                "Order Price : ${ordersModel.ordersPrice} s.y.p",
                style: TextStyle(
                    fontWeight: FontWeight.bold, color: Colors.blueGrey),
              ),
              SizedBox(height: 3),
              Text(
                "Delivery Price : ${ordersModel.ordersShipingprice} s.y.p",
                style: TextStyle(
                    fontWeight: FontWeight.bold, color: Colors.blueGrey),
              ),
              SizedBox(height: 3),
              Text(
                "Payment Method : ${controller.printPaymentMethod(ordersModel.ordersPaymentmethod!)}",
                style: TextStyle(
                    fontWeight: FontWeight.bold, color: Colors.blueGrey),
              ),
              SizedBox(height: 3),
              Text(
                "Order Status : ${controller.printOrderStatus(ordersModel.ordersStatus!)}",
                style: TextStyle(
                    fontWeight: FontWeight.bold, color: Colors.blueGrey),
              ),
              Divider(),
              Row(
                children: [
                  Text(
                    "Total Price : ${ordersModel.ordersTotalprice} S.Y.P",
                    style: TextStyle(
                        fontWeight: FontWeight.bold,
                        color: Colors.grey,
                        fontFamily: "BebasNeue",
                        fontSize: 20),
                  ),
                  Spacer(),
                  MaterialButton(
                    onPressed: () {},
                    color: AppColor.homepagecolorbackground,
                    textColor: Colors.blueGrey,
                    child: Text(
                      "Order Details",
                      style: TextStyle(fontWeight: FontWeight.bold),
                    ),
                  )
                ],
              )
            ],
          ),
        ),
      ),
    );
  }
}
