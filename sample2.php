<?php include('session.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>St. Patrick School, Jaunpur</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="./font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="./font-awesome/ionicons.min.css" rel="stylesheet" type="text/css" />

    <link href="./plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="./dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="./dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="./datepicker/jquery.datetimepicker.css" />


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-blue">
    <!-- Site wrapper -->
    <div class="wrapper">

        <?php include("./header.php"); ?>
        <?php include("./sidebar.php"); ?>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Add Issued Tc
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="box">
                    <div class="box-header with-border">
                        <p id="querystatus">
                            <?php
                            $queryresult = $_GET["queryresult"];
                            if ($queryresult == '1') {
                            ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4> <i class="icon fa fa-check"></i> Alert!</h4>
                            Details are successfully Added.
                        </div>
                    <?php } else if ($queryresult == '0') { ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            Errors occured while Adding Details.
                        </div>

                    <?php } ?>
                    </p>
                    </div>
                    <div class="box-body">
                        <form action="Tc_Save.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label>Admission No. / TC No.</label>
                                        <input class="form-control" name="admno" placeholder="Enter the Admission No. / TC No." type="text" required>
                                        <?php $date = date("dmYhis"); ?>
                                        <input class="form-control" name="tc_id" type="hidden" value="<?php echo $date; ?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Tc Photo</label>
                                        <input id="exampleInputFile" type="file" name="tc_photo">
                                        <p class="help-block">Browse the image from computer</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <button class="btn btn-block btn-default btn-sm" type="reset" name="Reset" value="Reset">Reset</button>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <button class="btn btn-block btn-info btn-sm" type="Submit" name="Submit" value="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                    <div class="box-footer"></div><!-- /.box-footer-->
                </div><!-- /.box -->

            </section><!-- /.content -->


            <section class="content">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="box">
                            <div class="box-header">
                                <h3>Tc List</h3>
                                <?php
                                $deleteresult = $_GET["deleteresult"];
                                if ($deleteresult == '1') {
                                ?>
                                    <div class="alert alert-success alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4> <i class="icon fa fa-check"></i> Alert!</h4>
                                        Details are successfully deleted.
                                    </div>
                                <?php } else if ($deleteresult == '0') { ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                        Errors occured while deleting Details.
                                    </div>

                                <?php } ?>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Admission No. / TC No.</th>
                                            <th>TC Uploaded Date</th>
                                            <th>View</th>
                                            <th>Tools</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        $query = "SELECT * FROM issued_tc ORDER BY id DESC";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $id = $row['id'];
                                            $tc_id = $row['tc_id'];
                                            $admno = $row['admno'];
                                            $tc_upload_date = $row['tc_upload_date'];
                                            $photo_url = $row['photo_url'];



                                        ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $admno; ?></td>
                                                <td><?php echo $tc_upload_date; ?></td>
                                                <td><?php if ($photo_url != "") { ?><a href="<?php echo $photo_url; ?>" target="_blank">View</a><?php } else {
                                                                                                                                            echo "Not Uploaded";
                                                                                                                                        } ?></td>
                                                <td>
                                                    <a data-toggle="modal" href="#edit<?php echo $id; ?>" class="btn btn-block btn-success btn-xs"><i class="fa fa-fw fa-edit"></i>Edit</a>
                                                    <a data-toggle="modal" href="#delete<?php echo $id; ?>" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-trash-o"></i>Delete</a>
                                                </td>
                                            </tr>
                                        <?php $count++;
                                        } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Admission No. / TC No.</th>
                                            <th>TC Uploaded Date</th>
                                            <th>View</th>
                                            <th>Tools</th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <!-- modal starts -->
                                <?php

                                $query = "SELECT * FROM issued_tc ";
                                $result = mysqli_query($con, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $tc_id = $row['tc_id'];
                                    $admno = $row['admno'];
                                    $photo_url = $row['photo_url'];
                                ?>
                                    <div class="modal" id="edit<?php echo $id; ?>">
                                        <div class="modal-dialog" style="width: 830px;">
                                            <div class="modal-content" style="width: 1024px;">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">Edit Tc Details</h4>
                                                </div>
                                                <div class="container"></div>
                                                <div class="modal-body">
                                                    <div class="box-body">

                                                        <form action="Tc_Save.php" method="POST" enctype="multipart/form-data">
                                                            <div class="row">
                                                                <div class="col-sm-6 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Admission Number</label>
                                                                        <input class="form-control" name="admno" placeholder="Enter the Tc Title" value="<?php echo $admno; ?>" type="text" required>
                                                                        <input class="form-control" name="tc_id" type="hidden" value="<?php echo $tc_id; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputFile">Tc Photo</label>
                                                                        <input id="exampleInputFile" type="file" name="tc_photo">
                                                                        <p class="help-block">Browse the image from computer</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6 col-md-6">
                                                                    <button class="btn btn-block btn-default btn-sm" type="reset" name="Reset" value="Reset">Reset</button>
                                                                </div>
                                                                <div class="col-sm-6 col-md-6">
                                                                    <button class="btn btn-block btn-info btn-sm" type="Submit" name="Submit" value="submit">Submit</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Delete modal start -->
                                    <div class="modal modal-danger" id="delete<?php echo $id; ?>">
                                        <div class="modal-dialog" style="width: 420px; padding-top: 100px; margin-left: 500px;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title"><i class="fa fa-fw fa-exclamation-triangle"></i>&nbsp;Alert</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p style="text-align:center;"> Do You Want to Delete This Data...?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" style="width:150px;">No</button>
                                                    <form action="deletetcitem.php" method="POST">
                                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                        <input type="Submit" name="Submit" value="Yes" class="btn btn-outline" style="width:200px;">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Delete modal ends -->
                                <?php } ?>











                            </div>
                        </div>
                    </div>
                </div>
            </section>














        </div><!-- /.content-wrapper -->

        <footer class="main-footer">

            <strong>Copyright &copy; 2019 St. Patrick School, Jaunpur Powered by <a href="http://cisoft.co.in/">Cisoft Technologies</a>.</strong>
        </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="./plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="./bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="./plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="./plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="./plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='./plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="./dist/js/app.min.js" type="text/javascript"></script>
    <script src="./dist/js/demo.js" type="text/javascript"></script>

    <script src="./datepicker/jquery.datetimepicker.js"></script>

    <script type="text/javascript">
        $(function() {
            $("#example1").dataTable();
            $('#example2').dataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": false,
                "bSort": true,
                "bInfo": true,
                "bAutoWidth": false
            });
        });

        $('#myModal').onclick('show.bs.modal', function(e) {
            if (!data) return e.preventDefault() // stops modal from being shown
        })
    </script>

    <script>
        $('#datetimepickera4').datetimepicker({
            timepicker: false,
            format: 'd/m/Y'
        });
    </script>
    <?php

    $query = "SELECT * FROM issued_tc";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
    ?>
        <script>
            $('#datetimepicker<?php echo $id; ?>').datetimepicker({
                timepicker: false,
                format: 'd/m/Y'
            });
        </script>
    <?php } ?>
    <script>
        $(".alert").delay(200).addClass("in").fadeOut(3500);
    </script>
</body>

</html>