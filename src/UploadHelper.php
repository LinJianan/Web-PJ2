<?php

include "Connect.php";

$UID = htmlspecialchars($_POST['UID']);
$ImageID = htmlspecialchars($_POST['ImageID']);
$Title = htmlspecialchars($_POST['Title']);
$Content = htmlspecialchars($_POST['Content']);
$Country = htmlspecialchars($_POST['Country']);
$City = htmlspecialchars($_POST['City']);
$Description = htmlspecialchars($_POST['Description']);

execute();

function execute() {
    global $conn;
    global $UID;
    global $ImageID;
    global $Title;
    global $Content;
    global $Country;
    global $City;
    global $Description;

    $sql = "SELECT ISO FROM geocountries WHERE CountryName = '$Country'";
    $check_query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($check_query);
    if (!$row) {
        echo "<script>
            alert('No Such Country!');
            window.location.href='Upload.php';
            </script>";
        return;
    }

    $CountryID = $row['ISO'];

    $sql = "SELECT GeoNameID FROM geocities WHERE AsciiName = '$City'";
    $check_query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($check_query);
    if (!$row) {
        echo "<script>
            alert('No Such City!');
            window.location.href='Upload.php';
            </script>";
        return;
    }

    $CityID = $row['GeoNameID'];

    $sql = "SELECT Title FROM travelimage WHERE Title = '$Title'";
    $check_query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($check_query);
    if ($row && $ImageID == -1) {
        echo "<script>
            alert('Title Already Exists!');
            window.location.href='Upload.php';
            </script>";
        return;
    }

    $Path = "";

    if ($_FILES["file"]["error"] > 0 && $ImageID == -1) {
        echo $_FILES["file"]["error"];
        echo "<script>
            alert('File Error!');
            window.location.href='Upload.php';
            </script>";
        return;
    }
    elseif ($_FILES["file"]["error"] == 0) {
        $Path = $_FILES["file"]["name"];
    }
    else {
        $Path = htmlspecialchars($_POST['Path']);
    }

    if ($ImageID == -1) { // upload
        $sql = "INSERT INTO travelimage (Title, Description, CountryCodeISO, CityCode, UID, PATH, Content, CountryName, CityName) 
        VALUES ('$Title', '$Description', '$CountryID', '$CityID', $UID, '$Path', '$Content', '$Country', '$City')";
        $check_query = mysqli_query($conn, $sql);
        $sql = "SELECT ImageID FROM travelimage WHERE Title = '$Title'";
        $check_query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($check_query);
        $ImageID = $row['ImageID'];
        echo "<script>
            alert('Upload Seccuss!');
            window.location.href='Details.php?ImageID=".$ImageID."';
            </script>";
    }
    else { // modify
        $sql = "UPDATE travelimage SET Title = '$Title', Description = '$Description', CountryCodeISO = '$CountryID', 
        CityCode = '$CityID', UID = $UID, PATH = '$Path', Content = '$Content', CountryName = '$Country', CityName = '$City'
        WHERE ImageID = $ImageID";
        $check_query = mysqli_query($conn, $sql);
        echo "<script>
            alert('Modify Seccuss!');
            window.location.href='Details.php?ImageID=".$ImageID."';
            </script>";
    }

}



?>
