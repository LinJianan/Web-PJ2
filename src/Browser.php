<html>
    <head>
            <title>Browse</title>
    </head>
    <div style="position:relative" class="ttop">
    <link href="./css/Browser.css" rel="stylesheet" type="text/css">
        <body>
            <div class="top">
                <center> 
                    <ul>
                    <img src="../img/cat.jpg" width="60" height="60" style="position:absolute; left:0px; top:0px; ">
                    <li><a href="./Home.php"><b>Home</b></a></li>
                    <li><a href="./Browser.php"><b><u>Browse</u></b></a></li>
                    <li><a href="./Search.php"><b>Search</b></a></li>
                
                    <?php include "Header.php" ?>     
                    </ul>
                    </center>      
            </div>
        </body>
    </div>

    <script>
        function display_alert(){
            alert("I am an alert box!!")
            }
    </script>

    <div class="content" style="position: relative;">
        <div class="contentleft">
            <form method="get">
                <input type="hidden" name="search" value="2" />
                <input type="hidden" name="pagenum" value="1" />
                <p style="position: absolute; left:100px">
                    <br><b>Search by Title</b><br>
                </p>
                <input type="text" name="title" style="position: absolute; left:90px; top:65px; width:150px; height:20px">
                <button id="search_button" type="submit" style="position: absolute; left:240px; top:64px; height:22px" >></button>
            </form>

            <p style="position: absolute; left:100px; top:150px; line-height: 150%">
                <b>Hot Content</b><br>
                <a href="?search=1&content=scenery&pagenum=1">Scenery<br></a>
            </p>
        
            <p style="position: absolute; left:100px; top:300px; line-height: 150%">
                <b>Hot Countries</b><br>
                <a href="?search=1&country=Canada&pagenum=1">Canada<br></a>
                <a href="?search=1&country=Germany&pagenum=1">Germany<br></a>
                <a href="?search=1&country=Spain&pagenum=1">Spain<br></a>
            </p>

            <p style="position: absolute; left:100px; top:500px; line-height: 150%">
                <b>Hot Cities</b><br>
                <a href="?search=1&city=Berlin&pagenum=1">Berlin<br></a>
                <a href="?search=1&city=New York City&pagenum=1">New York City<br></a>
                <a href="?search=1&city=Venezia&pagenum=1">Venezia<br></a>
            </p>
        </div>

        <?php 

        include "Connect.php";

        $content = "";
        $country = "";
        $city = "";
        $title = "";
        $search = 0;
        $pagenum = 1;
        $pagesize = 1;
        $ImageID = array(1, 2, 3, 4, 5, 6);
        $ImagePath = array();
        $url = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

        function ID2Path($ImageID) {
            global $conn;
            $ImagePath = array();
            for ($i = 0; $i < count($ImageID); $i++) {
                $sql = "SELECT PATH FROM travelimage WHERE ImageID = $ImageID[$i]";
                $check_query = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($check_query);
                array_push($ImagePath, $row['PATH']);
            }
            return $ImagePath;
        }

        function changePagenum($url, $num) {
            $temp = explode('pagenum=', $url);
            if (count($temp) <= 1) {
                return $url."pagenum=".$num;
            }
            else {
                $temp1 = explode('&', $temp[1]);
                if (count($temp1) < 1) {
                    return $temp[0]."pagenum=".$num;
                }
                else {
                    $result = $temp[0]."pagenum=".$num;
                    for ($i = 1; $i < count($temp1); $i++) {
                        $result = $result."&".$temp1[$i];
                    }
                    return $result;
                }
            }
        }

        /*function Country2ID($country) {
            $sql = "SELECT ISO FROM geocountries WHERE CountryName = '$country'";
            $check_query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($check_query);
            return $row['CountryName'];
        }

        function City2ID($city) {
            $sql = "SELECT GeoNameID FROM geocities WHERE AsciiName = '$city'";
            $check_query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($check_query);
            return $row['GeoNameID'];
        }*/

        function search_title() {
            global $conn;
            global $title;
            $sql = "";
            if ($title == "") {
                $sql = "SELECT ImageID FROM travelimage";
                //echo "1";
            }
            else {
                $sql = "SELECT ImageID FROM travelimage WHERE title like '%$title%'";
                //echo "2";
            }
            $check_query = mysqli_query($conn, $sql);
            $ImageID = array();
            while ($row = mysqli_fetch_array($check_query)) {
                array_push($ImageID, $row['ImageID']);
            }
            //echo count($ImageID);
            return $ImageID;
        }

        function filter($content, $country, $city) {
            global $conn;
            $ImageID = array();
            $sql = "SELECT ImageID FROM travelimage";
            $CountryID = "";
            $CityID = "";
            if ($content == "default" && $country == "default" && $city == "default") {
                ;
            }
            else {
                $sql .= " WHERE ";
                if ($content != "default") {
                    $sql .= "Content = '$content'";
                    if ($city != "default") {
                        $sql .= " and CityName = '$city'";
                    }
                    elseif ($country != "default") {
                        $sql .= " and CountryName = '$country'";
                    }
                }
                else {
                    if ($city != "default") {
                        $sql .= " CityName = '$city'";
                    }
                    elseif ($country != "default") {
                        $sql .= " CountryName = '$country'";
                    }
                }
            }
            $check_query = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($check_query)) {
                array_push($ImageID, $row['ImageID']);
            }
            return $ImageID;
        }

        function findAllContent() {
            global $conn;
            $sql = "SELECT DISTINCT Content FROM travelimage";
            $check_query = mysqli_query($conn, $sql);
            $AllContent = [];
            while ($row = mysqli_fetch_array($check_query)) {
                array_push($AllContent, $row['Content']);
            }
            return $AllContent;
        }

        function findAllCountry() {
            global $conn;
            $sql = "SELECT DISTINCT CountryName FROM travelimage";
            $check_query = mysqli_query($conn, $sql);
            $AllCountry = [];
            while ($row = mysqli_fetch_array($check_query)) {
                array_push($AllCountry, $row['CountryName']);
            }
            return $AllCountry;
        }

        function findAllCity( $CountryName ) {
            global $conn;
            $sql = "SELECT DISTINCT CityName FROM travelimage WHERE CountryName = '$CountryName' and CityName is not NULL and CityName != ''";
            $check_query = mysqli_query($conn, $sql);
            $AllCity = [];
            while ($row = mysqli_fetch_array($check_query)) {
                array_push($AllCity, $row['CityName']);
            }
            return $AllCity;
        }

        $content = empty($_GET['content']) ? "default" : $_GET['content'];
        $country = empty($_GET['country']) ? "default" : $_GET['country'];
        $city = empty($_GET['city']) ? "default" : $_GET['city'];
        $search = empty($_GET['search']) ? 0 : $_GET['search'];
        $pagenum = empty($_GET['pagenum']) ? 1 : $_GET['pagenum'];
        $title = empty($_GET['title']) ? "" : $_GET['title'];

        if ($search == 2) {
            $ImageID = search_title();
        }
        elseif ($search == 1) {
            $ImageID = filter($content, $country, $city);
        }

        $ImagePath = ID2Path($ImageID);

        $AllContent = findAllContent();
        $AllCountry = findAllCountry();
        $AllCity = [];
        for ($i = 0; $i < count($AllCountry); $i++) {
            $temp = findAllCity($AllCountry[$i]);
            $AllCity[] = $temp;
        }

        echo "<script>";
        echo "var AllContent = new Array();";
        for ($i = 0; $i < count($AllContent); $i++) {
            echo "AllContent[$i] = '".$AllContent[$i]."';";
        }
        echo "var AllCountry = new Array();";
        for ($i = 0; $i < count($AllCountry); $i++) {
            echo "AllCountry[$i] = '".$AllCountry[$i]."';";
        }
        echo "var AllCity = new Array();";
        echo "AllCity[0] = new Array();";
        for ($i = 0; $i < count($AllCountry); $i++) {
            echo "AllCity[$i] = new Array();";
            for ($j = 0; $j < count($AllCity[$i]); $j++) {
                echo "AllCity[$i][$j] = '".$AllCity[$i][$j]."';";
            }
        }
        echo "</script>";

        ?>

        <div class="contentright">
        <form method="get">
            <p style="position: absolute; left:400px; top:20px">
                <b>Filter</b>
            </p>
            <input type="hidden" name="search" value="1" />
            <input type="hidden" name="pagenum" value="1" />
            <select id="SelectContent" name="content" class="filter" style="position: absolute; left:400px; top:80px">
                <option id="A0" value="default" selected>Filter by Content</option>
                <option id="A1" value="Scenery">Scenery</option>
                <option id="A2" value="City">City</option>
                <option id="A3" value="People">People</option>
                <option id="A4" value="Animal">Animal</option>
                <option id="A5" value="Building">Building</option>
                <option id="A6" value="Wonder">Wonder</option>
            </select>

            <script>
                SelectContent = document.getElementById("SelectContent");
                SelectContent.innerHTML = "<option id='A0' value='default' selected>Filter by Content</option>";
                for (var i = 0; i < AllContent.length; i++) {
                    SelectContent.innerHTML = SelectContent.innerHTML + '<option id ="A'
                        + String(i+1) + '" value="' + AllContent[i] + '">' + AllContent[i]
                        + "</option>";
                }
            </script>

            <select id="SelectCountry" name="country" class="filter" style="position: absolute; left:700px; top:80px" onchange="Country2City(this.value)">
                <option id="B0" value="default" selected>Filter by Country</option>
                <option id="C1" value="America">America</option>
                <option id="C2" value="Britain">Britain</option>
                <option id="C3" value="China">China</option>
                <option id="C4" value="France">France</option>
                <option id="C5" value="Germany">Germany</option>
                <option id="C6" value="Japan">Japan</option>
            </select>

            <script>
                SelectCountry = document.getElementById("SelectCountry");
                SelectCountry.innerHTML = "<option id='B0' value='default' selected>Filter by Country</option>";
                for (var i = 0; i < AllCountry.length; i++) {
                    SelectCountry.innerHTML = SelectCountry.innerHTML + "<option id ='B"
                        + String(i+1) + "' value='" + AllCountry[i] + "'>" + AllCountry[i]
                        + "</option>";
                    //SelectCountry.innerHTML += "<option id='B1' value='123'>123</option>";
                }
            </script>

            <script>
                function Country2City(Country) {
                    var SelectCity = document.getElementById("SelectCity");
                    SelectCity.innerHTML = "<option id='C0' value='default' selected>Filter by City</option>";
                    if (Country == "default") {
                        return;
                    }
                    else {
                        var index = AllCountry.indexOf(Country);
                        for (var i = 0; i < AllCity[index].length; i++) {
                            SelectCity.innerHTML = SelectCity.innerHTML + "<option id ='C"
                                + String(i+1) + "' value='" + AllCity[index][i] + "'>" + AllCity[index][i]
                                + "</option>";
                        }
                    }
                }
            </script>

            <select id="SelectCity" name="city" class="filter" style="position: absolute; left:1000px; top:80px">
                <option id="C0" value="default" selected>Filter by City</option>
                <option id="C11" value="New York">New York</option>
                <option id="C12" value="Los Angeles">Los Angeles</option>
                <option id="C21" value="London">London</option>
                <option id="C22" value="Birmingham">Birmingham</option>
                <option id="C31" value="Beijing">Beijing</option>
                <option id="C32" value="Shanghai">Shanghai</option>
                <option id="C41" value="Paris">Paris</option>
                <option id="C42" value="Bordeaux">Bordeaux</option>
                <option id="C51" value="Berlin">Berlin</option>
                <option id="C52" value="Munich">Munich</option>
                <option id="C61" value="Tokyo">Tokyo</option>
            </select>

            <script>
                SelectCity = document.getElementById("SelectCity");
                SelectCity.innerHTML = "<option id='C0' value='default' selected>Filter by City</option>";
            </script>

            
            <button type="submit" style="position: absolute; left:1400px; top:77.5px; width: 200px; height:35px;" id="Filter">
                Filter
            </button>
            </form>

            <div>
            <?php
                $length = count($ImageID);
                //echo $length;
                $remain = $length - 6 * ($pagenum - 1);
                $times = 0;
                while ($times < 3 && $remain > 0) {
                    echo '<a href="./Details.php?ImageID='.$ImageID[6 * ($pagenum - 1) + $times].
                    '"><img src="../img/'.$ImagePath[6 * ($pagenum - 1) + $times].'" '.
                    'style = "position: absolute; left:'.(400 + 500 * $times).
                    'px; top:150px; width: 300px;"></a>';
                    $times++;
                    $remain--;
                }
                $times = 0;
                while ($times < 3 && $remain > 0) {
                    echo '<a href="./Details.php?ImageID='.$ImageID[6 * ($pagenum - 1) + 3 + $times].
                    '"><img src="../img/'.$ImagePath[6 * ($pagenum - 1) + 3 + $times].'" '.
                    'style = "position: absolute; left:'.(400 + 500 * $times).
                    'px; top:500px; width: 300px;"></a>';
                    $times++;
                    $remain--;
                }
            ?>

            <p style="position: absolute; left:850px; top:850px; text-decoration:none">
            <font color="blue">
            <?php
                //echo '1'.$url;
                $pagesize = floor(($length + 5) / 6);
                $pagesize = $pagesize > 5 ? 5 : $pagesize;
                $prev = $pagenum > 1 ? $pagenum - 1 : 1;
                $succ = $pagenum < $pagesize ? $pagenum + 1 : $pagesize;
                $url = changePagenum($url, $prev);
                echo "<a href='".$url."'><</a>";
                for ($i = 1; $i <= $pagesize; $i++) {
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                    $url = changePagenum($url, $i);
                    if ($i == $pagenum) {
                        echo "<a href='".$url."'><mark>".$i."</mark></a>";
                    }
                    else {
                        echo "<a href='".$url."'>".$i."</a>";
                    }
                }
                echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                $url = changePagenum($url, $succ);
                echo "<a href='".$url."'>></a>";
            ?>
            </font></p>

            </div>
            
    </div>

    <div class="top" style="position: relative; margin-bottom: 0%">
        <p align="center"><font size="4">
            <br>
            Contact with us: jnlin16@fudan.edu.cn
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            All Rights Reversed
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Copyright 2019-2021 Web Fundamental
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            CatHub
        </font></p>
    </div>
</html>