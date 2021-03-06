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
  
  .show th {border: 1; padding: 5px;}
  .show td {border: 1;}
 </style>
 </head>
 <body>
 <h1>Aplikasi Pendataan Inventaris</h1>
 <p>Silahkan memasukkan data inventaris melalui kolom berikut.</p>
<table>
     <tr>
        <td>Nama Barang</td>
        <td>Jumlah Barang</td>
     </tr>
     <tr>
        <form method="post" action="index.php" enctype="multipart/form-data">
            <td><input type="text" name="name" id="name"/></td>
            <td><input type="number" name="qty" id="qty"/></td>
            <td><input type="submit" name="submit" value="Submit" /></td>
            <td><input type="submit" name="load_data" value="Load Data" /></td>
        </form>
     </tr>
</table>
 <?php
    $host = "rifazures.database.windows.net";
    $user = "waynerog";
    $pass = "";
    $db = "inventaris";

    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Failed: " . $e;
    }

    if (isset($_POST['submit'])) {
        try {
            $name = $_POST['name'];
            $qty = $_POST['qty'];
            $date = date("Y-m-d");
            // Insert data
            $sql_insert = "INSERT INTO barang (nama_barang, jumlah_barang, tanggal_masuk) 
                        VALUES (?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $qty);
            $stmt->bindValue(3, $date);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }

        echo "<h3>Your're registered!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM barang";
            $stmt = $conn->query($sql_select);
            $barangs = $stmt->fetchAll(); 
            if(count($barangs) > 0) {
                echo "<h2>Data inventaris yang telah masuk :</h2>";
                echo "<table class='show'>";
                echo "<tr><th>ID Barang</th>";
                echo "<th>Nama Barang</th>";
                echo "<th>Jumlah Barang</th>";
                echo "<th>Tanggal Masuk</th>";
                foreach($barangs as $barang) {
                    echo "<tr><td style='text-align:center;'>".$barang['id_barang']."</td>";
                    echo "<td>".$barang['nama_barang']."</td>";
                    echo "<td style='text-align:center;'>".$barang['jumlah_barang']."</td>";
                    echo "<td style='text-align:center;'>".$barang['tanggal_masuk']."</td>";
                }
                echo "</table>";
            } else {
                echo "<h3 style='color: red'>Belum ada data inventaris yang dimasukkan.</h3>";
            }
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
    }
 ?>
 </body>
 </html>
