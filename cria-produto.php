<?php

include 'conexao.php';

$nome = $_POST['name'];
$descricao = $_POST['description'];
$preco = $_POST['price'];
$price = (float) $preco;
// $promo = $_POST['promotional_price'];
// $custo = $_POST['cost'];
$peso = (float) $_POST['weight'];
$largura = (float) $_POST['width'];
$altura = (float) $_POST['height'];
$comprimento = (float) $_POST['length'];
$marca = $_POST['brand'];

// SKU aleatório (9 dígitos)
function gerarSku() {
    return rand(100000000, 999999999);
}

// Gera EAN-13 válido
function gerarEan13() {
    $base = "";
    for ($i = 0; $i < 12; $i++) {
        $base .= rand(0, 9);
    }

    $sum = 0;
    for ($i = 0; $i < 12; $i++) {
        $num = intval($base[$i]);
        $sum += ($i % 2 == 0) ? $num : $num * 3;
    }

    $dv = (10 - ($sum % 10)) % 10;
    return $base . $dv;
}

$skuVariacao = gerarSku(); 
$ean = gerarEan13();  
// var_dump($ean);

// die();
$ref = gerarEan13();
$quantidade = 10;

$baseUrl = "https://www.replicade.com.br/api/v3/products";
$auth = "Authorization: Basic aXdPMzVLZ09EZnRvOHY3M1I6";


$data = [
   "product" => [
      "sku" => $skuVariacao,
      "name" => $nome,
      "description" => $descricao,
      "shortName" => "Produto Teste",
      "status" => "enabled",
      "wordKeys" => "teste,api,replicade",
      "price" => $price,
      "promotional_price" => $price,
      "cost" => $price,
      "weight" => $peso,
      "width" => $largura,
      "height" => $altura,
      "length" => $comprimento,
      "brand" => $marca,
      "urlYoutube" => "",
      "googleDescription" => "",
      "manufacturing" => "Nacional",
      "nbm" => "",
      "model" => "",
      "gender" => "",
      "volumes" => 1,
      "warrantyTime" => 12,
      "category" => "Teste",
      "subcategory" => "Subteste",
      "endcategory" => "Final Teste",
      "attribute" => [],
      "variations" => [
         [
            "ref" => $ref,
            "sku" => $skuVariacao,
            "qty" => $quantidade,
            "ean" => $ean,
            "images" => [
               "https://replicade.com.br/imagemteste.jpg"
            ],
            "specifications" => [
               [
                  "key" => "Cor",
                  "value" => "Branco"
               ]
            ]
         ]
      ]
   ]
];

$json = json_encode($data);

// CURL

$curl = curl_init($baseUrl);

curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $json,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        $auth
    ]
]);

$resposta = curl_exec($curl);
$http = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

// RESULTADO

echo "<pre>";
echo "HTTP CODE: $http\n\n";
echo "EAN GERADO: $ean\n";
echo "SKU VARIAÇÃO GERADO: $skuVariacao\n\n";
echo "Retorno da API:\n$resposta";

$decoded = json_decode($resposta, true);
$skuAPI = $decoded['sku'] ?? null;
$variationsAPI = $decoded['variations'] ?? [];
$variationsJSON = json_encode($variationsAPI);

// var_dump($variationsJSON);
// die();

if ($http == 200) {
   $sql = "INSERT INTO produtos (
    sku, name, shortName, description, status, wordKeys,
    price, promotional_price, cost, weight, width, height, length,
    brand, nbm, model, gender, volumes, warrantyTime, category,
    subcategory, endcategory, urlYoutube, googleDescription, manufacturing, quantidade, variations
) VALUES (
    :sku, :name, :shortName, :description, :status, :wordKeys,
    :price, :promotional_price, :cost, :weight, :width, :height, :length,
    :brand, :nbm, :model, :gender, :volumes, :warrantyTime, :category,
    :subcategory, :endcategory, :urlYoutube, :googleDescription, :manufacturing, :quantidade, :variations
)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':sku' => $skuVariacao,
    ':name' => $nome,
    ':shortName' => '',
    ':description' => $descricao,
    ':status' => 'enabled',
    ':wordKeys' => '',
    ':price' => $price,
    ':promotional_price' => $price,
    ':cost' => $price,

    ':weight' => $peso,
    ':width' => $largura,
    ':height' => $altura,
    ':length' => $comprimento,

    ':brand' => $marca,
    ':nbm' => '',
    ':model' => '',
    ':gender' => null,
    ':volumes' => 1,
    ':warrantyTime' => 12,
    ':category' => '',
    ':subcategory' => '',
    ':endcategory' => '',
    ':urlYoutube' => null,
    ':googleDescription' => null,
    ':manufacturing' => 'Nacional',
    ':quantidade' => $quantidade,
    ':variations' => $variationsJSON
]);

}else{
   echo "algo deu errado!";
   die();
}


if ($http == 200 && isset($decoded["code"]) && $decoded["code"] == 0) {
    echo "\n\n=== SUCESSO ===\n";
    echo "SKU PAI: " . $decoded["sku"] . "\n";

    if (!empty($decoded["variations"][0])) {
        echo "SKU VARIAÇÃO: " . $decoded["variations"][0]["sku"] . "\n";
        echo "REF: " . $decoded["variations"][0]["ref"] . "\n";
    }
}

echo "</pre>";

echo '<a href="index.php">voltar</a>';
