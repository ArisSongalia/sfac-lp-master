<?php
session_start();
include '../../includes/head.php';
include '../../includes/session.php';
?>
<title>
    View Teacher List | SFAC - Las Piñas
</title>
</head>

<body class="g-sidenav-show  bg-gray-100">
    <?php include '../../includes/sidebar.php'; ?>
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <!-- Navbar -->
        <?php include '../../includes/navbar-title.php'; ?>
        <h6 class="font-weight-bolder mb-0">View Teachers List</h6>
        <?php include '../../includes/navbar.php'; ?>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card shadow shadow-xl">
                        <!-- Card header -->
                        <div class="card-header">
                            <h5 class="mb-0">Teachers List</h5>
                            <p class="text-sm mb-0">Enter Firstname or Lastname in the Search box</p>
                            <!-- <p class="text-sm mb-0">
                                        A lightweight, extendable, dependency-free javascript HTML table plugin.
                                    </p> -->
                        </div>
                        <hr class="horizontal dark mt-0">
                        <div class="row d-flex justify-content-center mx-4">
                            <div class="col-md-6 m-1 ">
                                <form method="GET" action="list.teacher.php">
                                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                                        <div class="input-group">
                                            <!-- <span class="input-group-text text-body"><i class  ="fas fa-search"
                                                            aria-hidden="true"></i></span> -->
                                            <input type="text" class="form-control" name="search_text"
                                                placeholder="Search Teacher"
                                                <?php if (!empty($_GET['search_text'])) {
                                                        echo 'value="' . $_GET['search_text'] . '"';
                                                                                            }  ?>>
                                            <button class="btn-sm btn bg-gradient-dark ms-auto mb-0" type="submit"
                                                title="Send" name="search"><i class="fas fa-search text-lg"
                                                    aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive px-4 my-4">
                            <table class="table table-flush table-hover nowrap responsive" id="datatable-basic"
                                style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th></th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            I.D. No.</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            Fullname</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            Position</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            Status</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            Email</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            Username</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            Created At</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            Last Updated</th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            Updated By</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if (isset($_GET['search'])) {
                                        $_GET['search_text'] = addslashes($_GET['search_text']);
                                        if ($_SESSION['role'] == "Adviser") {
                                            $listTeacher = mysqli_query(
                                                $db,
                                                "SELECT *, CONCAT(facul.faculty_lastname, ', ', facul.faculty_firstname, ' ', facul.faculty_middlename) AS fullname
                                         FROM tbl_faculties_staff AS facul
                                        
                                        WHERE 
                                        (faculty_firstname LIKE '%$_GET[search_text]%' OR
                                        faculty_middlename LIKE '%$_GET[search_text]%' OR
                                        faculty_lastname LIKE '%$_GET[search_text]%' OR
                                        faculty_no LIKE '%$_GET[search_text]%' OR
                                        email LIKE '%$_GET[search_text]%')
                                         ORDER BY faculty_lastname DESC"
                                            ) or die(mysqli_error($db));
                                        } else {
                                            $listTeacher = mysqli_query(
                                                $db,
                                                "SELECT *, CONCAT(facul.faculty_lastname, ', ', facul.faculty_firstname, ' ', facul.faculty_middlename) AS fullname
                                         FROM tbl_faculties_staff AS facul
                                        
                                        WHERE 
                                        (faculty_firstname LIKE '%$_GET[search_text]%' OR
                                        faculty_middlename LIKE '%$_GET[search_text]%' OR
                                        faculty_lastname LIKE '%$_GET[search_text]%' OR
                                        faculty_no LIKE '%$_GET[search_text]%' OR
                                        email LIKE '%$_GET[search_text]%')
                                         ORDER BY faculty_lastname DESC"
                                            ) or die(mysqli_error($db));
                                        }

                                        while ($row = mysqli_fetch_array($listTeacher)) {
                                            $id = $row['faculty_id'];
                                    ?>


                                    

                                    <tr>
                                        <td></td>
                                        <td class="text-sm font-weight-normal">
                                            <?php if (empty($row['img'])) {
                                                        echo '<img class="border-radius-lg shadow-sm zoom" style="height:80px; width:80px;" src="../../assets/img/illustrations/user_prof.jpg"/>';
                                                    } else {
                                                        echo ' <img class=" border-radius-lg shadow-sm zoom" style="height:80px; width:80px;" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '" "/>';
                                                    } ?>
                                        </td>
                                        <td class="text-sm font-weight-normal">
                                            <?php echo $row['faculty_no'] ?>
                                        </td>
                                        <td class="text-sm font-weight-normal">
                                            <?php echo $row['fullname']; ?></td>
                                        <td class="text-sm font-weight-normal">
                                            <?php echo $row['position']; ?></td>
                                        <td class="text-sm font-weight-normal"><?php echo $row['status']; ?>
                                        </td>
                                        <td class="text-sm font-weight-normal"><?php echo $row['email']; ?></td>
                                        <td class="text-sm font-weight-normal"><?php echo $row['username']; ?>
                                        </td>
                                        <td class="text-sm font-weight-normal"><?php echo $row['created_at']; ?>
                                        </td>
                                        <td class="text-sm font-weight-normal">
                                            <?php echo $row['last_updated']; ?></td>
                                        <td class="text-sm font-weight-normal"><?php echo $row['updated_by']; ?>
                                        </td>
                                        <td class="text-sm font-weight-normal">
                                            <a class="btn bg-gradient-primary text-xs"
                                                href="edit.teacher.php?facultyStaff_id=<?php echo $id; ?>"><i
                                                    class="text-xs fas fa-edit"></i> Edit</a>

                                            <a class="btn btn-block bg-gradient-danger mb-3 text-xs disbaled"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-notification<?php echo $id; ?>"><i
                                                    class="text-xs fas fa-trash-alt"></i> Delete</a>


                                            <div class="modal fade" id="modal-notification<?php echo $id; ?>"
                                                tabindex="-1" role="dialog" aria-labelledby="modal-notification"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-danger modal-dialog-centered modal-"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title text-danger"
                                                                id="modal-title-notification"><i
                                                                    class="fas fa-exclamation-triangle"> </i>
                                                                Warning
                                                            </h6>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="py-3 text-center">
                                                                <i class="fas fa-trash-alt text-9xl"></i>
                                                                <h4 class="text-gradient text-danger mt-4">
                                                                    Delete Account!</h4>
                                                                <p>Are you sure you want to delete
                                                                    <br>
                                                                    <i><b><?php echo $row['fullname']; ?></b></i>?
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="userData/ctrl.del.teacher.php?facultyStaff_id=<?php echo $id; ?>"
                                                                class="btn btn-white text-white bg-danger">Delete</a>
                                                            <button type="button"
                                                                class="btn btn-link text-secondary btn-outline-dark ml-auto"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>






            <?php include '../../includes/footer.php'; ?>
            <!-- End footer -->
        </div>
    </main>
    <!--   Core JS Files   -->
    <?php include '../../includes/scripts.php'; ?>
</body>

</html>