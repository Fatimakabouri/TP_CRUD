<?php
    $pdo = new PDO(
        "mysql:host=localhost;dbname=devoir", 
        "root", 
        ""
    );
    $sql = "SELECT * FROM users";
    $stmt = $pdo->query($sql);
    
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <?php
    if(isset($_GET['delete'])){
        $id = $_GET['id'];
        $sql = "DELETE FROM users WHERE id=$id";

        $pdo->exec($sql);
        header("location:index.php");
    }
    if(isset($_GET['edit'])){
        $id = $_GET['id'];
        $sql = "SELECT * FROM users WHERE id=$id";
        $stmt = $pdo->query($sql);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="container">
    <h1>Edit user</h1>
    <form action="index.php" method="post">
        <input type="hidden" name="id1" value="<?= $id ?>">
        <input type="text" name="email1" class="form-control" >
        <input type="text" name="pass1" class="form-control">
        <select name="role1" class="form-control">
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="guest" <?= $user['role'] == 'guest' ? 'selected' : '' ?>>guest</option>
        </select>
        <button class="btn btn-primary col-12">Enregistrer</button>
    </form>
</div>
<?php 

    }
    if(isset($_POST['email1'])){
        $id=$_POST['id1'];
           $e = $_POST['email1'];
           $p = $_POST['pass1'];
           $r = $_POST['role1'];
       
           $sql = "UPDATE users SET email='$e', password='$p', role='$r' WHERE id=$id";
       
           $pdo->exec($sql);
           header("location:index.php");
        }
        ?>

<div class="container">
    <h1>Users List</h1>
    <?php if(isset($_GET['msg'])) : ?>
        <div class="alert alert-warning">
            Enregistrement déjà supprimé par quelcun d'autre
        </div>
    <?php endif ?>
    <form action="index.php">
        <input type="text" name="email" class="form-control" placeholder="Email">
        <input type="password" name="pass" class="form-control" placeholder="Pass">
        <select name="role" class="form-control">
            <option value="admin">Admin</option>
            <option value="guest">guest</option>
        </select>
        <button class="btn btn-primary col-12">Ajouter</button>
    </form>
    <?php
    if (isset ($_GET['email'])  && isset($_GET['pass'])){
        $e = $_GET['email'];
        $p = $_GET['pass'];
        $r = $_GET['role'];
    $sql = "INSERT INTO users VALUES (null,'$e', '$p', '$r')";

    $pdo->exec($sql);
    header("location:index.php");
    }
    ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>EMAIL</th>
                <th>PASSWORD</th>
                <th>ROLE</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as  $user) : ?>
                <tr>
                    <td><?php echo $user['id'] ?></td>
                    <td><?php echo $user['email'] ?></td>
                    <td><?php echo $user['password'] ?></td>
                    <td><?php echo $user['role'] ?></td>
                    <td><a onclick="confirmer(event)" class="btn btn-danger" href="index.php?delete=1&id=<?php echo $user['id'] ?>"><i class="bi bi-trash"></i></a></td>
                    <td><a class="btn btn-warning" href="index.php?edit=1&id=<?php echo $user['id'] ?>"><i class="bi bi-pencil-square"></i></a></td>
                </tr>
            <?php endforeach ?>


        </tbody>
    </table>
</div>

<hr>
<pre>

</pre>
    <script>
        function confirmer(evt) {
            if(!confirm('Etes vous sur de vouloir supprimer'))
                evt.preventDefault()
        }
    </script>
</body>
</html>