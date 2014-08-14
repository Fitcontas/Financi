<div ng-controller="FormEmpreendimentoCtrl">
<form id="#grid_empreendimento" class="grid">
    <div class="row margin-top-50">
        <div id="no-reg" class="content" style="display: none">
            <div class="container">
                <h5>No momento não existe nenhum registro cadastrado. <?php echo true ? 'Para inserir um novo clique em “Adicionar”.' : '' ?></h5>
                <div class="table-responsive hide">

                        <button class="btn btn-default dropdown-toggle no-margin" data-toggle="dropdown" type="button">
                            Adicionar &nbsp; <span class="caret"></span>
                        </button>

                </div>
            </div>
        </div>
        <div id="si-reg" class="content" style="display: block">
            <div class="mensagem">
                <!-- Conteúdo da mensagem -->
            </div>
            <div class="block-flat">
                <div class="header">
                    <h3>Relação de Empreendimentos</h3>
                </div>
                <div class="content spacer0 process">
                    <div class="toobar">
                        <div class="pull-left">
                        <div class="btn-group pull-left" id="buttons-grid">
                            <button type="button" class="btn btn-default" ng-click="showForm(false)"> Novo</button>
                            <button type="button" class="btn btn-default" ng-click="acao('excluir')"> Excluir</button>
                            <button type="button" class="btn btn-default" ng-click="acao('habilitar')"> Habilitar</button>
                            <button type="button" class="btn btn-default" ng-click="acao('desabilitar')"> Desabilitar</button></div>
                        </div>
                        <div class="pull-right">
                            <input class="form-control" type="text" aria-controls="tb_empreendimento" placeholder="Pesquisar" style="width:250px">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered spacer2 table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="checkall" ng-model="checkall"/></label>
                                        </div>
                                    </th>
                                    <th>Empreendimento</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="e in empreendimentos">
                                    <td><input type="checkbox" ng-model="confirmed" ng-change="checkAll(e)" ng-checked="checkall"/></td>
                                    <td><a ng-click="showForm(e)">{{e.empreendimento}}</a></td>
                                    <td width="5%">{{e.status == 1 ? 'Ativo' : 'Desabilitado'}}</td>
                                </tr>
                            </tbody>
                        </table>              
                    </div>
                    <div class="row-fluid" ng-show="paginas.length>1">
                      <div class="span12">
                         <div>
                          <ul class="pagination pull-right">
                            <li ng-repeat="i in paginas track by $index" ng-init="p=$index+1" ng-class="{'disabled':p==pagina}">
                              <a ng-click="start($index+1)" href="javascript:void(0)">{{$index+1}}</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<div role="dialog" id="usuario_modal" class="modal fade in" aria-hidden="false"><!-- Modal -->
    <form autocomplete="off" name="UsuarioForm" id="EmpreendimentoForm" class="form-horizontal" novalidate>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Empreendimento</h3>
                <span>Formulário de Cadastro</span>
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            </div>
            <div class="modal-body">
                <div class="mensagem-modal">
                </div>

                <div class="tab-container">
                        <ul class="nav nav-tabs flat-tabs">
                          <li class="active"><a data-toggle="tab" href="#home">Principal</a></li>
                          <li class=""><a data-toggle="tab" href="#endereco">Endereço</a></li>
                          <li class=""><a data-toggle="tab" href="#corretores">Corretores Autorizados</a></li>
                        </ul>
                        <!-- Início tab-content -->
                        <div class="tab-content">
                            <!-- Início tab-content -->
                            <input type="hidden" id="cliente-id" value="<?php //echo $id ?>">
                            <!-- Início home -->
                            <div id="home" class="tab-pane cont active">
                                <div class="spacer2">
                                    
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="nome">Empreendimento  </label>
                                        <div class="col-sm-18">
                                            <input type="text" value="" name="nome" req="" class="form-control" ng-model="empreendimento.empreendimento" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="nome">Matrícula CRI  </label>
                                        <div class="col-sm-18">
                                            <input type="text" value="" name="nome" req="" class="form-control" ng-model="empreendimento.cri" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="nome">Comissão  </label>
                                        <div class="col-sm-8">
                                            <div class="input-group no-margin-bottom">
                                                <input type="text" class="form-control" req="" ng-model="empreendimento.comissao" mask="99,99" required>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="nome">Intermediárias  </label>
                                        <div class="col-sm-8">
                                            <div class="input-group no-margin-bottom">
                                                <input type="text" class="form-control" req="" ng-model="empreendimento.intermediarias" required>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <select class="form-control" ng-model="empreendimento.periodo" req required>
                                                <option value="1">Mensal</option>
                                                <option value="2">Bimestral</option>
                                                <option value="3">Trimestral</option>
                                                <option value="5">Quatrimestral</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="nome">Qtd. Parcelas  </label>
                                        <div class="col-sm-8">
                                            <input type="text" value="" name="nome" req="" class="form-control" ng-model="empreendimento.qtd_parcelas" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="nome">Taxa do Financiamento  </label>
                                        <div class="col-sm-8">
                                            <div class="input-group no-margin-bottom">
                                                <input type="text" class="form-control" req="" ng-model="empreendimento.taxa_financimento" required>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="nome">Índice de Correção  </label>
                                        <div class="col-sm-8">
                                            <input type="text" value="" name="nome" req="" class="form-control" ng-model="empreendimento.qtd_parcelas" required>
                                        </div>
                                    </div>


                                </div>
                            </div>


                            <div id="endereco" class="tab-pane cont">
                                <div class="spacer2">
                                    
                                    <div class="form-group">
                                        <label  class="col-sm-6 control-label" for="">CEP</label>
                                         <div class="col-sm-8">
                                            <div class="input-group no-margin-bottom">
                                                <input type="text" value="" mask="99999-999" maxlength="9" class="form-control pesquisar_endereco_pelo_cep selected" ng-model="cliente.endereco.1.cep" id="endereco-secundario" ng-blur="completaEndereco(false)">
                                                <span class="input-group-btn">
                                                    <button title="Pesquisar CEP" type="button" class="btn btn-default buscar-cep"><i class="fa fa-search"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <div class="input-group no-margin-bottom">
                                                    <button class="btn-link completa" type="button" ng-click="completaEndereco(false)">Completar endereço</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="nome">Logradouro  </label>
                                        <div class="col-sm-10">
                                            <input type="text" value="" name="empreendimento[logradouro]" req="" class="form-control" ng-model="empreendimento.logradouro" required>
                                        </div>
                                        <label class="col-sm-4 control-label" for="empreendimento[numero]">Número  </label>
                                        <div class="col-sm-4">
                                            <input type="text" value="" name="empreendimento[numero]" req="" class="form-control" ng-model="empreendimento.numero" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="empreendimento[complemento]">Complemento  </label>
                                        <div class="col-sm-18">
                                            <input type="text" value="" name="empreendimento[complemento]" req="" class="form-control" ng-model="empreendimento.complemento" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="empreendimento[bairro]">Bairro  </label>
                                        <div class="col-sm-10">
                                            <input type="text" value="" name="empreendimento[bairro]" req="" class="form-control" ng-model="empreendimento.bairro" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="empreendimento[uf]">UF</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="empreendimento[uf]" ng-model="empreendimento.uf" req required>
                                                <option value="BA">BA</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-4 control-label" for="empreendimento[cidade]">Cidade  </label>
                                        <div class="col-sm-11">
                                            <select class="form-control" name="empreendimento[cidade]" ng-model="empreendimento.cidade" req required>
                                                <option value="2753">Teixeira de Freitas</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div id="corretores" class="tab-pane cont">
                                <div class="spacer2">
                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="nome">Nome  </label>
                                        <div class="col-sm-18">
                                            <input type="text" value="" name="nome" req="" class="form-control" ng-model="empreendimento.empreendimento" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <button class="btn btn-default">Adicionar</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                </div>

            </div>

            <div class="modal-footer">
                <div class="btn-group">
                    <button class="btn btn-primary" ng-click="salvar(usuario)">Salvar</button>
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="#" data-action="modal-add">Salvar e Adicionar novo</a></li>
                    </ul>
                </div>
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </form>
</div>
</div>