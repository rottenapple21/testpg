<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pelanggan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pelanggan_model', 'pelanggan');
	}

	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('templates/footer');
		$this->load->helper('url');
		$this->load->view('pelanggan_view');
	}

	public function ajax_list()
	{
		$list = $this->pelanggan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelanggan) {
			$no++;
			$row = array();
			$row[] = '<input class="form-check-input mt-0" name="" style="transform: translatex(230%) translatey(75%);" type="checkbox" value="" aria-label="Checkbox for following text input">';
			$row[] = $pelanggan->nomor_pelanggan;
			$row[] = $pelanggan->nama_pelanggan;
			$row[] = $pelanggan->jenis_keanggotaan;
			$row[] = $pelanggan->telp;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_pelanggan(' . "'" . $pelanggan->id_pelanggan . "'" . ')"> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_pelanggan(' . "'" . $pelanggan->id_pelanggan . "'" . ')"> Delete</a>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pelanggan->count_all(),
			"recordsFiltered" => $this->pelanggan->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->pelanggan->get_by_id($id);
		$data->tgl_lahir = ($data->tgl_lahir == '0000-00-00') ? '' : $data->tgl_lahir;
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
			'nomor_pelanggan' => $this->input->post('nomor_pelanggan'),
			'nama_pelanggan' => $this->input->post('nama_pelanggan'),
			'tgl_lahir' => $this->input->post('tgl_lahir'),
			'jenis_keanggotaan' => $this->input->post('jenis_keanggotaan'),
			'alamat' => $this->input->post('alamat'),
			'telp' => $this->input->post('telp'),
		);
		$insert = $this->pelanggan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
			'nomor_pelanggan' => $this->input->post('nomor_pelanggan'),
			'nama_pelanggan' => $this->input->post('nama_pelanggan'),
			'tgl_lahir' => $this->input->post('tgl_lahir'),
			'jenis_keanggotaan' => $this->input->post('jenis_keanggotaan'),
			'alamat' => $this->input->post('alamat'),
			'telp' => $this->input->post('telp'),
		);
		$this->pelanggan->update(array('id_pelanggan' => $this->input->post('id_pelanggan')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->pelanggan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('nomor_pelanggan') == '') {
			$data['inputerror'][] = 'nomor_pelanggan';
			$data['error_string'][] = 'Nomor pelanggan is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('nama_pelanggan') == '') {
			$data['inputerror'][] = 'nama_pelanggan';
			$data['error_string'][] = 'Nama pelanggan is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('tgl_lahir') == '') {
			$data['inputerror'][] = 'tgl_lahir';
			$data['error_string'][] = 'Tanggal lahir is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('jenis_keanggotaan') == '') {
			$data['inputerror'][] = 'jenis_keanggotaan';
			$data['error_string'][] = 'Please select jenis keanggotaan';
			$data['status'] = FALSE;
		}

		if ($this->input->post('alamat') == '') {
			$data['inputerror'][] = 'alamat';
			$data['error_string'][] = 'Alamat is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('telp') == '') {
			$data['inputerror'][] = 'telp';
			$data['error_string'][] = 'Telp name is required';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}
}
