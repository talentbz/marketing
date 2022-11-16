<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>123</h1>
    <script>
        var request = new XMLHttpRequest();

        request.open('GET', 'https://private-ea0372-hyros.apiary-mock.com/v1/api/v1.0/attribution?attributionModel=last_click&startDate=2022-11-01T10:00:00&endDate=2022-11-15T10:00:00&level=google_campaign&fields=revenue,total_revenue,refund,unique_sales&ids=ids=1057231095,10113550076,10127550431&currency={currency}&dayOfAttribution=false&scientificDaysRange=30');

        request.setRequestHeader('Content-Type', 'application/json');
        request.setRequestHeader('API-Key', 'b12a19f4521d44abc8d613efca7f9c23c88');

        request.onreadystatechange = function () {
        if (this.readyState === 4) {
            console.log('Status:', this.status);
            console.log('Headers:', this.getAllResponseHeaders());
            console.log('Body:', this.responseText);
        }
        };

        request.send();
    </script>
</body>
</html>