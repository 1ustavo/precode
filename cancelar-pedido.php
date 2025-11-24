<?php
include 'conexao.php';

$auth = "Authorization: Basic aXdPMzVLZ09EZnRvOHY3M1I6";
$baseUrl = "https://www.replicade.com.br/api/v1/pedido/pedido";
$id = $_GET['id'];

$consulta = $pdo->query("SELECT * FROM pedidos WHERE id = $id");
$consulta->execute();

$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

$idPedidoParceiro = $resultado['idpedidoparceiro'];

if (!$idPedidoParceiro) {
    die("ID do pedido ausente.");
}

// delete
$dados = [
    "pedido" => [
        "idPedidoParceiro" => $idPedidoParceiro
    ]
];

$json = json_encode($dados, JSON_UNESCAPED_UNICODE);

$curl = curl_init($baseUrl);
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "DELETE",
    CURLOPT_POSTFIELDS => $json,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        $auth
    ]
]);

$resposta = curl_exec($curl);
$http = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

$sql = "UPDATE pedidos SET status = :status WHERE id = :id";
 $update = $pdo->prepare($sql);

$update->execute([
    ':status' => 3,
    ':id' => $id
]);
if ($update == true) {
    echo "Cadastrado com sucesso!";
}
else{
   echo "algo deu errado!";
   die();
}

echo "<pre>";
echo "CANCELAR PEDIDO\n";
echo "ID: $idPedidoParceiro\n";
echo "HTTP: $http\n\n";
echo "RESPOSTA:\n$resposta";
echo "</pre>";
echo '<a href="listar-pedidos.php">voltar</a>';
