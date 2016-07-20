<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin DB</title>

    <script src="{{{ asset('bower_components/jquery/dist/jquery.min.js') }}}"></script>

    <!-- Bootstrap Core CSS -->
    <link href="{{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{{ asset('bower_components/metisMenu/dist/metisMenu.min.css') }}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{{ asset('dist/css/sb-admin-2.css') }}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}}" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <link href="{{{ asset('bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}}" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.css">

    <!-- Morris Charts CSS -->
    <link href="{{{ asset('bower_components/morrisjs/morris.css') }}}" rel="stylesheet">

    <style type="text/css">

        .modal-header-danger {
            color:#fff;
            padding:9px 15px;
            border-bottom:1px solid #eee;
            background-color: #d9534f;
            -webkit-border-top-left-radius: 5px;
            -webkit-border-top-right-radius: 5px;
            -moz-border-radius-topleft: 5px;
            -moz-border-radius-topright: 5px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .modal-header-success {
            color:#fff;
            padding:9px 15px;
            border-bottom:1px solid #eee;
            background-color: #5cb85c;
            -webkit-border-top-left-radius: 5px;
            -webkit-border-top-right-radius: 5px;
            -moz-border-radius-topleft: 5px;
            -moz-border-radius-topright: 5px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

    </style>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->


        @yield('header')

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">SB Admin v2.0</a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <a href="#">
                                    <div>
                                        <strong>John Smith</strong>
                                        <span class="pull-right text-muted">
                                            <em>Yesterday</em>
                                        </span>
                                    </div>
                                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <strong>John Smith</strong>
                                        <span class="pull-right text-muted">
                                            <em>Yesterday</em>
                                        </span>
                                    </div>
                                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <strong>John Smith</strong>
                                        <span class="pull-right text-muted">
                                            <em>Yesterday</em>
                                        </span>
                                    </div>
                                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>Read All Messages</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-tasks">
                            <li>
                                <a href="#">
                                    <div>
                                        <p>
                                            <strong>Task 1</strong>
                                            <span class="pull-right text-muted">40% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="99" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p>
                                            <strong>Task 2</strong>
                                            <span class="pull-right text-muted">20% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p>
                                            <strong>Task 3</strong>
                                            <span class="pull-right text-muted">60% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                <span class="sr-only">60% Complete (warning)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p>
                                            <strong>Task 4</strong>
                                            <span class="pull-right text-muted">80% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Tasks</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-tasks -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> New Comment
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> Message Sent
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-tasks fa-fw"></i> New Task
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-alerts -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="/auth/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="sidebar-search">
                                <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                                <!-- /input-group -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des demandes<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="/demande/add">Ajouter une demande</a>
                                    </li>
                                    <li>
                                        <a href="/demandes">Afficher les demandes</a>
                                    </li>
                                    <li>
                                        <a href="/demandes">Archive</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des interpreteurs<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="/interpreteur/add">Ajouter un interpreteur</a>
                                    </li>
                                    <li>
                                        <a href="#">Afficher les interpreteurs</a>
                                    </li>
                                    <li>
                                        <a href="/demandes">Archive</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des devis<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="/devis">Les devis en cours</a>
                                    </li>
                                    <li>
                                        <a href="/devis/archive">Archive</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des factures<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="/factures">Les factures en cours</a>
                                    </li>
                                    <li>
                                        <a href="/facture/archive">Archive</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des clients<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="/client/add">Ajouter un client</a>
                                    </li>
                                    <li>
                                        <a href="#">Afficher les clients</a>
                                    </li>
                                    <li>
                                        <a href="/demandes">Archive</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="index.html"><i class="fa fa-dashboard fa-fw"></i>Statistiques</a>
                            </li>
                            <li>
                                <a href="index.html"><i class="fa fa-dashboard fa-fw"></i>Traces</a>
                            </li>
                            <li>
                                <a href="/calandar"><i class="fa fa-table fa-fw"></i> Calendrier</a>
                            </li>
                            <!--
                            <li>
                               <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                           </li>
                           <li>
                               <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                               <ul class="nav nav-second-level">
                                <li>
                                 <a href="flot.html">Flot Charts</a>
                             </li>
                             <li>
                                 <a href="morris.html">Morris.js Charts</a>
                             </li>
                         </ul>

                     </li>
                     <li>
                       <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                   </li>
                   <li>
                       <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                   </li>
                   <li>
                       <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                       <ul class="nav nav-second-level">
                        <li>
                         <a href="panels-wells.html">Panels and Wells</a>
                     </li>
                     <li>
                         <a href="buttons.html">Buttons</a>
                     </li>
                     <li>
                         <a href="notifications.html">Notifications</a>
                     </li>
                     <li>
                         <a href="typography.html">Typography</a>
                     </li>
                     <li>
                         <a href="icons.html"> Icons</a>
                     </li>
                     <li>
                         <a href="grid.html">Grid</a>
                     </li>

                 </ul>
             </li>
             <li>
               <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
               <ul class="nav nav-second-level">
                <li>
                 <a href="#">Second Level Item</a>
             </li>
             <li>
                 <a href="#">Second Level Item</a>
             </li>
             <li>
                 <a href="#">Third Level <span class="fa arrow"></span></a>
                 <ul class="nav nav-third-level">
                  <li>
                   <a href="#">Third Level Item</a>
               </li>
               <li>
                   <a href="#">Third Level Item</a>
               </li>
               <li>
                   <a href="#">Third Level Item</a>
               </li>
               <li>
                   <a href="#">Third Level Item</a>
               </li>
           </ul>
       </li>
   </ul>
</li>
<li class="active">
   <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
   <ul class="nav nav-second-level">
    <li>
     <a class="active" href="blank.html">Blank Page</a>
 </li>
 <li>
     <a href="login.html">Login Page</a>
 </li>
</ul>
</li>
</ul>
-->
</ul>
</div>
<!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>

<!-- Page Content -->
<div id="page-wrapper">
   <div class="container-fluid">
    <div class="row">
     <div class="col-lg-12">

      @yield('content')

  </div>
  <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

</div>


<!-- Bootstrap Core JavaScript -->
<script src="{{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}}"></script>

<!-- DataTables JavaScript -->
<script src="{{{ asset('bower_components/datatables/media/js/jquery.dataTables.min.js') }}}"></script>

<script src="{{{ asset('bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}}"></script>


<!-- Metis Menu Plugin JavaScript -->
<script src="{{{ asset('bower_components/metisMenu/dist/metisMenu.min.js') }}}"></script>


<script src="{{{ asset('bower_components/datatables-responsive/js/dataTables.responsive.js') }}}"></script>



<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.1.2/js/buttons.colVis.min.js"></script>


<!--

        //code.jquery.com/jquery-1.12.0.min.js
        https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js
        https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js
        https://cdn.datatables.net/responsive/2.0.2/js/dataTables.responsive.min.js
        https://cdn.datatables.net/responsive/2.0.2/js/responsive.bootstrap.min.js
    -->


    @yield('footer')

<!-- Custom Theme JavaScript -->
<script src="{{{ asset('dist/js/sb-admin-2.js') }}}"></script>



</body>

</html>
