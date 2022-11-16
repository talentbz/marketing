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

        request.open('GET', 'https://private-ea0372-hyros.apiary-proxy.com/v1/api/v1.0/attribution?attributionModel={attributionModel}&startDate={startDate}&endDate={endDate}&level={level}&fields={fields}&ids={ids}&currency={currency}&dayOfAttribution={dayOfAttribution}&scientificDaysRange={scientificDaysRange}');

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