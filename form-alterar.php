<?php 
    include 'conexao.php';
    $id = $_GET['id'];
    $consulta = $pdo->query("SELECT * FROM produtos WHERE id = $id");
    $resultado = $consulta->fetchAll();
    // var_dump($resultado);
    // exit();
 ?>

<body>
   <?php include'header.php'; ?>

    <div class="container">
        <h2>Informações do Produto</h2>
        <form action="atualizar-produto.php" method="POST">

        <?php foreach ($resultado as $produto) {?>

        <input type="number" name="id" value="<?= htmlspecialchars($produto['id'])?>"hidden>
        <!-- CAMPOS SOMENTE PARA EXIBIR (NÃO EDITÁVEIS) -->
        <div class="field">
            <label>SKU</label>
            <input type="text" class="readonly" value="<?=htmlspecialchars($produto['sku']) ?? 'null'?>" readonly>
        </div>
        <div class="field">
            <label>Nome</label>
            <input type="text" class="readonly" value="<?=htmlspecialchars($produto['name'])?>" readonly>
        </div>
        <div class="field">
            <label>Marca</label>
            <input type="text" class="readonly" value="<?=htmlspecialchars($produto['brand'])?>" readonly>
        </div>

        <!-- CAMPOS EDITÁVEIS -->
        <h3>Alterar Valores</h3>
        <div class="field">
            <label>Novo Preço *</label>
            <input type="text" name="price" value="<?=htmlspecialchars($produto['price'])?>">
        </div>

        <!-- <div class="field">
            <label>Novo Preço Promocional *</label>
            <input type="text" name="promotional_price" value="<?=htmlspecialchars($produto['promotional_price'])?>">
        </div> -->

        <div class="field">
            <label>Estoque *</label>
            <input type="number" name="qty" value="<?=htmlspecialchars($produto['quantidade'])?>">
        </div>

        <input type="submit" value="SALVAR ALTERAÇÕES">
    <?php } ?>
    </form>
    </div>

   <?php include 'footer.php'; ?>
</body>
</html>
