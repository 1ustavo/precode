<?php
include 'conexao.php';
$consulta = $pdo->prepare("SELECT * FROM pedidos WHERE status = 1");
$consulta->execute();

$resultado = $consulta->fetchAll();

// var_dump($resultado);
// die();
?>
</head>
<body>
    <?php include 'header.php'; ?>

<div class="container">
    <h2>Lista de Pedidos</h2>

    <table>
        <thead>
            <tr>
                
                <th>ID Parceiro</th>
                <th>SKU</th>
                <th>Valor Unitário</th>
                <th>Quantidade</th>
                <th>Status</th>
                <th>Criado em</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($resultado as $pedido) { ?>
                
            <tr>
            
                <td><?= htmlspecialchars($pedido['idpedidoparceiro'])?> </td>
                <td><?= htmlspecialchars($pedido['sku'])?></td>
                <td><?= htmlspecialchars($pedido['valorunitario'])?></td>
                <td><?= htmlspecialchars($pedido['quantidade'])?></td>
                <td><?= htmlspecialchars($pedido['status'])?></td>
                <td><?= htmlspecialchars($pedido['created_at'])?></td>
                <td class="actions">
                    <a href="aprovar-pedido.php?id=<?= $pedido['id']?>" class="btn-editar">APROVAR</a>
                    <a href="cancelar-pedido.php?id=<?= $pedido['id'] ?>&idpedidoparceiro=<?= $pedido['idpedidoparceiro'] ?>" class="btn btn-cancel">CANCELAR</a>
                </td>

            </tr>
            <?php } ?>
        </tbody>
    </table>
<a href="index.php">voltar</a>
</div>

<?php include 'footer.php' ?>

</body>
</html>
