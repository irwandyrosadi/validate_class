<?php
    require '../Input.php';
    require '../Validate.php';

    $error = [];
    $success = "";

    if (!empty($_POST)) {
        $validate = new Validate($_POST);

        $validate->setRules('rd_framework', 'Framework', [
            'sanitize'  => 'string',
            'required'  => true,
            'regexp'    => '/^Codeigniter|Laravel|Symfony|Zend$/'
        ]);

        if (isset($_POST['rd_framework'])) {
            $success = "<div class=success>Anda memilih " . $_POST['rd_framework'] . "</div>";
        }

        if (!$validate->passed()) {
            $error = $validate->getError();
        }

    
    }

    $check_ci        = Input::get('rd_framework') === 'Codeigniter' ? 'checked' : '';
    $check_laravel   = Input::get('rd_framework') === 'Laravel'     ? 'checked' : '';
    $check_symfony   = Input::get('rd_framework') === 'Symfony'     ? 'checked' : '';
    $check_zend      = Input::get('rd_framework') === 'Zend'        ? 'checked' : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Framework Favorit</title>
    <style>
        .container { margin-left: 200px; }
        label input[type='radio'] {
            margin-bottom: 10px;
        }
        input[type='submit'] {
            background: #28C76F;
            cursor: pointer;
            padding: 7px;
            width: 100px;
            color: white;
            border: none;
            border-radius: 3px;
        }
        input[type='submit']:hover {
            background: #27ae60;
        }
        .error {
            margin-bottom: 20px;
            background: #fab1a0;
            width: 300px;
            text-align: center;
            padding: 10px;
            border: 2px solid #ff7675;
        }
        .success {
            margin-bottom: 20px;
            background: #7bed9f;
            width: 300px;
            text-align: center;
            padding: 10px;
            border: 2px solid #2ed573;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Framework PHP Favorit</h1>
        <?php
            foreach ($error as $key => $msg) {
                echo "<div class=error>$msg</div>";
            }

            echo $success

        ?>
        <form method="post">
        <div>
            <label>Pilihan Anda :</label>
            <div>
                <label><input type="radio" name="rd_framework" value="Codeigniter" <?= $check_ci ?>> Codeigniter</label>
            </div>
            <div>
                <label><input type="radio" name="rd_framework" value="Laravel" <?= $check_laravel ?>> Laravel</label>
            </div>
            <div>
                <label><input type="radio" name="rd_framework" value="Symfony" <?= $check_symfony ?>> Symfony</label>
            </div>
            <div>
                <label><input type="radio" name="rd_framework" value="Zend" <?= $check_zend ?>> Zend</label>
            </div>
            <div>
                <input type="submit" value="Submit" name="submit">
            </div>
        </div>
    </div>
</form>
</body>
</html>