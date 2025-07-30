<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Anggota_model');
		$this->load->model('Petugas_model');
		if($this->session->userdata('logged_in') == false){
			redirect('welcome');
		}
	}

	public function index(){
		$data['title'] = 'Anggota';
		$data['list'] = $this->Anggota_model->getList();
		$data['primary_view'] = 'anggota/anggota_view';
		$data['total'] = $this->Anggota_model->getCount();
		$this->load->view('template_view', $data);
	}

	public function detail(){
		$data['title'] = 'Detail Anggota';

		//GET : Detail data
		$id = $this->input->get('idtf');
		$data['row'] = $this->Anggota_model->getDetail($id);
		//CHECK : Data Availability
		if($this->Anggota_model->checkAvailability($id) == true){
			$data['primary_view'] = 'anggota/detail_anggota_view';
		}else{
			$data['primary_view'] = '404_view';
		}
		$this->load->view('template_view', $data);
	}

	public function add(){
		$data['title'] = 'Tambah Anggota';
		$data['primary_view'] = 'anggota/add_anggota_view';
		$this->load->view('template_view', $data);
	}

	public function edit(){
		$id = $this->input->get('idtf');
		//CHECK : Data Availability
		if($this->Anggota_model->checkAvailability($id) == true){
			$data['primary_view'] = 'anggota/edit_anggota_view';
		}else{
			$data['primary_view'] = '404_view';
		}
		$data['title'] = 'Edit Anggota';
		$data['detail'] = $this->Anggota_model->getDetail($id);
		//exit(json_encode($this->Anggota_model->getDetail($id)));
		$this->load->view('template_view', $data);
	}

	public function submit(){
		if($this->input->post('t')){
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('tmp_lahir', 'Tempat Lahir', 'trim|required');
			$this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'trim|required');
			$this->form_validation->set_rules('telp', 'No. Telepon', 'trim|required|numeric');
			$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');

			if ($this->form_validation->run() == true) {
				$config['upload_path'] = './assets/images/upload/anggota/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']  = '2000';
				
				$this->load->library('upload', $config);

				//GET : Petugas ID
				$username = $this->session->userdata('username');
				$id_petugas = $this->Petugas_model->getID($username);

				if ($this->upload->do_upload('foto')){
					if($this->Anggota_model->insert($id_petugas, $this->upload->data()) == true){
						$this->session->set_flashdata('announce', 'Berhasil menyimpan data');
						redirect('anggota/add');
					}else{
						$this->session->set_flashdata('announce', 'Gagal menyimpan data');
						redirect('anggota/add');
					}
				}else{
					$this->session->set_flashdata('announce', $this->upload->display_errors());
					redirect('anggota/add');
				}
			} else {
				$this->session->set_flashdata('announce', validation_errors());
				redirect('anggota/add');
			}
		}
	}

	public function submitEdit(){
		if($this->input->post('submit')){
			/* $this->form_validation->set_rules('judul', 'Judul Buku', 'trim|required');
			$this->form_validation->set_rules('penulis', 'Penulis', 'trim|required');
			$this->form_validation->set_rules('penerbit', 'Penerbit', 'trim|required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'trim|required|numeric');
			$this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required|numeric'); */

			//if ($this->form_validation->run() == true) {
				if($this->Anggota_model->update($this->input->post('id')) == true){
					$this->session->set_flashdata('announce', 'Berhasil menyimpan data');
					redirect('anggota/edit?idtf='.$this->input->post('id'));
				}else{
					$this->session->set_flashdata('announce', 'Gagal menyimpan data');
					redirect('anggota/edit?idtf='.$this->input->post('id'));
				}
			/* } else {
				$this->session->set_flashdata('announce', validation_errors());
				redirect('buku/edit?idtf='.$this->input->post('id'));
			} */
		}
	}

	public function delete(){
		$id = $this->input->get('rcgn');
		$hapus = $this->Anggota_model->delete($id);

		if ($hapus === true) {
			$this->session->set_flashdata('announce', 'Berhasil menghapus data');
		} elseif ($hapus === 'related') {
			$this->session->set_flashdata('announce', 'Tidak bisa menghapus anggota karena masih memiliki data peminjaman.');
		} else {
			$this->session->set_flashdata('announce', 'Gagal menghapus data');
		}

		redirect('anggota');
	}

	public function download_kartu()
	{
		$this->load->library('pdf');

		$id = $this->input->get('idtf');
		if (!empty($id)) {
			$anggota = $this->db->get_where('anggota', ['ID_ANGGOTA' => $id])->result();
		} else {
			$anggota = $this->db->get('anggota')->result();
		}

		// Ukuran kartu dan margin
		$card_width = 85.6;
		$card_height = 53.98;
		$gap = 3;
		$margin = 5;
		$total_width = ($card_width * 2) + $gap + ($margin * 2);
		$total_height = $card_height + ($margin * 2);

		$this->load->library('pdf');

		$pdf = new Pdf('L', 'mm', [$total_width, $total_height], true, 'UTF-8', false);


		$pdf->SetMargins(0, 0, 0);
		$pdf->SetAutoPageBreak(false);
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);

		foreach ($anggota as $a) {
			$pdf->AddPage();

			// Posisi awal kartu
			$offsetY = $margin;
			$offsetX_front = $margin;
			$offsetX_back = $offsetX_front + $card_width + $gap;

			// ============================
			// ▶ KARTU DEPAN
			// ============================
			$pdf->SetFillColor(240, 240, 240);
			$pdf->Rect($offsetX_front, $offsetY, $card_width, $card_height, 'F');

			$pdf->SetDrawColor(220, 220, 220);
			for ($y = 5; $y < $card_height; $y += 5) {
				$pdf->Line($offsetX_front, $offsetY + $y, $offsetX_front + $card_width, $offsetY + $y);
			}

			// Sidebar hijau
			$pdf->SetFillColor(23, 145, 141);
			$pdf->Rect($offsetX_front, $offsetY, 28, $card_height, 'F');

			// Logo
			$logo = FCPATH . 'assets/img/logo1.jpg';
			if (file_exists($logo)) {
				$pdf->Image($logo, $offsetX_front + 6, $offsetY + 4, 16, '', 'JPG');
			}

			// Nama singkat perpustakaan (sidebar)
			$pdf->SetFont('helvetica', 'B', 10);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->SetXY($offsetX_front, $offsetY + 22);
			$pdf->Cell(28, 5, 'PerpusBAD', 0, 0, 'C');

			// Header atas
			$pdf->SetFont('helvetica', 'B', 8.5);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY($offsetX_front + 28, $offsetY + 4);
			$pdf->Cell($card_width - 28, 4.5, 'Perpustakaan Pondok Pesantren', 0, 1, 'C');
			$pdf->SetX($offsetX_front + 28);
			$pdf->Cell($card_width - 28, 4.5, 'Baitul Abidin Darussalam', 0, 1, 'C');

			// Garis bawah header
			$pdf->SetDrawColor(23, 145, 141);
			$pdf->Line($offsetX_front + 28, $offsetY + 13, $offsetX_front + $card_width - 1, $offsetY + 13);

			// QR Code
			$qr_x = $offsetX_front + 4.5;
			$qr_y = $offsetY + 32.5;
			$qr_size = 19;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Rect($qr_x, $qr_y, $qr_size, $qr_size, 'F');
			$pdf->write2DBarcode($a->ID_ANGGOTA, 'QRCODE,H', $qr_x + 0.5, $qr_y + 0.5, $qr_size - 1, $qr_size - 1);

			// Data Anggota
			$startX = $offsetX_front + 32;
			$startY = $offsetY + 16;
			$labelWidth = 15;
			$valueWidth = 38;
			$lineHeight = 4;

			$pdf->SetFont('helvetica', '', 7);
			$pdf->SetTextColor(0, 0, 0);

			$pdf->SetXY($startX, $startY);
			$pdf->Cell($labelWidth, $lineHeight, 'ID', 0, 0);
			$pdf->Cell($valueWidth, $lineHeight, ': ' . $a->ID_ANGGOTA, 0, 1);

			$pdf->SetX($startX);
			$pdf->Cell($labelWidth, $lineHeight, 'Nama', 0, 0);
			$pdf->Cell($valueWidth, $lineHeight, ': ' . $a->FULL_NAME, 0, 1);

			$ttl = $a->TMP_LAHIR . ', ' . date('d-m-Y', strtotime($a->TGL_LAHIR));
			$pdf->SetX($startX);
			$pdf->Cell($labelWidth, $lineHeight, 'TTL', 0, 0);
			$pdf->Cell($valueWidth, $lineHeight, ': ' . $ttl, 0, 1);

			$pdf->SetX($startX);
			$pdf->Cell($labelWidth, $lineHeight, 'Tahun Masuk', 0, 0);
			$pdf->Cell($valueWidth, $lineHeight, ': ' . ($a->NO_HP ?? '-'), 0, 1);

			// Alamat multiline tanpa justify
			$alamat = $a->ALAMAT ?? '-';
			$pdf->SetX($startX);
			$pdf->Cell($labelWidth, $lineHeight, 'Alamat', 0, 0);
			$pdf->Cell(2, $lineHeight, ':', 0, 0);
			$pdf->MultiCell($valueWidth - 2, $lineHeight, $alamat, 0, 'L');

			// ============================
			// ▶ KARTU BELAKANG
			// ============================
			$pdf->SetFillColor(240, 240, 240);
			$pdf->Rect($offsetX_back, $offsetY, $card_width, $card_height, 'F');

			// Judul
			$pdf->SetFont('helvetica', 'B', 9);
			$pdf->SetTextColor(23, 145, 141);
			$pdf->SetXY($offsetX_back, $offsetY + 7);
			$pdf->Cell($card_width, 5, 'Informasi & Ketentuan', 0, 1, 'C');

			// Garis bawah header (cocokkan)
			$pdf->SetDrawColor(23, 145, 141);
			$pdf->Line($offsetX_back + 25, $offsetY + 12, $offsetX_back + 60, $offsetY + 12);

			// Isi ketentuan
			$pdf->SetFont('helvetica', '', 7);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetXY($offsetX_back + 8, $offsetY + 15);
			$pdf->MultiCell(70, 4.5,
				"1. Kartu ini milik Perpustakaan Pondok Pesantren Baitul Abidin Darussalam.\n" .
				"2. Tidak diperbolehkan dipindahtangankan.\n" .
				"3. Harap membawa kartu saat meminjam buku.\n" .
				"4. Kehilangan kartu harap segera dilaporkan.\n" .
				"5. Berlaku sampai: " . date('d-m-Y', strtotime('+1 year')),
				0, 'L');

			// Tanda tangan
			$pdf->SetXY($offsetX_back + 55, $offsetY + 38);
			$pdf->SetFont('helvetica', '', 7);
			$pdf->Cell(30, 4, 'Petugas Perpustakaan', 0, 1, 'C');

			$pdf->SetXY($offsetX_back + 55, $offsetY + 47);
			$pdf->SetFont('helvetica', 'B', 7);
			$pdf->Cell(30, 4, '(Pengurus)', 0, 1, 'C');

			// Garis tengah antar kartu (optional)
			$pdf->SetDrawColor(180, 180, 180);
			$pdf->Line($offsetX_front + $card_width + $gap / 2, $offsetY, $offsetX_front + $card_width + $gap / 2, $offsetY + $card_height);
		}

		$filename = !empty($id) ? 'kartu_anggota_' . $id .'.pdf' : 'kartu_anggota_perpustakaan.pdf';
		$pdf->Output($filename, 'D');
	}
}

/* End of file Anggota.php */
/* Location: ./application/controllers/Anggota.php */