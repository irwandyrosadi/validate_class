<?php
    require '../Input.php';
    require '../Validate.php';

    $error = [];

    if (!empty($_POST)) {
        $validate = new Validate($_POST);

        $username = $validate->setRules('username', 'Username', [
            'sanitize'  => 'string',
            'required'  => true,
            'min_char'  => 4
        ]);

        $password = $validate->setRules('password', 'Password', [
            'sanitize'  => 'string',
            'required'  => true,
            'min_char'  => 6
        ]);

        $ulangi_password = $validate->setRules('ulangi_password', 'Ulangi Password', [
            'sanitize'  => 'string',
            'required'  => true,
            'min_char'  => 6
        ]);

        $email = $validate->setRules('email', 'Email', [
            'sanitize'  => 'string',
            'required'  => true
        ]);

        if ($validate->passed()) {
            echo "Lolos Validasi!";
        } else {
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
    <title>Form Register</title>
    <style>
        .container {
            margin: 20px auto;
            width: 500px;
        }
        form > div {
            margin: 15px 0;
        }
        label {
            display:inline-block;
            width:130px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah User</h2>
        <div class="pesan-error">
            <ul>
                <?php
                    foreach ($error as $value) {
                        echo "<li>$value</li>";
                    }
                ?>
            </ul>
        </div>
        <form action="" method="post">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" value="<?php if (isset($username)) { echo $username; } ?>">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password">
            </div>
            <div>
                <label for="ulangi_password">Ulangi Password</label>
                <input type="password" name="ulangi_password">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="text" name="email" value="<?php if (isset($email)) { echo $email; } ?>">
            </div>
            <div>
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>