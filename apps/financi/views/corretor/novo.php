

<div class="row margin-top-50">

    <div class="block-flat">

        <div class="mensagem">

        </div>

        <div class="header">
            <h3>Cadastro de Corretor</h3>    
        </div>
        <div class="content" ng-controller="FormCtrl">
            
            <form style="border-radius: 0px;" action="#" name="CorretorForm" id="CorretorForm" class="group-border-dashed">
                                    <input type="hidden" id="corretor-id" value="<?php echo $id ?>">
                                    <?php 

                                    \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'CPF',
                                            'block_class' => 'col-sm-4',
                                            'name' => 'corretor[cpf]',
                                            'ng-model' => 'corretor.cpf',
                                            'attributes' => 'required mask="999.999.999-99" clean="true" req ng-blur="validaCpf()"'
                                        ],
                                        [
                                            'label' => 'Nome',
                                            'block_class' => 'col-sm-14',
                                            'name' => 'corretor[nome]',
                                            'ng-model' => 'corretor.nome',
                                            'attributes' => 'required req'
                                        ],
                                        [
                                            'label' => 'Sexo',
                                            'name' => 'corretor[sexo]',
                                            'block' => 'default-select',
                                            'block_class' => 'col-sm-3',
                                            'options' => [
                                                'M' => 'Masculino',
                                                'F' => 'Feminino'
                                            ],
                                            'ng-model' => 'corretor.sexo',
                                            'attributes' => 'required req'
                                        ],
                                        [
                                            'label' => 'Data de Cadastro',
                                            'block_class' => 'col-sm-3',
                                            'value' => date('d/m/Y'),
                                            'attributes' => 'disabled'
                                        ]
                                    ]); 

                                    \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'Data de Nascimento',
                                            'block_class' => 'col-sm-4',
                                            'block' => 'input-group-datepicker',
                                            'name' => 'corretor[data_nascimento]',
                                            'ng-model' => 'corretor.data_nascimento',
                                            'attributes' => 'required req'
                                        ],
                                         [
                                            'label' => 'Nacionalidade',
                                            'block_class' => 'col-sm-4',
                                            'name' => 'corretor[nacionalidade]',
                                            'ng-model' => 'corretor.nacionalidade',
                                            'attributes' => 'required req'
                                        ],
                                        [
                                            'label' => 'UF',
                                            'block' => 'default-select',
                                            'block_class' => 'col-sm-2',
                                            'options' => $ufs,
                                            'name' => 'corretor[naturalidade_uf]',
                                            'id' => 'naturalidade_uf',
                                            'ng-model' => 'corretor.naturalidade_uf',
                                            'attributes' => 'ng-change="get_cidade(\'naturalidade_uf\', \'cidades\')" required req'
                                        ],
                                        [
                                            'label' => 'Naturalidade',
                                            'block' => 'select-ng-repeat',
                                            'block_class' => 'col-sm-10',
                                            'name' => 'corretor[naturalidade]',
                                            'ng-model' => 'corretor.naturalidade',
                                            'attributes' => 'ng-selected="corretor.naturalidade" ng-options="c.id as c.nome for c in cidades" required req ng-select2',
                                        ],
                                        [
                                            'label' => 'Estado Civil',
                                            'block' => 'default-select',
                                            'block_class' => 'col-sm-4',
                                            'options' => [
                                                '1' => 'Solteiro',
                                                '2' => 'Casado',
                                                '3' => 'Viúvo',
                                                '4' => 'Divorciado'
                                            ],
                                            'name' => 'corretor[estado_civil]',
                                            'ng-model' => 'corretor.estado_civil',
                                        ]
                                    ]);

                                    \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'Registro Geral (RG)',
                                            'block_class' => 'col-sm-8',
                                            'name' => 'corretor[registro_geral]',
                                            'ng-model' => 'corretor.registro_geral'
                                        ],
                                        [
                                            'label' => 'Data de expedição',
                                            'block' => 'input-group-datepicker',
                                            'block_class' => 'col-sm-4 date',
                                            'name' => 'corretor[expedicao]',
                                            'ng-model' => 'corretor.expedicao',
                                            'class' => '',
                                        ],
                                        [
                                            'label' => 'CTPS',
                                            'block_class' => 'col-sm-8',
                                            'name' => 'ctps',
                                            'name' => 'corretor[ctps]',
                                            'ng-model' => 'corretor.ctps'
                                        ],
                                        [
                                            'label' => 'Residência',
                                            'block_class' => 'col-sm-4',
                                            'name' => 'corretor[residencia]',
                                            'block' => 'default-select',
                                            'options' => [
                                                '1' => 'Própria',
                                                '2' => 'Alugada'
                                            ],
                                            'ng-model' => 'corretor.residencia'
                                        ]
                                    ]);
                                        
                                    \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'Escolaridade',
                                            'block_class' => 'col-sm-6',
                                            'name' => 'corretor[escolaridade]',
                                            'block' => 'default-select',
                                            'options' => [
                                                '1' => 'Analfabeto',
                                                '2' => 'Alfabetizado',
                                                '3' => 'Médio Incompleto',
                                                '4' => 'Médio Completo',
                                                '5' => 'Superior Incompleto',
                                                '6' => 'Superior Completo',
                                                '7' => 'Pos-graduado',
                                                '8' => 'Mestre',
                                                '9' => 'Doutor'
                                            ],
                                            'ng-model' => 'corretor.escolaridade'
                                        ],
                                        [
                                            'label' => 'CBO',
                                            'block' => 'default-with-hidden',
                                            'block_class' => 'col-sm-12 typeahead',
                                            'name' => 'corretor[cbo_descricao]',
                                            'id' => 'cbo_descricao',
                                            'attributes' => 'sf-typeahead options="cboOptions" datasets="cboDataset" ng-model="selectedCbo" required req',
                                            'hidden' => '<input type="hidden" id="cbo" name="corretor[cbo]" ng-model="corretor.cbo">'
                                        ],
                                        [
                                            'label' => 'Registro Profissional',
                                            'name' => 'corretor[registro_profissional]',
                                            'ng-model' => 'corretor.registro_profissional',
                                            'attributes' => 'required req'
                                        ],
                                    ]);

                                    \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'Pai',
                                            'block_class' => 'col-sm-12',
                                            'name' => 'corretor[pai]',
                                            'ng-model' => 'corretor.pai'
                                        ],
                                        [
                                            'label' => 'Mãe',
                                            'block_class' => 'col-sm-12',
                                            'name' => 'corretor[mae]',
                                            'ng-model' => 'corretor.mae'
                                        ],
                                    ]);     
                                    ?>

                                    <div class="header margin-bottom">
                                        <h4>Endereço</h4>
                                    </div>
                                    
                                        <div id="endereco-principal" class="bloco" ng-show="endereco">
                                            <div class="row hpadding">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="corretor[endereco][0][cep]">CEP</label>
    
                                                        <input type="text" value="" mask="99999-999" maxlength="9" class="form-control pesquisar_endereco_pelo_cep selected" name="corretor[endereco][0][cep]" ng-model="corretor.endereco.0.cep" id="endereco-principal" ng-blur="completaEndereco(true)" req required clean="true">
    
                                                    </div>
                                                </div>
                                                <div class="col-sm-19">
                                                    <div class="form-group">
                                                        <label for="enderecos[0][completar]">&nbsp;</label>
                                                        <div class="input-group no-margin-bottom">
                                                            <button class="btn-link buscar-cep" type="button">Buscar CEP!</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php 

                                            \Financi\HTMLHelper::renderRow([
                                                [
                                                    'label' => 'Tipo',
                                                    'block_class' => 'col-sm-4',
                                                    'block' => 'default-select',
                                                    'options' => [
                                                        '1' => 'Rua'
                                                    ],
                                                    'name' => 'corretor[endereco][0][tipo]',
                                                    'ng-model' => 'corretor.endereco.0.tipo',
                                                    'attributes' => 'req required'
                                                ],
                                                [
                                                    'label' => 'Logradouro',
                                                    'block_class' => 'col-sm-10',
                                                    'name' => 'corretor[endereco][0][logradouro]',
                                                    'ng-model' => 'corretor.endereco.0.logradouro',
                                                    'attributes' => 'req required'
                                                ],
                                                [
                                                    'label' => 'Número',
                                                    'block_class' => 'col-sm-2',
                                                    'name' => 'corretor[endereco][0][numero]',
                                                    'ng-model' => 'corretor.endereco.0.numero',
                                                    'attributes' => 'req required'
                                                ],
                                                [
                                                    'label' => 'Complemento',
                                                    'block_class' => 'col-sm-8',
                                                    'name' => 'corretor[endereco][0][complemento]',
                                                    'ng-model' => 'corretor.endereco.0.complemento'
                                                ]
                                            ]);

                                            \Financi\HTMLHelper::renderRow([
                                                [
                                                    'label' => 'Bairro',
                                                    'block_class' => 'col-sm-12',
                                                    'name' => 'corretor[endereco][0][bairro]',
                                                    'ng-model' => 'corretor.endereco.0.bairro',
                                                    'attributes' => 'req required'
                                                ],
                                                [
                                                    'label' => 'UF',
                                                    'block_class' => 'col-sm-2',
                                                    'block' => 'default-select',
                                                    'options' => $ufs,
                                                    'name' => 'corretor[endereco][0][uf]',
                                                    'id' => 'uf_endereco_principal',
                                                    'ng-model' => 'corretor.endereco.0.uf',
                                                    'attributes' => 'req required ng-change="get_cidade(\'uf_endereco_principal\', \'cidades_endereco_principal\')"'
                                                ],
                                                [
                                                    'label' => 'Cidade',
                                                    'block_class' => 'col-sm-10',
                                                    'block' => 'select-ng-repeat',
                                                    'name' => 'corretor[endereco][0][cidade]',
                                                    'id' => 'cidade_principal',
                                                    'ng-model' => 'corretor.endereco.0.cidade',
                                                    'ng-option' => '<option ng-repeat="cidade in cidades_endereco_principal" value="{{ cidade.id }}" ng-selected="cidade.selected">{{ cidade.nome }}</option>',
                                                    'attributes' => 'req required ng-select2'
                                                ],
                                            ]);

                                            \Financi\HTMLHelper::renderRow([
                                                [
                                                    'label' => 'Referência',
                                                    'block_class' => 'col-sm-24',
                                                    'name' => 'corretor[endereco][0][referencia]',
                                                    'ng-model' => 'corretor.endereco.0.residencia'
                                                ]
                                            ]);
                                        ?> 
                                        </div>
                                        <div class="endereco-secundario bloco" ng-show="!endereco">
                                            <div class="row hpadding">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="corretor[endereco][1][cep]">CEP</label>
  
                                                        <input type="text" value="" mask="99999-999" maxlength="9" class="form-control pesquisar_endereco_pelo_cep selected" name="corretor[endereco][1][cep]" ng-model="corretor.endereco.1.cep" id="endereco-secundario" ng-blur="completaEndereco(false)" clean="true">

                                                    </div>
                                                </div>
                                                <div class="col-sm-19">
                                                    <div class="form-group">
                                                        <label for="enderecos[1][completar]">&nbsp;</label>
                                                        <div class="input-group no-margin-bottom">
                                                            <button class="btn-link buscar-cep" type="button">Buscar CEP!</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php 
                                            /*\Financi\HTMLHelper::renderRow([
                                                [
                                                    'label' => 'CEP',
                                                    'block' => 'input-group-buttom',
                                                    'block_class' => 'col-sm-4',
                                                    'input_group_symbol' => '<i class="fa fa-search"></i>',
                                                    'input_group_btn_class' => 'busca-cep',
                                                    'name' => 'corretor[endereco][1][cep]',
                                                    'ng-model' => 'corretor.endereco.1.cep'
                                                ]
                                            ]);*/

                                            \Financi\HTMLHelper::renderRow([
                                                [
                                                    'label' => 'Tipo',
                                                    'block_class' => 'col-sm-4',
                                                    'block' => 'default-select',
                                                    'options' => [
                                                        '1' => 'Rua'
                                                    ],
                                                    'name' => 'corretor[endereco][1][tipo]',
                                                    'ng-model' => 'corretor.endereco.1.tipo'
                                                ],
                                                [
                                                    'label' => 'Logradouro',
                                                    'block_class' => 'col-sm-10',
                                                    'name' => 'corretor[endereco][1][logradouro]',
                                                    'ng-model' => 'corretor.endereco.1.logradouro'
                                                ],
                                                [
                                                    'label' => 'Número',
                                                    'block_class' => 'col-sm-2',
                                                    'name' => 'corretor[endereco][1][numero]',
                                                    'ng-model' => 'corretor.endereco.1.numero'
                                                ],
                                                [
                                                    'label' => 'Complemento',
                                                    'block_class' => 'col-sm-8',
                                                    'name' => 'corretor[endereco][1][complemento]',
                                                    'ng-model' => 'corretor.endereco.1.complemento'
                                                ]
                                            ]);

                                            \Financi\HTMLHelper::renderRow([
                                                [
                                                    'label' => 'Bairro',
                                                    'block_class' => 'col-sm-12',
                                                    'name' => 'corretor[endereco][1][bairro]',
                                                    'ng-model' => 'corretor.endereco.1.bairro'
                                                ],
                                                [
                                                    'label' => 'UF',
                                                    'block_class' => 'col-sm-2',
                                                    'block' => 'default-select',
                                                    'options' => $ufs,
                                                    'name' => 'corretor[endereco][1][uf]',
                                                    'id' => 'uf_endereco_secundario',
                                                    'ng-model' => 'corretor.endereco.1.uf',
                                                    'attributes' => 'ng-change="get_cidade(\'uf_endereco_secundario\', \'cidades_endereco_secundario\')"'
                                                ],
                                                [
                                                    'label' => 'Cidade',
                                                    'block_class' => 'col-sm-10',
                                                    'block' => 'select-ng-repeat',
                                                    'name' => 'corretor[endereco][1][cidade]',
                                                    'ng-model' => 'corretor.endereco.1.cidade',
                                                    'ng-option' => '<option ng-repeat="cidade in cidades_endereco_secundario" value="{{ cidade.id }}" ng-selected="cidade.selected">{{ cidade.nome }}</option>',
                                                    'attributes' => 'ng-select2'
                                                ],
                                            ]);

                                            \Financi\HTMLHelper::renderRow([
                                                [
                                                    'label' => 'Referência',
                                                    'block_class' => 'col-sm-24',
                                                    'name' => 'corretor[endereco][1][referencia]',
                                                    'ng-model' => 'corretor.endereco.1.referencia'
                                                ]
                                            ]);
                                        ?> 
                                        </div>

                                        <div class="row hpadding" style="margin-bottom:9px">
                                            <div class="form-group" style="margin-top:8px">
                                                <div class="col-sm-24">
                                                    <a class="btn btn-default" style="margin-left:0" href="javascript://" ng-click="changeEndereco()">{{endereco ? 'Endereço Secundário' : 'Endereço Principal'}}</a>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <div class="row">
                                            <div class="fone col-sm-12 col-lg-12">
                                                <div class="header margin-bottom">
                                                    <h4>Telefone</h4>
                                                </div>
                                                <div class="content boxadd clearfix">

                                                            
                                                    <div class="form-group margin" ng-repeat="fone in corretor.telefones">

                                                        <input type="hidden" name="telefones[0][id_fone]">
                                                        <div class="col-sm-7">
                                                            <select class="form-control" name="" ng-model="corretor.telefones[$index].tipo">
                                                                <option value=""></option>
                                                                <option value="1">Celular</option>
                                                                <option value="2">Residencial</option>
                                                                <option value="3">Comercial</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" placeholder="DDD" class="form-control ddd" name="corretor[telefones][0][ddd]" ng-model="corretor.telefones[$index].ddd" mask="99">
                                                        </div>
                                                        <div class="col-sm-14">
                                                            <div class="input-group">
                                                                <input type="text" maxlength="10" placeholder="Telefone" name="" mask="9999-9999" clean="true" class="form-control num vfone" ng-model="corretor.telefones[$index].numero">
                                                                <span class="input-group-btn">
                                                                    <button title="Excluir" type="button" name="rem-fone" class="btn btn-default" ng-click="removeTelefone($index)"><i class="fa fa-trash-o"></i></button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>

                                                    
                                                </div>
                                                <div class="col-sm-24 no-padding">
                                                    <button class="btn btn-add btn-default button-auxiliar" type="button" ng-click="addTelefone()"><i class="fa fa-plus"></i> Adicionar</button>
                                                </div>
                                            </div>


                                            <div class="email col-sm-12 col-lg-12">
                                                    <div class="header margin-bottom">
                                                    <h4>E-mail</h4>
                                                </div>
                                                    <div style="" class="content boxadd clearfix">

                                                    
                                                    <div class="form-group margin" ng-repeat="mail in corretor.emails">
                                                        <div class="col-sm-7">
                                                            <select class="form-control" name="" ng-model="corretor.emails[$index].tipo">
                                                                <option value=""></option>
                                                                <option value="1">Pessoal</option>
                                                                <option value="2">Profissional</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-17">
                                                            <div class="input-group">
                                                                <input type="email" placeholder="E-mail" class="form-control smail vmail" name="" ng-model="corretor.emails[$index].email"> 
                                                                <span class="input-group-btn">
                                                                    <button title="Excluir" type="button" name="rem-email" class="btn btn-default" ng-click="removeEmail($index)"><i class="fa fa-trash-o"></i></button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    
                                                </div>
                                                <div class="col-sm-24 no-padding">
                                                    <button class="btn btn-add btn-default button-auxiliar" name="add-email" type="button" ng-click="addEmail()"><i class="fa fa-plus"></i> Adicionar</button>
                                                </div>
                                            </div>

                                        </div>

                <hr>
                <div class="form-footer row text-right vmargin-0">
                    <div class="btn-group">
                        <button class="btn btn-primary" type="button" ng-click="salvar(corretor, false)">Salvar</button>
                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#" data-action="form-add" ng-click="salvar(corretor, true)">Salvar e Adicionar novo</a></li>
                        </ul>
                    </div>
                    <a class="btn btn-default" id="cancelar-cadastro-pessoa" href="/corretor">Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</div>