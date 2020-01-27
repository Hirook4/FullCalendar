<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8' />
    <link href='css/core/main.min.css' rel='stylesheet' />
    <link href='css/daygrid/main.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/personalizado.css">

    <script src='js/core/main.min.js'></script>
    <script src='js/interaction/main.min.js'></script>
    <script src='js/daygrid/main.min.js'></script>
    <script src='js/core/locales/pt-br.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="js/personalizado.js"></script>
</head>

<body>

    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <div id='calendar'></div>

    <!--Modal de Exibição-->
    <div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalhes da Reunião</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="visEvent">
                        <dl class="row">
                            <dt class="col-sm-3">ID da Reunião</dt>
                            <dd class="col-sm-9" id="id"></dd>

                            <dt class="col-sm-3">Nome do Evento</dt>
                            <dd class="col-sm-9" id="title"></dd>

                            <dt class="col-sm-3">Inicio</dt>
                            <dd class="col-sm-9" id="start"></dd>

                            <dt class="col-sm-3">Termino</dt>
                            <dd class="col-sm-9" id="end"></dd>
                        </dl>
                        <button class="btn btn-warning btn-canc-vis">Editar</button>
                        <a href="" id="excluir_evento" class="btn btn-danger">Excluir</a>
                    </div>

                    <!--Modal de Edição-->
                    <div class="formEdit">
                        <span id="msg-edit"></span>
                        <form id="editEvent" method="POST">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Titulo</label>
                                <div class="col-sm-10">
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Titulo da Reunião">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cor</label>
                                <div class="col-sm-10">
                                    <select name="color" class="form-control" id="color">
                                        <option value="">Selecione</option>
                                        <option style="color:#FFD700;" value="#FFD700">Amarelo</option>
                                        <option style="color:#0071c5;" value="#0071c5">Azul Turquesa</option>
                                        <option style="color:#FF4500;" value="#FF4500">Laranja</option>
                                        <option style="color:#8B4513;" value="#8B4513">Marrom</option>
                                        <option style="color:#1C1C1C;" value="#1C1C1C">Preto</option>
                                        <option style="color:#436EEE;" value="#436EEE">Royal Blue</option>
                                        <option style="color:#A020F0;" value="#A020F0">Roxo</option>
                                        <option style="color:#40E0D0;" value="#40E0D0">Turquesa</option>
                                        <option style="color:#228B22;" value="#228B22">Verde</option>
                                        <option style="color:#8B0000;" value="#8B0000">Vermelho</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Inicio da Reunião</label>
                                <div class="col-sm-10">
                                    <input type="text" name="start" class="form-control" id="start" onkeypress="DataHora(event, this)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Final da Reunião</label>
                                <div class="col-sm-10">
                                    <input type="text" name="end" class="form-control" id="end" onkeypress="DataHora(event, this)">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" name="CadEvent" id="CadEvent" value="CadEvent" class="btn btn-success">Salvar</button>
                                    <button type="button" class="btn btn-danger btn-canc-edit">Cancelar</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!--Modal de Cadastro-->

    <div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <span id="msg-cad"></span>
                    <form id="addevent" method="POST">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Titulo</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" id="title" placeholder="Titulo da Reunião">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Cor</label>
                            <div class="col-sm-10">
                                <select name="color" class="form-control" id="color">
                                    <option value="">Selecione</option>
                                    <option style="color:#FFD700;" value="#FFD700">Amarelo</option>
                                    <option style="color:#0071c5;" value="#0071c5">Azul Turquesa</option>
                                    <option style="color:#FF4500;" value="#FF4500">Laranja</option>
                                    <option style="color:#8B4513;" value="#8B4513">Marrom</option>
                                    <option style="color:#1C1C1C;" value="#1C1C1C">Preto</option>
                                    <option style="color:#436EEE;" value="#436EEE">Royal Blue</option>
                                    <option style="color:#A020F0;" value="#A020F0">Roxo</option>
                                    <option style="color:#40E0D0;" value="#40E0D0">Turquesa</option>
                                    <option style="color:#228B22;" value="#228B22">Verde</option>
                                    <option style="color:#8B0000;" value="#8B0000">Vermelho</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Inicio da Reunião</label>
                            <div class="col-sm-10">
                                <input type="text" name="start" class="form-control" id="start" onkeypress="DataHora(event, this)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Final da Reunião</label>
                            <div class="col-sm-10">
                                <input type="text" name="end" class="form-control" id="end" onkeypress="DataHora(event, this)">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" name="CadEvent" id="CadEvent" value="CadEvent" class="btn btn-success">
                                    Cadastrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>