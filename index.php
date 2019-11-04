<?php
    require 'Input.php';
    require 'Validate.php';

    $error = [];

    if (!empty($_POST)) {

        $validate = new Validate($_POST);

        $nama_barang = $validate->setRules('nama_barang','Nama barang', [
            'sanitize' => 'string',
            'required' => true,
            'min_char' => 5,
        ]);

        $jumlah_barang = $validate->setRules('jumlah_barang','Jumlah barang', [
            'required'  => true,
            'numeric'   => true,
            'min_value' => 0,
            'max_value' => 110,
        ]);

        $harga_barang = $validate->setRules('harga_barang','Harga barang', [
            'required'  => true,
            'numeric'   => true,
            'min_value' => 0,
        ]);

        if ($validate->passed()) {
            echo "Lolos Validasi!";
        }
        else {
            $error = $validate->getError();
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Validation Class</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Barang</h2>
        <div class="pesan-error">
        <div class="pesan-error">
            <ul>
                <?php
                foreach ($error as $value) {
                    echo "<li>$value</li>";
                }
                ?>
            </ul>
        </div>
        </div>
        <form method="post">
            <div>
                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang" value="<?php if (isset($nama_barang)) { echo $nama_barang; } ?>">
            </div>
            <div>
                <label for="jumlah_barang">Jumlah</label>
                <input type="text" name="jumlah_barang" value="<?php if (isset($jumlah_barang)) { echo $jumlah_barang; } ?>">
            </div>
            <div>
                <label for="harga_barang">Harga Barang</label>
                <input type="text" name="harga_barang" value="<?php if (isset($harga_barang)) { echo $harga_barang; } ?>">
            </div>
            <div>
                <input type="submit" value="submit">
            </div>
        </form>
    </div>
</body>
</html>