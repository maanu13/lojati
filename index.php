<?php
require "config.php";

$rota = $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"] === "POST" ? "lojati" : "teste");

function readClientes($con){
    $stmt = $con->query("SELECT * FROM clientes");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function createCliente($con){
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];
    try {
        $stmt = $con->prepare("INSERT INTO clientes (nome, email, telefone, endereco) VALUES (?, ?, ?, ?)");
        $stmt ->execute([$nome, $email, $telefone, $endereco]);
        header("Location : ../front/index.html");
    }catch (PDOException $e){
        echo json_encode(["erro" => "Falha na conexão: " . $e->getMessage()]);
        // header("Location: ../front/erro.html");
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    createCliente($con);
}elseif ($rota === "clientes"){
    readClientes($con);
}else {
    teste();
}