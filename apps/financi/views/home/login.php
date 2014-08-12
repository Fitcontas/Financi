<div class="container main-box">
<form id="login" style="margin-bottom: 0px !important;" autocomplete="off" class="form-horizontal" method="POST" action="/logar">
    <div class="login-body">
        <div class="text-center">
            <div class="logo">
                <h1 class="inset-text"><span>Financi </span>Imóveis</h1>
                <p>ACESSE SUA CONTA</p>
            </div>
        
            <div class="photo">
                <i class="fa fa-key"></i>
            </div>
        </div>
        <div id="deslogado" class="">
            <div class="content">
                
                <div class="login-msg"></div>
                <div class="spacer2">
                    <?php if($flash->has('error')): ?>
                    <div id="alertdiv" class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><span><?php echo $flash->get('error') ?></span></div>
                    <?php endif ?>
                    <div class="form-group">
                        <div class="col-sm-24">
                            <div class="input-group login_input-wrapper">
                                <span class="input-group-addon"><i class="square fa fa-envelope"></i></span>
                                <input type="text" placeholder="Email" req name="email" class="form-control" id="email" value="">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-24">
                            <div class="input-group login_input-wrapper">
                                <span class="input-group-addon"><i class="square fa fa-lock"></i></span>
                                <input type="password" placeholder="Senha" req name="senha" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <input type='hidden' name='controle' value='Index'>
                    <input type='hidden' name='acao' value='login'>
                </div>
            </div>
            <div class="col-sm-24">
                <button id="submit_login" class="btn btn-primary btn-full">Acessar</button>
            </div>
            <div class="col-sm-24">
                <div class="recovery pull-right">
                    <a href="#">Esqueceu a senha?</a>
                </div>
            </div>
        </div>

        <div id="logado" class="hide">
            <div class="content text-center">
                <h4>Você esta logado como</h4>
                <h2></h2>
                <hr>
            </div>
            <div class="text-center foot">
                <!-- <a href="?controle=Index&acao=logout" class="btn btn-default">Trocar de usuário</a>   -->
                <a class="btn btn-primary btn-full" href="?controle=Home&acao=index">Retornar ao sistema</a>
            </div>

        </div>        
    </div>
    
</form>
</div>