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
                        // Fetch student ID based on parent ID
                        $parent_student_logic = $this->db->get_where('student', array('parent_id' => $this->session->userdata('parent_id')))->row()->student_id;

                        // Fetch all attendance information for the given student ID
                        $this->db->where('student_id', $parent_student_logic);
                        $get_attendance_information = $this->db->get('attendance');

                        // Count the number of rows
                        $display_attendance_here = $get_attendance_information->num_rows();

                        // Display the count
                        echo $display_attendance_here;

                        ?>
                    </h4>
                    <span class="text-muted"><?php echo get_phrase('Attendance'); ?></span>
                </div>
            </div>
        </div>
    </div>



    <!--/row -->
    <!-- .row -->

    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">My Child Attendance</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <input type="hidden" id="email_input" name="email_input" value="">
                    <script>

                        document.addEventListener('DOMContentLoaded', function () {
                            // Get the email from localStorage
                            var email = localStorage.getItem('email');

                            // Set the value in a hidden input field
                            document.getElementById('email_input').value = email;
                        });

                    </script>
                    <tbody>
                        <?php
                        $email = 'parent@parent.com'; // You should dynamically get this from localStorage
                        $parent_id = $this->crud_model->get_parent_id_by_email($email);

                        if ($parent_id) {
                            $students = $this->crud_model->get_students_by_parent_id($parent_id);

                            foreach ($students as $student) {
                                $attendance_records = $this->crud_model->get_attendance_by_student_id($student['student_id']);

                                // Group attendance records by date
                                $grouped_records = [];
                                foreach ($attendance_records as $record) {
                                    $grouped_records[$record['date']][] = $record;
                                }

                                foreach ($grouped_records as $date => $records) {
                                    $record_count = count($records);
                                    $has_timein = false;

                                    foreach ($records as $index => $record) {
                                        if ($record['status'] == 1) {
                                            if ($has_timein) {
                                                // If we already encountered a "timein" on the same date, set this one to "timeout"
                                                $status_text = 'timeout';
                                            } else {
                                                // The first "timein" we encounter stays "timein"
                                                $status_text = 'timein';
                                                $has_timein = true;
                                            }
                                        } elseif ($record['status'] == 2) {
                                            $status_text = 'absent';
                                        }

                                        // Display the record
                                        ?>
                                        <tr>
                                            <td><?php echo $record['date']; ?></td>
                                            <td><?php echo $status_text; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        } else {
                            echo '<tr><td colspan="3">No records found</td></tr>';
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>