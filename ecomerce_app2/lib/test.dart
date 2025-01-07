import "package:ecomerce_app2/core/function/get_token.dart";
import "package:flutter/material.dart";

class Test extends StatefulWidget {
  const Test({super.key});

  @override
  State<Test> createState() => _Mytest();
}

class _Mytest extends State<Test> {
  @override
  void initState() {
    getAccessToken();
    super.initState();
  }

  Widget build(BuildContext context) {
    return Scaffold(
        backgroundColor: Colors.white,
        appBar: AppBar(
          backgroundColor: Colors.blue,
          title: const Text("TEST"),
        ),
        body: ListView(
          children: [],
        ));
  }
}
