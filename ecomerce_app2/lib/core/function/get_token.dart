import 'package:http/http.dart' as http;
import 'package:googleapis_auth/auth_io.dart' as auth;

Future<String?> getAccessToken() async {
  final serviceAccountJson = {
    "type": "service_account",
    "project_id": "ecommerceapp2-aaed0",
    "private_key_id": "328c23be7d95a9e2fd3cd244c632dfd3b7b0e2a9",
    "private_key":
        "-----BEGIN PRIVATE KEY-----\nMIIEuwIBADANBgkqhkiG9w0BAQEFAASCBKUwggShAgEAAoIBAQDDvINtHKRcJjaF\ntsUYQoR/JGFhtInLFP1GYqthZiTXvDEzA06NBLKGH/iZq+ns5qZr4YYvqUEXrW+3\n7aSt7IJWxWJ4y4DwMh6GizQKGC6pa6ObNLtFSy0SNQU5vR+dfIQnKKJjlUezwZT7\nZq4APXyYjzQKRbp5fDpnjiAbW9BhT6qDxfzocNKIcU2MPz78Ub75tKXw7+hHX4Ag\ngGzYKAAYwgCNRFKJ8nawXBkOKozBhlqIc8QFzRDdkAn2YxESg6vcLXve/OejN2Yx\n7hbS2biaByVuUn17WEqq5ukhz/nHAUv+QRopc94vn0Tk5wnGpye+FNPEL0wZ4uBU\npycm3mjFAgMBAAECgf9fV/RGfsbEHD9yr3sfCUe0QIRiLQ7xw8ebmw4TSfrbgbZ1\nb6btPULr30CGALek+rUWCt5rv1MPTx9o+HK/ElwEge4otcT/O2qjHvhT8nOVEyZR\nwKqrL9mq6yi6EOWiUOtBwW++3xH0lz160dYjR9AcgAtZXAQsj3BKAQqir2NRnCC9\nWWNh6/TtzA+c+dr6sWGHXftk6wkPwsEXAk5A8cZoiLkJWoeSOR1IWi3cuYEoYni1\nQ0q1Z/b73bUuzpGKLlKAO2pnfPQ8vW5sIRyT9l9aLBoHGyLoGYrfa3Kadh2cPQoV\nc85U4aTipyCMx0Mouzq4XEycjn3G2yWiodU+BnMCgYEA/7ERHai299FYw1j5hLZB\ntHhEZQJsqUPM+pe/jxjjviLeEDtFuFMIAz+Y2T9qEdUHmR2dT8R4BUjbpN64QRKL\ncQS1ba3vvSEwtDosSnSvOtKwrywWHRacz5mgonNu1+1ZLJTvD2JMghaAH9yzawCq\ndieKZ2QBwD3xPUMVS8/Mjx8CgYEAw/jwJPvA9YEy1oxLITeX0jX/UgzlULX6xx+4\nDDhJVL01/e4QvNuoYFYkou8uLL5TlX/pi+wj1GCzy9f/FRZzRzJNUhGiS017xseY\nDddXjVnTK1Org3j7bmVRHV61DtDsYhX9EmghC7ELaS79mmKjaj7mw+M+yPfEN+x0\nXBxxH5sCgYAcFjg6GNFYcY+djcWC9X5MM7XXnqePBFqc4FRzhJlnxm68O7aR49UK\nfk7s9lFReiQmhqFEJOHGOtWdy7VTuJTGqmy/io6+KMov0gARgbXJ8WDlLSOUuGor\nR8XkcmenonPcONP1zad31r7mQRkYVO9koT1L1Cl5E5TPVPIe7MmcowKBgQCE9KyA\neukD5x7FnrMOGzh+nrHVSfh+VKiKVgO5Dqr5udEasVxbtS88BNWgUWNjadEtWXXq\nv0/js6PoBWgDN5MIV6FLr7kLG8uBJkMMCPBWbv2spHx1mywCTuzEX0+5eJcXSNHE\nni7lTr1uJDpcdtVlrL1FYzRihm5yfpLHN2isRwKBgBKGRVcrDY+A6KTZIJ1PG9bF\nZfiCU/rZ63uCEtAm4IR/QPcOyhBIo3hiLLk/c72Z8kT9OBsRsuv/nsLFqYREFvpl\n7fP4gyYFVNuCY5CGyrKZtnbMhrM+Sbvgn23J7eJindw9vdlOYVbdyu/ErVD4NGqb\nLyAMhWlyywCA/BI6gbsV\n-----END PRIVATE KEY-----\n",
    "client_email":
        "firebase-adminsdk-or5yo@ecommerceapp2-aaed0.iam.gserviceaccount.com",
    "client_id": "109253445218531765846",
    "auth_uri": "https://accounts.google.com/o/oauth2/auth",
    "token_uri": "https://oauth2.googleapis.com/token",
    "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
    "client_x509_cert_url":
        "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-or5yo%40ecommerceapp2-aaed0.iam.gserviceaccount.com",
    "universe_domain": "googleapis.com"
  };

  List<String> scopes = [
    "https://www.googleapis.com/auth/userinfo.email",
    "https://www.googleapis.com/auth/firebase.database",
    "https://www.googleapis.com/auth/firebase.messaging"
  ];

  try {
    http.Client client = await auth.clientViaServiceAccount(
        auth.ServiceAccountCredentials.fromJson(serviceAccountJson), scopes);

    auth.AccessCredentials credentials =
        await auth.obtainAccessCredentialsViaServiceAccount(
            auth.ServiceAccountCredentials.fromJson(serviceAccountJson),
            scopes,
            client);

    client.close();
    print(
        "Access Token: ${credentials.accessToken.data}"); // Print Access Token
    return credentials.accessToken.data;
  } catch (e) {
    print("Error getting access token: $e");
    return null;
  }
}
