<div class="row row margin-top-50">

    <div class="block-flat">

        <div class="mensagem">

        </div>

        <div class="header">
                <h3 class="pull-left">Cadastros de Clientes</h3>
                <div style="margin-top: -7px;" class="tab-container pull-right">
                    <ul class="nav nav-pills flat-tabs">
                          <li class="active"><a data-toggle="tab" href="#home"><i class="fa  fa-info-circle"></i> Identificação</a></li>
                          <li class=""><a data-toggle="tab" href="#conjuge"><i class="fa  fa-male"></i> Cônjuge</a></li>
                          <!--<li class=""><a data-toggle="tab" href="#messages">Profissional</a></li>-->
                        </ul>
                </div>
                <div class="clearfix"></div>
        </div>
        
        <div class="content" ng-controller="FormCtrl">
            
            <form style="border-radius: 0px;" action="#" name="ClienteForm" id="ClienteForm" class="group-border-dashed">
                <div class="tab-container">
                        
                        <!-- Início tab-content -->
                        <div class="tab-content">
                            <!-- Início tab-content -->
                            <input type="hidden" id="cliente-id" value="<?php echo $id ?>">
                            <!-- Início home -->
                            <div id="home" class="tab-pane cont active">
                                <div class="spacer2">
                                    <?php 

                                    \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'CPF',
                                            'block_class' => 'col-sm-4',
                                            'name' => 'cliente[cpf]',
                                            'ng-model' => 'cliente.cpf',
                                            'attributes' => 'required mask="999.999.999-99" clean="true" req'
                                        ],
                                        [
                                            'label' => 'Nome',
                                            'block_class' => 'col-sm-14',
                                            'name' => 'cliente[nome]',
                                            'ng-model' => 'cliente.nome',
                                            'attributes' => 'required req'
                                        ],
                                        [
                                            'label' => 'Sexo',
                                            'name' => 'cliente[sexo]',
                                            'block' => 'default-select',
                                            'block_class' => 'col-sm-3',
                                            'options' => [
                                                'M' => 'Masculino',
                                                'F' => 'Feminino'
                                            ],
                                            'ng-model' => 'cliente.sexo',
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
                                            'name' => 'cliente[data_nascimento]',
                                            'ng-model' => 'cliente.data_nascimento',
                                            'attributes' => 'required req',
                                            'class' => ''
                                        ],
                                         [
                                            'label' => 'Nacionalidade',
                                            'block_class' => 'col-sm-4',
                                            'name' => 'cliente[nacionalidade]',
                                            'ng-model' => 'cliente.nacionalidade',
                                            'attributes' => 'required req'
                                        ],
                                        [
                                            'label' => 'UF',
                                            'block' => 'default-select',
                                            'block_class' => 'col-sm-2',
                                            'options' => $ufs,
                                            'name' => 'cliente[naturalidade_uf]',
                                            'id' => 'naturalidade_uf',
                                            'ng-model' => 'cliente.naturalidade_uf',
                                            'attributes' => 'required req ng-change="get_cidade(\'naturalidade_uf\', \'cidades\')"'
                                        ],
                                        [
                                            'label' => 'Naturalidade',
                                            'block' => 'select-ng-repeat',
                                            'block_class' => 'col-sm-10',
                                            'name' => 'cliente[naturalidade]',
                                            'ng-model' => 'cliente.naturalidade',
                                            'attributes' => 'required req',
                                            'ng-option' => '<option ng-repeat="cidade in cidades" value="{{ cidade.id }}">{{ cidade.nome }}</option>'
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
                                            'name' => 'cliente[estado_civil]',
                                            'ng-model' => 'cliente.estado_civil',
                                            'attributes' => 'required req'
                                        ]
                                    ]);

                                    \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'Registro Geral (RG)',
                                            'block_class' => 'col-sm-8',
                                            'name' => 'cliente[registro_geral]',
                                            'ng-model' => 'cliente.registro_geral'
                                        ],
                                        [
                                            'label' => 'Data de expedição',
                                            'block' => 'input-group-datepicker',
                                            'block_class' => 'col-sm-4 date',
                                            'name' => 'cliente[expedicao]',
                                            'ng-model' => 'cliente.expedicao',
                                            'class' => '',
                                        ],
                                        [
                                            'label' => 'CTPS',
                                            'block_class' => 'col-sm-8',
                                            'name' => 'ctps',
                                            'name' => 'cliente[ctps]',
                                            'ng-model' => 'cliente.ctps'
                                        ],
                                        [
                                            'label' => 'Residência',
                                            'block_class' => 'col-sm-4',
                                            'name' => 'cliente[residencia]',
                                            'block' => 'default-select',
                                            'options' => [
                                                '1' => 'Própria',
                                                '2' => 'Alugada'
                                            ],
                                            'ng-model' => 'cliente.residencia'
                                        ]
                                    ]);
                                        
                                    \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'Escolaridade',
                                        ],
                                        [
                                            'label' => 'CBO',
                                            'block' => 'default-with-hidden',
                                            'block_class' => 'col-sm-12 typeahead',
                                            'name' => 'cliente[cbo]',
                                            'ng-model' => 'cliente.cbo',
                                            'attributes' => 'sf-typeahead options="cboOptions" datasets="cboDataset" ng-model="selectedCbo"',
                                            'hidden' => '<input type="hidden" id="cbo_id" name="cliente[cbo_id]">'
                                        ],
                                        [
                                            'label' => 'Registro Profissional',
                                            'name' => 'cliente[registro_profissional]',
                                            'ng-model' => 'cliente.registro_profissional'
                                        ],
                                    ]);

                                    \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'Pai',
                                            'block_class' => 'col-sm-12',
                                            'name' => 'cliente[pai]',
                                            'ng-model' => 'cliente.pai'
                                        ],
                                        [
                                            'label' => 'Mãe',
                                            'block_class' => 'col-sm-12',
                                            'name' => 'cliente[mae]',
                                            'ng-model' => 'cliente.mae'
                                        ],
                                    ]);     
                                    ?>

                                    <div class="header">
                                        <h3>Endereço</h3>
                                    </div>
                                    
                                        <div id="endereco-principal" ng-show="endereco">
                                            <div class="row hpadding">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="cliente[endereco][0][cep]">CEP</label>
                                                        <div class="input-group">
                                                            <input type="text" value="" mask="99999-999" maxlength="9" class="form-control pesquisar_endereco_pelo_cep selected" name="cliente[endereco][0][cep]" ng-model="cliente.endereco.0.cep" id="endereco-principal" ng-blur="completaEndereco(true)" req required>
                                                            <span class="input-group-btn">
                                                                <button title="Pesquisar CEP" type="button" name="enderecos[0][buscar]" class="btn btn-default buscar-cep"><i class="fa fa-search"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-19">
                                                    <div class="form-group">
                                                        <label for="enderecos[0][completar]">&nbsp;</label>
                                                        <div class="input-group no-margin-bottom">
                                                            <button class="btn-link completa" type="button" ng-click="completaEndereco(true)">Completar endereço</button>
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
                                                    'name' => 'cliente[endereco][0][cep]',
                                                    'ng-model' => 'cliente.endereco.0.cep'
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
                                                    'name' => 'cliente[endereco][0][tipo]',
                                                    'ng-model' => 'cliente.endereco.0.tipo',
                                                    'attributes' => 'req required'
                                                ],
                                                [
                                                    'label' => 'Logradouro',
                                                    'block_class' => 'col-sm-10',
                                                    'name' => 'cliente[endereco][0][logradouro]',
                                                    'ng-model' => 'cliente.endereco.0.logradouro',
                                                    'attributes' => 'req required'
                                                ],
                                                [
                                                    'label' => 'Número',
                                                    'block_class' => 'col-sm-2',
                                                    'name' => 'cliente[endereco][0][numero]',
                                                    'ng-model' => 'cliente.endereco.0.numero',
                                                    'attributes' => 'req required'
                                                ],
                                                [
                                                    'label' => 'Complemento',
                                                    'block_class' => 'col-sm-8',
                                                    'name' => 'cliente[endereco][0][complemento]',
                                                    'ng-model' => 'cliente.endereco.0.complemento'
                                                ]
                                            ]);

                                            \Financi\HTMLHelper::renderRow([
                                                [
                                                    'label' => 'Bairro',
                                                    'block_class' => 'col-sm-10',
                                                    'name' => 'cliente[endereco][0][bairro]',
                                                    'ng-model' => 'cliente.endereco.0.bairro',
                                                    'attributes' => 'req required'
                                                ],
                                                [
                                                    'label' => 'UF',
                                                    'block_class' => 'col-sm-4',
                                                    'block' => 'default-select',
                                                    'options' => $ufs,
                                                    'name' => 'cliente[endereco][0][uf]',
                                                    'id' => 'uf_endereco_principal',
                                                    'ng-model' => 'cliente.endereco.0.uf',
                                                    'attributes' => 'req required ng-change="get_cidade(\'uf_endereco_principal\', \'cidades_endereco_principal\')"'
                                                ],
                                                [
                                                    'label' => 'cidade',
                                                    'block_class' => 'col-sm-10',
                                                    'block' => 'select-ng-repeat',
                                                    'name' => 'cliente[endereco][0][cidade]',
                                                    'id' => 'cidade_principal',
                                                    'ng-model' => 'cliente.endereco.0.cidade',
                                                    'ng-option' => '<option ng-repeat="cidade in cidades_endereco_principal" value="{{ cidade.id }}" ng-selected="cidade.selected">{{ cidade.nome }}</option>',
                                                    'attributes' => 'req required'
                                                ],
                                            ]);

                                            \Financi\HTMLHelper::renderRow([
                                                [
                                                    'label' => 'Referência',
                                                    'block_class' => 'col-sm-24',
                                                    'name' => 'cliente[endereco][0][referencia]',
                                                    'ng-model' => 'cliente.endereco.0.residencia'
                                                ]
                                            ]);
                                        ?> 
                                        </div>
                                        <div class="endereco-secundario" ng-show="!endereco">
                                            <div class="row hpadding">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="cliente[endereco][1][cep]">CEP</label>
                                                        <div class="input-group">
                                                            <input type="text" value="" mask="99999-999" maxlength="9" class="form-control pesquisar_endereco_pelo_cep selected" name="cliente[endereco][1][cep]" ng-model="cliente.endereco.1.cep" id="endereco-secundario" ng-blur="completaEndereco(false)">
                                                            <span class="input-group-btn">
                                                                <button title="Pesquisar CEP" type="button" name="enderecos[1][buscar]" class="btn btn-default buscar-cep"><i class="fa fa-search"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-19">
                                                    <div class="form-group">
                                                        <label for="enderecos[1][completar]">&nbsp;</label>
                                                        <div class="input-group no-margin-bottom">
                                                            <button class="btn-link completa" type="button" ng-click="completaEndereco(false)">Completar endereço</button>
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
                                                    'name' => 'cliente[endereco][1][cep]',
                                                    'ng-model' => 'cliente.endereco.1.cep'
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
                                                    'name' => 'cliente[endereco][1][tipo]',
                                                    'ng-model' => 'cliente.endereco.1.tipo'
                                                ],
                                                [
                                                    'label' => 'Logradouro',
                                                    'block_class' => 'col-sm-10',
                                                    'name' => 'cliente[endereco][1][logradouro]',
                                                    'ng-model' => 'cliente.endereco.1.logradouro'
                                                ],
                                                [
                                                    'label' => 'Número',
                                                    'block_class' => 'col-sm-2',
                                                    'name' => 'cliente[endereco][1][numero]',
                                                    'ng-model' => 'cliente.endereco.1.numero'
                                                ],
                                                [
                                                    'label' => 'Complemento',
                                                    'block_class' => 'col-sm-8',
                                                    'name' => 'cliente[endereco][1][complemento]',
                                                    'ng-model' => 'cliente.endereco.1.complemento'
                                                ]
                                            ]);

                                            \Financi\HTMLHelper::renderRow([
                                                [
                                                    'label' => 'Bairro',
                                                    'block_class' => 'col-sm-10',
                                                    'name' => 'cliente[endereco][1][bairro]',
                                                    'ng-model' => 'cliente.endereco.1.bairro'
                                                ],
                                                [
                                                    'label' => 'UF',
                                                    'block_class' => 'col-sm-4',
                                                    'block' => 'default-select',
                                                    'options' => $ufs,
                                                    'name' => 'cliente[endereco][1][uf]',
                                                    'id' => 'uf_endereco_secundario',
                                                    'ng-model' => 'cliente.endereco.1.uf',
                                                    'attributes' => 'ng-change="get_cidade(\'uf_endereco_secundario\', \'cidades_endereco_secundario\')"'
                                                ],
                                                [
                                                    'label' => 'cidade',
                                                    'block_class' => 'col-sm-10',
                                                    'block' => 'select-ng-repeat',
                                                    'name' => 'cliente[endereco][1][cidade]',
                                                    'ng-model' => 'cliente.endereco.1.cidade',
                                                    'ng-option' => '<option ng-repeat="cidade in cidades_endereco_secundario" value="{{ cidade.id }}" ng-selected="cidade.selected">{{ cidade.nome }}</option>'
                                                ],
                                            ]);

                                            \Financi\HTMLHelper::renderRow([
                                                [
                                                    'label' => 'Referência',
                                                    'block_class' => 'col-sm-24',
                                                    'name' => 'cliente[endereco][1][referencia]',
                                                    'ng-model' => 'cliente.endereco.1.referencia'
                                                ]
                                            ]);
                                        ?> 
                                        </div>

                                        <div class="row hpadding">
                                            <div class="form-group">
                                                <div class="col-sm-24">
                                                    <a class="btn btn-default" style="margin-left:0" href="javascript://" ng-click="changeEndereco()">{{endereco ? 'Endereço Secundário' : 'Endereço Principal'}}</a>
                                                </div>
                                            </div>
                                        </div>
                                   
                                </div>

                            </div>
                            <!-- Fim /home -->

                            <!-- Início conjuge -->
                            <div id="conjuge" class="tab-pane cont">
                                <div class="spacer2">
                                    <?php 
                                        \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'CPF',
                                            'block_class' => 'col-sm-4',
                                            'name' => 'cliente[conjuge][cpf]',
                                            'ng-model' => 'cliente.conjuge.cpf'
                                        ],
                                        [
                                            'label' => 'Nome',
                                            'block_class' => 'col-sm-17',
                                            'name' => 'cliente[conjuge][nome]',
                                            'ng-model' => 'cliente.conjuge.nome'
                                        ],
                                        [
                                            'label' => 'Sexo',
                                            'name' => 'cliente[conjuge][sexo]',
                                            'block' => 'default-select',
                                            'block_class' => 'col-sm-3',
                                            'options' => [
                                                'M' => 'Masculino',
                                                'F' => 'Feminino'
                                            ],
                                            'ng-model' => 'cliente.conjuge.sexo'
                                        ]
                                    ]); 

                                    \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'Data de Nascimento',
                                            'block_class' => 'col-sm-4',
                                            'name' => 'cliente[conjuge][data_nascimento]',
                                            'ng-model' => 'cliente.conjuge.data_nascimento'
                                        ],
                                         [
                                            'label' => 'Nacionalidade',
                                            'block_class' => 'col-sm-4',
                                            'name' => 'cliente[conjuge][nacionalidade]',
                                            'ng-model' => 'cliente.conjuge.nacionalidade'
                                        ],
                                        [
                                            'label' => 'UF',
                                            'block' => 'default-select',
                                            'block_class' => 'col-sm-2',
                                            'options' => [
                                                'BA' => 'BA'
                                            ],
                                            'name' => 'cliente[conjuge][naturalidade_uf]',
                                            'ng-model' => 'cliente.conjuge.naturalidade_uf'
                                        ],
                                        [
                                            'label' => 'Naturalidade',
                                            'block_class' => 'col-sm-14',
                                            'name' => 'cliente[conjuge][naturalidade]',
                                            'ng-model' => 'cliente.conjuge.naturalidade'
                                        ]
                                    ]);

                                    \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'Registro Geral (RG)',
                                            'block_class' => 'col-sm-8',
                                            'name' => 'cliente[conjuge][registro_geral]',
                                            'ng-model' => 'cliente.conjuge.registro_geral'
                                        ],
                                        [
                                            'label' => 'Data de expedição',
                                            'block_class' => 'col-sm-4',
                                            'name' => 'cliente[conjuge][expedicao]',
                                            'ng-model' => 'cliente.conjuge.expedicao'
                                        ],
                                        [
                                            'label' => 'CTPS',
                                            'block_class' => 'col-sm-8',
                                            'name' => 'ctps',
                                            'name' => 'cliente[conjuge][ctps]',
                                            'ng-model' => 'cliente.conjuge.ctps'
                                        ],
                                        [
                                            'label' => 'Residência',
                                            'block_class' => 'col-sm-4',
                                            'name' => 'cliente[conjuge][residencia]',
                                            'block' => 'default-select',
                                            'options' => [
                                                '1' => 'Própria',
                                                '2' => 'Alugada'
                                            ],
                                            'ng-model' => 'cliente.conjuge.residencia'
                                        ]
                                    ]);
                                        
                                    \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'Escolaridade',
                                        ],
                                        [
                                            'label' => 'CBO',
                                            'block' => 'default-select',
                                            'block_class' => 'col-sm-12',
                                            'options' => [],
                                            'name' => 'cliente[conjuge][cbo]',
                                            'ng-model' => 'cliente.conjuge.cbo'
                                        ],
                                        [
                                            'label' => 'Registro Profissional',
                                            'name' => 'cliente[conjuge][registro_profissional]',
                                            'ng-model' => 'cliente.conjuge.registro_profissional'
                                        ],
                                    ]);

                                    \Financi\HTMLHelper::renderRow([
                                        [
                                            'label' => 'Pai',
                                            'block_class' => 'col-sm-12',
                                            'name' => 'cliente[conjuge][pai]',
                                            'ng-model' => 'cliente.conjuge.pai'
                                        ],
                                        [
                                            'label' => 'Mãe',
                                            'block_class' => 'col-sm-12',
                                            'name' => 'cliente[conjuge][mae]',
                                            'ng-model' => 'cliente.conjuge.mae'
                                        ],
                                    ]);     
                                    ?>
                                </div>
                            </div>
                            <!-- Fim /conjuge -->

                        </div>
                        <!-- Fim /tab-content -->
                </div>

                <hr>
                <div class="form-footer row text-right vmargin-0">
                    <div class="btn-group">
                        <button class="btn btn-primary" data-action="form-save" type="button" ng-click="salvar(cliente, false)">Salvar</button>
                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#" data-action="form-add" ng-click="salvar(cliente, true)">Salvar e Adicionar novo</a></li>
                        </ul>
                    </div>
                    <a class="btn btn-default" id="cancelar-cadastro-pessoa" href="/cliente">Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</div>