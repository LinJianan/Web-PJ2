<?php 

include 'Connect.php';

for ($i = 1; $i < 82; $i++) {
    $sql = "SELECT * FROM travelimage WHERE ImageID = $i";
    $check_query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($check_query);
    $CountryID = $row['CountryCodeISO'];
    $CityID = $row['CityCode'];

    $sql = "SELECT * FROM geocountries WHERE ISO = '$CountryID'";
    $check_query = mysqli_query($conn, $sql);
    $row1 = mysqli_fetch_array($check_query);
    $CountryName = $row1['CountryName'];

    $sql = "SELECT * FROM geocities WHERE GeoNameID = '$CityID'";
    $check_query = mysqli_query($conn, $sql);
    $row2 = mysqli_fetch_array($check_query);
    $CityName = $row2['AsciiName'];

    $sql = "UPDATE travelimage SET CountryName = '$CountryName' WHERE ImageID = $i";
    $check_query = mysqli_query($conn, $sql);

    $sql = "UPDATE travelimage SET CityName = '$CityName' WHERE ImageID = $i";
    $check_query = mysqli_query($conn, $sql);

    echo $i;
    echo $CountryID;
    echo $CityID;
    echo $CountryName;
    echo $CityName;
}


?>