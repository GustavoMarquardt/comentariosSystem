<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=projeto_comentarios', 'root', '');
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}
    if(isset($_POST['nome']) && !empty($_POST['nome'])){
        $nome = $_POST['nome'];
        $mensagem = $_POST['mensagem'];

        $sql = $pdo->prepare("INSERT INTO mensagens SET nome= :nome, msg = :msg, data_msg = NOW()");
        //não entendi muito bem o por que de fazer esses binds nas variaveis sendo que elas já foram lançadas para o BD
        $sql->bindValue(":nome",$nome);
        $sql->bindValue(":msg",$mensagem);
        $sql->execute();
    }
?>



<fieldset>
    <form method="POST">
        Nome:<br>
        <input type="text" name="nome"><br><br>
        Mensagem:<br>
        <textarea name="mensagem" rows="10" cols="30"></textarea><br><br>
        <input type="submit" value="Enviar comentario">
    </form>
</fieldset>
<br><br>
<?php
$sql = "SELECT * FROM mensagens ORDER BY data_msg DESC";
$sql = $pdo->query($sql);
if ($sql->rowCount() > 0) {
    foreach ($sql->fetchAll() as $mensagem) :
?>
        <strong> <?php echo $mensagem['nome']."------", $mensagem['data_msg'] ?></strong> <br>
        <?php echo $mensagem['msg']?> <br>
        <hr />
<?php
    endforeach;
} else {
    echo 'Nenhum comentario';
}
?>