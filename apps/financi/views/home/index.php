<div class="row margin-top-50">
    <div class="mensagem"></div>
    <div class="block-flat clearfix">
        <div class="header">
            <h3>Bem-vindo ao Financi Imóveis</h3>
        </div>

        <div class="container">
            <div class="stats_bar margin-top-50">
                <div class="butpro butstyle">
                    <div class="sub"><h2>Clientes</h2><span id="total_clientes"><?php echo $clientes->qtd ?></span></div>
                    <div class="stat"><span class="spk1"><canvas style="display: inline-block; width: 74px; height: 16px; vertical-align: top;" width="74" height="16"></canvas></span></div>
                </div>
                <div class="butpro butstyle">
                    <div class="sub"><h2>Vendas</h2><span>$951,611</span></div>
                    <div class="stat"><span class="up"> 13,5%</span></div>
                </div>
                <div class="butpro butstyle">
                    <div class="sub"><h2>Lotes</h2><span>125</span></div>
                    <div class="stat"><span class="down"> 20,7%</span></div>
                </div>  
                <div class="butpro butstyle">
                    <div class="sub"><h2>Empreendimentos</h2><span><?php echo $empreendimentos->qtd ?></span></div>
                    <div class="stat"><span class="spk1"><canvas style="display: inline-block; width: 74px; height: 16px; vertical-align: top;" width="74" height="16"></canvas></span></div>
                </div>  
                <div class="butpro butstyle">
                    <div class="sub"><h2>Reservas</h2><span>3%</span></div>
                    <div class="stat"><span class="spk2"><canvas style="display: inline-block; width: 80px; height: 16px; vertical-align: top;" width="80" height="16"></canvas></span></div>
                </div>
                <div class="butpro butstyle">
                    <div class="sub"><h2>Corretores</h2><span><?php echo $corretores->qtd ?></span></div>
                    <div class="stat"><span class="spk3"><canvas style="display: inline-block; width: 80px; height: 16px; vertical-align: top;" width="80" height="16"></canvas></span></div>
                </div>  

            </div>

            
            <?php //dump_r(\Financi\Auth::getUser()); ?>
        </div>
    </div>
</div>