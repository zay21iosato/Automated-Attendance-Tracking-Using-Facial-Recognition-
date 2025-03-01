<!-- Left navbar-header -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
                        <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                    </span>
                </div>
                <!-- /input-group -->
            </li>

            <li class="user-pro">
                <?php
                $key = $this->session->userdata('login_type') . '_id';
                $face_file = 'uploads/' . $this->session->userdata('login_type') . '_image/' . $this->session->userdata($key) . '.jpg';
                if (!file_exists($face_file)) {
                    $face_file = 'uploads/default.jpg';
                }
                ?>

                <a href="#" class="waves-effect"><img src="<?php echo base_url() . $face_file; ?>" alt="user-img"
                        class="img-circle"> <span class="hide-menu">

                        <?php
                        $account_type = $this->session->userdata('login_type');
                        $account_id = $account_type . '_id';
                        $name = $this->crud_model->get_type_name_by_id($account_type, $this->session->userdata($account_id), 'name');
                        echo $name;
                        ?>
                        <span class="fa arrow"></span></span>
                </a>
                <ul class="nav nav-second-level">
                    <li><a href="manage_profile"><i class="ti-user"></i> My Profile</a></li>
                    <li>
                        <a href="<?php echo base_url(); ?>login/logout" onclick="clearLocalStorage()">
                            <i class="fa fa-power-off"></i> Logout
                        </a>
                    </li>

                    <script>
                        function clearLocalStorage() {
                            // Clear localStorage
                            localStorage.removeItem('visitedWithLoginTrue');
                        }
                    </script>
                </ul>
            </li>



            <li> <a href="<?php echo base_url(); ?>teacher/dashboard" class="waves-effect"><i
                        class="ti-dashboard p-r-10"></i> <span
                        class="hide-menu"><?php echo get_phrase('Dashboard'); ?></span></a> </li>



            <li class="student"> <a href="#" class="waves-effect"><i data-icon="&#xe006;"
                        class="fa fa-users p-r-10"></i> <span
                        class="hide-menu"><?php echo get_phrase('manage_students'); ?><span
                            class="fa arrow"></span></span></a>

                <ul class=" nav nav-second-level<?php
                if (
                    $page_name == 'new_student' ||
                    $page_name == 'student_class' ||
                    $page_name == 'student_information' ||
                    $page_name == 'view_student' ||
                    $page_name == 'searchStudent'
                )
                    echo 'opened active has-sub';
                ?> ">



                    <li class="<?php if ($page_name == 'new_student')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>admin/new_student">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('admission_form'); ?></span>
                        </a>
                    </li>



                    <li class="<?php if ($page_name == 'student_information' || $page_name == 'student_information' || $page_name == 'view_student')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>admin/student_information">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('list_students'); ?></span>
                        </a>
                    </li>




                </ul>
            </li>

            <li class="attendance"> <a href="#" class="waves-effect"><i data-icon="&#xe006;"
                        class="fa fa-hospital-o p-r-10"></i> <span
                        class="hide-menu"><?php echo get_phrase('manage_attendance'); ?><span
                            class="fa arrow"></span></span></a>

                <ul class=" nav nav-second-level<?php
                if (
                    $page_name == 'manage_attendance' || $page_name == 'staff_attendance' ||
                    $page_name == 'attendance_report'
                )
                    echo 'opened active';
                ?>">


                    <li class="<?php if ($page_name == 'manage_attendance')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>teacher/manage_attendance/<?php echo date("d/m/Y"); ?>">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('mark_attendance'); ?></span>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="http://127.0.0.1:5000/?configure=True">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu">Face Attendance</span>
                        </a>
                    </li>

                    <li class="<?php if ($page_name == 'attendance_report')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>teacher/attendance_report">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('view_attendance'); ?></span>
                        </a>
                    </li>


                </ul>
            </li>

            <li> <a href="#" class="waves-effect"><i data-icon="&#xe006;" class="fa fa-bar-chart-o p-r-10"></i> <span
                        class="hide-menu"><?php echo get_phrase('student_scores'); ?><span
                            class="fa arrow"></span></span></a>

                <ul class=" nav nav-second-level<?php
                if (
                    $page_name == 'marks' ||
                    $page_name == 'exam_marks_sms' ||
                    $page_name == 'tabulation_sheet'
                )
                    echo 'opened active';
                ?>">

                    <?php $select_role = $this->db->get_where('teacher', array('teacher_id' => $this->session->userdata('teacher_id')))->row()->role; ?>
                    <?php if ($select_role == '1'): ?>
                        <li class="<?php if ($page_name == 'marks')
                            echo 'active'; ?> ">
                            <a href="<?php echo base_url(); ?>teacher/marks">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('class_teacher'); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php $select_role = $this->db->get_where('teacher', array('teacher_id' => $this->session->userdata('teacher_id')))->row()->role; ?>
                    <?php if ($select_role == '2'): ?>
                        <li class="<?php if ($page_name == 'student_marksheet_subject')
                            echo 'active'; ?> ">
                            <a href="<?php echo base_url(); ?>teacher/student_marksheet_subject">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('subject_teacher'); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </li>


            <li class="<?php if ($page_name == 'manage_profile')
                echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>teacher/manage_profile">
                    <i class="fa fa-gears p-r-10"></i>
                    <span class="hide-menu"><?php echo get_phrase('manage_profile'); ?></span>
                </a>
            </li>

            <li class="">
                <a href="<?php echo base_url(); ?>login/logout">
                    <i class="fa fa-sign-out p-r-10"></i>
                    <span class="hide-menu"><?php echo get_phrase('Logout'); ?></span>
                </a>
            </li>


        </ul>
    </div>
</div>
<!-- Left navbar-header end -->