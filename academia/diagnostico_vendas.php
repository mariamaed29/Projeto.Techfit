<?php
// Script para testar e diagnosticar o sistema de vendas
// Salve como: testar_vendas.php na pasta raiz

require_once __DIR__ . '/core/db.php';

echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <title>Teste de Sistema de Vendas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .box {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .warning {
            color: orange;
            font-weight: bold;
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
        }
        pre {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
<h1>🔍 Diagnóstico do Sistema de Vendas</h1>";

// 1. Testar conexão com o banco
echo "<div class='box'>";
echo "<h2>1. Conexão com o Banco de Dados</h2>";
try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    if ($conn->ping()) {
        echo "<p class='success'>✅ Conexão com banco de dados OK!</p>";
        echo "<p>Host: " . $conn->host_info . "</p>";
    } else {
        echo "<p class='error'>❌ Erro ao conectar com o banco</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Erro: " . $e->getMessage() . "</p>";
}
echo "</div>";

// 2. Verificar se a tabela vendas existe
echo "<div class='box'>";
echo "<h2>2. Verificação da Tabela 'vendas'</h2>";
try {
    $result = $conn->query("SHOW TABLES LIKE 'vendas'");
    
    if ($result->num_rows > 0) {
        echo "<p class='success'>✅ Tabela 'vendas' existe!</p>";
        
        // Mostrar estrutura da tabela
        $structure = $conn->query("DESCRIBE vendas");
        echo "<h3>Estrutura da Tabela:</h3>";
        echo "<table>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        while ($row = $structure->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    } else {
        echo "<p class='error'>❌ Tabela 'vendas' NÃO existe!</p>";
        echo "<p class='warning'>⚠️ Execute o SQL abaixo para criar a tabela:</p>";
        echo "<pre>CREATE TABLE `vendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(255) NOT NULL,
  `email_cliente` varchar(255) NOT NULL,
  `telefone_cliente` varchar(20) DEFAULT NULL,
  `cpf_cliente` varchar(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `produto_nome` varchar(255) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `valor_unitario` decimal(10,2) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `forma_pagamento` enum('cartao_credito','cartao_debito','pix','dinheiro') NOT NULL,
  `cartao_mascarado` varchar(20) DEFAULT NULL,
  `status` enum('pendente','confirmada','entregue','cancelada') NOT NULL DEFAULT 'confirmada',
  `data_venda` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `produto_id` (`produto_id`),
  KEY `email_cliente` (`email_cliente`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;</pre>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Erro ao verificar tabela: " . $e->getMessage() . "</p>";
}
echo "</div>";

// 3. Verificar produtos disponíveis
echo "<div class='box'>";
echo "<h2>3. Produtos Disponíveis</h2>";
try {
    $result = $conn->query("SELECT id, nome, preco, estoque, ativo FROM produtos ORDER BY id DESC LIMIT 5");
    
    if ($result->num_rows > 0) {
        echo "<p class='success'>✅ Produtos encontrados: " . $result->num_rows . "</p>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Nome</th><th>Preço</th><th>Estoque</th><th>Ativo</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $ativo = $row['ativo'] ? 'Sim' : 'Não';
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nome'] . "</td>";
            echo "<td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>";
            echo "<td>" . $row['estoque'] . "</td>";
            echo "<td>" . $ativo . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='warning'>⚠️ Nenhum produto encontrado</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Erro: " . $e->getMessage() . "</p>";
}
echo "</div>";

// 4. Verificar vendas existentes
echo "<div class='box'>";
echo "<h2>4. Vendas Registradas</h2>";
try {
    $result = $conn->query("SELECT COUNT(*) as total FROM vendas");
    $row = $result->fetch_assoc();
    $total = $row['total'];
    
    echo "<p class='success'>✅ Total de vendas: <strong>" . $total . "</strong></p>";
    
    if ($total > 0) {
        $vendas = $conn->query("SELECT id, nome_cliente, produto_nome, valor_total, status, data_venda FROM vendas ORDER BY id DESC LIMIT 10");
        echo "<h3>Últimas 10 Vendas:</h3>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Cliente</th><th>Produto</th><th>Valor</th><th>Status</th><th>Data</th></tr>";
        while ($v = $vendas->fetch_assoc()) {
            echo "<tr>";
            echo "<td>#" . str_pad($v['id'], 6, '0', STR_PAD_LEFT) . "</td>";
            echo "<td>" . $v['nome_cliente'] . "</td>";
            echo "<td>" . $v['produto_nome'] . "</td>";
            echo "<td>R$ " . number_format($v['valor_total'], 2, ',', '.') . "</td>";
            echo "<td>" . $v['status'] . "</td>";
            echo "<td>" . date('d/m/Y H:i', strtotime($v['data_venda'])) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='warning'>⚠️ Nenhuma venda registrada ainda</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Erro: " . $e->getMessage() . "</p>";
}
echo "</div>";

// 5. Teste de inserção simulado
echo "<div class='box'>";
echo "<h2>5. Teste de Permissões</h2>";
try {
    // Tentar criar uma tabela temporária
    $conn->query("CREATE TEMPORARY TABLE teste_permissao (id INT)");
    echo "<p class='success'>✅ Permissões de escrita OK!</p>";
    $conn->query("DROP TEMPORARY TABLE IF EXISTS teste_permissao");
} catch (Exception $e) {
    echo "<p class='error'>❌ Problema de permissões: " . $e->getMessage() . "</p>";
}
echo "</div>";

// 6. Verificar logs de erro
echo "<div class='box'>";
echo "<h2>6. Configuração PHP</h2>";
echo "<p><strong>Display Errors:</strong> " . (ini_get('display_errors') ? 'ON' : 'OFF') . "</p>";
echo "<p><strong>Error Reporting:</strong> " . error_reporting() . "</p>";
echo "<p><strong>Log Errors:</strong> " . (ini_get('log_errors') ? 'ON' : 'OFF') . "</p>";
echo "<p><strong>Error Log:</strong> " . ini_get('error_log') . "</p>";
echo "<p class='warning'>⚠️ Verifique o arquivo de log para erros detalhados</p>";
echo "</div>";

// 7. Links úteis
echo "<div class='box'>";
echo "<h2>7. Links para Teste</h2>";
echo "<ul>";
echo "<li><a href='/loja.html' target='_blank'>🛒 Ver Loja</a></li>";
echo "<li><a href='/admin/vendas' target='_blank'>📊 Gerenciar Vendas (Admin)</a></li>";
echo "<li><a href='/admin/produtos' target='_blank'>📦 Gerenciar Produtos (Admin)</a></li>";
echo "</ul>";
echo "</div>";

echo "</body></html>";

$conn->close();
?>