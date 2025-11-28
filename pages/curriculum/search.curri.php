<?php
session_start();
require '../../includes/conn.php';
include '../../includes/head.php';
include '../../includes/session.php';

?>
<title>
    Curriculum | SFAC - Bacoor
</title>
</head>


<body class="g-sidenav-show  bg-gray-100">
    <?php include '../../includes/sidebar.php'; ?>
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <!-- Navbar -->
        <?php include '../../includes/navbar-title.php'; ?>
        <h6 class="font-weight-bolder mb-0">Search Curriculum</h6>
        <?php include '../../includes/navbar.php'; ?>
        <!-- End Navbar -->


        <div class="container-fluid py-4">
            <div class="row mb-10">
                <div class="col-lg-9 col-12 mx-auto">
                    <div class="card card-body mt-4 shadow-sm">
                        <h6 class="mb-0">Search Curriculum</h6>
                        <hr class="horizontal dark my-3">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="mt-3">Course</label>
                                <select class="form-control" name="course" id="department">
                                    <option value="" disabled selected>Select Course
                                    </option>
                                    <?php
                                    $select_course = mysqli_query($db, "SELECT * FROM tbl_courses");
                                    while ($row = mysqli_fetch_array($select_course)) {
                                        ?>
                                        <option value="<?php echo $row['course_abv']?>"><?php echo $row['course_abv']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="mt-3">Curriculum</label>
                                <select class="form-control" name="eay" id="courses">
                                    <option value="" disabled selected>Select Curriculum
                                    </option>
                                    <?php
                                    $select_course = mysqli_query($db, "SELECT * FROM tbl_effective_acadyear");
                                    while ($row = mysqli_fetch_array($select_course)) {
                                        ?>
                                        <option value="<?php echo $row['eay']?>"><?php echo $row['eay']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" name="submit" class="btn bg-gradient-dark text-white m-0 ms-2">
                                    Search</button>
                            </div>
                        </form>
                        <?php
                         if (isset($_POST['submit'])) {
                            $course = mysqli_real_escape_string($db,$_POST['course']);
                            $eay = mysqli_real_escape_string($db,$_POST['eay']);
                            
                            $file = $course."-".$eay.".php";
                            
                                if (file_exists($file)) {
                                        echo'<script>{
                                        location.replace("'.$file.'")}
                                        </script>';
                                    }
                                
                         }
                        ?>
                    </div>
                </div>
            </div>
            <br>
            <?php include '../../includes/footer.php'; ?>
            <!-- End footer -->
            </form>
        </div>
    </main>
    <!--   Core JS Files   -->
    <?php include '../../includes/scripts.php'; ?>
</body>

</html>