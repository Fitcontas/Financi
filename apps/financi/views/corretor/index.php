<form id="#grid_cliente" class="grid" data-control="Clientes" data-list="dt_cliente(true)">
    <div class="row margin-top-50">
        <div id="no-reg" class="content" style="display: none">
            <div class="container">
                <h5>No momento não existe nenhum registro cadastrado. <?php echo true ? 'Para inserir um novo clique em “Adicionar”.' : '' ?></h5>
                <div class="table-responsive hide">
                    <div class="btn-group">
                        <button class="btn btn-default dropdown-toggle no-margin" data-toggle="dropdown" type="button">
                            Adicionar &nbsp; <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="?controle=Clientes&acao=manter&tipo=PF" class="pointer"> Cliente PF </a></li>
                            <li><a href="?controle=Clientes&acao=manter&tipo=PJ" class="pointer"> Cliente PJ </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="si-reg" class="content" style="display: block">
            <div class="mensagem">
                <!-- Conteúdo da mensagem -->
            </div>
            <div class="block-flat">
                <div class="header">
                    <h3>Relação de Corretores</h3>
                </div>
                <div class="content spacer0 process">
                    <div class="toobar">
                        <div class="pull-left">
                        <div class="btn-group pull-left" id="buttons-grid">
                            <a class="btn btn-default" href="/corretor/novo"> Novo</a>
                            <button type="button" class="btn btn-default" ng-click="acao('excluir')"> Excluir</button>
                            <button type="button" class="btn btn-default" ng-click="acao('habilitar')"> Habilitar</button>
                            <button type="button" class="btn btn-default" ng-click="acao('desabilitar')"> Desabilitar</button></div>
                        </div>
                        <div class="pull-right">
                            <input class="form-control" type="text" aria-controls="tb_cliente" placeholder="Pesquisar" style="width:250px">
                        </div>
                        
                    </div>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover spacer2" id="tb_cliente">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="checkall" class="checkall"/></label>
                                        </div>
                                    </th>
                                    <th>Nome/Razão Social</th>
                                    <th>Natureza</th>
                                    <th>CPF/CNPJ</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php foreach ($corretores as $c): ?>
                                    <?php if ($c->cpf): ?>
                                    <tr>
                                        <td><input type="checkbox" value="<?php echo $c->id ?>" name="check[]"></td>
                                        <td><?php echo $c->nome ?></td>
                                        <td><?php echo $c->cpf ? 'PF' : 'PJ' ?></td>
                                        <td><?php echo $c->cpf ? $c->cpf : $c->cnpj ?></td>
                                        <td><?php echo $c->status == 1 ? 'Ativo' : 'Inativo' ?></td>
                                    </tr>
                                    <?php endif ?>
                                <?php endforeach ?>

                            </tbody>
                        </table>                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="cliente_modal"   role="dialog"></div>