<div class="row margin-top-50" ng-cloak>
    <div class="mensagem"></div>
    <div class="block-flat clearfix">
        <div class="header">
            <h3>Mural</h3>
        </div>

        <div class="container">
            <div class="stats_bar" style="margin-top:15px;">
                <div class="butpro butstyle">
                    <div class="sub">
                        <h2>Vendas Efetuadas</h2>

                        <span>R$ <?php echo number_format($contratos[0]->valor, 2, ',', '.') ?></span>
                    </div>
                        <div class="stat text-center">Nº. Contratos <?php echo $contratos[0]->qtd ?></div>
                    
                </div>

                <div class="butpro butstyle">
                    <div class="sub"><h2>Lotes</h2><span><?php echo $lotes[0]->qtd ?></span></div>
                    <div class="stat">Vendidos: <?php echo $lotes_vendidos[0]->qtd ?> (<?php echo number_format(($lotes_vendidos[0]->qtd * 100) / $lotes[0]->qtd, 2, ',', '') ?>%)</div>
                </div>

                <div class="butpro butstyle">
                    <div class="sub"><h2>Reservas</h2>

                    <span><?php echo ($lotes_reservas[0]->qtd) ?></span></div>
                    <div class="stat">Porcentagem: (<?php echo number_format(($lotes_reservas[0]->qtd * 100) / $lotes[0]->qtd, 2, ',', '') ?>%)</div>
                </div>  

                <div class="butpro butstyle">
                    <div class="sub"><h2>Empreendimentos</h2><span><?php echo $empreendimentos->qtd ?></span></div>
                    <div class="stat"><span class="spk1"><canvas style="display: inline-block; width: 74px; height: 16px; vertical-align: top;" width="74" height="16"></canvas></span></div>
                </div>  

                <div class="butpro butstyle">
                    <div class="sub"><h2>Reservas</h2><span>0%</span></div>
                    <div class="stat"><span class="spk2"><canvas style="display: inline-block; width: 80px; height: 16px; vertical-align: top;" width="80" height="16"></canvas></span></div>
                </div>

                <div class="butpro butstyle">
                    <div class="sub"><h2>Corretores</h2><span><?php echo $corretores->qtd ?></span></div>
                    <div class="stat"><span class="spk3"><canvas style="display: inline-block; width: 80px; height: 16px; vertical-align: top;" width="80" height="16"></canvas></span></div>
                </div>  

            </div>

            
            
            <?php //dump_r(\Financi\Auth::getUser()); ?>
        </div>
        <?php if(count($ultimos_contratos)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Contrato</th>
                    <th width="10%">Data</th>
                    <th width="5%">Lote</th>
                    <th width="5%">Quadra</th>
                    <th width="30%">Empreendimento</th>
                    <th width="15%">Valor</th>
                    <th width="35%">Corretor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ultimos_contratos as $c): ?>
                <?php $data_emissao = $c->data_emissao->format('Y');
?>
                <tr>
                    <td>
                        <?php echo str_pad( $c->id.$data_emissao, 9, 0, STR_PAD_LEFT); ?>
                    </td>
                    <td><?php echo $c->data_emissao->format('d/m/Y') ?></td>
                    <td><?php echo $c->lote->numero ?></td>
                    <td><?php echo $c->lote->quadra ?></td>
                    <td><?php echo $c->lote->empreendimento->empreendimento ?></td>
                    <td><?php echo number_format($c->valor, 2, ',', '.') ?></td>
                    <td><?php echo $c->contrato_corretor[0]->corretor->nome ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

