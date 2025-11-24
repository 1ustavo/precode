<?php
include 'conexao.php';

// var_dump($_POST);
// die();

$id = $_POST['id'];

$novoPreco = (float) $_POST['price'];
$estoque = (float) $_POST['qty'];

// Sempre use prepare para segurança
$consulta = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
$consulta->execute([':id' => $id]);

$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

$variations = json_decode($resultado['variations'], true);

$sku = $variations[0]['sku'];
$ref   = $variations[0]['ref'];

$novoPromocional  = $novoPreco;
$novoCusto        = $novoPreco;
$novoPrazo        = 2;            // prazo adicional (shippingTime)
$novoStatus       = "enabled";    // "enabled" ou "disabled"

// Estoque por centro de distribuição:
$stores         = 50;
$availableStock = $estoque;
$realStock      = $estoque;

$baseUrl = "https://www.replicade.com.br/api/v3";
$endpoint = "/products/inventory";  // ou o endpoint da versão da API correta que você usa
$auth = "Authorization: Basic aXdPMzVLZ09EZnRvOHY3M1I6";

$productToUpdate = [
    "promotional_price" => $novoPreco,
    "price"              => $novoPreco,
    "cost"               => $novoPreco,
    "shippingTime"       => $novoPrazo,
    "status"             => $novoStatus,
    "stock" => [
        [
            "stores"         => $stores,
            "availableStock" => $availableStock,
            "realStock"      => $realStock
        ]
    ]
];

// Exigência de SKU ou REF
if (!empty($sku)) {
    $productToUpdate["sku"] = (int)$sku;
} elseif (!empty($ref)) {
    $productToUpdate["ref"] = $ref;
} else {
    die("Erro: informe SKU ou REF para atualizar.");
}

// Monta JSON com array de produtos
$data = [
    "products" => [ $productToUpdate ]
];

$json = json_encode($data);

// ===============================
// REQUISIÇÃO PUT cURL
// ===============================

$curl = curl_init($baseUrl . $endpoint);

curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST  => "PUT",
    CURLOPT_POSTFIELDS     => $json,
    CURLOPT_HTTPHEADER      => [
        "Content-Type: application/json",
        $auth
    ],
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode == 200) {
   $sql = "UPDATE produtos SET price = :price, promotional_price = :promotional_price, quantidade = :quantidade  WHERE id = :id";
$update = $pdo->prepare($sql);

$update->execute([
    ':price' => $novoPreco,
     ':promotional_price' => $novoPreco,
    ':quantidade' => $estoque,
    ':id' => $id
]);
if ($update == true) {
    echo "Cadastrado com sucesso!";
}

}else{
   echo "algo deu errado!";
   die();
}

echo "<pre>";
echo "HTTP CODE: $httpCode\n\n";
echo "JSON Enviado:\n";
print_r($data);
echo "\n\nResposta da API:\n$response\n";

$respDecoded = json_decode($response, true);
if ($httpCode == 200 && isset($respDecoded["products"])) {
    foreach ($respDecoded["products"] as $p) {
        echo "\nSKU: " . ($p["sku"] ?? "N/A") . "\n";
        echo "REF: " . ($p["ref"] ?? "N/A") . "\n";
        foreach ($p["return"] as $ret) {
            echo "→ Código retorno: " . $ret["code"] . " — Mensagem: " . $ret["message"] . "\n";
        }
    }
}
echo "</pre>";

echo '<a href="lista-produto.php">voltar</a>';
