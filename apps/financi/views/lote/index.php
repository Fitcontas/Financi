<div ng-controller="FormLoteCtrl">
<form id="#grid_lote" class="grid">
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
                    <h3>Relação de Lotes</h3>
                </div>

                <div class="content spacer0 process">
                    <div class="toobar">
                        <div class="pull-left">
                            <div class="btn-group pull-left" id="buttons-grid">
                                <button type="button" class="btn btn-default" ng-click="showForm(false)"> Novo</button>
                                <button type="button" class="btn btn-default" ng-disabled="!checkall && check_ctrl.length == 0" ng-click="acao('excluir')"> Excluir</button>
                            </div>
                        </div>
                        <div class="pull-right">
                            <div class="input-group">
                              <input class="form-control" type="text" placeholder="Pesquisar" style="width:250px"  ng-model="search">
                              <span class="input-group-btn">
                                <button class="btn btn-default btn-sm" type="button" ng-click="start()"><i class="fa fa-search"></i></button>
                              </span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <!-- Início data table content -->
                    <div class="table-responsive" ng-show="model.lotes.length>0">
                        <table class="table table-striped table-bordered spacer2 table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="checkall" ng-model="checkall"/></label>
                                        </div>
                                    </th>
                                    <th>Lote</th>
                                    <th>Quadra</th>
                                    <th>Empreendimento</th>
                                    <th>Valor</th>
                                    <th>Área Total</th>
                                    <th>Detalhes</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="l in model.lotes">
                                    <td><input type="checkbox" ng-model="confirmed" ng-change="checkAll(l)" ng-checked="checkall"/></td>
                                    <td><a ng-click="showForm(l)">{{l.numero}}</a></td>
                                    <td>{{l.quadra}}</td>
                                    <td>{{l.empreendimento}}</td>
                                    <td>{{l.valor}}</td>
                                    <td>{{l.area_total}}</td>
                                    <td><a href="">Detalhes</a></td>
                                    <td width="5%">{{ status[l.status] }}</td>
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
                    <div class="table-responsive" ng-show="!model.lotes.length && model.$resolved">
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
<div role="dialog" id="lote_modal" class="modal fade in" aria-hidden="false"><!-- Modal -->
    <form autocomplete="off" name="LoteForm" id="LoteForm" class="form-horizontal" novalidate>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Lote</h3>
                <span>Formulário de Cadastro</span>
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            </div>
            <div class="modal-body">
                <div class="mensagem-modal">
                </div>

                <div class="tab-container">
                        <ul class="nav nav-pills">
                          <li class="active"><a data-toggle="tab" href="#home">Principal</a></li>
                          <li class=""><a data-toggle="tab" href="#confrontante">Confrontante</a></li>
                          <li class=""><a data-toggle="tab" href="#endereco">Endereço</a></li>
                        </ul>
                        <!-- Início tab-content -->
                        <div class="tab-content">
                            <hr>
                            <!-- Início tab-content -->
                            <input type="hidden" id="cliente-id" value="<?php //echo $id ?>">
                            <!-- Início home -->
                            <div id="home" class="tab-pane cont active">
                                <div class="spacer2">
                                    
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="nome">Empreendimento  </label>
                                        <div class="col-sm-18">
                                            <select name="lote[empreendimento_id]" id="" class="form-control" ng-model="lote.empreendimento_id">
                                                <option value=""></option>
                                                <?php foreach ($empreendimentos as $e): ?>
                                                    <option value="<?php echo $e->id ?>"><?php echo $e->empreendimento ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="numero">Número  </label>
                                        <div class="col-sm-6">
                                            <input type="text" value="" name="lote[numero]" req="" class="form-control" ng-model="lote.numero" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="quadra">Quadra  </label>
                                        <div class="col-sm-6">
                                            <input type="text" value="" name="lote[quadra]" req="" class="form-control" ng-model="lote.quadra" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="valor">Valor  </label>
                                        <div class="col-sm-8">
                                            <input type="text" value="" name="lote[valor]" req="" class="form-control mask-money" ng-model="lote.valor" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="area_total">Àrea Total (M2)  </label>
                                        <div class="col-sm-8">
                                            <input type="text" value="" name="lote[area_total]" req="" class="form-control" ng-model="lote.area_total" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="matricula">Matrícula  </label>
                                        <div class="col-sm-8">
                                            <input type="text" value="" name="lote[matricula]" class="form-control" ng-model="lote.matricula">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="inscricao_municipal">Inscrição Municipal  </label>
                                        <div class="col-sm-8">
                                            <input type="text" value="" name="lote[inscricao_municipal]" class="form-control" ng-model="lote.inscricao_municipal">
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
                                                <input type="text" value="" mask="99999-999" maxlength="9" class="form-control pesquisar_endereco_pelo_cep selected" ng-model="empreendimento.cep" id="endereco-secundario" ng-blur="completaEndereco()">
                                                <span class="input-group-btn">
                                                    <button title="Pesquisar CEP" type="button" class="btn btn-default buscar-cep"><i class="fa fa-search"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <div class="input-group no-margin-bottom">
                                                    <button class="btn-link completa" type="button" ng-click="completaEndereco()">Completar endereço</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="nome">Logradouro  </label>
                                        <div class="col-sm-10">
                                            <input type="text" value="" name="lote[logradouro]" class="form-control" ng-model="lote.logradouro">
                                        </div>
                                        <label class="col-sm-4 control-label" for="lote[num]">Número  </label>
                                        <div class="col-sm-4">
                                            <input type="text" value="" name="lote[num]" class="form-control" ng-model="lote.num">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="lote[complemento]">Complemento  </label>
                                        <div class="col-sm-18">
                                            <input type="text" value="" name="lote[complemento]" class="form-control" ng-model="lote.complemento">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="lote[bairro]">Bairro  </label>
                                        <div class="col-sm-10">
                                            <input type="text" value="" name="lote[bairro]" class="form-control" ng-model="lote.bairro">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="lote[uf]">UF</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="lote[uf]" ng-model="lote.uf" ng-options="uf.uf as uf.uf for uf in ufs.ufs" ng-selected="lote.uf" ng-change="getCidades(lote.uf)">
                                            </select>
                                        </div>
                                        <label class="col-sm-4 control-label" for="lote[cidade]">Cidade  </label>
                                        <div class="col-sm-11">
                                            <select class="form-control" name="lote[cidade]" ng-model="lote.cidade" ng-options="cidade.nome as cidade.nome for cidade in cidades.cidades" ng-selected="lote.cidade">
                                                
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div id="confrontante" class="tab-pane cont">
                                <div class="spacer2">
                                    
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="frente">Frente  </label>
                                        <div class="col-sm-12">
                                            <input type="text" value="" name="lote[frente]" req="" class="form-control" ng-model="lote.frente" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" value="" name="lote[frente_metro]" req="" class="form-control" ng-model="lote.frente_metro" required> 
                                        </div>
                                        <div class="col-sm-2">
                                            <span>M</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="fundo">Fundo  </label>
                                        <div class="col-sm-12">
                                            <input type="text" value="" name="lote[fundo]" req="" class="form-control" ng-model="lote.fundo" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" value="" name="lote[fundo_metro]" req="" class="form-control" ng-model="lote.fundo_metro" required> 
                                        </div>
                                        <div class="col-sm-2">
                                            <span>M</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="lateral_direita">Lateral Direita  </label>
                                        <div class="col-sm-12">
                                            <input type="text" value="" name="lote[lateral_direita]" req="" class="form-control" ng-model="lote.lateral_direita" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" value="" name="lote[lateral_direita_metro]" req="" class="form-control" ng-model="lote.lateral_direita_metro" required> 
                                        </div>
                                        <div class="col-sm-2">
                                            <span>M</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="lateral_esquerda">Lateral Esquerda  </label>
                                        <div class="col-sm-12">
                                            <input type="text" value="" name="lote[lateral_esquerda]" req="" class="form-control" ng-model="lote.lateral_esquerda" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" value="" name="lote[lateral_esquerda_metro]" req="" class="form-control" ng-model="lote.lateral_esquerda_metro" required> 
                                        </div>
                                        <div class="col-sm-2">
                                            <span>M</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                </div>

            </div>

            <div class="modal-footer">
                <div class="btn-group">
                    <button class="btn btn-primary" ng-disabled="LoteForm.$invalid" ng-click="salvar(lote)">Salvar</button>
                    <button data-toggle="dropdown" ng-disabled="LoteForm.$invalid" class="btn btn-primary dropdown-toggle" type="button">
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