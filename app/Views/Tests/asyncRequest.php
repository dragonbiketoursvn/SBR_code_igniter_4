<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Async Request Attempt</title>
</head>
<body>
    <p class="holder"></p>
    <button class="requestButton">Press Me!</button>

    <script>
        // Create constants for the <p> element that will display the returned content and the button that will send the request
        const holder = document.querySelector('.holder');
        const requestButton = document.querySelector('.requestButton');

        requestButton.addEventListener('click', function(e) {
            var http = new XMLHttpRequest();
            var url = 'get_data.php';
            var params = 'orem=ipsum&name=binny';
            http.open('POST', url, true);

            //Send the proper header information along with the request
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            http.onreadystatechange = function() {//Call a function when the state changes.
                if(http.readyState == 4 && http.status == 200) {
                    var data = JSON.parse(http.response);
                    alert(data);
                }
            }
            http.send(params);
        });

    </script>
</body>
</html>