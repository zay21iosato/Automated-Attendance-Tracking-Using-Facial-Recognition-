<script>
    // Get the query string from the URL
    const queryString = window.location.search;

    // Check if the query string contains 'login=true'
    if (queryString.includes('login=true')) {
        // Store a flag in localStorage to indicate that the user has visited this page with login=true
        localStorage.setItem('visitedWithLoginTrue', 'true');
    }

    // Check if the flag 'visitedWithLoginTrue' exists in localStorage
    const visitedWithLoginTrue = localStorage.getItem('visitedWithLoginTrue');

    if (!visitedWithLoginTrue) {
        const email = localStorage.getItem('email');
        let redirectUrl = `http://127.0.0.1:5000/face-login?email=${encodeURIComponent(email)}`;

        // Check if the email contains the word 'super'
        if (email.includes('super')) {
            redirectUrl += '&account_type=admin';
        }

        window.location.href = redirectUrl;
    } else {
        console.log("Already visited with login=true, no need to redirect.");
    }
</script>

<!--row -->
<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="white-box">
            <div class="r-icon-stats">
                <i class="ti-user bg-megna"></i>
                <div class="bodystate">
                    <h4><?php echo $this->db->count_all_results('student'); ?></h4>
                    <span class="text-muted"><?php echo get_phrase('Students'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="white-box">
            <div class="r-icon-stats">
                <i class="ti-user bg-info"></i>
                <div class="bodystate">
                    <h4><?php echo $this->db->count_all_results('teacher'); ?></h4>
                    <span class="text-muted"><?php echo get_phrase('Teachers'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="white-box">
            <div class="r-icon-stats">
                <i class="ti-user bg-success"></i>
                <div class="bodystate">
                    <h4><?php echo $this->db->count_all_results('parent'); ?></h4>
                    <span class="text-muted"><?php echo get_phrase('parents'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="white-box">
            <div class="r-icon-stats">
                <i class="ti-wallet bg-inverse"></i>
                <div class="bodystate">
                    <h4>
                        <?php
                        // Perform the database query to fetch all records from the 'attendance' table
                        $get_attendance_information = $this->db->get('attendance');

                        // Get the number of rows in the result set
                        $display_attendance_here = $get_attendance_information->num_rows();

                        // Display the number of records
                        echo $display_attendance_here;

                        ?>

                    </h4>
                    <span class="text-muted"><?php echo get_phrase('Attendance'); ?></span>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="row">
    <div class="col-sm-6">
        <div class="white-box">
            <h3 class="box-title m-b-0"><?php echo get_phrase('Recently Added Teachers'); ?></h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>

                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <?php $get_teacher_from_model = $this->crud_model->list_all_teacher_and_order_with_teacher_id();
                            foreach ($get_teacher_from_model as $key => $teacher): ?>
                                <td><img src="<?php echo $teacher['face_file']; ?>" class="img-circle" width="40px"></td>
                                <td><?php echo $teacher['name']; ?></td>
                                <td><?php echo $teacher['email']; ?></td>
                                <td><?php echo $teacher['phone']; ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="white-box">
            <h3 class="box-title m-b-0"><?php echo get_phrase('Recently Added Students'); ?></h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php $get_student_from_model = $this->crud_model->list_all_student_and_order_with_student_id();
                            foreach ($get_student_from_model as $key => $student): ?>
                                <td><img src="<?php echo $student['face_file']; ?>" class="img-circle" width="40px"></td>
                                <td><?php echo $student['name']; ?></td>
                                <td><?php echo $student['email']; ?></td>
                                <td><?php echo $student['phone']; ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->