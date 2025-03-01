<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Crud_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function get_type_name_by_id($type, $type_id = '', $field = 'name')
    {
        $this->db->where($type . '_id', $type_id);
        $query = $this->db->get($type);
        $result = $query->result_array();
        foreach ($result as $row)
            return $row[$field];
    }



    function get_image_url($type = '', $id = '')
    {
        if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg'))
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = base_url() . 'uploads/user.jpg';

        return $image_url;

    }

    function get_subject_name_by_id($subject_id)
    {
        $query = $this->db->get_where('subject', array('subject_id' => $subject_id))->row();
        return $query->name;
    }

    function get_class_name($class_id)
    {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        $result = $query->result_array();
        foreach ($result as $key => $row)
            return $row['name'];

    }

    function get_teachers()
    {
        $query = $this->db->get('teacher');
        return $query->result_array();
    }


    function get_teacher_name($teacher_id)
    {
        $query = $this->db->get_where('teacher', array('teacher_id' => $teacher_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name'];
    }

    function get_admin_name($admin_id)
    {
        $query = $this->db->get_where('admin', array('admin_id' => $admin_id));
        $resi = $query->result_array();
        foreach ($resi as $row)
            return $row['name'];
    }

    function get_teacher_info($teacher_id)
    {
        $query = $this->db->get_where('teacher', array('teacher_id' => $teacher_id));
        return $query->result_array();
    }


    function get_invoice_info()
    {
        $query = $this->db->get('invoice');
        return $query->result_array();
    }

    /***********  Subjects  *******************/
    function get_subjects()
    {
        $query = $this->db->get('subject');
        return $query->result_array();
    }

    function get_subject_info($subject_id)
    {
        $query = $this->db->get_where('subject', array('subject_id' => $subject_id));
        return $query->result_array();
    }

    function get_subjects_by_class($class_id)
    {
        $query = $this->db->get_where('subject', array('class_id' => $class_id));
        return $query->result_array();
    }


    function get_class_name_numeric($class_id)
    {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name_numeric'];
    }

    function get_classes()
    {
        $query = $this->db->get('class');
        return $query->result_array();
    }

    function get_class_info($class_id)
    {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        return $query->result_array();
    }

    /***********  Exams  *******************/
    function get_exams()
    {
        $query = $this->db->get('exam');
        return $query->result_array();
    }

    function get_exam_info($exam_id)
    {
        $query = $this->db->get_where('exam', array('exam_id' => $exam_id));
        return $query->result_array();
    }

    /***********  Grades  *******************/
    function get_grades()
    {
        $query = $this->db->get('grade');
        return $query->result_array();
    }

    function get_grade_info($grade_id)
    {
        $query = $this->db->get_where('grade', array('grade_id' => $grade_id));
        return $query->result_array();
    }

    function get_students($class_id)
    {
        $query = $this->db->get_where('student', array('class_id' => $class_id));
        return $query->result_array();
    }

    function list_all_student_and_order_with_student_id()
    {

        $data = array();
        $sql = "select * from student order by student_id desc limit 0, 5";
        $all_student_selected = $this->db->query($sql)->result_array();

        foreach ($all_student_selected as $key => $selected_students_from_student_table) {
            $student_id = $selected_students_from_student_table['student_id'];
            $face_file = 'uploads/student_image/' . $student_id . '.jpg';
            if (!file_exists($face_file)) {
                $face_file = 'uploads/student_image/default_image.jpg/';
            }

            $selected_students_from_student_table['face_file'] = base_url() . $face_file;
            array_push($data, $selected_students_from_student_table);
        }

        return $data;
    }

    function get_parent_id_by_email($email)
    {
        $this->db->select('parent_id');
        $this->db->from('parent');
        $this->db->where('email', $email);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result ? $result['parent_id'] : null;
    }


    // Fetch students based on parent ID
    function get_students_by_parent_id($parent_id)
    {
        $this->db->select('student_id, name');
        $this->db->from('student');
        $this->db->where('parent_id', $parent_id);
        $query = $this->db->get();
        return $query->result_array();
    }



    // Fetch attendance records based on student ID
    function get_attendance_by_student_id($student_id)
    {
        $this->db->select('date, status');
        $this->db->from('attendance');
        $this->db->where('student_id', $student_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Fetch the parent ID based on email


    function list_all_teacher_and_order_with_teacher_id()
    {

        $data = array();
        $sql = "select * from teacher order by teacher_id desc limit 0, 5";
        $all_teacher_selected = $this->db->query($sql)->result_array();

        foreach ($all_teacher_selected as $key => $selected_teachers_from_teacher_table) {
            $teacher_id = $selected_teachers_from_teacher_table['teacher_id'];
            $face_file = 'uploads/teacher_image/' . $teacher_id . '.jpg';
            if (!file_exists($face_file)) {
                $face_file = 'uploads/teacher_image/default_image.jpg/';
            }

            $selected_teachers_from_teacher_table['face_file'] = base_url() . $face_file;
            array_push($data, $selected_teachers_from_teacher_table);
        }

        return $data;
    }


    function enquiry_category()
    {

        $page_data['category'] = $this->input->post('category');
        $page_data['purpose'] = $this->input->post('purpose');
        $page_data['whom'] = $this->input->post('whom');
        $this->db->insert('enquiry_category', $page_data);
    }

    function update_category($param2)
    {
        $page_data['category'] = $this->input->post('category');
        $page_data['purpose'] = $this->input->post('purpose');
        $page_data['whom'] = $this->input->post('whom');
        $this->db->where('enquiry_category_id', $param2);
        $this->db->update('enquiry_category', $page_data);

    }

    function delete_category($param2)
    {
        $this->db->where('enquiry_category_id', $param2);
        $this->db->delete('enquiry_category');

    }

    function delete_enquiry($param2)
    {
        $this->db->where('enquiry_id', $param2);
        $this->db->delete('enquiry');
    }

    function insert_club()
    {

        $page_data['club_name'] = $this->input->post('club_name');
        $page_data['desc'] = $this->input->post('desc');
        $page_data['date'] = $this->input->post('date');

        $this->db->insert('club', $page_data);
    }

    function update_club($param2)
    {

        $page_data['club_name'] = $this->input->post('club_name');
        $page_data['desc'] = $this->input->post('desc');
        $page_data['date'] = $this->input->post('date');

        $this->db->where('club_id', $param2);
        $this->db->update('club', $page_data);
    }


    function delete_club($param2)
    {
        $this->db->where('club_id', $param2);
        $this->db->delete('club');
    }


    function insert_circular()
    {

        $page_data['title'] = $this->input->post('title');
        $page_data['reference'] = $this->input->post('reference');
        $page_data['content'] = $this->input->post('content');
        $page_data['date'] = $this->input->post('date');

        $this->db->insert('circular', $page_data);

    }

    function update_circular($param2)
    {
        $page_data['title'] = $this->input->post('title');
        $page_data['reference'] = $this->input->post('reference');
        $page_data['content'] = $this->input->post('content');
        $page_data['date'] = $this->input->post('date');

        $this->db->where('circular_id', $param2);
        $this->db->update('circular', $page_data);
    }


    function delete_circular($param2)
    {
        $this->db->where('circular_id', $param2);
        $this->db->delete('circular');
    }


    function insert_parent()
    {

        $page_data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'password' => sha1($this->input->post('password')),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
            'profession' => $this->input->post('profession')
        );

        $this->db->insert('parent', $page_data);
    }


    function update_parent($param2)
    {
        $page_data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
            'profession' => $this->input->post('profession')
        );

        $this->db->where('parent_id', $param2);
        $this->db->update('parent', $page_data);
    }

    function delete_parent($param2)
    {
        $this->db->where('parent_id', $param2);
        $this->db->delete('parent');
    }


    function system_logo()
    {

        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
    }


    function update_settings()
    {

        $data['description'] = $this->input->post('system_name');
        $this->db->where('type', 'system_name');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_title');
        $this->db->where('type', 'system_title');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('address');
        $this->db->where('type', 'address');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('phone');
        $this->db->where('type', 'phone');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('paypal_email');
        $this->db->where('type', 'paypal_email');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('currency');
        $this->db->where('type', 'currency');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_email');
        $this->db->where('type', 'system_email');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('language');
        $this->db->where('type', 'language');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('text_align');
        $this->db->where('type', 'text_align');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('running_session');
        $this->db->where('type', 'session');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('footer');
        $this->db->where('type', 'footer');
        $this->db->update('settings', $data);
    }


    function update_theme()
    {

        $data['description'] = $this->input->post('skin_colour');
        $this->db->where('type', 'skin_colour');
        $this->db->update('settings', $data);
    }

    function get_settings($type)
    {
        $get_settings = $this->db->get_where('settings', array('type' => $type))->row()->description;
        return $get_settings;
    }


    function stripe_settings()
    {
        $stripe_info = array();

        $stripe['stripe_active'] = html_escape($this->input->post('stripe_active'));
        $stripe['testmode'] = html_escape($this->input->post('testmode'));
        $stripe['secret_key'] = html_escape($this->input->post('secret_key'));
        $stripe['public_key'] = html_escape($this->input->post('public_key'));
        $stripe['secret_live_key'] = html_escape($this->input->post('secret_live_key'));
        $stripe['public_live_key'] = html_escape($this->input->post('public_live_key'));

        array_push($stripe_info, $stripe);

        $data['description'] = json_encode($stripe_info);
        $this->db->where('type', 'stripe_setting');
        $this->db->update('settings', $data);

    }

    function paypal_settings()
    {
        $paypal_info = array();

        $stripe['paypal_active'] = html_escape($this->input->post('paypal_active'));
        $stripe['paypal_mode'] = html_escape($this->input->post('paypal_mode'));
        $stripe['sandbox_client_id'] = html_escape($this->input->post('sandbox_client_id'));
        $stripe['production_client_id'] = html_escape($this->input->post('production_client_id'));

        array_push($paypal_info, $stripe);

        $data['description'] = json_encode($paypal_info);
        $this->db->where('type', 'paypal_setting');
        $this->db->update('settings', $data);


    }








}

