<?php 
    include 'conexao.php'; 

    $consulta = $pdo->query("SELECT * FROM produtos");
    $resultado = $consulta->fetchAll();

    // var_dump($resultado);
    // die();
    include 'header.php';
?>


    <div class="container">
        <h2>Produtos Cadastrados</h2>

        <table>

            <tr>
                <th>SKU</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Marca</th>
                <th colspan="2">Ações</th>
            </tr>
             <?php foreach ($resultado as $produto) {?>
            <tr>
                <td><?= htmlspecialchars($produto['sku'])?></td>
                <td><?= htmlspecialchars($produto['name'])?></td>
                <td><?= htmlspecialchars($produto['price'])?></td>
                <td><?= htmlspecialchars($produto['brand'])?></td>
                <td><a href="form-alterar.php?id=<?= $produto['id'];?>" class="btn-editar">Alterar</a></td>
                <td><a href="criar-pedido.php?id=<?= $produto['id'];?>" class="btn-editar">Comprar</a></td>
            </tr>
          <?php  } ?>
            
        </table>

        <a href="index.php">voltar</a>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>