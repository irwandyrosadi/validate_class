<?php 
    require '../Input.php';
    require '../Validate.php';

    $error = [];

    if (!empty($_POST)) {
        $validate = new Validate($_POST);

        $cb_ci  = $validate->setRules('cb_codeigniter','Codeigniter', [
            'sanitize' => 'string',
            'required' => true,
            'regexp'   => '/^Codeigniter$/'
        ]);

        print_r($_POST);

        if ($validate->passed()) {
            echo "<p> Lolos Validasi! </p>";
        } else {
            $error = $validate->getError();
            print_r($error);
        }
    }

    $check_ci        = Input::get('cb_codeigniter') === 'Codeigniter' ? 'checked' : '';
    $check_laravel   = Input::get('cb_laravel')     === 'Laravel'     ? 'checked' : '';
    $check_symfony   = Input::get('cb_symfony')     === 'Symfony'     ? 'checked' : '';
    $check_zend      = Input::get('cb_zend')        === 'Zend'        ? 'checked' : '';
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
        label input[type='checkbox'] {
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Framework PHP Favorit</h1>
        <?php
            foreach ($error as $key => $error) {
                echo "<div class=error>$error</div>";
            }
        ?>
        <form method="post">
        <div>
            <label>Pilihan Anda :</label>
            <div>
                <label><input type="checkbox" name="cb_codeigniter" value="Codeigniter" <?= $check_ci ?>> Codeigniter</label>
            </div>
            <div>
                <label><input type="checkbox" name="cb_laravel" value="Laravel" <?= $check_laravel ?> > Laravel</label>
            </div>
            <div>
                <label><input type="checkbox" name="cb_symfony" value="Symfony" <?= $check_symfony ?>> Symfony</label>
            </div>
            <div>
                <label><input type="checkbox" name="cb_zend" value="Zend" <?= $check_zend ?>> Zend</label>
            </div>
            <div>
                <input type="submit" value="Submit" name="submit">
            </div>
        </div>
    </div>
</form>
</body>
</html>