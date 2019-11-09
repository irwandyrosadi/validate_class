<?php
    require_once '../Input.php';
    require_once '../Validate.php';

    $error = [];

    if (!empty($_POST)) {
        $validate = new Validate($_POST);

        $validate->setRules('sl_framework', 'Framework', [
            'sanitize' => 'string',
            'require'  => true,
            'regexp'   => '/^Codeigniter|Laravel|Symfony|Zend$/'
        ]);

        $validate->setRules('sl_tahun', 'Pilihan Tahun', [
            'sanitize' => 'string',
            'require'  => true
        ]);

        print_r($_POST);

        if ($validate->passed()) {
            echo "<p>Lolos Validasi!</p>";
        } else {
            $error = $validate->getError();
        }
    }

    // generate <option> tahun
    for ($i=2000; $i <= 2020; $i++) { 
        $pilihanTahun[] = $i;
    }

    $pilihanFramework = ['Codeigniter','Laravel','Symfony', 'Zend'];
    $optionFramework  = Input::generateOption($pilihanFramework, Input::get('sl_framework'));
    $optionTahun      = Input::generateOption($pilihanTahun, Input::get('sl_tahun'));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Select Framework</title>
</head>
<body>
    <h1>Framework PHP Favorit</h1>
    <form method="post">
        <div>
            <label>Pilihan Anda</label>
            <select name="sl_framework">
                <?= $optionFramework; ?>
            </select>
            <select name="sl_tahun">
                <?= $optionTahun; ?>
            </select>
        </div>
        <div>
            <input type="submit" value="submit" name="submit">
        </div>
    </form>
</body>
</html>