<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        // $this->load->model('jabatan_m');
        $this->load->model('lowongan_m');
        $this->load->model('jurusan_m');
        $this->load->model('alumni_m');

        // $level_akun = $this->session->userdata('level');
        // if ($level_akun != "admin") {
        //     return redirect('auth');
        // }
    }

    public function index()
    {
        $data['nama'] = $this->session->userdata('nama_alumni');
        $data['data'] = false;
        $data['judul'] = 'Dashboard';
        $data['jumlah_alumni'] = $this->alumni_m->jumlah_alumni();
        $data['jumlah_lowongan'] = $this->alumni_m->jumlah_lowongan();
        // $data['jml_alumni'] = $this->pegawai_m->jumlah_pegawai();
        // $data['jml_jurusan'] = $this->pegawai_m->jumlah_jurusan();
        // $data['jml_absen'] = $this->pegawai_m->jumlah_absen();
        // $bulan1 = "1";
        // $bulan = "08";
        // $data['bulan1'] = $this->pegawai_m->jumlah_absen_bulan("01");
        // $data['bulan2'] = $this->pegawai_m->jumlah_absen_bulan("02");
        // $data['bulan3'] = $this->pegawai_m->jumlah_absen_bulan("03");
        // $data['bulan4'] = $this->pegawai_m->jumlah_absen_bulan("04");
        // $data['bulan5'] = $this->pegawai_m->jumlah_absen_bulan("05");
        // $data['bulan6'] = $this->pegawai_m->jumlah_absen_bulan("06");
        // $data['bulan7'] = $this->pegawai_m->jumlah_absen_bulan("07");
        // $data['bulan8'] = $this->pegawai_m->jumlah_absen_bulan("08");
        // $data['bulan9'] = $this->pegawai_m->jumlah_absen_bulan("09");
        // $data['bulan10'] = $this->pegawai_m->jumlah_absen_bulan("10");
        // $data['bulan11'] = $this->pegawai_m->jumlah_absen_bulan("11");
        // $data['bulan12'] = $this->pegawai_m->jumlah_absen_bulan("12");

        $this->load->view('template/header', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('template/footer', $data);
    }

    // Jurusan
    // -------------------- //
    public function jurusan()
    {
        $data['judul'] = 'Data jurusan';
        $data['nama'] = $this->session->userdata('nama_alumni');
        $data['data'] = $this->jurusan_m->get_all_jurusan();
        $this->load->view('template/header', $data);
        $this->load->view('admin/jurusan/data_jurusan', $data);
        $this->load->view('template/footer');
    }
    public function tambah_jurusan()
    {
        $data['judul'] = 'Data jurusan';
        $data['nama'] = $this->session->userdata('nama_alumni');
        $this->load->view('template/header', $data);
        $this->load->view('admin/jurusan/input_jurusan', $data);
        $this->load->view('template/footer');
    }
    public function edit_jurusan($id_jurusan)
    {
        $data['judul'] = 'Data jurusan';
        $data['nama'] = $this->session->userdata('nama_alumni');
        $data['data'] = $this->jurusan_m->get_row_jurusan($id_jurusan);

        $this->load->view('template/header', $data);
        $this->load->view('admin/jurusan/edit_jurusan', $data);
        $this->load->view('template/footer');
    }
    public function edit_alumni($telpon)
    {
        $data['judul'] = 'Data jurusan';
        $data['nama'] = $this->session->userdata('nama_alumni');
        $data['data'] = $this->alumni_m->get_row_alumni($telpon);

        $this->load->view('template/header', $data);
        $this->load->view('admin/alumni/edit_alumni', $data);
        $this->load->view('template/footer');
    }
    public function kode_lowongan($id_lowongan)
    {
        $data['judul'] = 'Data jurusan';
        $data['nama'] = $this->session->userdata('nama_alumni');
        $data['data'] = $this->lowongan_m->get_row_lowongan($id_lowongan);

        $this->load->view('template/header', $data);
        $this->load->view('admin/lowongan/kode', $data);
        $this->load->view('template/footer');
    }
    public function update_kode($id_lowongan)
    {
        $data = array(
            "kode" =>                $this->input->post('kode')
        );
        $this->db->where('id_lowongan', $id_lowongan);
        $this->db->update('lowongan', $data);
        return redirect('admin/data_lowongan');
    }

    public function proses_update_jurusan($id_jurusan)
    {
        $this->form_validation->set_rules('nama_jurusan', 'jurusan', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['data'] = $this->jurusan_m->get_row_jurusan($id_jurusan);
            $data['judul'] = 'Data jurusan';
            $data['nama'] = $this->session->userdata('nama_alumni');
            $this->load->view('template/header', $data);
            $this->load->view('admin/jurusan/edit_jurusan', $data);
            $this->load->view('template/footer');
        } else {
            $data = array(
                'nama_jurusan' => $this->input->post('nama_jurusan')
            );
            $this->db->where('id_jurusan', $id_jurusan);
            $this->db->update('jurusan', $data);
            return redirect('admin/jurusan');
        }
    }
    public function proses_input_jurusan()
    {
        $this->form_validation->set_rules('nama_jurusan', 'jurusan', 'required');
        if ($this->form_validation->run() == FALSE) {

            $data['judul'] = 'Data jurusan';
            $data['nama'] = $this->session->userdata('nama_alumni');
            $this->load->view('template/header', $data);
            $this->load->view('admin/jurusan/input_jurusan', $data);
            $this->load->view('template/footer');
        } else {
            $data = array(
                'nama_jurusan' => $this->input->post('nama_jurusan')
            );
            $this->db->insert('jurusan', $data);
            return redirect('admin/jurusan');
        }
    }
    public function hapus_jurusan($id_jurusan)
    {
        $this->db->where('id_jurusan', $id_jurusan);
        $this->db->delete('jurusan');
        return redirect('admin/jurusan');
    }
    public function hapus_lowongan($id_lowongan)
    {
        $this->db->where('id_lowongan', $id_lowongan);
        $this->db->delete('lowongan');
        return redirect('admin/data_lowongan');
    }

    // jurusan end
    // -------------------- //


    // Pegawai
    // -------------------- //
    public function buat_lowongan_baru()
    {
        $data['judul'] = 'Data Pegawai';
        $data['nama'] = $this->session->userdata('nama_alumni');
        // $data['data'] = $this->pegawai_m->get_all_pegawai();

        $this->load->view('template/header', $data);
        $this->load->view('admin/lowongan/input_lowongan', $data);
        $this->load->view('template/footer');
    }
    public function edit_lowongan($id_lowongan)
    {
        $data['judul'] = 'Data Pegawai';
        $data['nama'] = $this->session->userdata('nama_alumni');
        $data['data'] = $this->lowongan_m->get_row_lowongan($id_lowongan);

        $this->load->view('template/header', $data);
        $this->load->view('admin/lowongan/edit_lowongan', $data);
        $this->load->view('template/footer');
    }

    public function proses_input_lowongan()
    {
        $this->form_validation->set_rules('nama_lowongan', 'Nama Lowongan', 'required');
        $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan');
        $this->form_validation->set_rules('batas_tanggal', 'Batas Tanggal');
        $this->form_validation->set_rules('isi_lowongan', 'Isi Lowongan');
        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Lowongan Baru';
            $data['nama'] = $this->session->userdata('nama_alumni');
            $data['jurusan'] = $this->jurusan_m->get_all_jurusan();

            $this->load->view('template/header', $data);
            $this->load->view('admin/lowongan/input_lowongan', $data);
            $this->load->view('template/footer');
        } else {
            $data = array(
                'nama_lowongan' => $this->input->post('nama_lowongan'),
                'nama_perusahaan' => $this->input->post('nama_perusahaan'),
                'batas_tanggal' => $this->input->post('batas_tanggal'),
                'isi_lowongan' => $this->input->post('isi_lowongan'),
            );

            $this->db->insert('lowongan', $data);
            return redirect('admin/data_lowongan');
        }
    }
    public function proses_update_lowongan($id_lowongan)
    {
        $this->form_validation->set_rules('nama_lowongan', 'Nama Lowongan', 'required');
        $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan');
        $this->form_validation->set_rules('batas_tanggal', 'Batas Tanggal');
        $this->form_validation->set_rules('isi_lowongan', 'Isi Lowongan');
        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Lowongan Baru';
            $data['nama'] = $this->session->userdata('nama_alumni');
            $data['jurusan'] = $this->jurusan_m->get_all_jurusan();

            $this->load->view('template/header', $data);
            $this->load->view('admin/lowongan/input_lowongan', $data);
            $this->load->view('template/footer');
        } else {
            $data = array(
                'nama_lowongan' => $this->input->post('nama_lowongan'),
                'nama_perusahaan' => $this->input->post('nama_perusahaan'),
                'batas_tanggal' => $this->input->post('batas_tanggal'),
                'isi_lowongan' => $this->input->post('isi_lowongan'),
            );
            $this->db->where('id_lowongan', $id_lowongan);

            $this->db->update('lowongan', $data);
            return redirect('admin/data_lowongan');
        }
    }

    public function jadikan_admin($nip)
    {
        $data = array(
            "level" => "admin"
        );
        $this->db->where('nip', $nip);
        $this->db->update('akun', $data);
        return redirect('admin/pegawai');
    }
    public function jadikan_user($nip)
    {
        $data = array(
            "level" => "user"
        );
        $this->db->where('nip', $nip);
        $this->db->update('akun', $data);
        return redirect('admin/pegawai');
    }

    public function lihat_lowongan($id_lowongan)
    {
        $data['judul'] = 'Data Lowongan';
        $data['nama'] = $this->session->userdata('nama_alumni');
        $data['data'] = $this->lowongan_m->get_row_lowongan($id_lowongan);

        $this->load->view('template/header', $data);
        $this->load->view('user/lowongan/lihat_lowongan', $data);
        $this->load->view('template/footer');
    }

    public function update_pegawai($id_pegawai)
    {
        $this->form_validation->set_rules('nip', 'NIP', 'required');
        $this->form_validation->set_rules('no_ktp', 'No KTP', 'required');
        $this->form_validation->set_rules('nama_alumni', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('nama_panggilan', 'Nama Panggilan', 'required');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tempat', 'Tempat', 'required');
        $this->form_validation->set_rules('ttl', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('alamat_saat_ini', 'Alamat Saat Ini', 'required');
        $this->form_validation->set_rules('alamat_permanen', 'Alamat Permanen', 'required');
        $this->form_validation->set_rules('no_telp', 'No Telpon', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('hobi', 'Hobi', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('mulai_bekerja', 'Mulai Bekerja', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
        $this->form_validation->set_rules('jurusan', 'jurusan', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Data Pegawai';
            $data['nama'] = $this->session->userdata('nama_alumni');
            $data['jurusan'] = $this->jurusan_m->get_all_jurusan();
            $data['jabatan'] = $this->jabatan_m->get_all_jab();
            $data['x'] = $this->pegawai_m->get_row_pegawai($id_pegawai);

            $this->load->view('template/header', $data);
            $this->load->view('admin/pegawai/edit_pegawai', $data);
            $this->load->view('template/footer');
        } else {
            $config['upload_path']   = './assets/foto_profil/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['remove_space'] = TRUE;
            //$config['max_size']      = 100; 
            //$config['max_width']     = 1024; 
            //$config['max_height']    = 768;  

            $this->load->library('upload', $config);
            // script upload file 1
            $y =   $this->upload->do_upload('foto');
            $x = $this->upload->data();

            $data = array(
                'nip' => $this->input->post('nip'),
                'no_ktp' => $this->input->post('no_ktp'),
                'nama_alumni' => $this->input->post('nama_alumni'),
                'nama_panggilan' => $this->input->post('nama_panggilan'),
                'jk' => $this->input->post('jk'),
                'tempat' => $this->input->post('tempat'),
                'ttl' => $this->input->post('ttl'),
                'alamat_saat_ini' => $this->input->post('alamat_saat_ini'),
                'alamat_permanen' => $this->input->post('alamat_permanen'),
                'no_telp' => $this->input->post('no_telp'),
                'agama' => $this->input->post('agama'),
                'jabatan' => $this->input->post('jabatan'),
                'jurusan' => $this->input->post('jurusan'),
                'hobi' => $this->input->post('hobi'),
                'email' => $this->input->post('email'),
                'mulai_bekerja' => $this->input->post('mulai_bekerja'),
                'foto' =>  $x["orig_name"],
                'status_pegawai' => "Aktif"
            );

            $akun = array(
                'nip' => $this->input->post('nip'),
                'level' => "user"
            );

            $akun_model = $this->pegawai_m->get_row_pegawai2($id_pegawai);

            $this->db->where('id_akun', $akun_model->nip);
            $this->db->update('akun', $akun);

            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->update('pegawai', $data);
            return redirect('admin/pegawai');
        }
    }
    public function delete_alumni($telpon)
    {
        $this->db->where('telpon', $telpon);
        $this->db->delete('alumni');

        $this->db->where('telpon', $telpon);
        $this->db->delete('akun');
        return redirect('admin/alumni');
    }

    // Pegawai end
    // -------------------- //

    // menerima pengajuan  
    // -------------------- //
    public function data_lowongan()
    {
        $data['judul'] = 'Data Lowongan';
        $data['data'] = $this->lowongan_m->get_all_lowongan();
        $data['nama'] = $this->session->userdata('nama_alumni');
        $this->load->view('template/header', $data);
        $this->load->view('admin/lowongan/data_lowongan', $data);
        $this->load->view('template/footer');
    }
    public function lowongan_lama()
    {
        $data['judul'] = 'Data Lowongan';
        $data['data'] = $this->lowongan_m->get_all_lowongan();
        $data['nama'] = $this->session->userdata('nama_alumni');
        $this->load->view('template/header', $data);
        $this->load->view('admin/lowongan/lowongan_lama', $data);
        $this->load->view('template/footer');
    }
    public function pengajuan_kerja()
    {
        $data['judul'] = 'Data Lowongan';
        $data['data'] = $this->alumni_m->get_pengajuan();
        $data['nama'] = $this->session->userdata('nama_alumni');
        $this->load->view('template/header', $data);
        $this->load->view('admin/lowongan/pengajuan_kerja', $data);
        $this->load->view('template/footer');
    }
    public function lihat_pelamar($telpon)
    {
        $data['judul'] = 'Alumni';
        $data['nama'] = $this->session->userdata('nama_alumni');
        // $telpon =  $this->session->userdata('telpon');
        $data['data'] = $this->alumni_m->get_row_alumni($telpon);
        $this->load->view('template/header', $data);
        $this->load->view('admin/lowongan/lihat_pelamar', $data);
        $this->load->view('template/footer');
    }
    public function semua_pelamar($id_pelamar)
    {
        $data['judul'] = 'Alumni';
        $data['nama'] = $this->session->userdata('nama_alumni');
        // $telpon =  $this->session->userdata('telpon');
        $data['data'] = $this->alumni_m->semua_pelamar($id_pelamar);
        $this->load->view('template/header', $data);
        $this->load->view('admin/lowongan/lihat_pelamar', $data);
        $this->load->view('template/footer');
    }

    public function alumni()
    {
        $data['judul'] = 'Data alumni';
        $data['nama'] = $this->session->userdata('nama_alumni');
        $data['data'] = $this->alumni_m->get_all_alumni();

        $this->load->view('template/header', $data);
        $this->load->view('admin/alumni/data_alumni', $data);
        $this->load->view('template/footer');
    }
    public function cetak_alumni()
    {
        $data['judul'] = 'Data alumni';
        $data['nama'] = $this->session->userdata('nama_alumni');
        $data['data'] = $this->alumni_m->get_all_alumni();

        // $this->load->view('template/header', $data);
        $this->load->view('admin/alumni/cetak_data_alumni', $data);
        // $this->load->view('template/footer');
    }


    public function tambah_alumni_baru()
    {
        $this->form_validation->set_rules('nama_alumni', 'Nama Lengkap', 'required|is_unique[alumni.email]');
        $this->form_validation->set_rules('jurusan_smk', 'Jurusan', 'required');
        $this->form_validation->set_rules('agama', 'Agama', 'required');
        $this->form_validation->set_rules('pendidikan_t', 'Pendidikan terakhir', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('telpon', 'Telpon', 'required|is_unique[alumni.telpon]');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[alumni.email]');
        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Data alumni';
            $data['nama'] = $this->session->userdata('nama_alumni');
            $data['jurusan'] = $this->jurusan_m->get_all_jurusan();

            $this->load->view('template/header', $data);
            $this->load->view('admin/alumni/input_alumni', $data);
            $this->load->view('template/footer');
        } else {
            $password = "123456";
            $config['upload_path']   = './assets/foto_profil/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['remove_space'] = TRUE;
            //$config['max_size']      = 100; 
            //$config['max_width']     = 1024; 
            //$config['max_height']    = 768;  

            $this->load->library('upload', $config);
            // script upload file 1
            $this->upload->do_upload('foto');
            $x = $this->upload->data();

            $data = array(
                'nama_alumni' => $this->input->post('nama_alumni'),
                'jurusan_smk' => $this->input->post('jurusan_smk'),
                'agama' => $this->input->post('agama'),
                'pendidikan_t' => $this->input->post('pendidikan_t'),
                'tgl_lahir' => $this->input->post('tgl_lahir'),
                'alamat' => $this->input->post('alamat'),
                'telpon' => $this->input->post('telpon'),
                'foto_profil' => $x["orig_name"],
                'email' => $this->input->post('email'),
            );
            $akun = array(
                'telpon' => $this->input->post('telpon'),
                'password' => md5($password),
                'level' => "user",
                'status' => "aktif",
            );

            $this->db->insert('alumni', $data);
            $this->db->insert('akun', $akun);
            return redirect('admin/alumni');
        }
    }

    public function view_alumni($telpon)
    {
        $data['judul'] = 'Dashboard Alumni';
        $data['nama'] = $this->session->userdata('nama_alumni');
        $data['data'] = $this->alumni_m->get_row_alumni($telpon);
        $this->load->view('template/header', $data);
        $this->load->view('admin/alumni/view_alumni', $data);
        $this->load->view('template/footer', $data);
    }

    public function tolak($id_lamaran)
    {
        $data = array(
            'status_lamaran' => '2'
        );
        $this->db->where('id_lamaran', $id_lamaran);
        $this->db->update('lamaran', $data);
        redirect("admin/pengajuan_kerja");
    }

    public function terima($id_lamaran)
    {
        $data = array(
            'status_lamaran' => '3'
        );
        $this->db->where('id_lamaran', $id_lamaran);
        $this->db->update('lamaran', $data);
        redirect("admin/pengajuan_kerja");
    }
}

/* End of file Admin.php */