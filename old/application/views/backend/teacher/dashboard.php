<!--row -->
<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="white-box">
            <div class="r-icon-stats">
                <i class="ti-user bg-megna"></i>
                <div class="bodystate">
                    <h4><?php echo $this->db->count_all_results('student'); ?></h4>
                    <span class="text-muted"><?php echo get_phrase('student'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="white-box">
            <div class="r-icon-stats">
                <i class="ti-user bg-info"></i>
                <div class="bodystate">
                    <h4><?php echo $this->db->count_all_results('parent'); ?></h4>
                    <span class="text-muted"><?php echo get_phrase('parent'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="white-box">
            <div class="r-icon-stats">
                <i class="ti-user bg-success"></i>
                <div class="bodystate">
                    <h4><?php echo $this->db->count_all_results('teacher'); ?></h4>
                    <span class="text-muted"><?php echo get_phrase('all_teachers'); ?></span>
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
<!--/row -->


<div class="row">

    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0"><?php echo get_phrase('Recently Added Students'); ?></h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php $get_student_from_model = $this->crud_model->list_all_student_and_order_with_student_id();
                            foreach ($get_student_from_model as $key => $student): ?>
                                <td><img src="<?php echo $student['face_file']; ?>" class="img-circle" width="40px"></td>
                                <td><?php echo $student['name']; ?></td>
                                <td><?php echo $student['email']; ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->