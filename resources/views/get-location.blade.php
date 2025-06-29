<!DOCTYPE html>
<html>
<head>
    <title>Get User Location</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Track My Location</h2>
    <p id="status">Waiting for location...</p>
    <p><strong>Latitude:</strong> <span id="latitude"></span></p>
    <p><strong>Longitude:</strong> <span id="longitude"></span></p>

    <script>
        $(document).ready(function () {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var lat = 28.6129;
                    var lng = 77.2295;

                    $('#latitude').text(lat);
                    $('#longitude').text(lng);
                    $('#status').text("Location fetched successfully.");

                    // Optional: Laravel/PHP backend pe bhejna
                    $.ajax({
                        url: "/get-address", // Laravel route
                        method: "POST",
                        data: {
                            lat: lat,
                            lng: lng,
                            _token: '{{ csrf_token() }}' // Only for Laravel
                        },
                        dataType:'json',
                        success: function (res) {
                            console.log("Saved to backend:", res);
                        }
                    });

                }, function (error) {
                    $('#status').text("Location access denied.");
                });
            } else {
                $('#status').text("Geolocation not supported.");
            }
        });
    </script>
</body>
</html>
