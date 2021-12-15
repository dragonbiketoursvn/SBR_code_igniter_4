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
    <input type="text" name="plate_number">

    <button class="requestButton">Press Me!</button>    

    <img src="<?= site_url('Admin/Bikes/displayRegPhoto/') . '51R5-3876_front.jpg' ?>" alt="">

    <script>
        // Create constants for the <p> element that will display the returned content and the button that will send the request
        const holder = document.querySelector('.holder');
        const requestButton = document.querySelector('.requestButton');
        // const plateNumber = document.querySelector('input[name="plate_number"]');

        // requestButton.addEventListener('click', function(e) {
        //     var http = new XMLHttpRequest();
        //     var url = "<?= site_url('Test/returnValue'); ?>";
        //     // var params = hiddenInput.name + '=' + hiddenInput.value + '&orem=ipsum&name=binny';
        //     var params = plateNumber.name + '=' + plateNumber.value;
        //     http.open('POST', url, true);

        //     //Send the proper header information along with the request
        //     http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        //     // http.onreadystatechange = function() {//Call a function when the state changes.
        //     //     if(http.readyState == 4 && http.status == 200) {
        //     //         var data = JSON.parse(http.response);
        //     //         alert(data);
        //     //     }
        //     // }

        //     http.onload = function() {
        //         let json = JSON.parse(this.response);
        //         holder.textContent = json.plate_number + ' ' + json.model;
        //     }

        //     http.send(params);
        // });
        
        const url = "<?= site_url('Test/returnValue/'); ?>";

        requestButton.addEventListener('click', function(e) {
        // const request = new XMLHttpRequest();

        // request.onload = function() {
        //     const json = JSON.parse(this.response);
        //     alert(json.penis);
        // }
        
        // request.open("GET", url);
        // request.send();
            fetch(url).then((response) => response.json()).then((json) => document.write(json.plate_number));
        });

    </script>
</body>
</html>