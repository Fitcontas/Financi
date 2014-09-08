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
                            <default:actions:buttons/>
                        </div>
                        <div class="pull-right">
                            <div class="input-group">
                              <input class="form-control" type="text" placeholder="Pesquisar" ng-model="search" ng-enter="start()">
                              <span class="input-group-btn">
                                <button class="btn btn-default btn-sm" type="button" ng-click="start()"><i class="fa fa-search"></i></button>
                              </span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <!-- Início data table content -->
                    <div class="table-responsive" ng-show="model.empreendimentos.length>0">
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
                                <tr ng-repeat="e in model.empreendimentos">
                                    <td><input type="checkbox" ng-model="confirmed" ng-change="checkAll(e)" ng-checked="checkall"/></td>
                                    <td><a ng-click="showForm(e)">{{e.empreendimento}}</a></td>
                                    <td width="5%">{{e.status == 1 ? 'Ativo' : 'Desabilitado'}}</td>
                                </tr>
                            </tbody>
                        </table>  

                        <!-- início da paginação -->
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
                        <div class="clearfix"></div>
                        <!-- /fim da paginação -->            
                    </div>

                    <!-- /Fim data table content -->

                    <!-- Início da mensagem caso não haja registro -->
                    <div class="table-responsive" ng-show="!model.empreendimentos.length && model.$resolved">
                        <div class="alert alert-warning alert-white rounded">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <div class="icon"><i class="fa fa-warning"></i></div>
                            <strong>Opss!</strong> Nenhum registro encontrado!
                         </div>
                    </div>
                    <!-- /Fim da mensagem caso não haja registro -->
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<div role="dialog" id="usuario_modal" class="modal fade in" aria-hidden="false"><!-- Modal -->
    <form autocomplete="off" name="EmpreendimentoForm" id="EmpreendimentoForm" class="form-horizontal" novalidate>
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
                        <div style="margin-top: -7px;" class="tab-container pull-right">
                        <ul class="nav nav-pills">
                          <li class="active"><a data-toggle="tab" href="#home">Principal</a></li>
                          <li class=""><a data-toggle="tab" href="#endereco">Endereço</a></li>
                          <li class=""><a data-toggle="tab" href="#corretores">Corretores Autorizados</a></li>
                        </ul>
                        </div>
                        <div class="clearfix"></div>
                        <!-- Início tab-content -->
                        <div class="tab-content">
                            <hr>
                            <!-- Início tab-content -->
                            <input type="hidden" id="cliente-id" value="<?php //echo $id ?>">
                            <!-- Início home -->
                            <div id="home" class="tab-pane cont active">
                                <div class="spacer2">
                                    
                                    <div class="form-group">
                                        <label class="col-sm-7 control-label" for="nome">Empreendimento  </label>
                                        <div class="col-sm-17">
                                            <input type="text" value="" name="nome" req="" class="form-control" ng-model="empreendimento.empreendimento" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-7 control-label" for="nome">Matrícula CRI  </label>
                                        <div class="col-sm-17">
                                            <input type="text" value="" name="nome" req="" class="form-control" ng-model="empreendimento.cri" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-7 control-label" for="nome">Comissão  </label>
                                        <div class="col-sm-7">
                                            <div class="input-group no-margin-bottom">
                                                <input type="text" class="form-control mask-money" req="" ng-model="empreendimento.comissao" placeholder="0,00" maxlength="6" required>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-7 control-label" for="nome">Intermediárias  </label>
                                        <div class="col-sm-7">
                                            <div class="input-group no-margin-bottom">
                                                <input type="text" class="form-control mask-money" req="" ng-model="empreendimento.intermediarias" placeholder="0,00" maxlength="6" required>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <select class="form-control" ng-model="empreendimento.periodo" req required ng-disabled="!empreendimento.intermediarias > 0 || empreendimento.intermediarias == '0,00'">
                                                <option value="1">Mensal</option>
                                                <option value="2">Bimestral</option>
                                                <option value="3">Trimestral</option>
                                                <option value="4">Quatrimestral</option>
                                                <option value="5">Semestral</option>
                                                <option value="6">Anual</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-7 control-label" for="nome">Qtd. Parcelas  </label>
                                        <div class="col-sm-7">
                                            <input type="number" value="" name="nome" req="" class="form-control" ng-model="empreendimento.qtd_parcelas" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-7 control-label" for="nome">Taxa do Financiamento  </label>
                                        <div class="col-sm-7">
                                            <div class="input-group no-margin-bottom">
                                                <input type="text" class="form-control mask-money" req="" ng-model="empreendimento.taxa_financiamento" placeholder="0,00" maxlength="6" required>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-7 control-label" for="nome">Índice de Correção  </label>
                                        <div class="col-sm-7">
                                            <select class="form-control" ng-model="empreendimento.indice_correcao" required>
                                                <option value="1">IPCA</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>
                            </div>


                            <div id="endereco" class="tab-pane cont">
                                <div class="spacer2">
                                    
                                    <div class="form-group no-margin-bottom">
                                        <label  class="col-sm-6 control-label" for="">CEP</label>
                                        <div class="col-sm-8">
                                                <input type="text" value="" mask="99999-999" maxlength="9" class="form-control pesquisar_endereco_pelo_cep selected" ng-model="empreendimento.cep" id="endereco-secundario" ng-blur="completaEndereco()">
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <div class="input-group no-margin-bottom">
                                                    <button class="btn-link buscar-cep" type="button">Buscar CEP!</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="nome">Logradouro  </label>
                                        <div class="col-sm-11">
                                            <input type="text" value="" name="empreendimento[logradouro]" req="" class="form-control" ng-model="empreendimento.logradouro" required>
                                        </div>
                                        <label class="col-sm-3 control-label" for="empreendimento[numero]">Número  </label>
                                        <div class="col-sm-4">
                                            <input type="text" value="" name="empreendimento[numero]" req="" class="form-control" ng-model="empreendimento.numero" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="empreendimento[complemento]">Complemento  </label>
                                        <div class="col-sm-18">
                                            <input type="text" value="" name="empreendimento[complemento]" class="form-control" ng-model="empreendimento.complemento">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="empreendimento[bairro]">Bairro  </label>
                                        <div class="col-sm-18">
                                            <input type="text" value="" name="empreendimento[bairro]" req="" class="form-control" ng-model="empreendimento.bairro" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="empreendimento[uf]">UF</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="empreendimento[uf]" ng-model="empreendimento.uf" req required ng-options="uf.uf as uf.uf for uf in ufs.ufs" ng-selected="empreendimento.uf" ng-change="getCidades(empreendimento.uf)">
                                            </select>
                                        </div>
                                        <label class="col-sm-3 control-label" for="empreendimento[cidade]">Cidade  </label>
                                        <div class="col-sm-12">
                                            <select class="form-control" name="empreendimento[cidade]" ng-model="empreendimento.cidade" req required ng-options="cidade.nome as cidade.nome for cidade in cidades.cidades" ng-selected="empreendimento.cidade">
                                                
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
                                            <select class="form-control" name="empreendimento[corretores]" ng-model="corretor" ng-options="corretor.id as corretor.nome for corretor in corretores.corretores">
                                                
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <button class="btn btn-default" ng-click="adicionarCorretor()">Adicionar</button>
                                        </div>
                                    </div>
                                    <div id="scrolling">
                                        <table class="table-corretor">
                                            <tbody>
                                                <tr ng-repeat="corretor in empreendimento.corretores" ng-mouseleave="count=0" ng-mouseover="count=1" ng-init="count=0" ng-class-odd="'odd'" ng-class-even="'even'">
                                                    <td width="10%">{{$index +1}}</td>
                                                    <td width="80%">{{corretor.nome}}</td>
                                                    <td width="10%"> <a ng-show="count==1" href="javascript:void(0)" ng-click="removerCorretor(corretor.id)">Excluir</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                </div>

            </div>

            <div class="modal-footer">
                <div class="btn-group">
                    <button class="btn btn-primary" ng-disabled="EmpreendimentoForm.$invalid" ng-click="salvar(empreendimento)">Salvar</button>
                    <button data-toggle="dropdown" ng-disabled="EmpreendimentoForm.$invalid" class="btn btn-primary dropdown-toggle" type="button">
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