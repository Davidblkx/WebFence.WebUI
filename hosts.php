<?php
session_start();
include('hostsinterop.php');
if($_SESSION['auth'] != 1 || !isset($_SESSION['user'])){//if user isn't authenticated or not set
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WebFence</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- My Modifier -->
    <link href="css/modifier.css" rel="stylesheet" type="text/css">

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
                <a class="navbar-brand" href="index.php">WebFence</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <a href="#"><i class="fa fa-user fa-2x"></i> <?php echo $_SESSION['user']; ?></a>
                </li>
                <li>
                    <a href="action.php?method=logout"><i class="fa fa-power-off fa-2x"></i></a>
                </li>
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="hosts.php"><i class="fa fa-cube fa-fw"></i> Hosts</a>
                        </li>
                        <li>
                            <a href="packs.php"><i class="fa fa-cubes fa-fw"></i> Packs</a>
                        </li>
                        <li>
                            <a href="users.php"><i class="fa fa-users fa-fw"></i> Users</a>
                        </li>
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
                        <h1 class="page-header">
                          <a class="btn btn-success btn-xs btn-addHost">
                            <i class="fa fa-plus"></i>
                          </a>
                          Hosts
                        </h1>
                        <table class="table table-hover table-condensed table-hosts">
                            <thead>
                                <tr>

                                    <td class="thosts-id">
                                        ID
                                    </td>
                                    <td class="thosts-name">
                                      Name
                                    </td>
                                    <td class="thosts-adress">Adress</td>
                                    <td class="thosts-action"></td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $hosts = new dbHosts();
                            $hosts->Init();

                            foreach($hosts->items as $itm){
                                $id = $itm->Id;
                                $name = $itm->Name;
                                $lst = $itm->Hosts;
                                $listHosts = '';
                                foreach($lst as $hName){
                                    $listHosts = $listHosts.$hName.";";
                                }

                                echo '<tr data-id="'.$id.'" data-name="'.$name.'">';

                                echo '<td class="host-id">'.$id.'</td>';
                                echo '<td class="host-name">'.$name.'</td>';
                                echo '<td class="host-value">'.$listHosts.'</td>';
                                echo '<td class="thosts-action"><div class="btn-group" role="group">'.
                                    '<a data-id="'.$id.'" class="btn btn-info btn-xs btnEdit"><i class="fa fa-edit"></i>Edit</a>'.
                                    '<a data-id="'.$id.'" class="btn btn-danger btn-xs btnRemove"><i class="fa fa-remove"></i>Delete</a>'.
                                    '</div></td>';
                                echo '</tr>';
                            }

                            ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <div class="modal fade" id="HostEditor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Host Editor</h4>
          </div>
          <div class="modal-body">
            <form id="formHostEditor" role="form">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-pencil-square-o"></i></div>
                <input type="text" class="form-control" id="hostName" placeholder="HostName">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btnHostEditor">Save</button>
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
    
    <script src="js/table-host.js"></script>
    
    <script>
      $('.btn-addHost').click(function(){
         $('#HostEditor').modal(); 
      });
    </script>

</body>

</html>
