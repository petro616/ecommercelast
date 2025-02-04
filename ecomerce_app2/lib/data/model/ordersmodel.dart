class OrdersModel {
  String? ordersId;
  String? ordersUsersid;
  String? ordersType;
  String? ordersAddress;
  String? ordersShipingprice;
  String? ordersPrice;
  String? ordersTotalprice;
  String? ordersCoupon;
  String? ordersPaymentmethod;
  String? ordersStatus;
  String? ordersDatetime;

  OrdersModel(
      {this.ordersId,
      this.ordersUsersid,
      this.ordersType,
      this.ordersAddress,
      this.ordersShipingprice,
      this.ordersPrice,
      this.ordersTotalprice,
      this.ordersCoupon,
      this.ordersPaymentmethod,
      this.ordersStatus,
      this.ordersDatetime});

  OrdersModel.fromJson(Map<String, dynamic> json) {
    ordersId = json['orders_id'];
    ordersUsersid = json['orders_usersid'];
    ordersType = json['orders_type'];
    ordersAddress = json['orders_address'];
    ordersShipingprice = json['orders_shipingprice'];
    ordersPrice = json['orders_price'];
    ordersTotalprice = json['orders_totalprice'];
    ordersCoupon = json['orders_coupon'];
    ordersPaymentmethod = json['orders_paymentmethod'];
    ordersStatus = json['orders_status'];
    ordersDatetime = json['orders_datetime'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['orders_id'] = this.ordersId;
    data['orders_usersid'] = this.ordersUsersid;
    data['orders_type'] = this.ordersType;
    data['orders_address'] = this.ordersAddress;
    data['orders_shipingprice'] = this.ordersShipingprice;
    data['orders_price'] = this.ordersPrice;
    data['orders_totalprice'] = this.ordersTotalprice;
    data['orders_coupon'] = this.ordersCoupon;
    data['orders_paymentmethod'] = this.ordersPaymentmethod;
    data['orders_status'] = this.ordersStatus;
    data['orders_datetime'] = this.ordersDatetime;
    return data;
  }
}
