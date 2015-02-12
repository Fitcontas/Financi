<div id="head-nav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="fa fa-gear"></span>
            </button>
            <a class="navbar-brand" href="" ng-click="showForm()">
                <div class="navbar-user">
                    <span class="navbar-user-avatar">
                        <img src="images/default.gif">
                    </span>

                    <span class="navbar-user-name">
                        <p><b>{{ usuario.apelido }}</b></p>
                        <p style="margin-top:-5px"><small>{{ usuario.email }}</small></p>
                    </span>
                </div>
            </a>
        </div>
        <div class="navbar-collapse collapse">

            <button id="sidebar-collapse" class="btn btn-sidebar-collapse btn-default" style=""><i class="fa fa-angle-left"></i></button>
            
            <ul class="nav navbar-nav navbar-right">
                <li class="button"><a href="javascript:;"><i class="fa fa-book"></i></a></li>
                <li class="button"><a href="/sair" ng-click=""><i class="fa fa-power-off"></i></a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>