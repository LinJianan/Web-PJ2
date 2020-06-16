<html>
    <head>
        <title>Home</title>
    </head>
    <div style="position:relative" class="ttop">
   
       <link href="./css/Home.css" rel="stylesheet" type="text/css">
        <body>
            <div class="top">
                   <center> 
                    <ul>
                    <img src="../img/cat.jpg" width="60" height="60" style="position:absolute; left:0px; top:0px; ">
                    <li><a href="#"><b><u>Home</u></b></a></li>
                    <li><a href="./Browser.php"><b>Browse</b></a></li>
                    <li><a href="./Search.php"><b>Search</b></a></li>
                   
                    <?php include "Header.php" ?>        
                      </ul>
                    </center>      
            </div>
        </body>
    
    </div>

    <div style="position:relative">
        <img src="../img/0.jpg" width="100%" style="position:relative">
    </div>

    <?php
    
    include 'Connect.php';
    
    $ImageIndex = array(1, 2, 3, 4, 5, 6);
    $Image = array(
        array("", "", ""),
        array("", "", ""),
        array("", "", ""),
        array("", "", ""),
        array("", "", ""),
        array("", "", "")
    );

    function getID($status, $conn, $ImageIndex) {
        $index = 0;
        if ($status == 0) {
            $sql = "SELECT ImageID, COUNT(*) FROM travelimagefavor GROUP BY ImageID ORDER BY COUNT(*) DESC";
            $check_query = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($check_query)) {
                if ($index > 5) {
                    break;
                }
                $ImageIndex[$index] = $row['ImageID'];
                $index++;
            }
        }
        while ($index < 6) {
            $sql = "SELECT max(ImageID) FROM travelimage";
            $check_query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($check_query);
            $temp = rand(1, $row['max(ImageID)']);
            if (in_array($temp, $ImageIndex)) {
                continue;
            }
            else {
                $ImageIndex[$index] = $temp;
                $index++;
            }
        }
        return $ImageIndex;
    }

    function getImage($conn, $ImageIndex, $Image) {
        for ($i = 0; $i < 6; $i++) {
            $temp = $ImageIndex[$i];
            $sql = "SELECT `PATH`, Title, `Description` FROM travelimage WHERE ImageID = $temp";
            $check_query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($check_query);
            $Image[$i][0] = $row['PATH'];
            $Image[$i][1] = $row['Title'];
            $Image[$i][2] = $row['Description'];
        }
        return $Image;
    }

    $status = empty($_GET['ImageID']) ? 0 : 1;
    //echo $Image;
    //echo $ImageIndex[5];
    $ImageIndex = getID($status, $conn, $ImageIndex);
    $Image = getImage($conn, $ImageIndex, $Image);

    ?>

    <div style="position:relative">
        <div class="firstpart">
            <ul item-width="100%">
                <li style="display:block" id="1"><a href="./Details.php?ImageID=<?php echo $ImageIndex[0] ?>"><img src="<?php echo '../img/'.$Image[0][0] ?>" width="100%"></a></li>
            </ul>
            <div>
                <p><b><font size="5">&nbsp;&nbsp;&nbsp;<?php echo $Image[0][1] ?></font></b></p>
                <p class="p2"><font size="4">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Image[0][2] ?></font></p>
            </div>
        </div>
        <div class="firstpart">
            <ul item-width="100%">
                <li style="display:block" id="2"><a href="./Details.php?ImageID=<?php echo $ImageIndex[1] ?>"><img src="<?php echo '../img/'.$Image[1][0] ?>" width="100%"></a></li>
            </ul>
            <div>
                <p><b><font size="5">&nbsp;&nbsp;&nbsp;<?php echo $Image[1][1] ?></font></b></p>
                <p class="p2"><font size="4">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Image[1][2] ?></font></p>
            </div>
        </div>
        <div class="firstpart">
            <ul item-width="100%">
                <li style="display:block" id="3"><a href="./Details.php?ImageID=<?php echo $ImageIndex[2] ?>"><img src="<?php echo '../img/'.$Image[2][0] ?>" width="100%"></a></li>
            </ul>
            <div>
                <p><b><font size="5">&nbsp;&nbsp;&nbsp;<?php echo $Image[2][1] ?></font></b></p>
                <p class="p2"><font size="4">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Image[2][2] ?></font></p>
            </div>
        </div>
    </div>

    <div style="position:relative">
        <div class="firstpart">
            <ul item-width="100%">
                <li style="display:block" id="4"><a href="./Details.php?ImageID=<?php echo $ImageIndex[3] ?>"><img src="<?php echo '../img/'.$Image[3][0] ?>" width="100%"></a></li>
            </ul>
            <div>
                <p><b><font size="5">&nbsp;&nbsp;&nbsp;<?php echo $Image[3][1] ?></font></b></p>
                <p class="p2"><font size="4">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Image[3][2] ?></font></p>
            </div>
        </div>
        <div class="firstpart">
            <ul item-width="100%">
                <li style="display:block" id="5"><a href="./Details.php?ImageID=<?php echo $ImageIndex[4] ?>"><img src="<?php echo '../img/'.$Image[4][0] ?>" width="100%"></a></li>
            </ul>
            <div>
                <p><b><font size="5">&nbsp;&nbsp;&nbsp;<?php echo $Image[4][1] ?></font></b></p>
                <p class="p2"><font size="4">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Image[4][2] ?></font></p>
            </div>
        </div>
        <div class="firstpart">
            <ul item-width="100%">
                <li style="display:block" id="6"><a href="./Details.php?ImageID=<?php echo $ImageIndex[5] ?>"><img src="<?php echo '../img/'.$Image[5][0] ?>" width="100%"></a></li>
            </ul>
            <div>
                <p><b><font size="5">&nbsp;&nbsp;&nbsp;<?php echo $Image[5][1] ?></font></b></p>
                <p class="p2"><font size="4">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Image[5][2] ?></font></p>
            </div>
        </div>
        </div>



    <a href="?ImageID=1"><button style="position: fixed; right: 5%; bottom: 20%; height: 40px; width: 100px;" id="btn1">></button></a>

    <button style="position: fixed; right: 5%; bottom: 10%; height: 40px; width: 100px;" id="btn">^</button>
    <script>
        function goTop(){
            //速度
            var speed = 100;
            //开启定时器
            
            var timer = setInterval(function(){
                //获取滚动条的高度
                var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                //设置滚动的高度
                document.documentElement.scrollTop = document.body.scrollTop = (scrollTop - speed);
                //清除定时器
                speed += 30;
                if(scrollTop <= 0){
                    clearInterval(timer);
                }
            },30)
        }

        btn.onclick = function(){
            
            goTop();//调用函数
        }
    </script>

    <div class="top" style="position: relative">
        <p align="center" ><font size="4">
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
