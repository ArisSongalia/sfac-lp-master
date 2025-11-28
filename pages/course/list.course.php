<?php
session_start();
include '../../includes/head.php';
include '../../includes/session.php';
?>
<title>
    Courses List | SFAC - Las Piñas
</title>
</head>

<body class="g-sidenav-show  bg-gray-100">
    <?php include '../../includes/sidebar.php'; ?>
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <!-- Navbar -->
        <?php include '../../includes/navbar-title.php'; ?>
        <h6 class="font-weight-bolder mb-0">View Course List</h6>
        <?php include '../../includes/navbar.php'; ?>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card shadow shadow-xl">
                        <!-- Card header -->
                        <div class="card-header m-1 my-0">
                            <h5 class="mb-0">Course List</h5>
                            <p class="text-sm mb-0">Enter course name, course abbrev, or department in search box</p>
                        </div>
                        <hr class="horizontal dark mt-0">

                        <!-- SEARCH BAR -->
                        <div class="row d-flex justify-content-center mx-4">
                            <div class="col-md-6 m-1 ">
                                <form method="GET" action="">
                                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search_text"
                                                placeholder="Search Course"
                                                <?php if (!empty($_GET['search_text'])) {
                                                    echo 'value="' . $_GET['search_text'] . '"';
                                                } ?>>
                                            <button class="btn-sm btn bg-gradient-dark ms-auto mb-0"
                                                type="submit" name="search">
                                                <i class="fas fa-search text-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-header"></div>

                        <!-- TABLE -->
                        <div class="table-responsive px-4 my-4">
                            <table class="table table-flush table-hover m-0 responsive nowrap" style="width: 100%;"
                                id="datatable-basic">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            Course</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            Course Abbrev.</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            Department</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                                            Option</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $results = [];

                                    // Only run search if the search button was clicked
                                    if (isset($_GET['search']) && !empty($_GET['search_text'])) {

                                        $search = mysqli_real_escape_string($db, $_GET['search_text']);

                                        $query = "
                                            SELECT *, CONCAT(cour.course, ', ', cour.course_abv) AS fullname
                                            FROM tbl_courses AS cour
                                            LEFT JOIN tbl_departments AS dep 
                                                ON dep.department_id = cour.department_id
                                            WHERE cour.course LIKE '%$search%'
                                            OR cour.course_abv LIKE '%$search%'
                                            OR dep.department_name LIKE '%$search%'
                                        ";

                                        $results = mysqli_query($db, $query);
                                    }

                                    // Display results only if search was made
                                    if (!empty($results)) {

                                        while ($row = mysqli_fetch_array($results)) {
                                            $id = $row['course_id'];
                                    ?>
                                            <tr>
                                                <td class="text-sm font-weight-normal">
                                                    <?php echo $row['fullname']; ?>
                                                </td>
                                                <td class="text-sm font-weight-normal">
                                                    <?php echo $row['course_abv']; ?>
                                                </td>
                                                <td class="text-sm font-weight-normal">
                                                    <?php echo $row['department_name']; ?>
                                                </td>

                                                <td class="text-sm font-weight-normal">
                                                    <a class="btn bg-gradient-primary text-xs"
                                                        href="edit.course.php?course_id=<?php echo $id; ?>">
                                                        <i class="text-xs fas fa-edit"></i> Edit
                                                    </a>

                                                    <a class="btn btn-block bg-gradient-danger mb-3 text-xs"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-notification<?php echo $id; ?>">
                                                        <i class="text-xs fas fa-trash-alt"></i> Delete
                                                    </a>

                                                    <!-- DELETE MODAL -->
                                                    <div class="modal fade" id="modal-notification<?php echo $id; ?>"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="modal-notification" aria-hidden="true">
                                                        <div class="modal-dialog modal-danger modal-dialog-centered modal-"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h6 class="modal-title text-danger">
                                                                        <i class="fas fa-exclamation-triangle"></i>
                                                                        Warning
                                                                    </h6>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="py-3 text-center">
                                                                        <i class="fas fa-trash-alt text-9xl"></i>
                                                                        <h4 class="text-gradient text-danger mt-4">
                                                                            Delete Course!
                                                                        </h4>
                                                                        <p>
                                                                            Are you sure you want to delete<br>
                                                                            <b><?php echo $row['fullname']; ?></b> from
                                                                            <b><?php echo $row['department_name']; ?></b>?
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="userData/ctrl.del.course.php?course_id=<?php echo $id; ?>"
                                                                        class="btn btn-white text-white bg-danger">
                                                                        Delete
                                                                    </a>
                                                                    <button type="button"
                                                                        class="btn btn-link text-secondary btn-outline-dark ml-auto"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php include '../../includes/footer.php'; ?>
        </div>
    </main>

    <?php include '../../includes/scripts.php'; ?>
</body>

</html>
