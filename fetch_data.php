<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Styles for the table */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .color-code {
            width: 20px;
            height: 20px;
            display: inline-block;
            border: 1px solid #000;
        }

        /* Styles for search input */
        #searchInput {
            width: 80%;
            padding: 10px;
            margin: 20px auto;
            display: block;
        }

        /* Styles for the modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Button styles */
        #openModalButton {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        #openModalButton:hover {
            background-color: #45a049;
        }

        /* Image display styles */
        #selectedImage {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- Search Area -->
<input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search">

<!-- PHP code for data fetching -->
<?php
$access_token = "575914e1466f7f603d1e7c926723e271baa9a330";

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.baubuddy.de/dev/index.php/v1/tasks/select",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $access_token",
        "Content-Type: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
   
}

$data = json_decode($response, true);

if (!empty($data)) {
    echo "<table id='myTable' border='1'>";
    echo "<tr><th>Task</th><th>Title</th><th>Description</th><th>Color Code</th></tr>";
    foreach ($data as $task) {
        echo "<tr>";
        echo "<td>{$task['task']}</td>";
        echo "<td>{$task['title']}</td>";
        echo "<td>{$task['description']}</td>";
        echo "<td><div class='color-code' style='background-color: {$task['colorCode']}'></div></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data available";
}
?>

<!-- JavaScript Search Function -->
<script>
    function searchTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; // Searching in the title
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<!-- JavaScript Auto Refresh Function -->
<script>
    setInterval(function() {
        
        location.reload();
    }, 3600000);
</script>

<!-- Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Select an Image</p>
        <input type="file" id="imageInput" accept="image/*">
        <br><br>
        <img id="selectedImage" src="#" alt="Selected Image" style="display: none;">
    </div>
</div>

<!-- Button to open the modal -->
<button id="openModalButton">Select Image</button>

<!-- JavaScript for Modal and Image Functionality -->
<script>
    
    var modal = document.getElementById("myModal");

    var imageInput = document.getElementById("imageInput");

    var selectedImage = document.getElementById("selectedImage");

    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // When an image is selected, display it
    imageInput.onchange = function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            selectedImage.src = reader.result;
            selectedImage.style.display = "block";
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    // Button to open the modal
    var openModalButton = document.getElementById("openModalButton");
    openModalButton.onclick = function() {
        modal.style.display = "block";
    }
</script>

</body>
</html>
