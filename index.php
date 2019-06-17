<html>
    <head>
        <Title>Registration Form</Title>
        <style type="text/css">
            body { background-color: #fff; border-top: solid 10px #000;
                color: #333; font-size: .85em; margin: 20; padding: 20;
                font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
            }
            h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
            h1 { font-size: 2em; }
            h2 { font-size: 1.75em; }
            h3 { font-size: 1.2em; }
            table { margin-top: 0.75em; }
            th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
            td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
        </style>
    </head>
    <body>
        <h1>Register here!</h1>
        <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
        <form method="post" action="index.php" enctype="multipart/form-data" >
            Name  <input type="text" name="nama" id="nama"/></br></br>
            Email <input type="text" name="email" id="email"/></br></br>
            Job <input type="text" name="pekerjaan" id="pekerjaan"/></br></br>
            <input type="submit" name="submit" value="Submit" />
            <input type="submit" name="load_data" value="Load Data" />
        </form>
        <?php
            $servername = "rifazures.database.windows.net";
            $username = "waynerog";
            $password = "Alkmenes1197";
            $dbname = "Pendaftaran";
            

                
                // PHP Data Objects(PDO) Sample Code:
                try {
                    $conn = new PDO("sqlsrv:server = tcp:rifazures.database.windows.net,1433; Database = Pendaftaran", "waynerog", "Alkmenes1197");
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                catch (PDOException $e) {
                    print("Error connecting to SQL Server.");
                    die(print_r($e));
                }

                // SQL Server Extension Sample Code:
                $connectionInfo = array("UID" => "waynerog@rifazures", "pwd" => "Alkmenes1197", "Database" => "Pendaftaran", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
                $serverName = "tcp:rifazures.database.windows.net,1433";
                $conn = sqlsrv_connect($serverName, $connectionInfo);
            if (isset($_POST['submit'])){

                try {
                    $sql = "INSERT INTO Pengguna (Nama, Email, Pekerjaan, Tanggal)
                    VALUES ($nama, $email, $pekerjaan, $tanggal)";
                    $conn->exec($sql);
                    echo "New record created successfully"; 
                } catch(Exception $e) {
                    echo "Failed: " . $e;
                }
                echo "<h3>Your're registered!</h3>";
            }

            else if (isset($_POST['load_data'])) {
                try {
                    $sql_select = "SELECT * FROM Pengguna";
                    $stmt = $conn->query($sql_select);
                    $registrants = $stmt->fetchAll(); 
                    if(count($registrants) > 0) {
                        echo "<h2>People who are registered:</h2>";
                        echo "<table>";
                        echo "<tr><th>Name</th>";
                        echo "<th>Email</th>";
                        echo "<th>Job</th>";
                        echo "<th>Date</th></tr>";
                        foreach($registrants as $registrant) {
                            echo "<tr><td>".$registrant['Nama']."</td>";
                            echo "<td>".$registrant['Email']."</td>";
                            echo "<td>".$registrant['Pekerjaan']."</td>";
                            echo "<td>".$registrant['Tanggal']."</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<h3>No one is currently registered.</h3>";
                    }
                } catch(Exception $e) {
                    echo "Failed: " . $e;
                }
            }

            mysqli_close($conn);
            ?> 
    </body>
</html>
