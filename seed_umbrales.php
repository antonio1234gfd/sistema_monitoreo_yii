<?php
try {
    $dsn = 'mysql:host=localhost;dbname=yii2advanced';
    $pdo = new PDO($dsn, 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar registros actuales
    $q = $pdo->query("SELECT * FROM `umbrales_configuracion`");
    $rows = $q->fetchAll(PDO::FETCH_ASSOC);

    echo "=== Registros actuales en umbrales_configuracion ===\n";
    echo json_encode($rows, JSON_PRETTY_PRINT) . "\n\n";

    // Insertar si no existen
    $parametros = ['conf_mq5' => 300.0, 'conf_mq135' => 150.0];
    foreach ($parametros as $param => $valor) {
        $check = $pdo->prepare("SELECT COUNT(*) FROM `umbrales_configuracion` WHERE `parametro` = ?");
        $check->execute([$param]);
        if ($check->fetchColumn() == 0) {
            $ins = $pdo->prepare("INSERT INTO `umbrales_configuracion` (`parametro`, `valor_limite`, `descripcion`) VALUES (?, ?, ?)");
            $desc = $param === 'conf_mq5' ? 'Límite gas inflamable MQ-5' : 'Límite calidad del aire MQ-135';
            $ins->execute([$param, $valor, $desc]);
            echo "✅ Insertado: $param = $valor\n";
        } else {
            echo "ℹ️  Ya existe: $param\n";
        }
    }

    echo "\n=== Registros finales ===\n";
    $q2 = $pdo->query("SELECT * FROM `umbrales_configuracion`");
    echo json_encode($q2->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT) . "\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
