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
                            localStorage.removeItem('visitedWithLoginTrue');
                        }
                    </script>
                </ul>
            </li>


            <!---  Permission for Admin Dashboard starts here ------>
            <?php $check_admin_permission = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row()->dashboard; ?>
            <?php if ($check_admin_permission == '1'): ?>
                <li> <a href="<?php echo base_url(); ?>admin/dashboard" class="waves-effect"><i
                            class="ti-dashboard p-r-10"></i> <span
                            class="hide-menu"><?php echo get_phrase('Dashboard'); ?></span></a> </li>
            <?php endif; ?>
            <!---  Permission for Admin Dashboard ends here ------>

            <!---  Permission for Admin Manage Academics starts here ------>
            <!-- <?php $check_admin_permission = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row()->manage_academics; ?>
            <?php if ($check_admin_permission == '1'): ?>
                <li> <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-mortar-board" data-icon="7"></i>
                        <span class="hide-menu"> <?php echo get_phrase('Manage Academics'); ?> <span
                                class="fa arrow"></span></span></a>
                    <ul class=" nav nav-second-level<?php
                    if (
                        $page_name == 'enquiry_category' ||
                        $page_name == 'list_enquiry' ||
                        $page_name == 'club' || $page_name == 'noticeboard' ||
                        $page_name == 'circular' ||
                        $page_name == 'academic_syllabus'
                    )
                        echo 'opened active';
                    ?> ">



                        <li class="<?php if ($page_name == 'club')
                            echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/club">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('school_clubs'); ?></span>
                            </a>
                        </li>

                        <li class="<?php if ($page_name == 'circular')
                            echo 'active'; ?> ">
                            <a href="<?php echo base_url(); ?>admin/circular">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"> <?php echo get_phrase('manage_circular'); ?></span>
                            </a>
                        </li>




                        <li class="<?php if ($page_name == 'noticeboard')
                            echo 'active'; ?> ">
                            <a href="<?php echo base_url(); ?>admin/noticeboard">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('manage_events'); ?></span>
                            </a>
                        </li>

                    </ul>
                </li>
            <?php endif; ?>
 -->




            <!---  Permission for Admin Manage Employee starts here ------>
            <?php $check_admin_permission = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row()->manage_employee; ?>
            <?php if ($check_admin_permission == '1'): ?>

                <li class="staff"> <a href="javascript:void(0);" class="waves-effect">
                        <i data-icon="&#xe006;" class="fa fa-user p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('Manage Employees'); ?>
                            <span class="fa arrow"></span></span></a>

                    <ul class=" nav nav-second-level<?php if ($page_name == 'teacher')
                        echo 'opened active'; ?> ">

                        <li class="<?php if ($page_name == 'department')
                            echo 'active'; ?> ">
                            <a href="<?php echo base_url(); ?>department/department">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('department'); ?></span>
                            </a>
                        </li>
                        <li class="<?php if ($page_name == 'teacher')
                            echo 'active'; ?> ">
                            <a href="<?php echo base_url(); ?>admin/teacher">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('teachers'); ?></span>
                            </a>
                        </li>

                    </ul>
                </li>
            <?php endif; ?> <!---  Permission for Admin Manage Employee ends here ------>






            <!---  Permission for Admin Manage Student starts here ------>
            <?php $check_admin_permission = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row()->manage_student; ?>
            <?php if ($check_admin_permission == '1'): ?>

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


                        <li class="<?php if ($page_name == 'studentCategory')
                            echo 'active'; ?> ">
                            <a href="<?php echo base_url(); ?>studentcategory/studentCategory">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('Student Categories'); ?></span>
                            </a>
                        </li>


                        <li class="<?php if ($page_name == 'clubActivity')
                            echo 'active'; ?> ">
                            <a href="<?php echo base_url(); ?>activity/clubActivity">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('Student Activity'); ?></span>
                            </a>
                        </li>



                    </ul>
                </li>
            <?php endif; ?> <!---  Permission for Admin Manage Student ends here ------>





            <!---  Permission for Admin Manage Attendance starts here ------>
            <?php $check_admin_permission = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row()->manage_attendance; ?>
            <?php if ($check_admin_permission == '1'): ?>

                <li class="attendance"> <a href="#" class="waves-effect"><i data-icon="&#xe006;"
                            class="fa fa-hospital-o p-r-10"></i> <span
                            class="hide-menu"><?php echo get_phrase('manage_attendance'); ?><span
                                class="fa arrow"></span></span></a>

                    <ul class=" nav nav-second-level<?php

                    if ($page_name == 'manage_attendance' || $page_name == 'attendance_report')
                        echo 'opened active'; ?>">


                        <li class="<?php if ($page_name == 'manage_attendance')
                            echo 'active'; ?> ">
                            <a href="<?php echo base_url(); ?>admin/manage_attendance/<?php echo date("d/m/Y"); ?>">
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
                            <a href="<?php echo base_url(); ?>admin/attendance_report">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('view_attendance'); ?></span>
                            </a>
                        </li>


                    </ul>
                </li>
            <?php endif; ?> <!---  Permission for Admin Manage Attendance ends here ------>






            <!---  Permission for Admin Download Parent Page starts here ------>
            <?php $check_admin_permission = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row()->manage_parent; ?>
            <?php if ($check_admin_permission == '1'): ?>

                <li class=" <?php if ($page_name == 'parent')
                    echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/parent">
                        <i class="fa fa-users p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('manage_parents'); ?></span>
                    </a>
                </li>
            <?php endif; ?> <!---  Permission for Admin Download Page  ends here ------>






            <li> <a href="#" class="waves-effect"><i data-icon="&#xe006;" class="fa fa-university p-r-10"></i> <span
                        class="hide-menu"><?php echo get_phrase('class_information'); ?><span
                            class="fa arrow"></span></span></a>

                <ul class=" nav nav-second-level<?php
                if (
                    $page_name == 'class' ||
                    $page_name == 'section' ||
                    $page_name == 'class_routine'
                )
                    echo 'opened active';
                ?>">



                    <li class="<?php if ($page_name == 'class')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>admin/classes">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('manage_classes'); ?></span>
                        </a>
                    </li>


                    <li class="<?php if ($page_name == 'section')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>admin/section">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('manage_sections'); ?></span>
                        </a>
                    </li>




                </ul>
            </li>





            <li class="<?php if ($page_name == 'subject')
                echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>subject/subject/">
                    <i class="fa fa-book p-r-10"></i>
                    <span class="hide-menu"><?php echo get_phrase('manage_subjects'); ?></span>
                </a>
            </li>
<!-- 

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

                    <li class="<?php if ($page_name == 'marks')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>admin/marks">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('class_teacher'); ?></span>
                        </a>
                    </li>

                    <li class="<?php if ($page_name == 'student_marksheet_subject')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>admin/student_marksheet_subject">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('subject_teacher'); ?></span>
                        </a>
                    </li>



                </ul>
            </li> -->

<!-- 
            <li class="collect_fee"> <a href="#" class="waves-effect"><i data-icon="&#xe006;"
                        class="fa fa-paypal p-r-10"></i> <span
                        class="hide-menu"><?php echo get_phrase('fee_collection'); ?><span
                            class="fa arrow"></span></span></a>

                <ul class=" nav nav-second-level<?php
                if (
                    $page_name == 'income' ||
                    $page_name == 'student_payment' ||
                    $page_name == 'view_invoice_details' ||
                    $page_name == 'invoice_add' ||
                    $page_name == 'list_invoice' ||
                    $page_name == 'studentSpecificPaymentQuery' ||
                    $page_name == 'student_invoice'
                )
                    echo 'opened active';
                ?>">

                    <li class="<?php if ($page_name == 'student_payment')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>admin/student_payment">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('collect_fees'); ?></span>
                        </a>
                    </li>

                    <li class="<?php if ($page_name == 'student_invoice')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>admin/student_invoice">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('manage_invoice'); ?></span>
                        </a>
                    </li>

                </ul>
            </li> -->





            <li> <a href="#" class="waves-effect"><i data-icon="&#xe006;" class="fa fa-gears p-r-10"></i> <span
                        class="hide-menu"><?php echo get_phrase('system_settings'); ?><span
                            class="fa arrow"></span></span></a>

                <ul class=" nav nav-second-level<?php
                if (
                    $page_name == 'system_settings' ||
                    $page_name == 'manage_language' ||
                    $page_name == 'paymentSetting' ||
                    $page_name == 'sms_settings'
                )
                    echo 'opened active';
                ?>">


                    <li class="<?php if ($page_name == 'system_settings')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>systemsetting/system_settings">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('general_settings'); ?></span>
                        </a>
                    </li>



<!-- 
                    <li class="<?php if ($page_name == 'manage_language')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>admin/manage_language">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('manage_language'); ?></span>
                        </a>
                    </li>


                    <li class="<?php if ($page_name == 'paymentSetting')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>payment/paymentSetting">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Payment Settings'); ?></span>
                        </a>
                    </li> -->

                </ul>
            </li>

<!-- 
            <li> <a href="#" class="waves-effect"><i data-icon="&#xe006;" class="fa fa-bar-chart-o p-r-10"></i> <span
                        class="hide-menu"><?php echo get_phrase('generate_reports'); ?><span
                            class="fa arrow"></span></span></a>

                <ul class=" nav nav-second-level">

                    <li class="<?php if ($page_name == 'studentPaymentReport')
                        echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>report/studentPaymentReport">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Student Payments'); ?></span>
                        </a>
                    </li>


                    <li class="<?php if ($page_name == 'classAttendanceReport')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>report/classAttendanceReport">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Attendance Report'); ?></span>
                        </a>
                    </li>

                    <li class="<?php if ($page_name == 'examMarkReport')
                        echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>report/examMarkReport">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Exam Mark Report'); ?></span>
                        </a>
                    </li>


                </ul>
            </li> -->


            <?php $checking_level = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->row()->level; ?>
            <?php if ($checking_level == '1'): ?>
                <li> <a href="#" class="waves-effect"><i data-icon="&#xe006;" class="fa fa-cubes p-r-10"></i> <span
                            class="hide-menu"><?php echo get_phrase('role_managements'); ?><span
                                class="fa arrow"></span></span></a>

                    <ul class=" nav nav-second-level<?php
                    if ($page_name == 'newAdministrator')
                        echo 'opened active'; ?>">

                        <li class="<?php if ($page_name == 'admin_add')
                            echo 'active'; ?> ">
                            <a href="<?php echo base_url(); ?>admin/newAdministrator">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('new_admin'); ?></span>
                            </a>
                        </li>


                    </ul>
                </li>
            <?php endif; ?>

            <?php $checking_level = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->row()->level; ?>
            <?php if ($checking_level == '2'): ?>


                <li class="<?php if ($page_name == 'manage_profile')
                    echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>admin/manage_profile">
                        <i class="fa fa-gears p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('manage_profile'); ?></span>
                    </a>
                </li>
            <?php endif; ?>


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