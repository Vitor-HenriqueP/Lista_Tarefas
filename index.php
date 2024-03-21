<?php
    $acao = 'recuperarTarefasPendentes';
    require 'tarefa_controller.php';

    // Verifica se o parâmetro "ordenar" foi enviado via GET
    if (isset($_GET['ordenar'])) {
        $ordenacao = $_GET['ordenar'];
    } else {
        $ordenacao = 'nome_asc'; // Ordenação padrão
    }
?>

<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App Lista Tarefas</title>

        <link rel="stylesheet" href="css/estilo.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
                    App Lista Tarefas
                </a>
            </div>
        </nav>

        <div class="container app">
            <div class="row">
                <div class="col-md-3 menu">
                    <ul class="list-group">
                        <li class="list-group-item active"><a href="#">Tarefas pendentes</a></li>
                        <li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
                        <li class="list-group-item"><a href="todas_tarefas.php">Todas tarefas</a></li>
                    </ul>
                    <hr>
                    <label for="ordenacao">Ordenar por:</label>
                    <select class="form-control" id="ordenacao" onchange="ordenar()">
                        <option value="nome_asc" <?php if ($ordenacao == 'nome_asc') echo 'selected'; ?>>A-Z</option>
                        <option value="data_criacao_desc" <?php if ($ordenacao == 'data_criacao_desc') echo 'selected'; ?>>Data de criação (Mais recente primeiro)</option>
                    </select>
                </div>

                <div class="col-md-9">
                    <div class="container pagina">
                        <div class="row">
                            <div class="col">
                                <h4>Tarefas pendentes</h4>
                                <hr />

                                <?php foreach($tarefas as $indice => $tarefa) { ?>
                                    <div class="row mb-3 d-flex align-items-center tarefa">
                                        <div class="col-sm-9" id="tarefa_<?= $tarefa->id ?>">
                                            <?= $tarefa->tarefa ?>
                                        </div>
                                        <div class="col-sm-3 mt-2 d-flex justify-content-between">
                                            <a class="link-trash" href="#" onclick="remover(<?= $tarefa->id ?>)">
                                                <i class="fas fa-trash-alt fa-lg text-danger"></i>
                                            </a>
                                            <a class="link-edit" href="#" onclick="editar(<?= $tarefa->id ?>, '<?= $tarefa->tarefa ?>')">
                                                <i class="fas fa-edit fa-lg text-info"></i>
                                            </a>
                                            <a class="link-check" href="tarefa_controller.php?acao=marcarRealizada&id=<?= $tarefa->id ?>">
                                                <i class="fas fa-check-square"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Função para redirecionar a página ao selecionar uma opção de ordenação
            function ordenar() {
                var ordenacao = document.getElementById("ordenacao").value;
                if (ordenacao !== '<?php echo $ordenacao; ?>') {
                    window.location.href = "index.php?ordenar=" + ordenacao;
                }
            }
        </script>
    </body>
</html>